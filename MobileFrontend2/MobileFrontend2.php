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
