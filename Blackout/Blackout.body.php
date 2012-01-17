<?php

/**
 * Class file for the Blackout extension
 *
 * @addtogroup Extensions
 * @license GPL
 */

/**
 * Blackout class
 */
class Blackout {

	/**
	 * Function displaying banner
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool
	 */
	public static function BlackoutBanner( OutputPage &$out, Skin &$skin ) {
		global $wgBlackout, $wgOut;

		$out->addModules( 'ext.blackout' );

		return true;
	}

	/**
	 * SkinAfterBottomScripts hook handler
	 * This function outputs the call to the geoIP lookup
	 * @param $skin Skin
	 * @param $text string
	 * @return bool
	 */
	function GeoLoader( $skin, &$text ) {
		// Insert the geoIP lookup
		$text .= Html::linkedScript( "//geoiplookup.wikimedia.org/" );
		return true;
	}
}
