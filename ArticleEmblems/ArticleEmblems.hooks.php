<?php
/**
 * Hooks for ArticleEmblems extension
 * 
 * @file
 * @ingroup Extensions
 */

class ArticleEmblemsHooks {
	/**
	 * ParserFirstCallInit hook handler
	 *
	 * @param $parser Parser
	 */
	public static function parserFirstCallInit( &$parser ) {
		$parser->setHook( 'emblem', 'ArticleEmblemsHooks::render' );
		return true;
	}
	
	/**
	 * Renderer for <emblem> parser tag hook
	 *
	 * @param $input
	 * @param $args Array
	 * @param $parser Parser
	 * @param $frame
	 */
	public static function render( $input, $args, Parser $parser, PPFrame $frame ) {
		$output = $parser->getOutput();
		if ( !isset( $output->articleEmblems ) ) {
			$output->articleEmblems = array();
		}
		$output->articleEmblems[] = $parser->recursiveTagParse( $input, $frame );
		return '';
	}

	/**
	 * ParserBeforeTidy tag hook
	 *
	 * @param Parser $parser
	 * @param string $text
	 * @return Boolean 
	 */
	public static function parserBeforeTidy( Parser &$parser, &$text ) {
		$out = $parser->getOutput();
		if ( isset( $out->articleEmblems ) ) {
			$emblems = array();
			foreach ( $out->articleEmblems as $emblem ) {
				$emblems[] = '<li class="articleEmblem">' . $emblem . '</li>';
			}
			$text = '<ul id="articleEmblems">' . implode( $emblems ) . '</ul>' . $text;
		}
		return true;
	}

	/**
	 * OutputPageParserOutput hook handler
	 * @param OutputPage $out
	 * @param ParserOutput $parserOutput
	 * @return type 
	 */
	public static function outputPageParserOutput( OutputPage &$out, ParserOutput $parserOutput ) {
		$out->addModuleStyles( 'ext.articleEmblems' );

		return true;
	}
}
