<?php

/**
 * File holding the SPSDateIterator class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSDateIterator class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSDateIterator extends SPSIterator {
	
	/**
	 * @return array An array containing the names of the parameters this iterator uses.
	 */
	function getParameterNames() {
		return array('start', 'end', 'period', 'unit');
	}
	
	/**
	 * @return an array of the values to be used in the target field of the target form
	 */
	function getValues ( &$data ){
		
		//prepare params for getDatesForRecurringEvent
		$params = array (
			'property=SomeDummyProperty',
			'start=' . $data['start'],
			'end=' . $data['end'],
			'period=' . $data['period'],
			'unit=' . $data['unit'],
			);

		$values = SMWSetRecurringEvent::getDatesForRecurringEvent($params);

		// if the first date did not contain a time, remove the time from all
		// generated dates
		if ( preg_match( '/.:../', $values[1][0] ) === 0 ) {
			foreach ( $values[1] as $key => $value ) {
				$values[1][$key] = trim( preg_replace( '/..:..:../', '', $value ) );
			}
		}

		var_dump($values);
		die();
		
		return $values[1];
	}
}
