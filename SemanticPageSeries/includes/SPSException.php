<?php

/**
 * File holding the SPSException class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSException class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSException extends MWException {

	/**
	 * Return a HTML message.
	 * 
	 * Overrides method from MWException: We don't need a backtrace
	 * 
	 * @return String html to output
	 */
	function getHTML() {
		return '<p>' . nl2br( htmlspecialchars( $this->getMessage() ) ) .
			"</p>\n";
	}

	/**
	 * Return a text message.
	 * 
	 * Overrides method from MWException: We don't need a backtrace
	 * 
	 */
	function getText() {
		return $this->getMessage();
	}

	/**
	 * Return titles of this error page
	 * 
	 * Overrides method from MWException: We have a different page title
	 * 
	 */
	function getPageTitle() {
		if ( $this->useMessageCache() ) {
			return wfMsg( 'spserror' );
		} else {
			global $wgSitename;
			return "$wgSitename error";
		}
	}

}
