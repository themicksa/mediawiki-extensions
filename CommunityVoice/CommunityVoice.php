<?php
/**
 * CommunityVoice extension
 *
 * @file
 * @ingroup Extensions
 *
 * This is the main include file for the CommunityVoice extension.
 *
 * Installation: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/CommunityVoice/CommunityVoice.php" );
 *
 * This extension depends on the ClientSide extension, which provides functions
 * for generating code in client-side formats such as HTML, CSS and JavaScript
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo ( "This is a MediaWiki extension and cannot be run standalone.\n" );
	die ( 1 );
}

/* Configuration */

// Web-accessable resource path
$egCommunityVoiceResourcesPath = $wgScriptPath .
	'/extensions/CommunityVoice/Resources';

/* MediaWiki Integration */

// Credits
$wgExtensionCredits['other'][] = array(
	'name' => 'CommunityVoice',
	'author' => 'Trevor Parscal',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CommunityVoice',
	'descriptionmsg' => 'communityvoice-desc',
	'version' => '0.1.0',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['CommunityVoice'] = $dir . 'CommunityVoice.i18n.php';
$wgExtensionAliasesFiles['CommunityVoice'] = $dir . 'CommunityVoice.alias.php';

// Class Autoloading
$wgAutoloadClasses['CommunityVoice'] = $dir . 'CommunityVoice.php';
$wgAutoloadClasses['CommunityVoicePage'] = $dir . 'CommunityVoice.page.php';
$wgAutoloadClasses['CommunityVoiceRatings'] = $dir . 'Modules/Ratings.php';

// Special Pages
$wgSpecialPages['CommunityVoice'] = 'CommunityVoicePage';
$wgSpecialPageGroups['CommunityVoice'] = 'wiki';

// Setup Hooks
$wgExtensionFunctions[] = 'CommunityVoice::registerModules';
$wgHooks['AjaxAddScript'][] = 'CommunityVoice::addScripts';
$wgHooks['BeforePageDisplay'][] = 'CommunityVoice::addStyles';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efCheckSchema';

function efCheckSchema() {
	// Get a connection
	$db = wfGetDB( DB_MASTER );
	// Create table if it doesn't exist
	if ( !$db->tableExists( 'cv_ratings_votes' ) ) {
		$db->sourceFile( dirname( __FILE__  ) . '/CommunityVoice.sql' );
	}
	if ( !$db->tableExists( 'cv_ratings_usage' ) ) {
		$db->sourceFile( dirname( __FILE__  ) . '/CommunityVoice.sql' );
	}
	// Continue
	return true;
}

/* Classes */
// FIXME: classes should be put in their own files
abstract class CommunityVoice {

	/* Static Members */

	static private $modules = array(
		'Ratings' => array( 'class' => 'CommunityVoiceRatings' )
	);
	static private $messagesLoaded = false;

	/* Static Functions */

	public static function getModules() {
		return array_keys( self::$modules );
	}

	public static function callModuleAction( $module, $type, $action = '' ) {
		// Checks for class
		if ( isset( self::$modules[$module] ) ) {
			if ( class_exists( self::$modules[$module]['class'] ) ) {
				// Builds function
				$function = array(
					self::$modules[$module]['class'], $type . $action
				);
				// Checks callability
				if ( is_callable( $function ) ) {
					// Calls function on class
					return call_user_func( $function );
				} else {
					// Throws unfound/uncallable function exception
					throw new MWException(
						implode( '::', $function ) .
						' was not found or is not callable!'
					);
				}
			} else {
				// Throws non-existant class exception
				throw new MWException(
					self::$modules[$module]['class'] . ' is not a class!'
				);
			}
		} else {
			// Throws non-existant module exception
			throw new MWException( $module . ' is not a module!' );
		}
	}

	/**
	 * Registers modules with MediaWiki
	 */
	public static function registerModules() {
		// Loops over each module
		foreach ( self::getModules() as $module ) {
			self::callModuleAction( $module, 'register' );
		}
		return true;
	}

	public static function getMessage( $module, $message, $parameter = null	) {
		// Checks if extension messages have been loaded already
		if ( !self::$messagesLoaded ) {
			// Loads extension messages
			wfLoadExtensionMessages( 'CommunityVoice' );
			self::$messagesLoaded = true;
		}
		// Returns message
		return wfMsg( 'communityvoice-' . $module . '-' . $message, $parameter );
	}

	public static function touchArticle( $article ) {
		// Gets the title of the article which included the scale
		$articleTitle = Title::newFromText( $article );
		// Invalidates the cache of the article
		$articleTitle->invalidateCache();
	}

	/**
	 * Adds scripts to document
	 */
	public static function addScripts( $out ) {
		global $wgJsMimeType;
		global $egCommunityVoiceResourcesPath;

		$out->addInlineScript(
			sprintf(
				"var egCommunityVoiceResourcesPath = '%s';\n" ,
				Xml::escapeJsString( $egCommunityVoiceResourcesPath )
			)
		);
		$out->addScript(
			Xml::element(
				'script',
				array(
					'type' => $wgJsMimeType,
					'src' => $egCommunityVoiceResourcesPath .
						'/CommunityVoice.js'
				),
				'',
				false
			)
		);
		return true;
	}

	/**
	 * Adds styles to document
	 */
	public static function addStyles(
		$out
	) {
		global $egCommunityVoiceResourcesPath;
		$out->addLink(
			array(
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $egCommunityVoiceResourcesPath . '/CommunityVoice.css'
			)
		);
		return true;
	}
}
