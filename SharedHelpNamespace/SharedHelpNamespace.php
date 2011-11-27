<?php
/**
* SharedHelpNamespace
*
* @package MediaWiki
* @subpackage Extensions
*
* @author: Tim 'SVG' Weyer <SVG@Wikiunity.com>
*
* @copyright Copyright (C) 2011 Tim 'SVG' Weyer, Wikiunity
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
*/

if (!defined('MEDIAWIKI')) {
	echo "THIS IS NOT VALID ENTRY POINT";
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'SharedHelpNamespace',
	'author'         => array( 'Tim Weyer' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SharedHelpNamespace',
	'descriptionmsg' => 'sharedhelpnamespace-desc',
	'version'        => '1.0',
);

// Internationalization
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SharedHelpNamespace'] = $dir . 'SharedHelpNamespace.i18n.php';

// Help wiki(s) where the help namespace is fetched from
if( !isset($wgSharedHelpNamespaceFetchingWikis) ) {
	$wgSharedHelpNamespaceFetchingWikis = array();
}

// Hooks
$wgHooks['ShowMissingArticle'][] = 'wfSharedHelpNamespaceLoad';
$wgHooks['ArticlePageDataBefore'][] = 'wfSharedHelpNamespaceRedirectTalks';
$wgHooks['LinkBegin'][] = 'efSharedHelpNamespaceMakeBlueLinks';
$wgHooks['DoEditSectionLink'][] = 'wfSharedHelpNamespaceChangeEditSectionLink';
$wgHooks['getUserPermissionsErrors'][] = 'fnProtectSharedHelpNamespace';


function wfSharedHelpNamespaceLoad( $article ) {
	global $wgTitle, $wgOut, $wgContLang, $wgSharedHelpNamespaceFetchingWikis, $wgLanguageCode, $wgDBname;

	if ( $wgTitle->getNamespace() == NS_HELP ) {

		$replacewhitespace = str_replace( ' ', '_', $wgOut->getTitle() );
		$title = str_replace( $wgContLang->namespaceNames[NS_HELP].':', '', $replacewhitespace );

		foreach ( $wgSharedHelpNamespaceFetchingWikis as $language => $urls ) {
			foreach ( $urls as $url => $wgSharedHelpNamespaceFetchingWiki ) {
				if ( $wgLanguageCode == "$language" && $wgDBname != $wgSharedHelpNamespaceFetchingWiki ) {
					$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedHelpNamespaceFetchingWiki );
					$page = $dbr->query( 'SELECT page_title, page_namespace, page_latest FROM page WHERE page_namespace = 12 AND page_title = '.$dbr->addQuotes($title) );
					$page = $dbr->fetchObject( $page );
				}
			}
		}
		if ( !empty($page->page_title) ) {
			$rev = $dbr->select( 'revision',
					array( 'rev_id', 'rev_text_id' ),
					'rev_id = '.$dbr->addQuotes($page->page_latest),
					__METHOD__ );
					$rev = $dbr->fetchObject( $rev );
		} else {
			return false;
		}
		$text = $dbr->select( 'text',
				array( 'old_id', 'old_text' ),
				'old_id = '.$dbr->addQuotes($rev->rev_text_id),
				__METHOD__ );
				$text = $dbr->fetchObject( $text );

		if ( !empty($text->old_text) ) {
			echo $wgOut->addWikiText( $text->old_text );
			return true;
		} else {
			return false;
		}

		} else {
			return false;
	}

}


function wfSharedHelpNamespaceRedirectTalks( $article, $fields ) {
	global $wgTitle, $wgOut, $wgContLang, $wgSharedHelpNamespaceFetchingWikis, $wgLanguageCode, $wgDBname;

	if ( $wgTitle->getNamespace() == NS_HELP_TALK ) {

		$replacewhitespace = str_replace( ' ', '_', $wgOut->getTitle() );
		$title = str_replace( $wgContLang->namespaceNames[NS_HELP_TALK].':', '', $replacewhitespace );

		foreach ( $wgSharedHelpNamespaceFetchingWikis as $language => $urls ) {
			foreach ( $urls as $url => $wgSharedHelpNamespaceFetchingWiki ) {
				if ( $wgLanguageCode == "$language" && $wgDBname != $wgSharedHelpNamespaceFetchingWiki ) {
					$dbr = wfGetDB( DB_SLAVE, array(), $wgSharedHelpNamespaceFetchingWiki );
					$page = $dbr->query( 'SELECT page_title, page_namespace, page_latest FROM page WHERE page_namespace = 12 AND page_title = '.$dbr->addQuotes($title) );
					$page = $dbr->fetchObject( $page );
				}
				if ( !empty($page->page_title) ) {
					if ( $page->page_title == $title && !$wgTitle->exists() ) {
						$sharedHelpRedirectTalk = Title::newFromText( $url . '/index.php?title=' . str_replace( ' ', '_', $wgOut->getTitle() ) );
						$redirectTalkPage = $sharedHelpRedirectTalk->getFullText();
						$wgOut->redirect( $redirectTalkPage );
						return true;
					} else {
						return false;
					}
				}
			}
		}
		return true;
	} else {
		return false;
	}
}


function efSharedHelpNamespaceMakeBlueLinks( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {

	if ( is_null( $target ) ) {
		return true;
	}

	// only affects non-existing Help pages
	if ( $target->getNamespace() != NS_HELP || $target->exists() ) {
		return true;
	}

	// remove "broken" assumption/override
	$brokenKey = array_search( 'broken', $options );
	if ( $brokenKey !== false ) {
		unset( $options[$brokenKey] );
	}

	// make the link "blue"
	$options[] = 'known';

	return true;
}


function wfSharedHelpNamespaceChangeEditSectionLink( $skin, $title, $section, $tooltip, $result, $lang = false ) {
	global $wgTitle, $wgSharedHelpNamespaceFetchingWikis, $wgLanguageCode, $wgDBname;

	if ( $wgTitle->getNamespace() == NS_HELP ) {
		foreach ( $wgSharedHelpNamespaceFetchingWikis as $language => $urls ) {
			foreach ( $urls as $url => $wgSharedHelpNamespaceFetchingWiki ) {
				if ( $wgLanguageCode == "$language" && $wgDBname != $wgSharedHelpNamespaceFetchingWiki ) {
					$result = '<span class="editsection">[<a href="'.$url.'/index.php?title='.str_replace( ' ', '_', $title ).'&amp;action=edit&amp;section='.$section.'" title="'.wfMsg( 'editsectionhint', $tooltip ).'">'.wfMsg( 'editsection' ).'</a>]</span>';
				}
			}
		}
		return true;
	} else {
		return false;
	}

}


function fnProtectSharedHelpNamespace( &$title, &$user, $action, &$result) {
	global $wgSharedHelpNamespaceFetchingWikis, $wgDBname;
	
	foreach ( $wgSharedHelpNamespaceFetchingWikis as $language => $urls ) {
		foreach ( $urls as $url => $wgSharedHelpNamespaceFetchingWiki ) {
	// only protect Help pages on non-help-pages-fetching wikis
	if( $wgDBname != $wgSharedHelpNamespaceFetchingWiki ) {

			// block actions 'edit' and 'create'
			if( $action != 'edit' && $action != 'create' ) {
				return true;
			}

			$dbr = wfGetDB(DB_SLAVE, array(), $wgSharedHelpNamespaceFetchingWiki);
			$res = $dbr->query( 'SELECT page_title, page_namespace FROM page WHERE page_namespace = 12 AND page_title = '.$dbr->addQuotes(str_replace( ' ', '_', $title->getText())) );

			if ( $dbr->numRows($res) < 1 ) {
				return true;
			}

	$ns = $title->getNamespace();

	// check namespaces
	if( $ns == 12 || $ns == 13 ) {

		// error message if action is blocked
		$result = array('protectedpagetext');

		// bail, and stop the request
		return false;
	}
		}
	}
	}

	return true;
}

