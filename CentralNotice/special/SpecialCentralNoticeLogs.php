<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CentralNotice extension\n";
	exit( 1 );
}

class SpecialCentralNoticeLogs extends UnlistedSpecialPage {
	public $logType = 'campaignsettings';
	
	function __construct() {
		// Register special page
		parent::__construct( "CentralNoticeLogs" );
	}
	
	/**
	 * Handle different types of page requests
	 */
	function execute( $sub ) {
		global $wgOut, $wgRequest, $wgExtensionAssetsPath;
		
		if ( $wgRequest->wasPosted() ) {
			$this->logType = $wgRequest->getText( 'log', 'campaignsettings' );
		}

		// Begin output
		$this->setHeaders();
		
		// Add style file to the output headers
		$wgOut->addExtensionStyle( "$wgExtensionAssetsPath/CentralNotice/centralnotice.css" );
		
		// Add script file to the output headers
		$wgOut->addScriptFile( "$wgExtensionAssetsPath/CentralNotice/centralnotice.js" );

		// Initialize error variable
		$this->centralNoticeError = false;

		// Show summary
		$wgOut->addWikiMsg( 'centralnotice-summary' );

		// Show header
		CentralNotice::printHeader();

		// Begin Banners tab content
		$wgOut->addHTML( Xml::openElement( 'div', array( 'id' => 'preferences' ) ) );
		
		$htmlOut = '';
		
		// Begin log selection fieldset
		$htmlOut .= Xml::openElement( 'fieldset', array( 'class' => 'prefsection' ) );
		
		$htmlOut .= Xml::openElement( 'form', array( 'method' => 'post' ) );
		$htmlOut .= Xml::element( 'h2', null, wfMsg( 'centralnotice-view-logs' ) );
		$htmlOut .= Xml::closeElement( 'form' );
		
		// End log selection fieldset
		// Uncomment when we have multiple logs
		//$htmlOut .= Xml::closeElement( 'fieldset' );

		$wgOut->addHTML( $htmlOut );
		
		$this->showLog( $this->logType );

		// End Banners tab content
		$wgOut->addHTML( Xml::closeElement( 'div' ) );
	}
	
	/**
	 * Show a log.
	 */
	function showLog( $logType ) {
		global $wgOut;
		
		$pager = new CentralNoticeLogPager( $this );
		$htmlOut = '';
		
		// Begin log fieldset
		// Uncomment when we have multiple logs
		//$htmlOut .= Xml::openElement( 'fieldset', array( 'class' => 'prefsection' ) );
		
		// Show paginated list of log entries
		$htmlOut .= Xml::tags( 'div', 
			array( 'class' => 'cn-pager' ), 
			$pager->getNavigationBar() );
		$htmlOut .= $pager->getBody();
		$htmlOut .= Xml::tags( 'div', 
			array( 'class' => 'cn-pager' ), 
			$pager->getNavigationBar() );
		
		// End log fieldset
		$htmlOut .= Xml::closeElement( 'fieldset' );

		$wgOut->addHTML( $htmlOut );
	}

}

class CentralNoticeLogPager extends ReverseChronologicalPager {
	var $viewPage, $special;

	function __construct( $special ) {
		$this->special = $special;
		parent::__construct();
		
		// Override paging defaults
		list( $this->mLimit, /* $offset */ ) = $this->mRequest->getLimitOffset( 20, '' );
		$this->mLimitsShown = array( 20, 50, 100 );
		
		$this->viewPage = SpecialPage::getTitleFor( 'CentralNotice' );
	}
	
	/**
	 * Sort the log list by timestamp
	 */
	function getIndexField() {
		return 'notlog_timestamp';
	}
	
	/**
	 * Pull log entries from the database
	 */
	function getQueryInfo() {
		return array(
			'tables' => array( 'cn_notice_log' ),
			'fields' => '*',
		);
	}
	
	/**
	 * Generate the content of each table row (1 row = 1 log entry)
	 */
	function formatRow( $row ) {
		global $wgLang, $wgExtensionAssetsPath;
		
		// Create a user object so we can pull the name, user page, etc.
		$loggedUser = User::newFromId( $row->notlog_user_id );
		// Create the user page link
		$userLink = $this->getSkin()->makeLinkObj( $loggedUser->getUserPage(), 
			$loggedUser->getName() );
		$userTalkLink = $this->getSkin()->makeLinkObj( $loggedUser->getTalkPage(), 
			wfMsg ( 'centralnotice-talk-link' ) );
		
		// Create the campaign link
		$campaignLink = $this->getSkin()->makeLinkObj( $this->viewPage,
			htmlspecialchars( $row->notlog_not_name ),
			'method=listNoticeDetail&notice=' . urlencode( $row->notlog_not_name ) );
				
		// Begin log entry primary row
		$htmlOut = Xml::openElement( 'tr' );
		
		$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top' ) );
		if ( $row->notlog_action !== 'removed' ) {
			$htmlOut .= '<a href="javascript:toggleDisplay(\''.$row->notlog_id.'\')">'.
				'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/collapsed.png" id="cn-collapsed-'.$row->notlog_id.'" style="display:block;vertical-align:baseline;"/>'.
				'<img src="'.$wgExtensionAssetsPath.'/CentralNotice/uncollapsed.png" id="cn-uncollapsed-'.$row->notlog_id.'" style="display:none;vertical-align:baseline;"/>'.
				'</a>';
		}
		$htmlOut .= Xml::closeElement( 'td' );
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$wgLang->date( $row->notlog_timestamp ) . ' ' . $wgLang->time( $row->notlog_timestamp )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			wfMsg ( 'centralnotice-user-links', $userLink, $userTalkLink )
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$row->notlog_action
		);
		$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top', 'class' => 'primary' ),
			$campaignLink
		);
		$htmlOut .= Xml::tags( 'td', array(),
			'&nbsp;'
		);
		
		// End log entry primary row
		$htmlOut .= Xml::closeElement( 'tr' );
		
		if ( $row->notlog_action !== 'removed' ) {
			// Begin log entry secondary row
			$htmlOut .= Xml::openElement( 'tr', array( 'id' => 'cn-log-details-'.$row->notlog_id, 'style' => 'display:none;' ) );
			
			$htmlOut .= Xml::tags( 'td', array( 'valign' => 'top' ),
				'&nbsp;' // force a table cell in older browsers
			);
			$htmlOut .= Xml::openElement( 'td', array( 'valign' => 'top', 'colspan' => '5' ) );
			if ( $row->notlog_action == 'created' ) {
				$htmlOut .= $this->showInitialSettings( $row );
			} else if ( $row->notlog_action == 'modified' ) {
				$htmlOut .= $this->showChanges( $row );
			}
			$htmlOut .= Xml::closeElement( 'td' );
			
			// End log entry primary row
			$htmlOut .= Xml::closeElement( 'tr' );
		}
		
		return $htmlOut;
	}
	
	function showInitialSettings( $row ) {
		global $wgLang;
		$details = '';
		$details .= '<b>'.wfMsg ( 'centralnotice-start-date' ).':</b> '.
			$wgLang->date( $row->notlog_end_start ).' '.
			$wgLang->time( $row->notlog_end_start )."<br/>";
		$details .= '<b>'.wfMsg ( 'centralnotice-end-date' ).':</b> '.
			$wgLang->date( $row->notlog_end_end ).' '.
			$wgLang->time( $row->notlog_end_end )."<br/>";
		$details .= '<b>'.wfMsg ( 'centralnotice-projects' ).':</b> '.
			$row->notlog_end_projects."<br/>";
		$language_count = count( explode ( ', ', $row->notlog_end_languages ) );
		$languageList = '';
		if ( $language_count > 15 ) {
			$languageList = wfMsg ( 'centralnotice-multiple-languages', $language_count );
		} elseif ( $language_count > 0 ) {
			$languageList = $row->notlog_end_languages;
		}
		$details .= '<b>'.wfMsg ( 'centralnotice-languages' ).':</b> '.
			$languageList."<br/>";
		$details .= '<b>'.wfMsg ( 'centralnotice-geo' ).':</b> ';
		$details .= $row->notlog_end_geo ? 'on' : 'off';
		$details .= "<br/>";
		if ( $row->notlog_end_geo ) {
			$country_count = count( explode ( ', ', $row->notlog_end_countries ) );
			$countryList = '';
			if ( $country_count > 20 ) {
				$countryList = wfMsg ( 'centralnotice-multiple-countries', $country_count );
			} elseif ( $country_count > 0 ) {
				$countryList = $row->notlog_end_countries;
			}
			$details .= '<b>'.wfMsg ( 'centralnotice-countries' ).':</b> '.
				$countryList."<br/>";
		}
		return $details;
	}
	
	function showChanges( $row ) {
		global $wgLang;
		$details = '';
		if ( $row->notlog_begin_start !== $row->notlog_end_start ) {
			$details .= '<b>'.wfMsg ( 'centralnotice-start-date' ).':</b> ';
			$details .= wfMsg ( 'centralnotice-changed', 
				$wgLang->date( $row->notlog_begin_start ).' '.$wgLang->time( $row->notlog_begin_start ), 
				$wgLang->date( $row->notlog_end_start ).' '.$wgLang->time( $row->notlog_end_start ) )."<br/>";
		}
		if ( $row->notlog_begin_end !== $row->notlog_end_end ) {
			$details .= '<b>'.wfMsg ( 'centralnotice-end-date' ).':</b> ';
			$details .= wfMsg ( 'centralnotice-changed', 
				$wgLang->date( $row->notlog_begin_end ).' '.$wgLang->time( $row->notlog_begin_end ), 
				$wgLang->date( $row->notlog_end_end ).' '.$wgLang->time( $row->notlog_end_end ) )."<br/>";
		}
		$details .= $this->testBooleanChange( 'enabled', $row );
		$details .= $this->testBooleanChange( 'preferred', $row );
		$details .= $this->testBooleanChange( 'locked', $row );
		$details .= $this->testBooleanChange( 'geo', $row );
		$details .= $this->testSetChange( 'projects', $row );
		$details .= $this->testSetChange( 'languages', $row );
		$details .= $this->testSetChange( 'countries', $row );
		if ( $row->notlog_begin_banners !== $row->notlog_end_banners ) {
			// Show changes to banner weights and assignment
			$beginBannersObject = json_decode( $row->notlog_begin_banners );
			$endBannersObject = json_decode( $row->notlog_end_banners );
			$beginBanners = array();
			$endBanners = array();
			foreach( $beginBannersObject as $key => $weight ) {
				$beginBanners[$key] = $key.' ('.$weight.')';
			}
			foreach( $endBannersObject as $key => $weight ) {
				$endBanners[$key] = $key.' ('.$weight.')';
			}
			$details .= '<b>'.wfMsg ( 'centralnotice-templates' ).':</b> ';
			if ( $beginBanners ) {
				$before = implode( ', ', $beginBanners );
			} else {
				$before = wfMsg ( 'centralnotice-no-assignments' );
			}
			if ( $endBanners ) {
				$after = implode( ', ', $endBanners );
			} else {
				$after = wfMsg ( 'centralnotice-no-assignments' );
			}
			$details .= wfMsg ( 'centralnotice-changed', $before, $after) . "<br/>";
		}
		return $details;
	}
	
	private function testBooleanChange( $param, $row ) {
		$result = '';
		$beginField = 'notlog_begin_'.$param;
		$endField = 'notlog_end_'.$param;
		if ( $row->$beginField !== $row->$endField ) {
			$result .= '<b>'.wfMsg ( 'centralnotice-'.$param ).':</b> ';
			$result .= wfMsg ( 'centralnotice-changed', 
				( $row->$beginField ? wfMsg ( 'centralnotice-on' ) : wfMsg ( 'centralnotice-off' ) ), 
				( $row->$endField ? wfMsg ( 'centralnotice-on' ) : wfMsg ( 'centralnotice-off' ) ) )."<br/>";
		}
		return $result;
	}
	
	private function testSetChange( $param, $row ) {
		$result = '';
		$beginField = 'notlog_begin_'.$param;
		$endField = 'notlog_end_'.$param;
		if ( $row->$beginField !== $row->$endField ) {
			$beginSet = array();
			$endSet = array();
			if ( $row->$beginField ) {
				$beginSet = explode( ', ', $row->$beginField );
			}
			if ( $row->$endField ) {
				$endSet = explode( ', ', $row->$endField );
			}
			$added = array_diff( $endSet, $beginSet );
			$removed = array_diff( $beginSet, $endSet );
			$result .= '<b>'.wfMsg ( 'centralnotice-'.$param ).':</b> ';
			if ( $added ) {
				$result .= wfMsg ( 'centralnotice-added', implode( ', ', $added ) );
				if ( $removed ) {
					$result .= '; ';
				} else {
					$result .= '<br/>';
				}
			}
			if ( $removed ) {
				$result .= wfMsg ( 'centralnotice-removed', implode( ', ', $removed ) ).'<br/>';
			}
		}
		return $result;
	}
	
	/**
	 * Specify table headers
	 */
	function getStartBody() {
		$htmlOut = '';
		$htmlOut .= Xml::openElement( 'table', array( 'id' => 'cn-campaign-logs', 'cellpadding' => 3 ) );
		$htmlOut .= Xml::openElement( 'tr' );
		$htmlOut .= Xml::element( 'th', array( 'style' => 'width: 20px;' ) );
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 130px;' ),
			 wfMsg ( 'centralnotice-timestamp' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 160px;' ),
			 wfMsg ( 'centralnotice-user' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 100px;' ),
			 wfMsg ( 'centralnotice-action' )
		);
		$htmlOut .= Xml::element( 'th', array( 'align' => 'left', 'style' => 'width: 160px;' ),
			wfMsg ( 'centralnotice-notice' )
		);
		$htmlOut .= Xml::tags( 'td', array(),
			'&nbsp;'
		);
		$htmlOut .= Xml::closeElement( 'tr' );
		return $htmlOut;
	}
	
	/**
	 * Close table
	 */
	function getEndBody() {
		$htmlOut = '';
		$htmlOut .= Xml::closeElement( 'table' );
		return $htmlOut;
	}
}
