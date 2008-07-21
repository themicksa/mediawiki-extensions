<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

wfLoadExtensionMessages( 'RatingHistory' );
class RatingHistory extends UnlistedSpecialPage
{
    function __construct() {
        UnlistedSpecialPage::UnlistedSpecialPage( 'RatingHistory', 'feedback' );
    }

    function execute( $par ) {
        global $wgRequest, $wgUser, $wgOut;
		$this->setHeaders();
		if( $wgUser->isAllowed( 'feedback' ) ) {
			if( $wgUser->isBlocked() ) {
				$wgOut->blockedPage();
				return;
			}
		} else {
			$wgOut->permissionRequired( 'feedback' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		$this->skin = $wgUser->getSkin();
		# Our target page
		$this->target = $wgRequest->getText( 'target' );
		$this->page = Title::newFromUrl( $this->target );
		# We need a page...
		if( is_null($this->page) ) {
			$wgOut->showErrorPage( 'notargettitle', 'notargettext' );
			return;
		}
		$period = $wgRequest->getInt( 'period' );
		$validPeriods = array(30,365,1095);
		if( !in_array($period,$validPeriods) ) {
			$period = 30; // default
		}
		$this->period = $period;
		
		$this->showHeader();
		$this->showForm();
		$this->showGraphs();
	}
	
	protected function showHeader() {
		global $wgOut;
		$wgOut->addWikiText( wfMsg('ratinghistory-text',$this->page->getPrefixedText()) );
	}
	
	protected function showForm() {
		global $wgOut, $wgTitle, $wgScript;
		$form = Xml::openElement( 'form',
			array( 'name' => 'reviewedpages', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset><legend>".wfMsg('ratinghistory-leg')."</legend>\n";
		$form .= Xml::hidden( 'title', $wgTitle->getPrefixedDBKey() );
		$form .= Xml::hidden( 'target', $this->page->getPrefixedDBKey() );
		$form .= $this->getPeriodMenu( $this->period );
		$form .= " ".Xml::submitButton( wfMsg( 'go' ) );
		$form .= "</fieldset></form>\n";
		$wgOut->addHTML( $form );
	}
	
   	/**
	* Get a selector of time period options
	* @param int $selected, selected level
	*/
	protected function getPeriodMenu( $selected=null ) {
		$s = "<label for='period'>" . wfMsgHtml('ratinghistory-period') . "</label>&nbsp;";
		$s .= Xml::openElement( 'select', array('name' => 'period', 'id' => 'period') );
		$s .= Xml::option( wfMsg( "ratinghistory-month" ), 30, $selected===30 );
		$s .= Xml::option( wfMsg( "ratinghistory-year" ), 365, $selected===365 );
		$s .= Xml::option( wfMsg( "ratinghistory-3years" ), 1095, $selected===1095 );
		$s .= Xml::closeElement('select')."\n";
		return $s;
	}
	
	protected function showGraphs() {
		global $wgOut;
		// Do each graphs for said time period
		foreach( FlaggedRevs::getFeedbackTags() as $tag => $weight ) {
			// Show title
			$wgOut->addHTML( '<h2>' . wfMsgHtml("readerfeedback-$tag") . '</h2>' );
			// Check if cached version is available.
			// If not, then generate a new one.
			$filePath = $this->getFilePath( $tag );
			$url = $this->getUrlPath( $tag );
			if( 1 || !file_exists($filePath) || $this->fileExpired($tag,$filePath) ) {
				$this->makeTagGraph( $tag, $filePath );
			}
			// Output the image
			$wgOut->addHTML( 
				Xml::openElement( 'div', array('class' => 'reader_feedback_graph') ) .
				Xml::openElement( 'img', array('src' => $url) ) . Xml::closeElement( 'img' ) .
				Xml::closeElement( 'div' )
			);
			// Show legend
			$wgOut->addHTML( Xml::openElement( 'div', array('class' => 'reader_feedback_legend') ) );
			for( $i=0; $i <= 4; $i++) {
				$wgOut->addHTML( "&nbsp;&nbsp;&nbsp;<b>[$i]</b> - " . wfMsgHtml( "readerfeedback-level-$i" ) . "</li>" );
			}
			$wgOut->addHTML( Xml::closeElement( 'div' ) );
		}
	}
	
	/**
	* Generate a graph for this tag
	* @param string $tag
	* @param string $filePath
	* @returns string, url path to file
	*/
	public function makeTagGraph( $tag, $filePath ) {
		global $wgPHPlotDir;
		require_once( "$wgPHPlotDir/phplot.php" ); // load classes
		// Define the object
		$plot = new PHPlot(800,600);
		// Set file path
		$dir = dirname($filePath);
		// Make sure directory exists
		if( !is_dir($dir) && !wfMkdirParents( $dir, 0777 ) ) {
			return false;
		}
		$plot->SetOutputFile( $filePath );
		$plot->SetIsInline( true );
		// Set titles (FIXME: other languages?)
		#$plot->SetTitle("Rating history");
		#$plot->SetXTitle('Date');
		#$plot->SetYTitle('Daily and running average');
		// Define the data using the DB rows
		$data = array();
		$totalVal = $totalCount = 0;
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'reader_feedback_history',
			array( 'rfh_total', 'rfh_count', 'rfh_date' ),
			array( 'rfh_page_id' => $this->page->getArticleId(), 'rfh_tag' => $tag ),
			__METHOD__,
			array( 'ORDER BY' => 'rfh_date DESC' ) );
		while( $row = $dbr->fetchObject( $res ) ) {
			$totalVal += (int)$row->rfh_total;
			$totalCount += (int)$row->rfh_count;
			$dayAve = (int)$row->rfh_total/(int)$row->rfh_count;
			$cumAve = $totalVal/$totalCount;
			$month = substr( $row->rfh_date, 4, 2 );
			$day = substr( $row->rfh_date, 6, 2 );
			$data[] = array("{$month}/{$day}",$dayAve,$cumAve);
		}
		// Flip order
		$data = array_reverse($data);
		$plot->SetDataValues($data);
		// Turn off X axis ticks and labels because they get in the way:
		$plot->SetXTickLabelPos('none');
		$plot->SetXTickPos('none');
		// Draw it!
		$plot->DrawGraph();
		return true;
	}
	
	/**
	* Get the path to where the corresponding graph file should be
	* @param string $tag
	* @returns string
	*/
	public function getFilePath( $tag ) {
		global $wgUploadDirectory;
		$rel = self::getRelPath( $tag );
		return "{$wgUploadDirectory}/graphs/{$rel}";
	}
	
	/**
	* Get the url to where the corresponding graph file should be
	* @param string $tag
	* @returns string
	*/
	public function getUrlPath( $tag ) {
		global $wgUploadPath;
		$rel = self::getRelPath( $tag );
		return "{$wgUploadPath}/graphs/{$rel}";
	}
	
	public function getRelPath( $tag ) {
		$pageId = $this->page->getArticleId();
		# Paranoid check. Should not be necessary, but here to be safe...
		if( !preg_match('/^[a-zA-Z]{1,20}$/',$tag) ) {
			throw new MWException( 'Invalid tag name!' );
		}
		return "{$pageId}/{$tag}/l{$this->period}d.png";
	}
	
	/**
	* Check if a graph file is expired.
	* @param string $tag
	* @param string $path, filepath to existing file
	* @returns string
	*/
	public function fileExpired( $tag, $path ) {
		$dbr = wfGetDB( DB_SLAVE );
		$tagTimestamp = $dbr->selectField( 'reader_feedback_pages', 
			'rfp_touched',
			array( 'rfp_page_id' => $this->page->getArticleId(), 'rfp_tag' => $tag ),
			__METHOD__ );
		$tagTimestamp = wfTimestamp( TS_MW, $tagTimestamp );
		$fileTimestamp = wfTimestamp( TS_MW, filemtime($path) );
		return ($fileTimestamp < $tagTimestamp );
	}
}
