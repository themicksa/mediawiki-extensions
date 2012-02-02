<?php

/**
 * File holding the SPSUtils class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticPageSeries
 */
if ( !defined( 'SPS_VERSION' ) ) {
	die( 'This file is part of the SemanticPageSeries extension, it is not a valid entry point.' );
}

/**
 * The SPSUtils class.
 *
 * @ingroup SemanticPageSeries
 */
class SPSUtils {

	/**
	 * Initialize the parser functions of the extension.
	 * 
	 * Currently only #serieslink
	 * 
	 * @param Parser $parser
	 * @return bool 
	 */
	static public function initParserFunction( &$parser ) {

		// Create a function hook associating the "example" magic word with the
		// efExampleParserFunction_Render() function.
		$parser->setFunctionHook( 'serieslink', array('SPSUtils', 'renderSeriesLink') );

		// Return true so that MediaWiki continues to load extensions.
		return true;
	}

	/**
	 * Renders the #serieslink parser function.
	 * 
	 * @param Parser $parser
	 * @return string the unique tag which must be inserted into the stripped text 
	 */
	static public function renderSeriesLink( &$parser ) {
		
		global $wgTitle;
		
		$params = func_get_args();
		array_shift( $params ); // We don't need the parser.
		
		// remove the target parameter should it be present
		foreach ( $params as $key => $value ) {
			$elements = explode( '=', $value, 2 );
			if ( $elements[0] === 'target' ){
				unset($params[$key]);
			}

		}

		// set the origin parameter
		// This will block it from use as iterator parameter. Oh well.
		$params[] = "origin=" . $parser->getTitle()->getArticleId();
		
		// hack to remove newline from beginning of output, thanks to
		// http://jimbojw.com/wiki/index.php?title=Raw_HTML_Output_from_a_MediaWiki_Parser_Function
		return $parser->insertStripItem( SFUtils::createFormLink( $parser, 'SeriesEdit', $params ), $parser->mStripState );
	}

}
