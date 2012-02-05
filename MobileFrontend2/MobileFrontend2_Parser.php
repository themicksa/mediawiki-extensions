<?php

/**
 * Replacement parser for the mobile frontend so we can modify the output
 */
class MobileFrontend2_Parser extends Parser {
	/*function makeImage( $title, $options, $holders = false ) {
		return '<!-- img -->';
	}*/
	function formatHeadings( $text, $origText, $isMain = true ) {

		// Kill the TOC with vengeance
		$this->mShowToc = false;
		unset( $this->mDoubleUnderscores['forcetoc'] );

		return parent::formatHeadings( $text, $origText, $isMain );
	}

}
