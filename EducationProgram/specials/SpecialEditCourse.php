<?php

/**
 * Addition and modification interface for courses.
 *
 * @since 0.1
 *
 * @file SpecialEditCourse.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialEditCourse extends SpecialEPFormPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'EditCourse', 'ep-course', 'EPCourse', 'Courses', 'Course' );

		$this->getOutput()->addModules( 'ep.datepicker' );
	}

	/**
	 * (non-PHPdoc)
	 * @see SpecialEPFormPage::getFormFields()
	 * @return array
	 */
	protected function getFormFields() {
		$fields = parent::getFormFields();

		$orgOptions = EPOrg::getOrgOptions();

		$fields['name'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-name',
			'required' => true,
		);

		$fields['org_id'] = array (
			'type' => 'select',
			'label-message' => 'ep-course-edit-org',
			'required' => true,
			'options' => $orgOptions,
			'validation-callback' => function ( $value, array $alldata = null ) use ( $orgOptions ) {
				return in_array( (int)$value, array_values( $orgOptions ) ) ? true : wfMsg( 'ep-course-invalid-org' );
			},
		);

		$fields['token'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-token',
			'maxlength' => 255,
			'required' => true,
			'size' => 20,
			'validation-callback' => function ( $value, array $alldata = null ) {
				$strLen = strlen( $value );
				return ( $strLen !== 0 && $strLen < 2 ) ? wfMsgExt( 'ep-course-invalid-token', 'parsemag', 2 ) : true;
			} ,
		);

		$fields['term'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-term',
			'required' => true,
		);

		$fields['start'] = array (
			'class' => 'EPHTMLDateField',
			'label-message' => 'ep-course-edit-start',
			'required' => true,
		);

		$fields['end'] = array (
			'class' => 'EPHTMLDateField',
			'label-message' => 'ep-course-edit-end',
			'required' => true,
		);

		$fields['field'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-field',
			'required' => true,
		);

		$fields['level'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-level',
			'required' => true,
		);

		$langOptions = EPUtils::getLanguageOptions( $this->getLanguage()->getCode() );
		$fields['lang'] = array (
			'type' => 'select',
			'label-message' => 'ep-course-edit-lang',
			'maxlength' => 255,
			'required' => true,
			'options' => $langOptions,
			'validation-callback' => function ( $value, array $alldata = null ) use ( $langOptions ) {
				return in_array( $value, $langOptions ) ? true : wfMsg( 'ep-course-invalid-lang' );
			}
		);

		$fields['mc'] = array (
			'type' => 'text',
			'label-message' => 'ep-course-edit-mc',
			'required' => true,
		);

		$fields['description'] = array (
			'type' => 'textarea',
			'label-message' => 'ep-course-edit-description',
			'required' => true,
			'validation-callback' => function ( $value, array $alldata = null ) {
				return strlen( $value ) < 10 ? wfMsgExt( 'ep-course-invalid-description', 'parsemag', 10 ) : true;
			} ,
			'rows' => 10,
			'id' => 'wpTextbox1',
		);

		return $this->processFormFields( $fields );
	}

	/**
	 * (non-PHPdoc)
	 * @see SpecialEPFormPage::getNewData()
	 */
	protected function getNewData() {
		return array(
			'org_id' => $this->getRequest()->getVal( 'neworg' ),
			'name' => wfMsgExt(
				'ep-course-edit-name-format',
				'parsemag',
				$this->getRequest()->getVal( 'newname' ),
				$this->getRequest()->getVal( 'newterm' )
			),
			'term' => $this->getRequest()->getVal( 'newterm' ),
			'mc' => $this->getRequest()->getVal( 'newname' ),
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see SpecialEPFormPage::handleKnownField()
	 */
	protected function handleKnownField( $name, $value ) {
		if ( in_array( $name, array( 'end', 'start' ) ) ) {
			$value = wfTimestamp( TS_MW, strtotime( $value ) );
		}

		return $value;
	}

}
