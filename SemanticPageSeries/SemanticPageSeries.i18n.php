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
	'spssuccess' => '$1 pages will be created.',
	'spserror' => 'An error occurred',
	
	'spserror_diffnotsupported' => 'The diff action is not supported for page series.',
	'spserror_previewnotsupported' => 'The preview action is not supported for page series.',
	'spserror_noiteratorname' => 'No iterator name given.',
	'spserror_iteratorunknown' => 'Iterator "$1" does not exist.',
	'spserror_noformname' => 'No form name given.',
	'spserror_formunknown' => 'Form "$1" does not exist.',
	'spserror_notargetformname' => 'No target form name given.',
	'spserror_notargetfieldname' => 'No target field name given.',
	'spserror_iteratorparammissing' => "The following iterator parameters are missing in the #seriesformlink call:\n$1",
	'spserror_noiteratordata' => 'No iterator parameters found in the sent data.',
	'spserror_pagegenerationlimitexeeded' => 'You tried to generate $1 pages. This exeeds your allowed limit of $2 pages.',
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
	'spserror_noiteratorname' => 'An error message',
	'spserror_iteratorunknown' => 'An error message',
	'spserror_noformname' => 'An error message',
	'spserror_formunknown' => 'An error message',
	'spserror_notargetformname' => 'An error message',
	'spserror_notargetfieldname' => 'An error message',
	'spserror_iteratorparammissing' => 'An error message',
	'spserror_noiteratordata' => 'An error message',
	'spserror_pagegenerationlimitexeeded' => 'An error message',
);

