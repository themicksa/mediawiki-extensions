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
}