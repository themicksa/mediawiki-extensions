<?php
class PreviewFunctions {

	/** 
	 * Register the parser hook.
	 * @param $parser Parser
	 */
	public static function register( Parser $parser ) {
		$parser->setFunctionHook( 'ifpreview', 'PreviewFunctions::ifPreview', Parser::SFH_OBJECT_ARGS );
		$parser->setFunctionHook( 'previewwarning', 'PreviewFunctions::addWarning' );
		return true;
	}

	public static function ifPreview( $parser, $frame, $args ) {
		if ( $parser->getOptions()->getIsPreview() ) {
			# Is a preview. Return first
			return isset( $args[0] ) ? trim( $frame->expand( $args[0] ) ) : '';
		} else {
			# Otherwise return second arg.
			return isset( $args[1] ) ? trim( $frame->expand( $args[1] ) ) : '';
		}
	}

	public static function addWarning( $parser, $warning ) {
		if ( $warning === '' ) return '';

		// Not 100% sure if doing this right.
		// Note, EditPage.php parses such warnings
		// (but with a different parser object)

		// Even with something like PPFrame::RECOVER_ORIG - tag extensions are still expanded.

		// Not doing:
		// $warning = $parser->mStripState->unstripGeneral( $warning );
		// Because double parses things that should be treated as html.

		// Based on a line in CoreParserFunctions::displaytitle.
		// Can't just substitute a <nowiki>$1</nowiki> and then unstripNoWiki, since that doesn't work
		// for other extensions that put nowiki content (Since some like $wgRawHtml's <html> 
		// would not like the tag escaping done by <nowiki>.
		// I suppose I could look for the nowiki part of "UNIQ7d3e18c0572c78c3-nowiki-00000031-QINU"
		// but thats super hacky. So just delete the strip items.
		$warning = preg_replace( '/' . preg_quote( $parser->uniqPrefix(), '/' ) . '.*?'
                	        . preg_quote( Parser::MARKER_SUFFIX, '/' ) . '/',
			'',
			$warning
		);

		$warning = Html::rawElement( 'div', array( 'class' => 'error mw-previewfunc-warning' ), $warning );
		$parser->getOutput()->addWarning( $warning );
	}
}
