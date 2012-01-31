<?php
/**
 * Language file for Semantic Page Series
 */

$messages = array();

/** English
 * @author F.trott
 */
$messages['en'] = array(
	'semanticpageseries-desc' => 'Creating a series of pages from one [https://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Form]',
	'spssuccesstitle' => 'Creating $1 pages',
	'spssuccess' => '{{PLURAL:$1|One page|$1 pages}} will be created.',
	'spserror' => 'An error occurred',
	
	'spserror_diffnotsupported' => 'The diff action is not supported for page series.',
	'spserror_previewnotsupported' => 'The preview action is not supported for page series.',
	'spserror_noiteratorname' => 'No iterator specified. You have to set the parameter "iterator" in the #serieslink parser function call.',
	'spserror_iteratorunknown' => 'Iterator "$1" does not exist. You have to correct the parameter "iterator" in the #serieslink parser function call.',
	'spserror_noformname' => 'No form name given.  You have to set the parameter "form" in the #serieslink parser function.',
	'spserror_formunknown' => 'Form "$1" does not exist.',
	'spserror_notargetformname' => 'No target form name given. You have to set the parameter "target form" in the #serieslink parser function call.',
	'spserror_notargetfieldname' => 'No target field name given. You have to set the parameter "target field" in the #serieslink parser function call.',
	'spserror_iteratorparammissing' => "The following iterator parameters are missing in the #serieslink call:\n$1",
	'spserror_noiteratordata' => 'No iterator parameters found in the sent data.',
	'spserror_pagegenerationlimitexeeded' => 'You tried to generate {{PLURAL:$1|one page|$1 pages}}. This exeeds your allowed limit of {{PLURAL:$2|one page|$2 pages}}.',
);

/** Message documentation (Message documentation)
 * @author F.trott
 */
$messages['qqq'] = array(
	'semanticpageseries-desc' => '{{desc}}',
	'spssuccesstitle' => 'The title of a page containing a success message. The parameter will contain the category of pages to be created, e.g. Event',
	'spssuccess' => 'A success message. The parameter will contain a number.',
	'spserror' => 'The title of en error page',

	'spserror_diffnotsupported' => 'An error message',
	'spserror_previewnotsupported' => 'An error message',
	'spserror_noiteratorname' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. The name of the parameter in quotes should not be translated!',
	'spserror_iteratorunknown' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. The name of the parameter in quotes should not be translated!',
	'spserror_noformname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror_formunknown' => 'An error message',
	'spserror_notargetformname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror_notargetfieldname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror_iteratorparammissing' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator.',
	'spserror_noiteratordata' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator.',
	'spserror_pagegenerationlimitexeeded' => 'An error message',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'semanticpageseries-desc' => 'Ermöglicht das Erstellen einer Seitenfolge mit einem von [https://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms] bereitgestellten Formular',
	'spssuccesstitle' => '$1 Seiten werden erstellt …',
	'spssuccess' => '$1 Seiten werden erstellt.',
	'spserror' => 'Ein Fehler ist aufgetreten',
	'spserror_diffnotsupported' => 'Die Aktion „diff“ wird nicht unterstützt.',
	'spserror_previewnotsupported' => 'Die Seitenvorschau wird nicht unterstützt.',
	'spserror_noiteratorname' => 'Es wurde kein Seitenfolgebezeichner für die Seitennamen angegeben.',
	'spserror_iteratorunknown' => 'Der Seitenfolgebezeichner „$1“ ist nicht vorhanden.',
	'spserror_noformname' => 'Der Name des Formulars wurde nicht angegeben.',
	'spserror_formunknown' => 'Das Formular „$1“ ist nicht vorhanden.',
	'spserror_notargetformname' => 'Der Name des Zielformulars wurde nicht angegeben.',
	'spserror_notargetfieldname' => 'Der Name des Zielfeldes wurde nicht angegeben.',
	'spserror_iteratorparammissing' => 'Die folgenden Parameter zum Seitenfolgebezeichner fehlen beim Aufruf der Funktion #seriesformlink:
$1',
	'spserror_noiteratordata' => 'Die gesendeten Daten enthalten keine Parameter zum Seitenfolgebezeichner.',
	'spserror_pagegenerationlimitexeeded' => 'Es sollten $1 Seiten erstellt werden. Diese Anzahl übertrifft den zulässigen Grenzwert von $2 Seiten.',
);

