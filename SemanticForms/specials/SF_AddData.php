<?php
/**
 * Displays a pre-defined form for adding data.
 *
 * @author Yaron Koren
 */
if (!defined('MEDIAWIKI')) die();

global $sfgIP;
require_once( $sfgIP . "/includes/SF_FormPrinter.inc" );

global $IP;
require_once( "$IP/includes/SpecialPage.php" );

SpecialPage::addPage( new SpecialPage('AddData','',true,'doSpecialAddData',false) );

function doSpecialAddData($query = '') {
	global $wgRequest;

	$form_name = $wgRequest->getVal('form');
	$target_name = $wgRequest->getVal('target');

	// if query string did not contain these variables, try the URL
	if (! $form_name && ! $target_name) {
		$queryparts = explode('/', $query, 2);
		$form_name = isset($queryparts[0]) ? $queryparts[0] : '';
		$target_name = isset($queryparts[1]) ? $queryparts[1] : '';
	}

	$alt_forms = $wgRequest->getArray('alt_form');

	printAddForm($form_name, $target_name, $alt_forms);
}

function printAltFormsList($alt_forms, $target_name) {
	$text = "";
	$ad = SpecialPage::getPage('AddData');
	$i = 0;
	foreach ($alt_forms as $alt_form) {
		if ($i++ > 0) { $text .= ", "; }
		$text .= '<a href="' . $ad->getTitle()->getFullURL() . "/" . $alt_form . "/" . $target_name . '">' . str_replace('_', ' ', $alt_form) . "</a>";
	}
	return $text;
}

function printAddForm($form_name, $target_name, $alt_forms) {
	global $wgOut, $wgRequest, $sfgScriptPath, $sfgFormPrinter;

	// initialize some variables
	$page_title = NULL;
	$target_title = NULL;
	$page_name_formula = NULL;

	// get contents of form and target page - if there's only one,
	// it might be a target with only alternate forms
	if ($form_name == '') {
		$wgOut->addHTML( "<p class='error'>" . wfMsg('sf_adddata_badurl') . '</p>');
		return;
	} elseif ($target_name == '') {
		// parse the form to see if it has a 'page name' value set
		$form_title = Title::newFromText($form_name, SF_NS_FORM);
		$form_article = new Article($form_title);
		$form_definition = $form_article->getContent();
		$form_definition = StringUtils::delimiterReplace('<noinclude>', '</noinclude>', '', $form_definition);
		$matches;
		if (preg_match('/{{{info.*page name=([^\|}]*)/', $form_definition, $matches)) {
			$page_name_formula = str_replace('_', ' ', $matches[1]);
		} else {
			$wgOut->addWikiText( "<p class='error'>" . wfMsg('sf_adddata_badurl') . '</p>');
			return;
		}
	}

	$form_title = Title::newFromText($form_name, SF_NS_FORM);

	if ($target_name != '') {
		$target_title = Title::newFromText($target_name);
		$s = wfMsg('sf_adddata_title', $form_title->getText(), $target_title->getPrefixedText());
		$wgOut->setPageTitle($s);
	}

	// target_title should be null - we shouldn't be adding a page that
	// already exists
	if ($target_title && $target_title->exists()) {
		$wgOut->addWikiText( "<p class='error'>" . wfMsg('articleexists') . '</p>');
		return;
	} elseif ($target_name != '') {
		$page_title = str_replace('_', ' ', $target_name);
	}

	if (! $form_title || ! $form_title->exists() ) {
		if ($form_name == '')
			$text = '<p>' . wfMsg('sf_adddata_badurl') . "</p>\n";
		else
			$text = '<p>' . wfMsg('sf_addpage_badform', sffLinkText(SF_NS_FORM, $form_name)) . ".</p>\n";
	} elseif ($target_name == '' && $page_name_formula == '') {
		$text = '<p>' . wfMsg('sf_adddata_badurl') . "</p>\n";
	} else {
		$form_article = new Article($form_title);
		$form_definition = $form_article->getContent();

		$save_page = $wgRequest->getCheck('wpSave');
		$preview_page = $wgRequest->getCheck('wpPreview');
		$diff_page = $wgRequest->getCheck('wpDiff');
		$form_submitted = ($save_page || $preview_page || $diff_page);
		// get 'preload' query value, if it exists
		if (!$form_submitted && $wgRequest->getCheck('preload')) {
			$page_is_source = true;
			$page_contents = $sfgFormPrinter->getPreloadedText($wgRequest->getVal('preload'));
		} else {
			$page_is_source = false;
			$page_contents = null;
		}
		list ($form_text, $javascript_text, $data_text, $form_page_title, $generated_page_name) =
			$sfgFormPrinter->formHTML($form_definition, $form_submitted, $page_is_source, $page_contents, $page_title, $page_name_formula);
		if ($form_submitted) {
			if ($page_name_formula != '') {
				// replace "unique number" tag with one that
				// won't get erased by the next line
				$target_name = preg_replace('/<unique number>/', '{num}', $generated_page_name, 1);
				// if any formula stuff is still in the name
				// after the parsing, just remove it
				$target_name = StringUtils::delimiterReplace('<', '>', '', $target_name);
				if (strpos($target_name, '{num}')) {
					// cycle through numbers for this tag
					// until we find one that gives a
					// nonexistent page title
					$title_number = 1;
					do {
						$target_title = Title::newFromText(str_replace('{num}', $title_number, $target_name));
						$title_number++;
					} while ($target_title->exists());
				} else {
					$target_title = Title::newFromText($target_name);
				}
			}
			$text = sffPrintRedirectForm($target_title, $data_text, $wgRequest->getVal('wpSummary'), $save_page, $preview_page, $diff_page, $wgRequest->getCheck('wpMinoredit'), $wgRequest->getCheck('wpWatchthis'));
		} else {
			// override the default title for this page if
			// a title was specified in the form
			if ($form_page_title != NULL) {
				if ($target_name == '') {
					$wgOut->setPageTitle($form_page_title);
				} else {
					$wgOut->setPageTitle("$form_page_title: {$target_title->getPrefixedText()}");
				}
			}
			$text = "";
			if (count($alt_forms) > 0) {
				$text .= '<div class="info_message">' . wfMsg('sf_adddata_altforms') . ' ';
				$text .= printAltFormsList($alt_forms, $target_name);
				$text .= "</div>\n";
			}
			$text .=<<<END
				<form name="createbox" onsubmit="return validate_all()" action="" method="post" class="createbox">

END;
			$text .= $form_text;
		}
	}
	$mainCssUrl = $sfgScriptPath . '/skins/SF_main.css';
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $mainCssUrl
	));
	$sfgYUIBase = "http://yui.yahooapis.com/2.4.1/build/";
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $sfgYUIBase . "autocomplete/assets/skins/sam/autocomplete.css"
	));
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection",
		'href' => $sfgScriptPath . '/skins/SF_yui_autocompletion.css'
	));
	$wgOut->addScript('<script type="text/javascript" src="' . $sfgYUIBase . 'yahoo/yahoo-min.js"></script>' . "\n");
	$wgOut->addScript('<script type="text/javascript" src="' . $sfgYUIBase . 'dom/dom-min.js"></script>' . "\n");
	$wgOut->addScript('<script type="text/javascript" src="' . $sfgYUIBase . 'event/event-min.js"></script>' . "\n");
	$wgOut->addScript('<script type="text/javascript" src="' .  $sfgYUIBase . 'autocomplete/autocomplete-min.js"></script>' . "\n");
	$wgOut->addScript('<script type="text/javascript" src="' . $sfgScriptPath . '/libs/SF_yui_autocompletion.js"></script>' . "\n");
	if (! empty($javascript_text))
		$wgOut->addScript('		<script type="text/javascript">' . "\n" . $javascript_text . '</script>' . "\n");
	$wgOut->addHTML($text);
}
