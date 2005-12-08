<?
# Run the following SQL on your database prior to use :
#
# ALTER TABLE page ADD page_stable INT( 8 ) UNSIGNED NOT NULL DEFAULT '0' ;

if (!defined('MEDIAWIKI')) die();

$wgExtensionCredits['StableVersion'][] = array(
        'name' => 'Stable version',
        'description' => 'An extension to allow the marking of a stable version.',
        'author' => 'Magnus Manske'
);

$wgAvailableRights[] = 'stableversion';
$wgExtensionFunctions[] = 'wfStableVersion' ;
$wgHooks['ArticleViewHeader'][] = 'wfStableVersionHeaderHook' ;
$wgHooks['ArticlePageDataBefore'][] = 'wfStableVersionArticlePageDataBeforeHook' ;
$wgHooks['ArticlePageDataAfter'][] = 'wfStableVersionArticlePageDataAfterHook' ;

# BEGIN logging functions
$wgHooks['LogPageValidTypes'][] = 'wfStableVersionAddLogType';
$wgHooks['LogPageLogName'][] = 'wfStableVersionAddLogName';
$wgHooks['LogPageLogHeader'][] = 'wfStableVersionAddLogHeader';
$wgHooks['LogPageActionText'][] = 'wfStableVersionAddActionText';

function wfStableVersionAddLogType( &$types ) {
	if ( !in_array( 'stableversion', $types ) )
		$types[] = 'stableversion';
	return true;
}

function wfStableVersionAddLogName( &$names ) {
	$names['stableversion'] = 'stableversion_logpage';
	return true;
}

function wfStableVersionAddLogHeader( &$headers ) {
	$headers['stableversion'] = 'stableversion_logpagetext';
	return true;
}

function wfStableVersionAddActionText( &$actions ) {
	$actions['stableversion/stableversion'] = 'stableversion_logentry';
	return true;
}
# END logging functions





# Text adding function
function wfStableVersionAddCache () {
	global $wgMessageCache , $wgStableVersionAddCache ;
	if ( $wgStableVersionAddCache ) return ;
	$wgStableVersionAddCache = true ;
	$wgMessageCache->addMessages(
		array(
			'stableversion_this_is_stable' => 'This is the stable version of this article. You can also look at the <a href="$1">latest draft version</a>.',
			'stableversion_this_is_draft_no_stable' => 'You are looking at a draft version of this article; there is no stable version of this article yet.',
			'stableversion_this_is_draft' => 'This is a draft version of this article. You can also look at the <a href="$1">stable version</a>.',
			'stableversion_reset_stable_version' => 'Click <a href="$1">here</a> to remove this as stable version!',
			'stableversion_set_stable_version' => 'Click <a href="$1">here</a> to set this as stable version!',
			'stableversion_set_ok' => 'The stable version has been successfully set.',
			'stableversion_reset_ok' => 'The stable version has been successfully removed. This article has no stable version right now.',
			'stableversion_return' => 'Return to <a href="$1">$2</a>',
			
			'stableversion_reset_log' => 'Stable version has been removed.',
			'stableversion_logpage' => 'Stable version log',
			'stableversion_logpagetext' => 'This is a log of changes to stable versions',
			'stableversion_logentry' => '',
			'stableversion_log' => 'Revision #$1 is now the stable version.',
		)
	);
}

# Adds query for stable version
function wfStableVersionArticlePageDataBeforeHook ( $a , &$b ) {
	$b[] = "page_stable" ;
}

# Adds new variable "mStable" to the article
function wfStableVersionArticlePageDataAfterHook ( &$a , $b ) {
	$a->mStable = $b->page_stable ;
}

# Decides wether a user can set the stable version
function wfStableVersionCanChange () {
	global $wgUser ;
	return true ; # Dummy, everyone can set stable versions
}

# Generates the little header line
function wfStableVersionHeaderHook ( $a ) {
	global $wgOut , $wgArticle , $wgTitle ;
	wfStableVersionAddCache () ;
	$st = "" ; # Subtitle
	
	if ( $wgArticle->getRevIdFetched() == $wgArticle->mStable ) { # This is the stable version
		$url = $wgTitle->getFullURL () ;
		$st = wfMsg ( 'stableversion_this_is_stable' , $url ) ;
	} else if ( $wgArticle->mStable == "0" ) { # There is no spoon, er, stable version
		$st = wfMsg ( 'stableversion_this_is_draft_no_stable' ) ;
	} else { # This is not the stable version, recommend it
		$url = $wgTitle->getFullURL ( "oldid=" . $wgArticle->mStable ) ;
		$st = wfMsg ( 'stableversion_this_is_draft' , $url ) ;
	}
	
	if ( wfStableVersionCanChange() ) { # This user may alter the stable version info
		$st .= " " ;
		$sp = Title::newFromText ( "Special:StableVersion" ) ;
		if ( $wgArticle->getRevIdFetched() == $wgArticle->mStable ) { # This is the stable version - reset?
			$url = $sp->getFullURL ( "id=" . $wgArticle->getID() . "&mode=reset" ) ;
			$st .= wfMsg ( 'stableversion_reset_stable_version' , $url ) ;
		} else {
			$url = $sp->getFullURL ( "&id=" . $wgArticle->getID() . "&mode=set&revision=" . $wgArticle->getRevIdFetched() ) ;
			$st .= wfMsg ( 'stableversion_set_stable_version' , $url ) ;
		}
	}

	if ( $st == "" ) return ;
	$st = $wgOut->getSubtitle() . "<br/>" . $st ;
	$wgOut->setSubtitle ( $st ) ;
}

# The special page
function wfStableVersion() {
	global $IP, $wgMessageCache;
	wfStableVersionAddCache () ;

	$wgMessageCache->addMessage( 'stableversion', 'Stable Version' );

	require_once "$IP/includes/SpecialPage.php";

	class SpecialStableVersion extends SpecialPage {
		/**
		* Constructor
		*/
		function SpecialStableVersion() {
			SpecialPage::SpecialPage( 'StableVersion' );
			$this->includable( true );
		}
	
		/**
		* main()
		*/
		function execute( $par = null ) {
			global $wgOut , $wgRequest ;
			$mode = $wgRequest->getText('mode', "") ;
			if ( $mode != 'set' && $mode != 'reset' ) return ; # Should be error (wrong call)
			$id = $wgRequest->getText ( 'id', "0" ) ;
			if ( $id == "0" ) return ; # Should be error (wrong call)
			if ( !wfStableVersionCanChange() ) return ; # Should be error (not allowed)
			if ( $mode == 'set' ) { # Set
				$newstable = $wgRequest->getText ( 'revision', "0" ) ;
				$out = wfMsg ( 'stableversion_set_ok' ) ;
				$act = wfMsg ( 'stableversion_log' , $newstable ) ;
			} else { # Reset
				$newstable = "0" ;
				$out = wfMsg ( 'stableversion_reset_ok' ) ;
				$act = wfMsg ( 'stableversion_reset_log' ) ;
			}

			$conditions = array( 'page_id' => $id );
			$fname = "SpecialStableVersion:execute" ;
			$dbw = wfGetDB( DB_MASTER );
			$dbw->update( 'page',
				array( /* SET */
					'page_stable'      => $newstable,
				),
				$conditions,
				$fname );

			$t = Title::newFromID ( $id ) ;
			$url = $t->getFullURL ( "&id=" . $id . "&mode=set&revision=" . $newstable ) ;
			$out = "<p>{$out}</p><p>" . wfMsg ( 'stableversion_return' , $url , $t->getFullText() ) . "</p>" ;

			# Logging
			$log = new LogPage( 'stableversion' );
			$log->addEntry( 'stableversion', $t , $act );

			$this->setHeaders();
			$wgOut->addHtml( $out );
		}
	} # end of class

	SpecialPage::addPage( new SpecialStableVersion );
}


?>
