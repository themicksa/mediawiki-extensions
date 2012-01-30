<?php

/**
 * Abstract action for viewing EPDBObject items.
 *
 * @since 0.1
 *
 * @file EPViewAction.php
 * @ingroup EducationProgram
 * @ingroup Action
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class EPViewAction extends FormlessAction {

	protected function getDescription() {
		return '';
	}

	/**
	 * Returns the class name of the EPDBObject this action handles.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	protected abstract function getItemClass();

	/**
	 *
	 *
	 * @return String HTML
	 */
	public function onView() {
		$out = $this->getOutput();
		$name = $this->getTitle()->getText();
		$class = $this->getItemClass();

		$object = false;

		if ( $this->getRequest()->getCheck( 'revid' ) ) {
			$currentObject = $class::get( $name, 'id' );

			if ( $currentObject !== false ) {
				$rev = EPRevision::selectRow( null, array(
					'id' => $this->getRequest()->getInt( 'revid' ),
					'object_id' => $currentObject->getField( 'id' )
				) );

				if ( $rev === false ) {
					// TODO
				}
				else {
					$object = $rev->getObject();
					$this->displayRevisionNotice( $rev );
				}
			}
		}

		if ( $object === false ) {
			$object = $class::get( $name );
		}

		if ( $object === false ) {
			$this->displayNavigation();

			if ( $this->getUser()->isAllowed( $class::getEditRight() ) ) {
				$out->redirect( $this->getTitle()->getLocalURL( array( 'action' => 'edit' ) ) );
			}
			else {
				$out->addWikiMsg( strtolower( get_called_class() ) . '-none', $name );
			}
		}
		else {
			$this->displayPage( $object );
		}

		return '';
	}

	protected function displayRevisionNotice( EPRevision $rev ) {
		$lang = $this->getLanguage();

		$current = false; // TODO
		$td = $lang->timeanddate( $rev->getField( 'time' ), true );
		$tddate = $lang->date( $rev->getField( 'time' ), true );
		$tdtime = $lang->time( $rev->getField( 'time' ), true );

		$userToolLinks = Linker::userLink(  $rev->getUser()->getId(), $rev->getUser()->getName() )
			. Linker::userToolLinks( $rev->getUser()->getId(), $rev->getUser()->getName() );

		$infomsg = $current && !wfMessage( 'revision-info-current' )->isDisabled()
			? 'revision-info-current'
			: 'revision-info';

		$this->getOutput()->setSubtitle(
			"<div id=\"mw-{$infomsg}\">" .
				wfMessage( $infomsg, $td )->rawParams( $userToolLinks )->params(
					$rev->getId(),
					$tddate,
					$tdtime,
					$rev->getUser()
				)->parse() .
				"</div>"
		);
	}

	protected function displayPage( EPDBObject $object ) {
		$this->displayNavigation();

		$this->displaySummary( $object );
	}

	/**
	 * Adds a navigation menu with the provided links.
	 * Links should be provided in an array with:
	 * label => Title (object)
	 *
	 * @since 0.1
	 *
	 * @param array $items
	 */
	protected function displayNavigation( array $items = array() ) {
		$links = array();
		$items = array_merge( $this->getDefaultNavigationItems(), $items );

		foreach ( $items as $label => $data ) {
			if ( is_array( $data ) ) {
				$target = array_shift( $data );
				$attribs = $data;
			}
			else {
				$target = $data;
				$attribs = array();
			}

			$links[] = Linker::linkKnown(
				$target,
				htmlspecialchars( $label ),
				$attribs
			);
		}

		$this->getOutput()->addHTML(
			Html::rawElement( 'p', array(), $this->getLanguage()->pipeList( $links ) )
		);
	}

	/**
	 * Returns the default nav items for @see displayNavigation.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected function getDefaultNavigationItems() {
		$items = array(
			wfMsg( 'ep-nav-orgs' ) => SpecialPage::getTitleFor( 'Institutions' ),
			wfMsg( 'ep-nav-courses' ) => SpecialPage::getTitleFor( 'Courses' ),
		);

		$items[wfMsg( 'ep-nav-students' )] = SpecialPage::getTitleFor( 'Students' );

		if ( EPStudent::has( array( 'user_id' => $this->getUser()->getId() ) ) ) {
			$items[wfMsg( 'ep-nav-mycourses' )] = SpecialPage::getTitleFor( 'MyCourses' );
		}

		return $items;
	}

	/**
	 * Display the summary data.
	 *
	 * @since 0.1
	 *
	 * @param EPDBObject $item
	 * @param boolean $collapsed
	 * @param array $summaryData
	 */
	protected function displaySummary( EPDBObject $item, $collapsed = false, array $summaryData = null ) {
		$out = $this->getOutput();

		$class = 'wikitable ep-summary mw-collapsible';

		if ( $collapsed ) {
			$class .= ' mw-collapsed';
		}

		$out->addHTML( Html::openElement( 'table', array( 'class' => $class ) ) );

		$out->addHTML( '<tr>' . Html::element( 'th', array( 'colspan' => 2 ), wfMsg( 'ep-item-summary' ) ) . '</tr>' );

		$summaryData = is_null( $summaryData ) ? $this->getSummaryData( $item ) : $summaryData;

		foreach ( $summaryData as $stat => $value ) {
			$out->addHTML( '<tr>' );

			$out->addHTML( Html::element(
				'th',
				array( 'class' => 'ep-summary-name' ),
				wfMsg( strtolower( get_called_class() ) . '-summary-' . $stat )
			) );

			$out->addHTML( Html::rawElement(
				'td',
				array( 'class' => 'ep-summary-value' ),
				$value
			) );

			$out->addHTML( '</tr>' );
		}

		$out->addHTML( Html::closeElement( 'table' ) );
	}

	/**
	 * Gets the summary data.
	 * Returned values must be escaped.
	 *
	 * @since 0.1
	 *
	 * @param EPDBObject $item
	 *
	 * @return array
	 */
	protected function getSummaryData( EPDBObject $item ) {
		return array();
	}
	
}