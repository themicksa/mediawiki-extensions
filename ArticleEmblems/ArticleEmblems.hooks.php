<?php
/**
 * Hooks for ArticleEmblems extension
 * 
 * @file
 * @ingroup Extensions
 */

class ArticleEmblemsHooks {
	
	/* Protected Static Members */
	
	protected static $emblems = array();
	
	/* Static Methods */

	/**
	 * ParserInit hook
	 *
	 * @param $parser Parser
	 */
	public static function parserInit( &$parser ) {
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
	public static function render( $input, $args, $parser, $frame ) {
		self::$emblems[] = $parser->recursiveTagParse( $input, $frame );
		return null;
	}
	
	/**
	 * ArticleViewHeader hook
	 *
	 * @param $article Article
	 * @param $outputDone
	 * @param $pcache
	 */
	public static function articleViewHeader( &$article, &$outputDone, &$pcache ) {
		global $wgOut;
		
		$wgOut->addModuleStyles( 'ext.articleEmblems' );
		
		$articleId = $article->getId();
		$dbr = wfGetDB( DB_SLAVE );
		$results = $dbr->select( 'articleemblems', 'ae_value', array( 'ae_article' => $articleId ), __METHOD__ );
		$emblems = array();
		foreach ( $results as $emblem ) {
			$emblems[] = '<li class="articleEmblem">' . $emblem['ae_value'] . '</li>';
		}
		$wgOut->addHtml( '<ul id="articleEmblems">' . implode( $emblems ) . '</ul>' );
		return true;
	}
}
