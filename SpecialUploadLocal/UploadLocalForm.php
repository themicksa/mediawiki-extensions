<?php

require_once('SpecialUpload.php');

class UploadLocalForm extends UploadForm
{

	var $_error = '';
	var $_filename;

	/**
	 * With our parameters, simulate a request
	 */
	function UploadLocalForm($filename, $description, $watch, $dest) {
		global $wgUploadLocalDirectory;

		// Prepare our directory
		$dir = $wgUploadLocalDirectory;
		if ($dir[strlen($dir)-1] !== '/') $dir .= '/';

		// Create faux request object with basic parameters.
		$request = new FauxRequest(array(
			'wpDestFile' => $dest,
			'wpIgnoreWarning' => true,
			'wpUploadDescription' => $description,
			'wpUpload' => true,
			'wpWatchthis' => $this->watch,
		), true);

		// Instantiate private variables with those values, also note
		// initializeFromUpload() call will fail, but we don't have any
		// way of overriding that, and the failure is silent.
		parent::UploadForm($request);

		// initializeFromLocalFile() style functionality
		$this->mTempPath       = $dir . $filename;
		$this->mFileSize       = filesize($dir . $filename);
		$this->mSrcName        = $dir . $filename;
		$this->mCurlError      = false;
		$this->mSessionKey     = false;
		$this->mStashed        = false;
		// Our files are not under PHP's jurisdiction, so we need to remove
		// it ourselves.
		$this->mRemoveTempFile = true;

	}

	function getFilename() {return $this->_filename;}
	function getUploadSaveName() {return $this->mDesiredDestName;}

	function mainUploadForm($error) {$this->_error = $error;}
	function uploadError($error) {$this->_error = $error;}
	function showSuccess() {}

	function getError() {return $this->_error;}

}
