<?php
/**
* Extension MobileFrontend2 — Mobile Frontend 2
*
* @file
* @ingroup Extensions
*/

// Needs to be called within MediaWiki; not standalone
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MobileFrontend2',
	'version' => 1,
	'author' => 'John Du Hart',
	'descriptionmsg' => 'mobile-frontend2-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MobileFrontend2',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['MobileFrontend2'] = $dir . 'MobileFrontend2.i18n.php';

$wgAutoloadClasses['MobileFrontend2_Detection'] = $dir . 'MobileFrontend2_Detection.php';
$wgAutoloadClasses['MobileFrontend2_Hooks'] = $dir . 'MobileFrontend2_Hooks.php';
$wgAutoloadClasses['MobileFrontend2_Parser'] = $dir . 'MobileFrontend2_Parser.php';

// Skins
$wgAutoloadClasses['SkinMobile'] = $dir . 'skins/Mobile.php';

// Hooks
$wgHooks['RequestContextCreateSkin'][] = 'MobileFrontend2_Hooks::createSkin';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'MobileFrontend2_Hooks::modifyTemplate';
$wgHooks['PageRenderingHash'][] = 'MobileFrontend2_Hooks::renderHash';
$wgHooks['ParserSectionCreate'][] = 'MobileFrontend2_Hooks::parserSectionCreate';
$wgExtensionFunctions[] = 'MobileFrontend2_Hooks::setup';

// Modules
$commonModuleInfo = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'CodeReview/modules',
);

// Main style
$wgResourceModules['ext.mobileFrontend2'] = array(
	'styles' => 'ext.mobileFrontend2/ext.mobileFrontend2.css',
) + $commonModuleInfo;

// Config
/**
 * Logo used on MobileFrontend2
 *
 * @var $wgMobileFrontend2Logo string
 */
$wgMobileFrontend2Logo = null;