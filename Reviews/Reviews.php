<?php

/**
 * Initialization file for the Reviews extension.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:Reviews
 * Support					https://www.mediawiki.org/wiki/Extension_talk:Reviews
 * Source code:			    http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Reviews
 *
 * @file Reviews.php
 * @ingroup Reviews
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Reviews.
 *
 * @defgroup Reviews Reviews
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.18c', '<' ) ) { // Needs to be 1.18c because version_compare() works in confusing ways
	die( '<b>Error:</b> Reviews requires MediaWiki 1.18 or above.' );
}

define( 'REVIEWS_VERSION', '0.1 alpha' );

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Reviews',
	'version' => REVIEWS_VERSION,
	'author' => array(
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
	),
	'url' => 'http://www.mediawiki.org/wiki/Extension:Reviews',
	'descriptionmsg' => 'reviews-desc'
);

// i18n
$wgExtensionMessagesFiles['Reviews'] 			= dirname( __FILE__ ) . '/Reviews.i18n.php';
$wgExtensionMessagesFiles['ReviewsAlias']		= dirname( __FILE__ ) . '/Reviews.alias.php';

// Autoloading
$wgAutoloadClasses['ReviewsHooks'] 				= dirname( __FILE__ ) . '/Reviews.hooks.php';
$wgAutoloadClasses['ReviewsSettings'] 			= dirname( __FILE__ ) . '/Reviews.settings.php';

$wgAutoloadClasses['ApiDeleteReviews'] 			= dirname( __FILE__ ) . '/api/ApiDeleteReviews.php';
$wgAutoloadClasses['ApiQueryReviews'] 			= dirname( __FILE__ ) . '/api/ApiQueryReviews.php';
$wgAutoloadClasses['ApiReviewQuery'] 			= dirname( __FILE__ ) . '/api/ApiReviewQuery.php';
$wgAutoloadClasses['ApiSubmitReview'] 			= dirname( __FILE__ ) . '/api/ApiSubmitReview.php';

$wgAutoloadClasses['Review'] 					= dirname( __FILE__ ) . '/includes/Review.php';
$wgAutoloadClasses['ReviewPager'] 				= dirname( __FILE__ ) . '/includes/ReviewPager.php';
$wgAutoloadClasses['ReviewRating'] 				= dirname( __FILE__ ) . '/includes/ReviewRating.php';
$wgAutoloadClasses['ReviewsDBObject'] 			= dirname( __FILE__ ) . '/includes/ReviewsDBObject.php';

$wgAutoloadClasses['SpecialMyReviews'] 			= dirname( __FILE__ ) . '/specials/SpecialMyReviews.php';
$wgAutoloadClasses['SpecialReviews'] 			= dirname( __FILE__ ) . '/specials/SpecialReviews.php';

// Special pages
$wgSpecialPages['Reviews'] 						= 'SpecialReviews';
$wgSpecialPages['MyReviews'] 					= 'SpecialMyReviews';

$wgSpecialPageGroups['Reviews'] 				= 'reviews';
$wgSpecialPageGroups['MyReviews'] 				= 'reviews';

// API
$wgAPIModules['deletereviews'] 					= 'ApiDeleteReviews';
$wgAPIModules['submitreview'] 					= 'ApiSubmitReview';
$wgAPIListModules['reviews'] 					= 'ApiQueryReviews';

// Hooks
$wgHooks['LoadExtensionSchemaUpdates'][] 		= 'ReviewsHooks::onSchemaUpdate';
$wgHooks['UnitTestsList'][] 					= 'ReviewsHooks::registerUnitTests';
$wgHooks['PersonalUrls'][] 						= 'ReviewsHooks::onPersonalUrls';
$wgHooks['GetPreferences'][] 					= 'ReviewsHooks::onGetPreferences';

// Rights
$wgAvailableRights[] = 'reviewsadmin';
$wgAvailableRights[] = 'reviewer';

# Users that can manage the reviews.
$wgGroupPermissions['*'            ]['reviewsadmin'] = false;
//$wgGroupPermissions['user'         ]['reviewsadmin'] = false;
//$wgGroupPermissions['autoconfirmed']['reviewsadmin'] = false;
//$wgGroupPermissions['bot'          ]['reviewsadmin'] = false;
$wgGroupPermissions['sysop'        ]['reviewsadmin'] = true;
$wgGroupPermissions['reviewsadmin' ]['reviewsadmin'] = true;

# Users that can post reviews.
$wgGroupPermissions['*'            ]['reviewer'] = false;
$wgGroupPermissions['user'         ]['reviewer'] = true;
//$wgGroupPermissions['autoconfirmed']['reviewer'] = true;
//$wgGroupPermissions['bot'          ]['reviewer'] = false;
$wgGroupPermissions['sysop'        ]['reviewer'] = true;
$wgGroupPermissions['reviewer']['reviewer'] = true;


// Resource loader modules
$moduleTemplate = array(
	'localBasePath' => dirname( __FILE__ ) . '/resources',
	'remoteExtPath' => 'Reviews/resources'
);

unset( $moduleTemplate );

$egReviewsSettings = array();

# The default value for the user preference to display a top link to the my reviews special page.
$wgDefaultUserOptions['reviews_showtoplink'] = false;
