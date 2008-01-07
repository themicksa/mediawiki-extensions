<?php
/*
 * MV_SpecialExport.php Created on Oct 23, 2007
 * 
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http:/metavid.ucsc.edu/code
 * 
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.ucsc.edu
 * 
 * exports Video feeds in a few different queries to machine readable formats
 * initially target: rss, miro  (format attribute)
 * atom etc would be good.  
 * 
 * 
 * Special:MvExport 
 */
if (!defined('MEDIAWIKI')) die();

global $IP, $smwgIP;

function doSpecialExport($par = null) {
	//list( $limit, $offset ) = wfCheckLimits();
	$MvSpecialExport = new MV_SpecialExport();
	$MvSpecialExport->execute();
}
SpecialPage::addPage( new SpecialPage('MvVideoFeed','',true,'doSpecialExport',false) );
SpecialPage::addPage( new SpecialPage('MvExportStream','',true,'doSpecialExport',false) );
//extend supported feed types:
$wgFeedClasses['cmml']='CmmlFeed';
$wgFeedClasses['podcast']='PodcastFeed';

class MV_SpecialExport {
	var $feed = null;
	//initialy just do feeds per category	
	function execute() {
		global $wgRequest, $wgOut, $wgUser, $mvStream_name, $mvgIP;
		$html='';
				
		$this->feed_format = $wgRequest->getVal('feed_format');	//values 'rss', 'cmml'			
			//one of the following: 			
		$this->cat=$wgRequest->getVal('cat'); 		//a category name
		$this->seq_title = $wgRequest->getVal('seq_tilte');//a sequence name
		$this->stream_name = $wgRequest->getVal('stream_name');//a stream name (cmml is defaulted in this case)		
		$this->req_time = $wgRequest->getVal('t');
		if(!$this->req_time)$this->req_time = $wgRequest->getVal('time_range');
		if($this->feed_format){
			$html.='feed format:'. $this->feed_format;  
		}	
		//populate the dateset: 
		if($this->cat){
			$this->get_category_feed();			
		}elseif($this->seq_title){
			
		}elseif($this->stream_name){
			$this->get_stream_cmml();
		}		
		#init html output var:  
		$wgOut->addHTML( $html );
	}    
	function get_stream_cmml(){		
		$dbr =& wfGetDB(DB_SLAVE);
		//get the stream title	
		$streamTilte = new MV_Title($this->stream_name.'/'.$this->req_time);	
		//do mvd_index query:
		$mvd_res = MV_Index::getMVDInRange($streamTilte->getStreamId(),
				$streamTilte->getStartTimeSeconds(), 
				$streamTilte->getEndTimeSeconds());
		//get the stream stream req 
		header('Content-Type: text/xml');
		//print the header:
		print '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
?>
<!DOCTYPE cmml SYSTEM "cmml.dtd">
<cmml lang="en" id="simple">	
	<stream id="<?=$this->stream_name?>" basetime="0">
		<import id="videosrc" lang="en" title="<?=$streamTilte->getStreamNameText()?>" 
			granulerate="25/1" contenttype="video/theora" 
		src="<?=$streamTilte->getWebStreamURL()?>" start="0" end="60">
			<param id="vheight" name="video.height" value="320"/>
			<param id="vwidth"  name="video.width"  value="240"/>
		</import>
	</stream>	
	<head>
		<title><?=$streamTilte->getTitleDesc()?></title>
	</head>
<?
	if(count($dbr->numRows($mvd_res))!=0){ 
		global $wgOut;
		$MV_Overlay = new MV_Overlay();	
		$wgOut->clearHTML();	
		while($mvd = $dbr->fetchObject($mvd_res)){	
			$MV_Overlay->get_article_html($mvd);	
			/*$curTitle = Title::newFromText($mvd->wiki_title, MV_NS_MVD);
			$curArticle=new Article($curTitle);
			*/
			//print_r($curArticle->getContent() );
			?>
		<clip id="mvd_<?=$mvd->id?>" start="ntp:<?=seconds2ntp($mvd->start_time)?>" end="ntp:<?=seconds2ntp($mvd->end_time)?>">
		<?
			//format output based on type:
			//@@TODO make absolute links: 			
			switch($mvd->mvd_type){
				case 'Ht_en':				
					?>
					<caption><![CDATA[
					<?=$wgOut->getHTML();?>
					]]></caption>
					<?
				break;
				case 'Anno_en':				
					?>								
					<desc><![CDATA[
						<?=$wgOut->getHTML();?>
					]]></desc><?
				break;
			}
			//clear wgOutput
			$wgOut->clearHTML();
?>
</clip>
<?
		}
	}
?>	
</cmml>
<?
exit;
}
	// @@todo integrate cache query (similar to SpecialRecentChanges::rcOutputFeed ))
	function get_category_feed(){
		global $wgSitename, $wgRequest, $wgOut, $wgCategoryPagingLimit;		
		//get the category article: 
		$title = Title::makeTitle( NS_CATEGORY,  $this->cat);		
		$article = new Article($title);
		
		$this->limit = $wgCategoryPagingLimit;	
		
		$this->feed = new mvRSSFeed(
			$wgSitename . ' - ' . wfMsgForContent( 'video_feed_cat' ) .$this->cat, //title 
			$article->getContent(), //description
			$title->getFullUrl() //link 
		);
		$this->feed->outHeader();
		
		$this->from = $wgRequest->getVal( 'from' );
		$this->until = $wgRequest->getVal( 'until' );
		
		//do a query (get all video items in this category) 
		if( $this->from != '' ) {
			$pageCondition = 'cl_sortkey >= ' . $dbr->addQuotes( $this->from );
			$this->flip = false;
		} elseif( $this->until != '' ) {
			$pageCondition = 'cl_sortkey < ' . $dbr->addQuotes( $this->until );
			$this->flip = true;
		} else {
			$pageCondition = '1 = 1';
			$this->flip = false;
		}
		$dbr = wfGetDB( DB_SLAVE );				
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_title', 'page_namespace', 'page_len', 'page_is_redirect', 'cl_sortkey' ),
			$pageCondition . " AND (
				  `page_namespace`  =  ".MV_NS_MVD." OR 
				  `page_namespace`  =  ".MV_NS_STREAM." OR 
				  `page_namespace`  = ".MV_NS_SEQUENCE." )
				   AND `cl_from`=  `page_id`
			       AND `cl_to` = '{$title->getDBKey()}'
			       AND `page_is_redirect`=0",
			#+ $pageCondition,
			__METHOD__,
			array( 'ORDER BY' => $this->flip ? 'cl_sortkey DESC' : 'cl_sortkey',
			       'USE INDEX' => 'cl_sortkey', 
			       'LIMIT'    => $this->limit + 1 ) );
		
		//echo 'last query: ' . $dbr->lastQuery();
		$count = 0;
		$this->nextPage = null;
		while( $x = $dbr->fetchObject ( $res ) ) {
			if( ++$count > $this->limit ) {
				// We've reached the one extra which shows that there are
				// additional pages to be had. Stop here...
				$this->nextPage = $x->cl_sortkey;
				break;
			}				
			$title = Title::makeTitle( $x->page_namespace, $x->page_title );
			$article = new Article($title);
			$mvTitle = new MV_Title($title);
			
			//this should be done cleaner & we need absolute links
			$wgOut->clearHTML(); 			
			$wgOut->addWikiText($article->getContent() );
			$desc_html = $wgOut->getHTML();		
			$wgOut->clearHTML();	
						
			$stream_url = $mvTitle->getWebStreamURL();
			
			$talkpage = $title->getTalkPage();
			
			
			
			$type_desc = ($mvTitle->getMvdTypeKey())?wfMsg($mvTitle->getMvdTypeKey()):'';			
			$time_desc = ($mvTitle->getTimeDesc())?$mvTitle->getTimeDesc():'';
				
			$thumb_ref = $mvTitle->getStreamImageURL('320x240');
			$desc ='<![CDATA[
					
<center class="mv_rss_view_only">
<a href="'.$title->getFullUrl().'"><img src="'.$thumb_ref.'" border="0" /></a>
</center>
<br />'.
	
	$desc_html. 
']]>';
?>
	<item>
		<link><?=mvRSSFeed::xmlEncode($title->getFullUrl())?></link>
		<title><?=mvRSSFeed::xmlEncode(
			$mvTitle->getStreamNameText() . ' ' .  $time_desc)?></title>
		<description><?=$desc?></description>
		<enclosure type="video/ogg" url="<?=mvRSSFeed::xmlEncode($stream_url)?>"/>
		<comments><?=mvRSSFeed::xmlEncode($talkpage->getFullUrl())?></comments>
		<media:thumbnail url="<?=mvRSSFeed::xmlEncode($thumb_ref)?>"/>
		<?
		/*todo add in alternate streams HQ, lowQ archive.org etc: 
		<media:group>
    		<media:content blip:role="Source" expression="full" fileSize="2702848" height="240" isDefault="true" type="video/msvideo" url="http://blip.tv/file/get/Conceptdude-EroticDanceOfANiceBabe266.avi" width="360"></media:content>
    		<media:content blip:role="web" expression="full" fileSize="3080396" height="240" isDefault="false" type="video/x-flv" url="http://blip.tv/file/get/Conceptdude-EroticDanceOfANiceBabe266.flv" width="360"></media:content>
  		</media:group>
  		*/
  		?>
	</item>
			<?		
		}				
		$this->feed->outFooter();
		//$this->rows =  
	}      
}
class mvRSSFeed extends ChannelFeed{
	function outHeader() {
		$this->outXmlHeader();
		?>
<rss version="2.0"
	xmlns:creativeCommons="http://backend.userland.com/creativeCommonsRssModule"
	xmlns:media="http://search.yahoo.com/mrss/"
	xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
	xmlns:geo="http://www.w3.org/2003/01/geo/wgs84_pos#"
	xmlns:blip="http://blip.tv/dtd/blip/1.0"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
    xmlns:amp="http://www.adobe.com/amp/1.0"
	xmlns:dcterms="http://purl.org/dc/terms"
	xmlns:gm="http://www.google.com/schemas/gm/1.1">
	<channel>
	<title><?=$this->getTitle()?></title>
	<link><?=$this->getUrl()?></link>
	<description><?=$this->getDescription()?></description>';	
	<?
	}
}
?>
