<?php

/**
 * File holding the SPSSpecialSeriesEdit class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSSpecialSeriesEdit class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSSpecialSeriesEdit extends SpecialPage {

	public function __construct() {
		parent::__construct( 'SeriesEdit' );
	}

	public function execute( $parameters ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		if ( $wgRequest->getCheck( 'wpDiff' ) ) {
			// no support for the diff action
			throw new SPSException( wfMsg( 'spserror_diffnotsupported' ) );
		} elseif ( $wgRequest->getCheck( 'wpPreview' ) ) {

			// no support for the preview action
			throw new SPSException( wfMsg( 'spserror_previewnotsupported' ) );
		} elseif ( $wgRequest->getCheck( 'wpSave' ) ) {

			// saving requested

			$this->evaluateForm( $wgRequest );
		} elseif ( isset( $_SESSION ) && isset( $_SESSION['spsForm'] ) && isset( $_SESSION['spsResult'] ) ) {

			// cookies enabled and result data stored
			$wgOut->setPageTitle( wfMsg( 'spssuccesstitle', $_SESSION['spsForm'] ) );
			$wgOut->addHTML( wfMsg( 'spssuccess', $_SESSION['spsResult'] ) );
			
			unset( $_SESSION['spsForm'] );
			unset( $_SESSION['spsResult'] );
			
		} elseif ( !isset( $_SESSION ) && count( $_GET ) === 2 ) {

			// cookies disabled, try getting result data from URL
			$get = $_GET;
			unset( $get['title'] );
			$keys = array_keys( $get );

			$wgOut->setPageTitle( wfMsg( 'spssuccesstitle', $keys[0] ) );
			$wgOut->addHTML( wfMsg( 'spssuccess', $get[$keys[0]] ) );
		} else {

			// no action requested, show form
			$this->printForm( $parameters, $wgRequest );
		}
	}

	private function printForm( &$parameters, WebRequest &$request ) {

		global $wgOut, $sfgFormPrinter;

		// Prepare parameters for SFFormPrinter::formHTML
		// there is no ONE target page
		$targetTitle = null;

		// formDefinition
		$formName = $request->getText( 'form' );

		// if query string did not contain these variables, try the URL
		if ( $formName === '' ) {
			$queryparts = explode( '/', $parameters );
			$formName = isset( $queryparts[0] ) ? $queryparts[0] : null;

			// if the form name wasn't in the URL either, throw an error
			if ( is_null( $formName ) || $formName === '' ) {
				throw new SPSException( wfMsg( 'spserror_noformname' ) );
			}
		}

		$formTitle = Title::makeTitleSafe( SF_NS_FORM, $formName );

		if ( !$formTitle->exists() ) {
			throw new SPSException( wfMsg( 'spserror_formunknown', $formName ) );
		}

		$formArticle = new Article( $formTitle );
		$formDefinition = StringUtils::delimiterReplace( '<noinclude>', '</noinclude>', '', $formArticle->getContent() );

		// formSubmitted
		$formSubmitted = false;

		// pageContents
		$pageContents = null;

		// get 'preload' query value, if it exists
		if ( $request->getCheck( 'preload' ) ) {
			$pageContents = SFFormUtils::getPreloadedText( $request->getVal( 'preload' ) );
		} else {
			// let other extensions preload the page, if they want
			wfRunHooks( 'sfEditFormPreloadText', array(&$pageContents, $targetTitle, $formTitle) );
		}

		// pageIsSource
		$pageIsSource = ( $pageContents != null );

		// pageNameFormula
		// parse the form to see if it has a 'page name' value set
		$matches;
		if ( preg_match( '/{{{info.*page name\s*=\s*(.*)}}}/m', $formDefinition, $matches ) ) {
			$pageNameElements = SFUtils::getFormTagComponents( $matches[1] );
			$pageNameFormula = $pageNameElements[0];
		} else {
			return 'sf_formedit_badurl';
		}

		// get the iterator parameters
		$iteratorData = $this->buildIteratorParameters( $request );

		// Call SFFormPrinter::formHTML
		list ( $formText, $javascriptText, $dataText, $formPageTitle, $generatedPageName ) =
			$sfgFormPrinter->formHTML( $formDefinition, $formSubmitted, $pageIsSource, $formArticle->getID(), $pageContents, '', $pageNameFormula );

		// Set Special page main header;
		// override the default title for this page if a title was specified in the form
		if ( $formPageTitle != null ) {
			$wgOut->setPageTitle( $formPageTitle );
		} else {
			$wgOut->setPageTitle( wfMsg( 'sf_formedit_createtitlenotarget', $formTitle->getText() ) );
		}

		$preFormHtml = '';
		wfRunHooks( 'sfHTMLBeforeForm', array(&$targetTitle, &$preFormHtml) );

		$text = '<form name="createbox" id="sfForm" action="" method="post" class="createbox">'
			. $preFormHtml
			. "\n"
			. SFFormUtils::hiddenFieldHTML( 'iteratordata', $iteratorData )
			. $formText;

		SFUtils::addJavascriptAndCSS();

		if ( !empty( $javascriptText ) ) {
			$wgOut->addScript( '		<script type="text/javascript">' . "\n$javascriptText\n" . '</script>' . "\n" );
		}

		$wgOut->addHTML( $text );

		return null;
	}

	private function evaluateForm( WebRequest &$request ) {

		global $wgOut, $spsgIterators;

		$requestValues = $_POST;

		if ( array_key_exists( 'iteratordata', $requestValues ) ) {
			$iteratorData = FormatJson::decode( $requestValues['iteratordata'], true );
			unset( $requestValues['iteratordata'] );
		} else {
			throw new SPSException(  wfMsg( 'spserror_noiteratordata' ) );
		}

		$iteratorName = null;
		$targetFormName = null;
		$targetFieldName = null;

		foreach ( $iteratorData as $param => $value ) {

			switch ( $param ) {
				case 'iterator':
					// iteratorName
					$iteratorName = $value;
					break;
				case 'targetform':
					$targetFormName = $value;
					break;
				case 'targetfield':
					$targetFieldName = $value;
					break;
				default :
					$iteratorParams[$param] = $this->getAndRemoveFromArray( $requestValues, $value );
			}
		}

		if ( is_null( $iteratorName ) || $iteratorName === '' ) {
			throw new SPSException( wfMsg( 'spserror_noiteratorname' ) );
		}

		if ( !array_key_exists( $iteratorName, $spsgIterators ) ) {
			throw new SPSException( wfMsg( 'spserror_iteratorunknown', $iteratorName ) );
		}

		// iterator
		$iterator = new $spsgIterators[$iteratorName];

		$iteratorValues = $iterator->getValues( $iteratorParams );
		$iteratorValuesCount = count( $iteratorValues );
		$userlimit = $this->getPageGenerationLimit();
		
		// check userlimit
		if ( $iteratorValuesCount > $userlimit ) {
			throw new SPSException( wfMsg( 'spserror_pagegenerationlimitexeeded', $iteratorValuesCount, $userlimit ) );
		}
		
		$targetFormTitle = Title::makeTitleSafe( SF_NS_FORM, $targetFormName );

		foreach ( $iteratorValues as $value ) {
			SFAutoeditAPI::addToArray( $requestValues, $targetFieldName, $value, true );
			wfDebugLog( 'sps', 'Insert SPSPageCreationJob' );
			$job = new SPSPageCreationJob( $targetFormTitle, $requestValues );
			$job->insert();
		}

		if ( isset( $_SESSION ) ) {
			// cookies enabled
			$request->setSessionData( 'spsResult', $iteratorValuesCount );
			$request->setSessionData( 'spsForm', $targetFormName );
			header( 'Location: ' . $this->getTitle()->getFullURL() );
		} else {

			// cookies disabled, write result data to URL
			header( 'Location: ' . $this->getTitle()->getFullURL() . '?' . "$targetFormName=" . $iteratorValuesCount );
		}

		return null;
	}

	/**
	 * Builds a JSON blob of the data required to use the iterator.
	 * @param WebRequest $request
	 * @return type 
	 */
	private function buildIteratorParameters( WebRequest &$request ) {

		global $spsgIterators;

		// iteratorName
		$iteratorName = $request->getVal( 'iterator' );

		if ( is_null( $iteratorName ) ) {
			throw new SPSException( wfMsg( 'spserror_noiteratorname' ) );
		}

		if ( !array_key_exists( $iteratorName, $spsgIterators ) ) {
			throw new SPSException( wfMsg( 'spserror_iteratorunknown', $iteratorName ) );
		}

		// iterator
		$iterator = new $spsgIterators[$iteratorName];

		// targetFormName
		$targetFormName = $request->getVal( 'target_form' );

		if ( is_null( $targetFormName ) ) {
			throw new SPSException( wfMsg( 'spserror_notargetformname' ) );
		}

		// targetFormTitle is not really needed at this stage,
		// but we throw an error early if it does not exist
		$targetFormTitle = Title::makeTitleSafe( SF_NS_FORM, $targetFormName );

		if ( !$targetFormTitle->exists() ) {
			throw new SPSException( wfMsg( 'spserror_formunknown', $targetFormName ) );
		}

		// targetFieldName
		$targetFieldName = $request->getVal( 'target_field' );

		if ( is_null( $targetFieldName ) ) {
			throw new SPSException( wfMsg( 'spserror_notargetfieldname' ) );
		}

		$params = array(
			'iterator' => $iteratorName,
			'targetform' => $targetFormName,
			'targetfield' => $targetFieldName
		);

		$paramNames = $iterator->getParameterNames();
		$errors = '';

		foreach ( $paramNames as $paramName ) {

			$param = $request->getVal( $paramName );

			if ( is_null( $param ) ) {
				$errors .= "$paramName\n";
			}
			$params[$paramName] = $param;
		}

		if ( $errors !== '' ) {
			throw new SPSException( wfMsg( 'spserror_iteratorparammissing', $errors ) );
		}

		return FormatJson::encode( $params );
	}

	/**
	 * This function recursively retrieves a value from an array of arrays and deletes it.
	 * $key identifies path.
	 * Format: 1stLevelName[2ndLevel][3rdLevel][...], i.e. normal array notation
	 * $toplevel: if this is a toplevel value.
	 *
	 * @param type $array
	 * @param type $key
	 * @param type $toplevel 
	 */
	private function getAndRemoveFromArray( &$array, $key, $toplevel = true ) {

		$matches = array();

		if ( array_key_exists( $key, $array ) ) {
			$value = $array[$key];
			unset( $array[$key] );
			return $value;
		} elseif ( preg_match( '/^([^\[\]]*)\[([^\[\]]*)\](.*)/', $key, $matches ) ) {

			// for some reason toplevel keys get their spaces encoded by MW.
			// We have to imitate that.
			// FIXME: Are there other cases than spaces?
			if ( $toplevel ) {
				$key = str_replace( ' ', '_', $matches[1] );
			} else {
				$key = $matches[1];
			}

			if ( !array_key_exists( $key, $array ) ) {
				return null;
			}

			$value = $this->getAndRemoveFromArray( $array[$key], $matches[2] . $matches[3], false );

			if ( empty( $array[$key] ) ) {
				unset( $array[$key] );
			}

			return $value;
		} else {
			// key not found in array
			return null;
		}
	}

	public function getPageGenerationLimit() {
		global $wgUser, $spsgPageGenerationLimits;
		
		$limit = 0;
		$groups = $wgUser->getEffectiveGroups();
		
		foreach ( $groups as $group ) {
			if ( array_key_exists( $group, $spsgPageGenerationLimits) ) {
				$limit = max($limit, $spsgPageGenerationLimits[$group]);
			}
		}
		
		return $limit;
	}
}
