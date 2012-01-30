<?php

/**
 * Action for viewing an org.
 *
 * @since 0.1
 *
 * @file ViewOrgAction.php
 * @ingroup EducationProgram
 * @ingroup Action
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ViewOrgAction extends EPViewAction {
	
	public function getName() {
		return 'vieworg';
	}

	/**
	 * 
	 *
	 * @return String HTML
	 */
	public function onView() {
		$out = $this->getOutput();
		
		$name = $this->getTitle()->getText();
		
		$out->setPageTitle( wfMsgExt( 'ep-institution-title', 'parsemag', $name ) );

		$org = EPOrg::get( $name );

		if ( $org === false ) {
			if ( $this->getUser()->isAllowed( 'ep-org' ) ) {
				$out->redirect( $this->getTitle()->getLocalURL( array( 'action' => 'edit' ) ) );
			}
			else {
				$out->addWikiMsg( 'ep-institution-none', $name );
			}
		}
		else {
			$this->displayNavigation();

			$this->displaySummary( $org );

			$out->addHTML( Html::element( 'h2', array(), wfMsg( 'ep-institution-courses' ) ) );

			EPCourse::displayPager( $this->getContext(), array( 'org_id' => $org->getId() ) );

			if ( $this->getUser()->isAllowed( 'ep-course' ) ) {
				$out->addHTML( Html::element( 'h2', array(), wfMsg( 'ep-institution-add-course' ) ) );

				EPCourse::displayAddNewControl( $this->getContext(), array( 'org' => $org->getId() ) );
			}
		}

		return '';
	}
	
	/**
	 * Gets the summary data.
	 *
	 * @since 0.1
	 *
	 * @param EPOrg $org
	 *
	 * @return array
	 */
	protected function getSummaryData( EPDBObject $org ) {
		$stats = array();

		$stats['name'] = $org->getField( 'name' );
		$stats['city'] = $org->getField( 'city' );

		$countries = CountryNames::getNames( $this->getLanguage()->getCode() );
		$stats['country'] = $countries[$org->getField( 'country' )];

		$stats['status'] = wfMsgHtml( $org->getField( 'active' ) ? 'ep-institution-active' : 'ep-institution-inactive' );

		$stats['courses'] = $this->getLanguage()->formatNum( $org->getField( 'courses' ) );
		$stats['students'] = $this->getLanguage()->formatNum( $org->getField( 'students' ) );

		foreach ( $stats as &$stat ) {
			$stat = htmlspecialchars( $stat );
		}

		if ( $org->getField( 'courses' ) > 0 ) {
			$stats['courses'] = Linker::linkKnown(
				SpecialPage::getTitleFor( 'Courses' ),
				$stats['courses'],
				array(),
				array( 'org_id' => $org->getId() )
			);
		}

		return $stats;
	}
	
}