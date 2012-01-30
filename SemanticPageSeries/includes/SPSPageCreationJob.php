<?php

/**
 * File holding the SPSPageCreationJob class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSPageCreationJob class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSPageCreationJob extends Job {

//	public function __construct( $command, $title, $params = false, $id = 0 ) {
//		parent::__construct( $command, $title, $params, $id );
//	}

	function __construct( $title, $params = '', $id = 0 ) {
		parent::__construct( 'spsCreatePage', $title, $params, $id );
	}

	/**
	 * Run the job
	 * @return boolean success
	 */
	function run() {

		$this->params['form'] = $this->title->getText();

		$handler = new SFAutoeditAPI( null, 'sfautoedit' );
		$handler->isApiQuery( false );
		$handler->setOptions( $this->params );

		$result = $handler->storeSemanticData( false );

		// wrap result in ok/error message
		if ( $result === true ) {

			$options = $handler->getOptions();
			$result = wfMsg( 'sf_autoedit_success', $options['target'], $options['form']) ;
		} else {

			$result = wfMsgReplaceArgs( '$1', array($result) );
		}
		
		wfDebugLog( 'sps', 'Page Creation Job: ' . $result );
	}

}
