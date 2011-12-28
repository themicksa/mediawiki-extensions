<?php
/**
* Internationalisation file for MediaWikiFeedback extension.
*
* @file
* @ingroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'feedback-desc'      => 'Collect feedback from users about features',
	'feedback-bugornote' => 'If you are ready to describe a technical problem in detail please [$1 report a bug].
Otherwise, you can use the easy form below. Your comment will be added to the page "[$3 $2]", along with your username and what browser you are using.',
	'feedback-subject'   => 'Subject:',
	'feedback-message'   => 'Message:',
	'feedback-cancel'    => 'Cancel',
	'feedback-submit'    => 'Submit Feedback',
	'feedback-adding'    => 'Adding feedback to page...',
	'feedback-error1'    => 'Error: Unrecognized result from API',
	'feedback-error2'    => 'Error: Edit failed',
	'feedback-error3'    => 'Error: No response from API',
	'feedback-thanks'    => 'Thanks! Your feedback has been posted to the page "[$2 $1]".',
	'feedback-close'     => 'Done',
	'feedback-bugcheck'  => 'Great! Just check that it is not already one of the [$1 known bugs].',
	'feedback-bugnew'    => 'I checked. Report a new bug',
);

$messages['qqq'] = array(
	'feedback-desc'      => '{{desc}}',
	'feedback-bugornote' => 'When feedback dialog box is opened, this introductory message in small print explains the options to report a bug or add simple feedback. We expect that people in a hurry will not read this.',
	'feedback-subject'   => 'Label for a text input
{{Identical|Subject}}',
	'feedback-message'   => 'Label for a textarea; signature referrs to a Wikitext signature.',
	'feedback-cancel'    => 'Button label
{{Identical|Cancel}}',
	'feedback-submit'    => 'Button label
{{Identical|Submit}}',
	'feedback-adding'    => 'Progress notice',
	'feedback-error1'    => 'Error message, appears when an unknown error occurs submitting feedback',
	'feedback-error2'    => 'Error message, appears when we could not add feedback',
	'feedback-error3'    => 'Error message, appears when we lose our connection to the wiki',
	'feedback-thanks'    => 'Thanks message, appears if feedback was successful',
	'feedback-close'     => 'Button label
{{Identical|Done}}',
	'feedback-bugcheck'  => 'Message that appears before the user submits a bug, reminding them to check for known bugs.',
	'feedback-bugnew'    => 'Button label - asserts that the user has checked for existing bugs. When clicked will launch a bugzilla form to add a new bug in a new tab or window',

);
