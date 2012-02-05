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
		if ( !MobileFrontend2_Detection::isEnabled() ) {
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

	/**
	 * Since we use a custom parser we need to segregate the cache
	 *
	 * @param $hash
	 * @return bool
	 */
	public static function renderHash( &$hash ) {
		if ( MobileFrontend2_Detection::isEnabled() ) {
			$hash .= 'M';
		}

		return true;
	}

	/**
	 * Adds jump back a section links to content blocks
	 *
	 * @param $parser MobileFrontend2_Parser
	 * @param $i int
	 * @param $section string
	 * @param $showEditLink bool
	 * @return bool
	 */
	public static function parserSectionCreate( $parser, $i, &$section, $showEditLink ) {
		if ( !MobileFrontend2_Detection::isEnabled() ) {
			return true;
		}

		// We don't enclose the opening section
		if ( $i == 0 ) {
			return true;
		}

		// Separate the header from the section
		preg_match( '/<H[1-6].*?' . '>.*?<\/H[1-6]>/i', $section, $match );
		$headerLength = strlen( $match[0] );

		$section = substr( $section, 0, $headerLength )
			. '<div class="content_block">'
			. substr( $section, $headerLength )
			. '<div class="section_anchors">'
				. '<a href="#section_' . $i . '" class="back_to_top">↑Jump back a section</a>'
			. '</div></div>';

		return true;
	}

	/**
	 * Perform very early setup
	 *
	 * This implements the parser if we're going to use the frontend
	 * @return bool
	 */
	public static function setup() {
		if ( !MobileFrontend2_Detection::isEnabled() ) {
			return true;
		}
		global $wgMobileFrontend2Logo, $wgExtensionAssetsPath, $wgParser;
		global $wgParserConf;

		// We need a sane default and $wgExtensionAssetsPath isn't ready until
		// after LocalSettings
		if ( $wgMobileFrontend2Logo === null ) {
			$wgMobileFrontend2Logo = $wgExtensionAssetsPath . '/MobileFrontend2/modules/ext.mobileFrontend2/images/mw.png';
		}

		// If they're using a custom parser we're pretty much boned and should
		// just abort now and avoid problems later
		if ( $wgParserConf['class'] != 'Parser' ) {
			throw new MWException( '$wgParserConf is set to use a non-standard parser, which is incompatible with MobileFrontend2' );
		}

		$wgParserConf['class'] = 'MobileFrontend2_Parser';
		$wgParser = new StubObject( 'wgParser', $wgParserConf['class'], array( $wgParserConf ) );
	}
}