<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MediaWikiFeedback',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Feedback',
	'author' => array( 'Ryan Kaldari', 'Neil Kandalgaonkar' ),
	'descriptionmsg' => 'feedback-desc',
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['Feedback'] = $dir . 'Feedback.i18n.php';

$wgResourceModules['ext.feedback'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'Feedback/modules',
	'scripts' => 'ext.feedback.js',
	'dependencies' => array(
		'mediawiki.api.edit',
		'mediawiki.Title',
		'mediawiki.jqueryMsg',
		'jquery.ui.dialog',
	),
	'messages' => array(
		'feedback-bugornote',
		'feedback-subject',
		'feedback-message',
		'feedback-cancel',
		'feedback-submit',
		'feedback-adding',
		'feedback-error1',
		'feedback-error2',
		'feedback-error3',
		'feedback-thanks',
		'feedback-close',
		'feedback-bugcheck',
		'feedback-bugnew',
	),
);
