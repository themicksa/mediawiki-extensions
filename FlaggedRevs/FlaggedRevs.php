<?php
/*
 (c) Aaron Schulz, Joerg Baach, 2007-2008 GPL

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 http://www.gnu.org/copyleft/gpl.html
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "FlaggedRevs extension\n";
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Flagged Revisions',
	'author'         => array( 'Aaron Schulz', 'Joerg Baach' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:FlaggedRevs',
	'descriptionmsg' => 'flaggedrevs-desc',
);

# Load global constants
require( "FlaggedRevs.defines.php" );

# Load default configuration variables
require( "FlaggedRevs.config.php" );

# This messes with dump HTML...
if ( defined( 'MW_HTML_FOR_DUMP' ) ) {
	return;
}

# Bots are granted autoreview via hooks, mark in rights
# array so that it shows up in sp:ListGroupRights...
$wgGroupPermissions['bot']['autoreview'] = true;

# Lets some users access the review UI and set some flags
$wgAvailableRights[] = 'review'; # review pages to basic levels
$wgAvailableRights[] = 'validate'; # review pages to all levels
$wgAvailableRights[] = 'autoreview'; # auto-review pages on edit (including rollback)
$wgAvailableRights[] = 'autoreviewrestore'; # auto-review on rollback
$wgAvailableRights[] = 'unreviewedpages'; # view the list of unreviewed pages
$wgAvailableRights[] = 'movestable'; # move pages with stable versions
$wgAvailableRights[] = 'stablesettings'; # change page stability settings

$wgExtensionFunctions[] = 'efLoadFlaggedRevs';

$dir = dirname( __FILE__ ) . '/';
$langDir = $dir . 'presentation/language/';

# Load main i18n file and special page alias file
$wgExtensionMessagesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.i18n.php';
$wgExtensionAliasesFiles['FlaggedRevs'] = $langDir . 'FlaggedRevs.alias.php';

$accessDir = $dir . 'dataclasses/';
# Utility classes...
$wgAutoloadClasses['FlaggedRevs'] = $accessDir . 'FlaggedRevs.class.php';
$wgAutoloadClasses['FRUserCounters'] = $accessDir . 'FRUserCounters.php';
$wgAutoloadClasses['FRUserActivity'] = $accessDir . 'FRUserActivity.php';
$wgAutoloadClasses['FRPageConfig'] = $accessDir . 'FRPageConfig.php';
$wgAutoloadClasses['FlaggedRevsLog'] = $accessDir . 'FlaggedRevsLog.php';
$wgAutoloadClasses['FRInclusionCache'] = $accessDir . 'FRInclusionCache.php';
$wgAutoloadClasses['FlaggedRevsStats'] = $accessDir . 'FlaggedRevsStats.php';
# Data object classes...
$wgAutoloadClasses['FRExtraCacheUpdate'] = $accessDir . 'FRExtraCacheUpdate.php';
$wgAutoloadClasses['FRExtraCacheUpdateJob'] = $accessDir . 'FRExtraCacheUpdate.php';
$wgAutoloadClasses['FRSquidUpdate'] = $accessDir . 'FRExtraCacheUpdate.php';
$wgAutoloadClasses['FRDependencyUpdate'] = $accessDir . 'FRDependencyUpdate.php';
$wgAutoloadClasses['FRInclusionManager'] = $accessDir . 'FRInclusionManager.php';
$wgAutoloadClasses['FlaggableWikiPage'] = $accessDir . 'FlaggableWikiPage.php';
$wgAutoloadClasses['FlaggedRevision'] = $accessDir . 'FlaggedRevision.php';
$wgAutoloadClasses['FRParserCacheStable'] = $accessDir . 'FRParserCacheStable.php';

# Event handler classes...
$wgAutoloadClasses['FlaggedRevsHooks'] = $dir . 'dataclasses/FlaggedRevs.hooks.php';
$wgAutoloadClasses['FlaggedRevsUIHooks'] = $dir . 'presentation/FlaggedRevsUI.hooks.php';
$wgAutoloadClasses['FlaggedRevsApiHooks'] = $dir . 'api/FlaggedRevsApi.hooks.php';
$wgAutoloadClasses['FlaggedRevsUpdaterHooks'] = $dir . 'schema/FlaggedRevsUpdater.hooks.php';
$wgAutoloadClasses['FlaggedRevsTestHooks'] = $dir . 'tests/FlaggedRevsTest.hooks.php';

# Business object classes
$wgAutoloadClasses['FRGenericSubmitForm'] = $dir . 'business/FRGenericSubmitForm.php';
$wgAutoloadClasses['RevisionReviewForm'] = $dir . 'business/RevisionReviewForm.php';
$wgAutoloadClasses['PageStabilityForm'] = $dir . 'business/PageStabilityForm.php';
$wgAutoloadClasses['PageStabilityGeneralForm'] = $dir . 'business/PageStabilityForm.php';
$wgAutoloadClasses['PageStabilityProtectForm'] = $dir . 'business/PageStabilityForm.php';

# Presentation classes...
$wgAutoloadClasses['FlaggablePageView'] = $dir . 'presentation/FlaggablePageView.php';
$wgAutoloadClasses['FlaggedRevsLogView'] = $dir . 'presentation/FlaggedRevsLogView.php';
$wgAutoloadClasses['FlaggedRevsXML'] = $dir . 'presentation/FlaggedRevsXML.php';
$wgAutoloadClasses['RevisionReviewFormUI'] = $dir . 'presentation/RevisionReviewFormUI.php';
$wgAutoloadClasses['RejectConfirmationFormUI'] = $dir . 'presentation/RejectConfirmationFormUI.php';

$specialActionDir = $dir . 'presentation/specialpages/actions/';
# Load revision review UI
$wgAutoloadClasses['RevisionReview'] = $specialActionDir . 'RevisionReview_body.php';
$wgExtensionMessagesFiles['RevisionReview'] = $langDir . 'RevisionReview.i18n.php';
# Stable version config UI
$wgAutoloadClasses['Stabilization'] = $specialActionDir . 'Stabilization_body.php';
$wgExtensionMessagesFiles['Stabilization'] = $langDir . 'Stabilization.i18n.php';

$specialReportDir = $dir . 'presentation/specialpages/reports/';
# Reviewed versions list
$wgAutoloadClasses['ReviewedVersions'] = $specialReportDir . 'ReviewedVersions_body.php';
$wgExtensionMessagesFiles['ReviewedVersions'] = $langDir . 'ReviewedVersions.i18n.php';
# Unreviewed pages list
$wgAutoloadClasses['UnreviewedPages'] = $specialReportDir . 'UnreviewedPages_body.php';
$wgExtensionMessagesFiles['UnreviewedPages'] = $langDir . 'UnreviewedPages.i18n.php';
$wgSpecialPageGroups['UnreviewedPages'] = 'quality';
# Pages with pending changes list
$wgAutoloadClasses['PendingChanges'] = $specialReportDir . 'PendingChanges_body.php';
$wgExtensionMessagesFiles['PendingChanges'] = $langDir . 'PendingChanges.i18n.php';
$wgSpecialPageGroups['PendingChanges'] = 'quality';
# Pages with tagged pending changes list
$wgAutoloadClasses['ProblemChanges'] = $specialReportDir . 'ProblemChanges_body.php';
$wgExtensionMessagesFiles['ProblemChanges'] = $langDir . 'ProblemChanges.i18n.php';
$wgSpecialPageGroups['ProblemChanges'] = 'quality';
# Reviewed pages list
$wgAutoloadClasses['ReviewedPages'] = $specialReportDir . 'ReviewedPages_body.php';
$wgExtensionMessagesFiles['ReviewedPages'] = $langDir . 'ReviewedPages.i18n.php';
$wgSpecialPageGroups['ReviewedPages'] = 'quality';
# Stable pages list (for protection config)
$wgAutoloadClasses['StablePages'] = $specialReportDir . 'StablePages_body.php';
$wgExtensionMessagesFiles['StablePages'] = $langDir . 'StablePages.i18n.php';
$wgSpecialPageGroups['StablePages'] = 'quality';
# Configured pages list (non-protection config)
$wgAutoloadClasses['ConfiguredPages'] = $specialReportDir . 'ConfiguredPages_body.php';
$wgExtensionMessagesFiles['ConfiguredPages'] = $langDir . 'ConfiguredPages.i18n.php';
$wgSpecialPageGroups['ConfiguredPages'] = 'quality';
# Filterable review log page to oversee reviews
$wgAutoloadClasses['QualityOversight'] = $specialReportDir . 'QualityOversight_body.php';
$wgExtensionMessagesFiles['QualityOversight'] = $langDir . 'QualityOversight.i18n.php';
$wgSpecialPageGroups['QualityOversight'] = 'quality';
# Review statistics
$wgAutoloadClasses['ValidationStatistics'] = $specialReportDir . 'ValidationStatistics_body.php';
$wgExtensionMessagesFiles['ValidationStatistics'] = $langDir . 'ValidationStatistics.i18n.php';
$wgSpecialPageGroups['ValidationStatistics'] = 'quality';

$apiActionDir = $dir . 'api/actions/';
# Page review module for API
$wgAutoloadClasses['ApiReview'] = $apiActionDir . 'ApiReview.php';
$wgAPIModules['review'] = 'ApiReview';
# Page review activity module for API
$wgAutoloadClasses['ApiReviewActivity'] = $apiActionDir . 'ApiReviewActivity.php';
$wgAPIModules['reviewactivity'] = 'ApiReviewActivity';
# Stability config module for API
$wgAutoloadClasses['ApiStabilize'] = $apiActionDir . 'ApiStabilize.php';
$wgAutoloadClasses['ApiStabilizeGeneral'] = $apiActionDir . 'ApiStabilize.php';
$wgAutoloadClasses['ApiStabilizeProtect'] = $apiActionDir . 'ApiStabilize.php';

$apiReportDir = $dir . 'api/reports/';
# OldReviewedPages for API
$wgAutoloadClasses['ApiQueryOldreviewedpages'] = $apiReportDir . 'ApiQueryOldreviewedpages.php';
$wgAPIListModules['oldreviewedpages'] = 'ApiQueryOldreviewedpages';
# UnreviewedPages for API
$wgAutoloadClasses['ApiQueryUnreviewedpages'] = $apiReportDir . 'ApiQueryUnreviewedpages.php';
# ReviewedPages for API
$wgAutoloadClasses['ApiQueryReviewedpages'] = $apiReportDir . 'ApiQueryReviewedpages.php';
# ConfiguredPages for API
$wgAutoloadClasses['ApiQueryConfiguredpages'] = $apiReportDir . 'ApiQueryConfiguredPages.php';
# Flag metadata for pages for API
$wgAutoloadClasses['ApiQueryFlagged'] = $apiReportDir . 'ApiQueryFlagged.php';
$wgAPIPropModules['flagged'] = 'ApiQueryFlagged';
# Site flag config for API
$wgAutoloadClasses['ApiFlagConfig'] = $apiReportDir . 'ApiFlagConfig.php';
$wgAPIModules['flagconfig'] = 'ApiFlagConfig';

# Special case cache invalidations
$wgJobClasses['flaggedrevs_CacheUpdate'] = 'FRExtraCacheUpdateJob';

# New user preferences
$wgDefaultUserOptions['flaggedrevssimpleui'] = (int)$wgSimpleFlaggedRevsUI;
$wgDefaultUserOptions['flaggedrevsstable'] = FR_SHOW_STABLE_DEFAULT;
$wgDefaultUserOptions['flaggedrevseditdiffs'] = true;
$wgDefaultUserOptions['flaggedrevsviewdiffs'] = false;

# Add review log
$wgLogTypes[] = 'review';
# Add stable version log
$wgLogTypes[] = 'stable';

# Log action handlers
FlaggedRevsUIHooks::defineLogBasicDesc( $wgLogNames, $wgLogHeaders, $wgFilterLogTypes );
FlaggedRevsUIHooks::defineLogActionHanders( $wgLogActions, $wgLogActionsHandlers );

# JS/CSS modules and message bundles used by JS scripts
FlaggedRevsUIHooks::defineResourceModules( $wgResourceModules );

# ####### EVENT-HANDLER FUNCTIONS  #########

# ######## User interface #########
# Override current revision, add patrol links, set cache...
$wgHooks['ArticleViewHeader'][] = 'FlaggedRevsUIHooks::onArticleViewHeader';
$wgHooks['ImagePageFindFile'][] = 'FlaggedRevsUIHooks::onImagePageFindFile';
# Override redirect behavior...
$wgHooks['InitializeArticleMaybeRedirect'][] = 'FlaggedRevsUIHooks::overrideRedirect';
# Set page view tabs
$wgHooks['SkinTemplateTabs'][] = 'FlaggedRevsUIHooks::onSkinTemplateTabs'; // All skins
$wgHooks['SkinTemplateNavigation'][] = 'FlaggedRevsUIHooks::onSkinTemplateNavigation'; // Vector
# Add notice tags to edit view
$wgHooks['EditPage::showEditForm:initial'][] = 'FlaggedRevsUIHooks::addToEditView';
# Tweak submit button name/title
$wgHooks['EditPageBeforeEditButtons'][] = 'FlaggedRevsUIHooks::onBeforeEditButtons';
# Autoreview information from form
$wgHooks['EditPageBeforeEditChecks'][] = 'FlaggedRevsUIHooks::addReviewCheck';
$wgHooks['EditPage::showEditForm:fields'][] = 'FlaggedRevsUIHooks::addRevisionIDField';
# Add draft link to section edit error
$wgHooks['EditPageNoSuchSection'][] = 'FlaggedRevsUIHooks::onNoSuchSection';
# Add notice tags to history
$wgHooks['PageHistoryBeforeList'][] = 'FlaggedRevsUIHooks::addToHistView';
# Add review form and visiblity settings link
$wgHooks['SkinAfterContent'][] = 'FlaggedRevsUIHooks::onSkinAfterContent';
# Mark items in page history
$wgHooks['PageHistoryPager::getQueryInfo'][] = 'FlaggedRevsUIHooks::addToHistQuery';
$wgHooks['PageHistoryLineEnding'][] = 'FlaggedRevsUIHooks::addToHistLine';
$wgHooks['LocalFile::getHistory'][] = 'FlaggedRevsUIHooks::addToFileHistQuery';
$wgHooks['ImagePageFileHistoryLine'][] = 'FlaggedRevsUIHooks::addToFileHistLine';
# Select extra info & filter items in RC
$wgHooks['SpecialRecentChangesQuery'][] = 'FlaggedRevsUIHooks::modifyRecentChangesQuery';
$wgHooks['SpecialNewpagesConditions'][] = 'FlaggedRevsUIHooks::modifyNewPagesQuery';
$wgHooks['SpecialWatchlistQuery'][] = 'FlaggedRevsUIHooks::modifyChangesListQuery';
# Mark items in RC
$wgHooks['ChangesListInsertArticleLink'][] = 'FlaggedRevsUIHooks::addToChangeListLine';
# RC filter UIs
$wgHooks['SpecialNewPagesFilters'][] = 'FlaggedRevsUIHooks::addHideReviewedFilter';
$wgHooks['SpecialRecentChangesFilters'][] = 'FlaggedRevsUIHooks::addHideReviewedFilter';
$wgHooks['SpecialWatchlistFilters'][] = 'FlaggedRevsUIHooks::addHideReviewedFilter';
# Page review on edit
$wgHooks['ArticleUpdateBeforeRedirect'][] = 'FlaggedRevsUIHooks::injectPostEditURLParams';
# Diff-to-stable
$wgHooks['DiffViewHeader'][] = 'FlaggedRevsUIHooks::onDiffViewHeader';
# Add diff=review url param alias
$wgHooks['NewDifferenceEngine'][] = 'FlaggedRevsUIHooks::checkDiffUrl';
# Local user account preference
$wgHooks['GetPreferences'][] = 'FlaggedRevsUIHooks::onGetPreferences';
# Show unreviewed pages links
$wgHooks['CategoryPageView'][] = 'FlaggedRevsUIHooks::onCategoryPageView';
# Review/stability log links
$wgHooks['LogLine'][] = 'FlaggedRevsUIHooks::logLineLinks';

# Add review notice, backlog notices and CSS/JS and set robots
$wgHooks['BeforePageDisplay'][] = 'FlaggedRevsUIHooks::onBeforePageDisplay';
# Add global JS vars
$wgHooks['MakeGlobalVariablesScript'][] = 'FlaggedRevsUIHooks::injectGlobalJSVars';

# Add flagging data to ApiQueryRevisions
$wgHooks['APIGetAllowedParams'][] = 'FlaggedRevsApiHooks::addApiRevisionParams';
$wgHooks['APIQueryAfterExecute'][] = 'FlaggedRevsApiHooks::addApiRevisionData';
# ########

# ######## Parser #########
# Parser hooks, selects the desired images/templates
$wgHooks['BeforeParserFetchTemplateAndtitle'][] = 'FlaggedRevsHooks::parserFetchStableTemplate';
$wgHooks['BeforeParserFetchFileAndTitle'][] = 'FlaggedRevsHooks::parserFetchStableFile';
# B/C for before ParserOutput::mImageTimeKeys
$wgHooks['OutputPageParserOutput'][] = 'FlaggedRevsHooks::outputSetVersioningFlag';
# ########

# ######## DB write operations #########
# Autopromote Editors
$wgHooks['ArticleSaveComplete'][] = 'FlaggedRevsHooks::onArticleSaveComplete';
# Auto-reviewing
$wgHooks['RecentChange_save'][] = 'FlaggedRevsHooks::autoMarkPatrolled';
$wgHooks['NewRevisionFromEditComplete'][] = 'FlaggedRevsHooks::maybeMakeEditReviewed';
# Null edit review via checkbox
$wgHooks['ArticleSaveComplete'][] = 'FlaggedRevsHooks::maybeNullEditReview';
# User edit tallies
$wgHooks['ArticleRollbackComplete'][] = 'FlaggedRevsHooks::incrementRollbacks';
$wgHooks['NewRevisionFromEditComplete'][] = 'FlaggedRevsHooks::incrementReverts';
# Update fr_page_id and tracking rows on revision restore and merge
$wgHooks['ArticleRevisionUndeleted'][] = 'FlaggedRevsHooks::onRevisionRestore';
$wgHooks['ArticleMergeComplete'][] = 'FlaggedRevsHooks::onArticleMergeComplete';

# Update tracking rows and cache on page changes (@TODO: this sucks):
# Article edit/create
$wgHooks['ArticleEditUpdates'][] = 'FlaggedRevsHooks::onArticleEditUpdates';
# Article delete/restore
$wgHooks['ArticleDeleteComplete'][] = 'FlaggedRevsHooks::onArticleDelete';
$wgHooks['ArticleUndelete'][] = 'FlaggedRevsHooks::onArticleUndelete';
# Revision delete/restore
$wgHooks['ArticleRevisionVisibilitySet'][] = 'FlaggedRevsHooks::onRevisionDelete';
# Article move
$wgHooks['TitleMoveComplete'][] = 'FlaggedRevsHooks::onTitleMoveComplete';
# File upload
$wgHooks['FileUpload'][] = 'FlaggedRevsHooks::onFileUpload';
# ########

# ######## Other #########
# Determine what pages can be moved and patrolled
$wgHooks['getUserPermissionsErrors'][] = 'FlaggedRevsHooks::onUserCan';
# Implicit autoreview rights group
$wgHooks['AutopromoteCondition'][] = 'FlaggedRevsHooks::checkAutoPromoteCond';

# Actually register special pages
$wgHooks['SpecialPage_initList'][] = 'FlaggedRevsUIHooks::defineSpecialPages';

# Stable dump hook
$wgHooks['WikiExporter::dumpStableQuery'][] = 'FlaggedRevsHooks::stableDumpQuery';

# GNSM category hooks
$wgHooks['GoogleNewsSitemap::Query'][] = 'FlaggedRevsHooks::gnsmQueryModifier';

# Duplicate flagged* tables in parserTests.php
$wgHooks['ParserTestTables'][] = 'FlaggedRevsTestHooks::onParserTestTables';
# Integration tests
$wgHooks['UnitTestsList'][] = 'FlaggedRevsTestHooks::getUnitTests';

# Database schema changes
$wgHooks['LoadExtensionSchemaUpdates'][] = 'FlaggedRevsUpdaterHooks::addSchemaUpdates';

# ########

function efSetFlaggedRevsConditionalHooks() {
	global $wgHooks, $wgFlaggedRevsProtection;
	# Mark items in user contribs
	if ( !$wgFlaggedRevsProtection ) {
		$wgHooks['ContribsPager::getQueryInfo'][] = 'FlaggedRevsUIHooks::addToContribsQuery';
		$wgHooks['ContributionsLineEnding'][] = 'FlaggedRevsUIHooks::addToContribsLine';
	} else {
		# Add protection form field
		$wgHooks['ProtectionForm::buildForm'][] = 'FlaggedRevsUIHooks::onProtectionForm';
		$wgHooks['ProtectionForm::showLogExtract'][] = 'FlaggedRevsUIHooks::insertStabilityLog';
		# Save stability settings
		$wgHooks['ProtectionForm::save'][] = 'FlaggedRevsUIHooks::onProtectionSave';
		# Parser stuff
		$wgHooks['ParserFirstCallInit'][] = 'FlaggedRevsHooks::onParserFirstCallInit';
		$wgHooks['LanguageGetMagic'][] = 'FlaggedRevsHooks::onLanguageGetMagic';
		$wgHooks['ParserGetVariableValueSwitch'][] = 'FlaggedRevsHooks::onParserGetVariableValueSwitch';
		$wgHooks['MagicWordwgVariableIDs'][] = 'FlaggedRevsHooks::onMagicWordwgVariableIDs';
	}
	# Give bots the 'autoreview' right (here so it triggers after CentralAuth)
	# @TODO: better way to ensure hook order
	$wgHooks['UserGetRights'][] = 'FlaggedRevsHooks::onUserGetRights';
}

# ####### END HOOK TRIGGERED FUNCTIONS  #########

// Note: avoid calls to FlaggedRevs class here for performance
function efLoadFlaggedRevs() {
	# Conditional autopromote groups
	efSetFlaggedRevsAutopromoteConfig();

	# Conditional API modules
	efSetFlaggedRevsConditionalAPIModules();
	# Load hooks that aren't always set
	efSetFlaggedRevsConditionalHooks();
	# Remove conditionally applicable rights
	efSetFlaggedRevsConditionalRights();
	# Defaults for user preferences
	efSetFlaggedRevsConditionalPreferences();
}

function efSetFlaggedRevsAutopromoteConfig() {
	global $wgFlaggedRevsAutoconfirm, $wgFlaggedRevsAutopromote;
	global $wgAutopromoteOnce, $wgGroupPermissions;
	# $wgFlaggedRevsAutoconfirm is now a wrapper around $wgAutopromoteOnce
	$req = $wgFlaggedRevsAutoconfirm; // convenience
	if ( is_array( $req ) ) {
		$criteria = array( '&', // AND
			array( APCOND_AGE, $req['days']*86400 ),
			array( APCOND_EDITCOUNT, $req['edits'] ),
			array( APCOND_FR_EDITSUMMARYCOUNT, $req['editComments'] ),
			array( APCOND_FR_UNIQUEPAGECOUNT, $req['uniqueContentPages'] ),
			array( APCOND_FR_EDITSPACING, $req['spacing'], $req['benchmarks'] ),
			array( '|', // OR
				array( APCOND_FR_CONTENTEDITCOUNT, $req['totalContentEdits'] ),
				array( APCOND_FR_CHECKEDEDITCOUNT, $req['totalCheckedEdits'] )
			)
		);
		if ( $req['email'] ) {
			$criteria[] = array( APCOND_EMAILCONFIRMED );
		}
		if ( $req['neverBlocked'] ) {
			$criteria[] = array( APCOND_FR_NEVERBOCKED );
		}
		$wgAutopromoteOnce['onEdit']['autoreview'] = $criteria;
		$wgGroupPermissions['autoreview']['autoreview'] = true;
	}

	# $wgFlaggedRevsAutoconfirm is now a wrapper around $wgAutopromoteOnce
	$req = $wgFlaggedRevsAutopromote; // convenience
	if ( is_array( $req ) ) {
		$criteria = array( '&', // AND
			array( APCOND_AGE, $req['days']*86400 ),
			array( APCOND_FR_EDITCOUNT, $req['edits'], $req['excludeLastDays']*86400 ),
			array( APCOND_FR_EDITSUMMARYCOUNT, $req['editComments'] ),
			array( APCOND_FR_UNIQUEPAGECOUNT, $req['uniqueContentPages'] ),
			array( APCOND_FR_USERPAGEBYTES, $req['userpageBytes'] ),
			array( APCOND_FR_NEVERDEMOTED ), // for b/c
			array( APCOND_FR_EDITSPACING, $req['spacing'], $req['benchmarks'] ),
			array( '|', // OR
				array( APCOND_FR_CONTENTEDITCOUNT,
					$req['totalContentEdits'], $req['excludeLastDays']*86400 ),
				array( APCOND_FR_CHECKEDEDITCOUNT,
					$req['totalCheckedEdits'], $req['excludeLastDays']*86400 )
			),
			array( APCOND_FR_MAXREVERTEDEDITRATIO, $req['maxRevertedEditRatio'] ),
			array( '!', APCOND_ISBOT )
		);
		if ( $req['neverBlocked'] ) {
			$criteria[] = array( APCOND_FR_NEVERBOCKED );
		}
		$wgAutopromoteOnce['onEdit']['editor'] = $criteria;
	}
}

function efSetFlaggedRevsConditionalAPIModules() {
	global $wgAPIModules, $wgAPIListModules, $wgFlaggedRevsProtection;
	if ( $wgFlaggedRevsProtection ) {
		$wgAPIModules['stabilize'] = 'ApiStabilizeProtect';
	} else {
		$wgAPIModules['stabilize'] = 'ApiStabilizeGeneral';
		$wgAPIListModules['reviewedpages'] = 'ApiQueryReviewedpages';
		$wgAPIListModules['unreviewedpages'] = 'ApiQueryUnreviewedpages';
		$wgAPIListModules['configuredpages'] = 'ApiQueryConfiguredpages';
	}
}

function efSetFlaggedRevsConditionalRights() {
	global $wgGroupPermissions, $wgFlaggedRevsProtection;
	if ( $wgFlaggedRevsProtection ) {
		// Removes sp:ListGroupRights cruft
		if ( isset( $wgGroupPermissions['editor'] ) ) {
			unset( $wgGroupPermissions['editor']['unreviewedpages'] );
		}
		if ( isset( $wgGroupPermissions['reviewer'] ) ) {
			unset( $wgGroupPermissions['reviewer']['unreviewedpages'] );
		}
	}
}

function efSetFlaggedRevsConditionalPreferences() {
	global $wgDefaultUserOptions, $wgSimpleFlaggedRevsUI;
	$wgDefaultUserOptions['flaggedrevssimpleui'] = (int)$wgSimpleFlaggedRevsUI;
}

# AJAX functions
$wgAjaxExportList[] = 'RevisionReview::AjaxReview';
$wgAjaxExportList[] = 'FlaggablePageView::AjaxBuildDiffHeaderItems';

# Cache update
$wgSpecialPageCacheUpdates['UnreviewedPages'] = 'UnreviewedPages::updateQueryCache';
$wgSpecialPageCacheUpdates['ValidationStatistics'] = 'FlaggedRevsStats::updateCache';

# B/C ...
$wgLogActions['rights/erevoke']  = 'rights-editor-revoke';
