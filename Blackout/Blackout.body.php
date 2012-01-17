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
	 * Override action hook. This is the show-stopper
	 *
	 * @param $output OutputPage
	 * @param $article Article
	 * @param $title Title
	 * @param $user User
	 * @param $request WebRequest
	 * @param $wiki MediaWiki
	 */
	public static function overrideAction( $output, $article, $title, $user, $request, $wiki ) {

		$output->clearHTML();
		$skin = new SkinBlackout();
		$output->getContext()->setSkin( $skin );

		//$tpl = new BlackoutTemplate();

		//$output->addTemplate( $tpl );

		return false;
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
