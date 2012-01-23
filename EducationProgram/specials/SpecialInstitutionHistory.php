<?php

/**
 * Special page for listing the history of an institution.
 *
 * @since 0.1
 *
 * @file SpecialInstitutionHistory.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialInstitutionHistory extends SpecialEPHistory {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'InstitutionHistory', '', false );
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	public function execute( $subPage ) {
		parent::execute( $subPage );

		$org = EPOrg::selectRow( null, array( 'name' => $subPage ) );

		if ( $org === false ) {
			// TODO
		}
		else {
			$this->displayRevisions( $org );
		}
	}



}
