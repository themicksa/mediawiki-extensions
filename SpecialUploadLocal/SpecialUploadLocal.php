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

$wgExtensionFunctions[] = "wfSetupUploadLocal";
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'UploadLocal',
	'description' => 'allows users to link in files already on the server'
);

$wgUploadLocalDirectory = $IP . '/extensions/SpecialUploadLocal/data';

$wgAvailableRights[] = 'uploadlocal';
$wgGroupPermissions['uploader']['uploadlocal'] = true;
$wgGroupPermissions['sysop']   ['uploadlocal'] = true;

function wfSetupUploadLocal() {
	require_once( 'SpecialPage.php' );

	global $wgMessageCache;

	$messages = array(
		'uploadlocal' => 'Upload local files'
	   ,'uploadlocal_directory_readonly' => 'The local upload directory ($1) is'.
		   ' not writeable by the webserver.'
	   ,'uploadlocaltext' => 'Use this form to mass upload files already on the'.
		   ' server in the upload local directory. You can find out more'.
		   ' general information at [[Special:Upload|the regular upload file'.
		   ' page]].'
	   ,'uploadlocalbtn' => 'Upload local files'
	   ,'nolocalfiles' => 'There are no files in the local upload folder. Try'.
		   ' placing some files in "<code>$1</code>."'
	   ,'uploadednolocalfiles' => 'You did not upload any files.'
	   ,'allfilessuccessful' => 'All files uploaded successfully'
	   ,'uploadlocalerrors' => 'Some files had errors'
	   ,'allfilessuccessfultext' => 'All files uploaded successfully. Return to'.
		   ' [[Main Page]].'
	   ,'uploadlocal_descriptions_append' => 'Append to description: '
	   ,'uploadlocal_descriptions_prepend' => 'Prepend to description: '
	   ,'uploadlocal_dest_file_append' => 'Append to dest. filename: '
	   ,'uploadlocal_dest_file_prepend' => 'Prepend to dest. filename: '
	   ,'uploadlocal_file_list' => 'Files ready for upload'
	   ,'uploadlocal_file_list_explanation' => '\'\'\'X\'\'\' indicates'.
		   ' whether or not you want the file to be uploaded (uncheck to'.
		   ' prevent a file from being processed). \'\'\'W\'\'\' indicates'.
		   ' whether you want the file added to your watchlist.'
	   ,'uploadlocal_global_params' => 'Global parameters'
	   ,'uploadlocal_global_params_explanation' => 'What is entered here will'.
		   ' automatically get added to the entries listed above. This helps'.
		   ' remove repetitive text such as categories and metadata. To \'\'\''.
		   'append\'\'\' is to add to the end of text, while to \'\'\'prepend'.
		   '\'\'\' means to add to the beginning of text. Especially for'.
		   ' descriptions, make sure you give a few linebreaks before/after'.
		   ' the text.'
		);
	$wgMessageCache->addMessages($messages);
	SpecialPage::addPage( new SpecialPage( 'UploadLocal', 'uploadlocal',
	  /*listed*/ true, /*function*/ false, /*file*/ false )  );

}

function wfSpecialUploadLocal() {
	global $wgRequest, $wgUploadLocalDirectory, $wgMessageCache;

	$prefix = 'extensions/SpecialUploadLocal/';
	require($prefix . 'UploadLocalDirectory.php');
	require($prefix . 'UploadLocalForm.php');

	$directory =& new UploadLocalDirectory($wgRequest, $wgUploadLocalDirectory);
	$directory->execute();
}
