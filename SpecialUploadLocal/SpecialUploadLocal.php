<?php
if (!defined('MEDIAWIKI')) die();

/*

TODO:
 * Considered more advanced file scanning regexps/recursive searching
 * Allow unzipping without ssh'ing (need a tar library or shell)
 * Migrate repository to Mercurial so we can easily push changes

BUGS:
 * Figure out how to get image overwrites to work properly or fail gracefully
 * Warn when filename contains ampersand. (Apache doesn't like that)

ENHANCEMENTS:
 * Mute extra output from the new page function.
 * Remove debugging info.
 * Dry run capability.

*/

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'UploadLocal',
	'description' => 'allows users to link in files already on the server'
);
$wgSpecialPages['SpecialUploadLocal'] = 'SpecialUploadLocal';
$wgExtensionMessagesFiles['SpecialUploadLocal'] = dirname( __FILE__ ) . '/SpecialUploadLocal.i18n.php';
$wgAutoloadClasses[ 'SpecialUploadLocal' ] = dirname( __FILE__ ) . '/SpecialUploadLocal_body.php';
/** (CSN) 27 Oct 2011 - Need to add new class for 1.17.0 */
$wgAutoloadClasses[ 'WebRequestUploadLocal' ] = dirname( __FILE__ ) . '/WebRequestUploadLocal.php';
/* (CSN) end mod **/

$wgUploadLocalDirectory = $IP . '/extensions/SpecialUploadLocal/data';

$wgAvailableRights[] = 'uploadlocal';
$wgGroupPermissions['uploader']['uploadlocal'] = true;
$wgGroupPermissions['sysop']   ['uploadlocal'] = true;
$wgSpecialPageGroups['SpecialUploadLocal'] = 'media';
