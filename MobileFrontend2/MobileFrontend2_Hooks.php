<?php

/**
 * Hooks for the new mobile frontend
 */
class MobileFrontend2_Hooks {
	/**
	 * Loads the mobile skin if we need to
	 *
	 * @param $context ResourceContext
	 * @param $skin Skin
	 * @return bool
	 */
	public static function createSkin( $context, &$skin ) {
		// Abort if we're not using the mobile frontend
		if ( !MobileFrontend2_Detection::shouldEnable() ) {
			return true;
		}

		// TODO: WML support
		$skin = new SkinMobile;

		// Be a dick and halt the hook
		return false;
	}

	/**
	 * Makes modifications to the mobile skin template
	 *
	 * @param $skin SkinTemplate
	 * @param $tpl QuickTemplate
	 * @return bool
	 */
	public static function modifyTemplate( SkinTemplate &$skin, &$tpl ) {
		if ( get_class( $skin ) !== 'SkinMobile' ) {
			return true;
		}

		global $wgMobileFrontend2Logo;

		$tpl->setRef( 'mobilelogopath', $wgMobileFrontend2Logo );

		return true;
	}

	public static function setup() {
		global $wgMobileFrontend2Logo, $wgExtensionAssetsPath;

		if ( $wgMobileFrontend2Logo === null ) {
			$wgMobileFrontend2Logo = $wgExtensionAssetsPath . '/MobileFrontend2/modules/ext.mobileFrontend2/images/mw.png';
		}
	}
}