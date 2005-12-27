<?
/**
* Run the following SQL on your database prior to use :

CREATE TABLE stableversions (
  sv_page_id int(8) unsigned NOT NULL default '0',
  sv_page_rev int(8) unsigned NOT NULL default '0',
  sv_type tinyint(2) unsigned NOT NULL default '0',
  sv_user int(8) unsigned NOT NULL default '0',
  sv_date varchar(14) NOT NULL default '',
  sv_cache mediumblob NOT NULL,
  KEY sv_page_id (sv_page_id,sv_page_rev,sv_type)
) TYPE=InnoDB;

* Some global variables:
$wgStableVersionThereCanOnlyBeOne // Set this to true is you want to have only a single stable version per article
*/

if (!defined('MEDIAWIKI')) die();

/**@+ Version type constants */
define( 'SV_TYPE_UNDEFINED',  0 );
define( 'SV_TYPE_STABLE',     1 );
define( 'SV_TYPE_STABLE_CANDIDATE', 2 );
/**@-*/

# Global variables to configure StableVersion
$wgStableVersionThereCanOnlyBeOne = false ;

# Evil variables, needed internally
$wgStableVersionCaching = false ;

$wgExtensionCredits['StableVersion'][] = array(
        'name' => 'Stable version',
        'description' => 'An extension to allow the marking of a stable version.',
        'author' => 'Magnus Manske'
);

$wgAvailableRights[] = 'stableversion';
$wgExtensionFunctions[] = 'wfStableVersion' ;
$wgHooks['ArticleViewHeader'][] = 'wfStableVersionHeaderHook' ;
$wgHooks['ArticlePageDataBefore'][] = 'wfStableVersionArticlePageDataBeforeHook' ;
$wgHooks['ArticlePageDataAfter'][] = 'wfStableVersionArticlePageDataAfterHook' ;
$wgHooks['ParserBeforeInternalParse'][] = 'wfStableVersionParseBeforeInternalParseHook' ;
$wgHooks['ArticleAfterFetchContent'][] = 'wfStableVersionArticleAfterFetchContentHook' ;

# BEGIN logging functions
$wgHooks['LogPageValidTypes'][] = 'wfStableVersionAddLogType';
$wgHooks['LogPageLogName'][] = 'wfStableVersionAddLogName';
$wgHooks['LogPageLogHeader'][] = 'wfStableVersionAddLogHeader';
$wgHooks['LogPageActionText'][] = 'wfStableVersionAddActionText';

function wfStableVersionAddLogType( &$types ) {
	if ( !in_array( 'stablevers', $types ) )
		$types[] = 'stablevers';
	return true;
}

function wfStableVersionAddLogName( &$names ) {
	$names['stablevers'] = 'stableversion_logpage';
	return true;
}

function wfStableVersionAddLogHeader( &$headers ) {
	$headers['stablevers'] = 'stableversion_logpagetext';
	return true;
}

function wfStableVersionAddActionText( &$actions ) {
	$actions['stablevers/stablevers'] = 'stableversion_logentry';
	return true;
}
# END logging functions


# Text adding function
function wfStableVersionAddCache () {
	global $wgMessageCache , $wgStableVersionAddCache ;
	if ( $wgStableVersionAddCache ) return ;
	$wgStableVersionAddCache = true ;
	
	// Default language is english
	require_once('language/en.php');

	global $wgLanguageCode;
	$filename = 'language/' . addslashes($wgLanguageCode) . '.php' ;
	// inclusion might fail :p
	include( $filename );
}

/**
* Adds query for stable version
* @param $article (not used)
* @param $fields Fields for query
*/
function wfStableVersionArticlePageDataBeforeHook ( &$article , &$fields ) {
	return true ;
#	$fields[] = "page_stable" ;
#	$fields[] = "page_stable_cache" ;
}

/**
* Adds new variables "mStable" and "mStableCache" to the article
* @param $article The article
* @param $fields Query result object
*/
function wfStableVersionArticlePageDataAfterHook ( &$article , &$fields ) {
	global $wgRequest ;
	
	$dbr =& wfGetDB( DB_SLAVE );
	$fname = "wfStableVersionArticlePageDataAfterHook" ;
	$title = $article->getTitle() ;
	
	# No stable versions of a non-existing article
	if ( !$title->exists() ) return ;

	$res = $dbr->select(
			/* FROM   */ 'stableversions',
			/* SELECT */ '*',
			/* WHERE  */ array( 'sv_page_id' => $title->getArticleID() ) ,
			$fname,
			array ( "ORDER BY" => "sv_page_rev DESC" )
	);

	# Trying to figure out the revision number
	$rev = $wgRequest->getText('oldid', "") ;
	if ( $rev == "" ) $fields['page_latest'] ;
	
	$article->mIsStable = false ;
	$article->mLastStable = 0 ;
	while ( $o = $dbr->fetchObject( $res ) ) {
		if ( $o->sv_type == SV_TYPE_STABLE ) {
			if ( $o->sv_page_rev == $rev ) {
				# This is a stable version, set mark and get cache
				$article->mIsStable = true ;
				$article->mStableCache = $o->sv_cache ;
			}
			if ( $article->mLastStable == 0 ) {
				# The latest stable version
				$article->mLastStable = $o->sv_page_rev ;
			}
		}
	}
	$dbr->freeResult( $res );

	return true ;
}

/**
* Decides wether a user can set the stable version
* @return bool (always TRUE by default, for testing)
*/
function wfStableVersionCanChange () {
	return true ; # Dummy, everyone can set stable versions
	global $wgUser ;
	if ( !$wgUser->isAllowed( 'stableversion' ) ) {
		$wgOut->permissionRequired( 'stableversion' );
		return false ;
	}
	return true ;
}

/**
* Generates the little header line
* @param $article The article
*/
function wfStableVersionHeaderHook ( &$article ) {
	global $wgOut , $wgTitle ;
	wfStableVersionAddCache () ;
	$st = "" ; # Subtitle
	
	if ( $article->mIsStable ) { # This is the stable version
		if ( $article->mLatest == $article->mLastStable ) {
			$st .= wfMsg ( 'stableversion_this_is_stable_and_current' ) ;
		} else {
			$url = $wgTitle->getLocalURL () ;
			$st .= wfMsg ( 'stableversion_this_is_stable' , $url ) ;
		}
	} else if ( $article->mLastStable == "0" ) { # There is no spoon, er, stable version
		$st = wfMsg ( 'stableversion_this_is_draft_no_stable' ) ;
	} else { # This is not the stable version, recommend it
		$url = $wgTitle->getLocalURL ( "oldid=" . $article->mLastStable ) ;
		$st = wfMsg ( 'stableversion_this_is_draft' , $url ) ;
	}
	
	if ( wfStableVersionCanChange() ) { # This user may alter the stable version info
		$st .= " " ;
		$sp = Title::newFromText ( "Special:StableVersion" ) ;
		if ( $article->getRevIdFetched() == $article->mLastStable ) { # This is the stable version - reset?
			$url = $sp->getLocalURL ( "id=" . $article->getID() . "&mode=reset&revision=" . $article->getRevIdFetched() ) ;
			$st .= wfMsg ( 'stableversion_reset_stable_version' , $url ) ;
		} else {
			$url = $sp->getLocalURL ( "id=" . $article->getID() . "&mode=set&revision=" . $article->getRevIdFetched() ) ;
			$st .= wfMsg ( 'stableversion_set_stable_version' , $url ) ;
		}
	}

	$st = $wgOut->getSubtitle() . "<div id='stable_version_header'>" . $st . "</div>" ;
	$wgOut->setSubtitle ( $st ) ;
	return true ;
}


/**
* This is a parser hook that will terminate the parsing process after stripping
*/
function wfStableVersionParseBeforeInternalParseHook ( &$parser , &$text , &$x ) {
	global $wgStableVersionTempText , $wgStableVersionTempX , $wgStableVersionCaching ;
	if ( !$wgStableVersionCaching ) return true ; # Normal parsing, no caching
	
	# Stop the parsing process
	return false ;
}

/**
*/
function wfStableVersionArticleAfterFetchContentHook ( &$article , &$content ) {
	if ( !isset ( $article->mIsStable ) ) return true ;
	if ( !isset ( $article->mStableCache ) ) return true ;
	if ( !$article->mIsStable ) return true ;
	
	# This is a stable version and has a cache, so use that
	$content = $article->mStableCache ;
	return true ;
}



# The special page
function wfStableVersion() {
	global $IP, $wgMessageCache;
	wfStableVersionAddCache () ;

	$wgMessageCache->addMessage( 'stableversion', 'Stable Version' );

	require_once "$IP/includes/SpecialPage.php";

	class SpecialStableVersion extends SpecialPage {
		/**
		* Constructor
		*/
		function SpecialStableVersion() {
			SpecialPage::SpecialPage( 'StableVersion' );
			$this->includable( true );
		}
		
		
		function fixNoWiki( &$state ) {
			if ( !is_array( $state ) ) {
				return ;
			}
	
			# Surround nowiki content with <nowiki> again
			for ( $content = end($state['nowiki']); $content !== false; $content = prev( $state['nowiki'] ) ) {
				$key = key( $state['nowiki'] ) ;
				$state['nowiki'][$key] = "<nowiki>" . $content . "</nowiki>" ;
			}
			
		}

		/**
		*/
		function getCacheText ( &$article ) {
			global $wgStableVersionCaching , $wgUser ;
			$title = $article->getTitle() ;
			$article->loadContent ( true ) ; # FIXME: Do we need the "true" here? For what? Safe redirects??
			$text = $article->mContent ;
			
			$p = new Parser ;
			$wgStableVersionCaching = true ;
			$parserOptions = ParserOptions::newFromUser( $wgUser ); # Dummy

			$text = $p->parse ( $text , $title , $parserOptions ) ;
			$stripState = $p->mStripState ;
			$wgStableVersionCaching = false ;
			$text = $p->replaceVariables ( $text , $parse_options ) ;
		
			$this->fixNoWiki ( $stripState ) ;
			$p->mStripState = $stripState ;
			$text = $p->unstrip( $text, $p->mStripState );
			$text = $p->unstripNoWiki( $text, $p->mStripState );
			
			return $text ;
		}
	
		/**
		* main()
		*/
		function execute( $par = null ) {
			global $wgOut , $wgRequest , $wgUser , $wgArticle ;
			global $wgStableVersionThereCanOnlyBeOne ;
			
			# Sanity checks
			$mode = $wgRequest->getText('mode', "") ;
			if ( $mode != 'set' && $mode != 'reset' ) return ; # Should be error (wrong call)
			$id = $wgRequest->getText ( 'id', "0" ) ;
			if ( $id == "0" ) return ; # Should be error (wrong call)
			if ( !wfStableVersionCanChange() ) return ; # Should be error (not allowed)

			# OK, now do business
			$t = Title::newFromID ( $id ) ;

			if ( $mode == 'set' ) { # Set new version as stable
				$newstable = $wgRequest->getText ( 'revision', "0" ) ;
				$clearstable = $newstable ;
				$out = wfMsg ( 'stableversion_set_ok' ) ;
				$url = $t->getLocalURL ( "oldid=" . $newstable ) ;
				$act = wfMsg ( 'stableversion_log' , $newstable ) ;
			} else if ( $mode == "reset" ) { # Reset stable version
				$newstable = "0" ;
				$clearstable = $wgRequest->getText ( 'revision', "0" ) ;
				$out = wfMsg ( 'stableversion_reset_ok' ) ;
				$url = $t->getLocalURL () ;
				$act = wfMsg ( 'stableversion_reset_log' ) ;
			}
			else { # FIXME: Should be some error message for wrong mode
			}
			
			$article = new Article ( $t ) ;

			# Old stable version
			$oldstable = isset ( $wgArticle->mLastStable ) ? $wgArticle->mLastStable : 0 ;
			if ( $oldstable == 0 ) $before = wfMsg ( 'stableversion_before_no' ) ;
			else $before = wfMsg ( 'stableversion_before_yes' , $oldstable ) ;
			$act .= " " . $before ;
			
			$type = SV_TYPE_STABLE ; # FIXME: This should become something else once there are several "types"
			
			# Get template-replaced cache
			$cache = $this->getCacheText ( $article ) ;

			$dbw =& wfGetDB( DB_MASTER );
			$dbw->begin () ;
			
			# Delete this just in case it was already set
			$conditions = array ( 'sv_page_id' => $id ) ;
			if ( !$wgStableVersionThereCanOnlyBeOne )
				$conditions['sv_page_rev'] = $clearstable ;
			$dbw->delete ( 'stableversions' , $conditions , $fname ) ;
			
			$values = array (
				'sv_page_id' => $id,
				'sv_page_rev' => $newstable,
				'sv_type' => $type,
				'sv_user' => $wgUser->getID(),
				'sv_date' => "12345678123456" ,
				'sv_cache' => $cache,
			) ;
			
			if ( $newstable > 0 )
				$dbw->insert( 'stableversions',
					$values ,
					$fname );
			$dbw->commit () ;

			$out = "<p>{$out}</p><p>" . wfMsg ( 'stableversion_return' , $url , $t->getFullText() ) . "</p>" ;
			$act = "[[" . $t->getText() . "]] : " . $act ;

			# Logging
			$log = new LogPage( 'stablevers' );
			$log->addEntry( 'stablevers', $t , $act );

			$this->setHeaders();
			$wgOut->addHtml( $out );
		}
	} # end of class

	SpecialPage::addPage( new SpecialStableVersion );
}


?>
