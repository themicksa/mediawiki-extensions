<?php

class SpecialUploadLocal extends SpecialPage {
	function __construct() {
		parent::__construct( 'SpecialUploadLocal',  'uploadlocal' );
		wfLoadExtensionMessages( 'SpecialUploadLocal' );
	}

	function execute( $par ) {
		global $wgRequest, $wgUploadLocalDirectory, $wgMessageCache;
		wfLoadExtensionMessages( 'SpecialUploadLocal' );
		
		$prefix = 'extensions/SpecialUploadLocal/';
		require($prefix . 'UploadLocalDirectory.php');
		require($prefix . 'UploadLocalForm.php');
		
		$directory = new UploadLocalDirectory($wgRequest, $wgUploadLocalDirectory);
		$directory->execute();
	}
}
