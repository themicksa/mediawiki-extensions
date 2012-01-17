<?php

/**
 * Base class for different kinds of blacklists
 */
abstract class BaseBlacklist {

	/**
	 * Array of blacklist sources
	 *
	 * @var array
	 */
	public $files = array();

	/**
	 * Array containing regexes to test against
	 *
	 * @var bool|array
	 */
	protected $regexes = false;

	/**
	 * Chance of receiving a warning when the filter is hit
	 *
	 * @var int
	 */
	public $warningChance = 100;

	/**
	 * @var int
	 */
	public  $warningTime = 600;

	/**
	 * @var int
	 */
	public $expiryTime = 900;

	/**
	 * Constructor
	 *
	 * @param array $settings
	 */
	function __construct( $settings = array() ) {
		foreach ( $settings as $name => $value ) {
			$this->$name = $value;
		}
	}

	/**
	 * Returns the code for the blacklist implementation
	 *
	 * @return string
	 */
	abstract protected function getBlacklistType();

	/**
	 * Check if the given local page title is a spam regex source.
	 * @param Title $title
	 * @return bool
	 */
	function isLocalSource( $title ) {
		global $wgDBname;
		$listType = ucfirst( $this->getBlacklistType() );

		if( $title->getNamespace() == NS_MEDIAWIKI ) {
			$sources = array(
				"$listType-blacklist",
				"$listType-whitelist" );
			if( in_array( $title->getDBkey(), $sources ) ) {
				return true;
			}
		}

		$thisHttp = wfExpandUrl( $title->getFullUrl( 'action=raw' ), PROTO_HTTP );
		$thisHttpRegex = '/^' . preg_quote( $thisHttp, '/' ) . '(?:&.*)?$/';

		foreach( $this->files as $fileName ) {
			$matches = array();
			if ( preg_match( '/^DB: (\w*) (.*)$/', $fileName, $matches ) ) {
				if ( $wgDBname == $matches[1] ) {
					if( $matches[2] == $title->getPrefixedDbKey() ) {
						// Local DB fetch of this page...
						return true;
					}
				}
			} elseif( preg_match( $thisHttpRegex, $fileName ) ) {
				// Raw view of this page
				return true;
			}
		}

		return false;
	}

	/**
	 * Fetch local and (possibly cached) remote blacklists.
	 * Will be cached locally across multiple invocations.
	 * @return array set of regular expressions, potentially empty.
	 */
	function getBlacklists() {
		if( $this->regexes === false ) {
			$this->regexes = array_merge(
				$this->getLocalBlacklists(),
				$this->getSharedBlacklists() );
		}
		return $this->regexes;
	}

	/**
	 * Returns the local blacklist
	 *
	 * @return array Regular expressions
	 */
	public function getLocalBlacklists() {
		return SpamRegexBatch::regexesFromMessage( "{$this->getBlacklistType()}-blacklist" );
	}

	/**
	 * Returns the (local) whitelist
	 *
	 * @return array Regular expressions
	 */
	public function getWhitelists() {
		return SpamRegexBatch::regexesFromMessage( "{$this->getBlacklistType()}-whitelist" );
	}

	/**
	 * Fetch (possibly cached) remote blacklists.
	 * @return array
	 */
	function getSharedBlacklists() {
		global $wgMemc, $wgDBname;
		$listType = $this->getBlacklistType();
		$fname = 'SpamBlacklist::getRegex';
		wfProfileIn( $fname );

		wfDebugLog( 'SpamBlacklist', "Loading $listType regex..." );

		if ( count( $this->files ) == 0 ){
			# No lists
			wfDebugLog( 'SpamBlacklist', "no files specified\n" );
			wfProfileOut( $fname );
			return array();
		}

		// This used to be cached per-site, but that could be bad on a shared
		// server where not all wikis have the same configuration.
		$cachedRegexes = $wgMemc->get( "$wgDBname:{$listType}_blacklist_regexes" );
		if( is_array( $cachedRegexes ) ) {
			wfDebugLog( 'SpamBlacklist', "Got shared spam regexes from cache\n" );
			wfProfileOut( $fname );
			return $cachedRegexes;
		}

		$regexes = $this->buildSharedBlacklists();
		$wgMemc->set( "$wgDBname:{$listType}_blacklist_regexes", $regexes, $this->expiryTime );

		return $regexes;
	}

	function clearCache() {
		global $wgMemc, $wgDBname;
		$listType = $this->getBlacklistType();

		$wgMemc->delete( "$wgDBname:{$listType}_blacklist_regexes" );
		wfDebugLog( 'SpamBlacklist', "$listType blacklist local cache cleared.\n" );
	}

	function buildSharedBlacklists() {
		$regexes = array();
		$listType = $this->getBlacklistType();
		# Load lists
		wfDebugLog( 'SpamBlacklist', "Constructing $listType blacklist\n" );
		foreach ( $this->files as $fileName ) {
			$matches = array();
			if ( preg_match( '/^DB: ([\w-]*) (.*)$/', $fileName, $matches ) ) {
				$text = $this->getArticleText( $matches[1], $matches[2] );
			} elseif ( preg_match( '/^http:\/\//', $fileName ) ) {
				$text = $this->getHttpText( $fileName );
			} else {
				$text = file_get_contents( $fileName );
				wfDebugLog( 'SpamBlacklist', "got from file $fileName\n" );
			}

			// Build a separate batch of regexes from each source.
			// While in theory we could squeeze a little efficiency
			// out of combining multiple sources in one regex, if
			// there's a bad line in one of them we'll gain more
			// from only having to break that set into smaller pieces.
			$regexes = array_merge( $regexes,
				SpamRegexBatch::regexesFromText( $text, $fileName ) );
		}

		return $regexes;
	}

	function getHttpText( $fileName ) {
		global $wgDBname, $messageMemc;
		$listType = $this->getBlacklistType();

		# HTTP request
		# To keep requests to a minimum, we save results into $messageMemc, which is
		# similar to $wgMemc except almost certain to exist. By default, it is stored
		# in the database
		#
		# There are two keys, when the warning key expires, a random thread will refresh
		# the real key. This reduces the chance of multiple requests under high traffic
		# conditions.
		$key = "{$listType}_blacklist_file:$fileName";
		$warningKey = "$wgDBname:{$listType}filewarning:$fileName";
		$httpText = $messageMemc->get( $key );
		$warning = $messageMemc->get( $warningKey );

		if ( !is_string( $httpText ) || ( !$warning && !mt_rand( 0, $this->warningChance ) ) ) {
			wfDebugLog( 'SpamBlacklist', "Loading $listType blacklist from $fileName\n" );
			$httpText = Http::get( $fileName );
			if( $httpText === false ) {
				wfDebugLog( 'SpamBlacklist', "Error loading $listType blacklist from $fileName\n" );
			}
			$messageMemc->set( $warningKey, 1, $this->warningTime );
			$messageMemc->set( $key, $httpText, $this->expiryTime );
		} else {
			wfDebugLog( 'SpamBlacklist', "Got $listType blacklist from HTTP cache for $fileName\n" );
		}
		return $httpText;
	}

	/**
	 * Fetch an article from this or another local MediaWiki database.
	 * This is probably *very* fragile, and shouldn't be used perhaps.
	 *
	 * @param string $db
	 * @param string $article
	 * @return string
	 */
	function getArticleText( $db, $article ) {
		wfDebugLog( 'SpamBlacklist', "Fetching {$this->getBlacklistType()} spam blacklist from '$article' on '$db'...\n" );
		global $wgDBname;
		$dbr = wfGetDB( DB_READ );
		$dbr->selectDB( $db );
		$text = false;
		if ( $dbr->tableExists( 'page' ) ) {
			// 1.5 schema
			$dbw = wfGetDB( DB_READ );
			$dbw->selectDB( $db );
			$revision = Revision::newFromTitle( Title::newFromText( $article ) );
			if ( $revision ) {
				$text = $revision->getText();
			}
			$dbw->selectDB( $wgDBname );
		} else {
			// 1.4 schema
			$title = Title::newFromText( $article );
			$text = $dbr->selectField( 'cur', 'cur_text', array( 'cur_namespace' => $title->getNamespace(),
				'cur_title' => $title->getDBkey() ), __METHOD__ );
		}
		$dbr->selectDB( $wgDBname );
		return strval( $text );
	}

}
