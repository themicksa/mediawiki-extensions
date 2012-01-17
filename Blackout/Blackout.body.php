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
	 * Override action hook. This is the show-stopper
	 *
	 * @param $output OutputPage
	 * @param $article Article
	 * @param $title Title
	 * @param $user User
	 * @param $request WebRequest
	 * @param $wiki MediaWiki
	 * @return bool
	 */
	public static function overrideAction( $output, $article, $title, $user, $request, $wiki ) {
		global $wgBlackout;

		// You know what this does
		if ( !$wgBlackout['Enable'] ) {
			return true;
		}

		$skinClass = "Skin{$wgBlackout['Skin']}";
		$skin = new $skinClass();
		$output->getContext()->setSkin( $skin );

		return false;
	}
}
