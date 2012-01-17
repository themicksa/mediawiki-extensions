<?php

/**
 * Hooks for the spam blacklist extension
 */
class SpamBlacklistHooks {
	/**
	 * Get an instance of SpamBlacklist and do some first-call initialisation.
	 * All actual functionality is implemented in that object
	 */
	static function getSpamBlacklistObject() {
		global $wgSpamBlacklistFiles, $wgSpamBlacklistSettings;
		static $spamObj;
		if ( !$spamObj ) {
			require_once( "SpamBlacklist_body.php" );
			$spamObj = new SpamBlacklist( $wgSpamBlacklistSettings );
			if( $wgSpamBlacklistFiles ) {
				$spamObj->files = $wgSpamBlacklistFiles;
			}
		}
		return $spamObj;
	}

	/**
	 * Hook function for EditFilterMerged
	 */
	static function filterMerged( $editPage, $text, &$hookErr, $editSummary ) {
		global $wgTitle;
		if( is_null( $wgTitle ) ) {
			# API mode
			# wfSpamBlacklistFilterAPIEditBeforeSave already checked the blacklist
			return true;
		}

		$spamObj = self::getSpamBlacklistObject();
		$title = $editPage->mArticle->getTitle();
		$ret = $spamObj->filter( $title, $text, '', $editSummary, $editPage );
		if ( $ret !== false ) {
			// spamPageWithContent() method was added in MW 1.17
			if ( method_exists( $editPage, 'spamPageWithContent' ) ) {
				$editPage->spamPageWithContent( $ret );
			} else {
				$editPage->spamPage( $ret );
			}
		}
		// Return convention for hooks is the inverse of $wgFilterCallback
		return ( $ret === false );
	}

	/**
	 * Hook function for APIEditBeforeSave
	 */
	static function filterAPIEditBeforeSave( $editPage, $text, &$resultArr ) {
		$spamObj = self::getSpamBlacklistObject();
		$title = $editPage->mArticle->getTitle();
		$ret = $spamObj->filter( $title, $text, '', '', $editPage );
		if ( $ret!==false ) {
			$resultArr['spamblacklist'] = $ret;
		}
		// Return convention for hooks is the inverse of $wgFilterCallback
		return ( $ret === false );
	}

	/**
	 * Hook function for EditFilter
	 * Confirm that a local blacklist page being saved is valid,
	 * and toss back a warning to the user if it isn't.
	 */
	static function validate( $editPage, $text, $section, &$hookError ) {
		$spamObj = self::getSpamBlacklistObject();
		return $spamObj->validate( $editPage, $text, $section, $hookError );
	}

	/**
	 * Hook function for ArticleSaveComplete
	 * Clear local spam blacklist caches on page save.
	 */
	static function articleSave( &$article, &$user, $text, $summary, $isminor, $iswatch, $section ) {
		$spamObj = self::getSpamBlacklistObject();
		return $spamObj->onArticleSave( $article, $user, $text, $summary, $isminor, $iswatch, $section );
	}
}
