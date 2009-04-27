<?php

/**
 * Extension to enable MathML output for <math> tags
 *
 * @addtogroup Extensions
 * @author David Harvey <dmharvey@math.harvard.edu>
 * @author Jitse Niesen <j.niesen@latrobe.edu.au>
 * @copyright 2005, 2006 David Harvey and Jitse Niesen
 * @licence GNU General Public Licence
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/* Customization variables */

/** Location of the blahtex binary */
$wgBlahtex = './extensions/Blahtex/blahtex';
/** Command-line options for blahtex */
$wgBlahtexOptions = '--texvc-compatible-commands --mathml-version-1-fonts --disallow-plane-1 --spacing strict';

/* Register the extension */

$wgExtensionFunctions[] = 'efBlahtex';
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Blahtex',
	'author' => 'David Harvey and Jitse Niesen',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Blahtex',
	'description' => 'MathML output for &lt;math&gt; tags',
	'descriptionmsg' => 'math-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Blahtex'] = $dir . 'Blahtex.i18n.php';

/**
 * Initialize Blahtex
 */
function efBlahtex() {
	global $wgHooks;
	$wgHooks['MathAfterTexvc'][] = 'efBlahtexMathAfterTexvc';
	$wgHooks['ParserBeforeTidy'][] = 'efBlahtexParserBeforeTidy';
	$wgHooks['ParserAfterTidy'][] = 'efBlahtexParserAfterTidy';
	wfLoadExtensionMessages( 'Blahtex' );
}

/**
 * Hook function for MathAfterTexvc
 *
 * This function is called from Math.php after texvc is run.
 */
function efBlahtexMathAfterTexvc( &$mathRenderer, &$errmsg ) {
	 $br = new BlahtexRenderer();
	 $br->setState( $mathRenderer, $errmsg );
	 $br->render();
	 $errmsg = $br->getErrmsg();
	 wfDebug('Blahtex MathML: ' . $br->mr->mathml . "\n");
	 wfDebug('Blahtex errmsg: ' . $errmsg . "\n");

	 return true;
}

/**
 * Hook function for ParserBeforeTidy
 *
 * HTML Tidy does not understand MathML, and
 * Sanitizer::normalizeCharReferences() does not know about plane-1
 * entities like &Ascr; . Therefore, we replace all MathML tags with
 * placeholders. The original MathML is stored in $parser.
 */
function efBlahtexParserBeforeTidy( &$parser, &$text ) {
	global $wgBlahtexMathContent, $wgBlahtexMathTags;
	$mathtags = array();
	$endtag = "</math>";
	$stripped = "";
	$pos = 0;
	$rand =  dechex(mt_rand(0, 0x7fffffff)) . dechex(mt_rand(0, 0x7fffffff));
	$n = 1;

	while(TRUE) {
		$res = preg_match( "/<math[^>]*>/i", $text, $matches, PREG_OFFSET_CAPTURE, $pos );
		if ( $res == 0 )
			break;
		$pos2 = stripos( $text, $endtag, $matches[0][1] );
		if ( $pos2 == 0 )
			break;
		$stripped .= substr( $text, $pos, $matches[0][1] - $pos );
		$marker = "UNIQ-blahtex-$rand" . sprintf('%08X', $n++) . '-QINU';
		$stripped .= $marker;
		$pos = $pos2 + strlen($endtag);
		$mathtags[$marker] = substr( $text, $matches[0][1], $pos - $matches[0][1] );
	}
	$parser->blahtexMathtags = $mathtags;
	$text = $stripped . substr( $text, $pos );

	return true;
}

/**
 * Hook function for ParserAfterTidy
 *
 * Undo the replacement in efBlahtexBeforeTidy() .
 */
function efBlahtexParserAfterTidy( &$parser, &$text ) {
	global $wgBlahtexMathContent, $wgBlahtexMathTags;
	$text = strtr( $text, $parser->blahtexMathtags );

	return true;
}

class BlahtexRenderer {

	/** @privatesection */
	var $mode = MW_MATH_MODERN; /**< @User preference for maths */
	var $tex = '';              /**< LaTeX fragment */
	var $inputhash = '';        /**< Hash value of $tex */
	var $hash = '';             /**< Name of PNG file */
	var $html = '';             /**< HTML rendering of $tex */
	var $mathml = '';           /**< MathML rendering of $tex */
	var $conservativeness = 0;  /**< How conservative the HTML rendering is */
	var $mr;                    /**< MathRenderer instance */
	var $errmsg;

	function setState( $mathRenderer, $errmsg ) {
		 $this->mr = $mathRenderer;
		 /* $this->mode = $mathRenderer->mode;
		 $this->tex = $mathRenderer->tex;
		 $this->inputhash = $mathRenderer->inputhash;
		 $this->hash = $mathRenderer->hash;
		 $this->html = $mathRenderer->html; */
		 /* mathml skipped; do not use the MathML generated by texvc */
		 /* $this->conservativeness = $mathRenderer->conservativeness; */
		 $this->errmsg = $errmsg;
	}

	function getErrmsg() {
		 return $this->errmsg;
	}

	function render() {
		 list( $success, $res ) = $this->invokeBlahtex( $this->mr->tex, $this->mr->hash == NULL );
		 if ( !$success )
			  $this->errmsg = $res;
		 else {
			  $parser = new blahtexOutputParser();
			  $output = $parser->parse( $res );
			  $blahtexErrmsg = $this->processOutput( $output );
			  if ( $blahtexErrmsg && $this->errmsg )
				  $this->errmsg = $blahtexErrmsg;
			  else
				  $this->errmsg = '';
		 }
	}

	/**
	 * Invoke the blahtex executable.
	 * This function invokes the @c blahtex helper program. The
	 * location of the program is specified in $wgBlahtex. Extra
	 * options may be specified in $wgBlahtexOptions.
	 * @param $tex LaTeX fragment to be rendered (string)
	 * @param $makePNG Whether blahtex should generate both MathML and
	 *    PNG (@c true) or only MathML (@c false).
	 * @return A 2-tuple.
	 *  - If an error occurred, then the first element is @c false and
	 *    the second element is a string containing an HTML fragment
	 *    with the error message.
	 *  - Otherwise, the first element is @c true and the second
	 *    element is a string containing the output of @c blahtex.
	 */
	function invokeBlahtex( $tex, $makePNG )
	{
		global $wgBlahtex, $wgBlahtexOptions, $wgTmpDirectory;

		$descriptorspec = array( 0 => array( "pipe", "r" ),
					 1 => array( "pipe", "w" ) );
		$options = '--mathml ' . $wgBlahtexOptions;
		if ( $makePNG )
			$options .= " --png --temp-directory $wgTmpDirectory --png-directory $wgTmpDirectory";

		if ( function_exists( 'is_executable' ) && !is_executable( $wgBlahtex ) )
			return array( false, $this->error( 'math_noblahtex', $wgBlahtex ) );

		wfDebug("Blahtex command: $wgBlahtex $options\n");
		wfDebug("Blahtex input: \\displaystyle $tex\n");
		$process = proc_open( $wgBlahtex.' '.$options, $descriptorspec, $pipes );
		if ( !$process ) {
			return array( false, $this->error( 'math_unknown_error' ) );
		}
		fwrite( $pipes[0], '\\displaystyle ' );
		fwrite( $pipes[0], $tex );
		fclose( $pipes[0] );

		$contents = '';
		while ( !feof($pipes[1] ) ) {
			$contents .= fgets( $pipes[1], 4096 );
		}
		wfDebug("Blahtex output: $contents\n");
		fclose( $pipes[1] );
		if ( proc_close( $process ) != 0 ) {
			// exit code of blahtex is not zero; this shouldn't happen
			return array( false, $this->error( 'math_unknown_error' ) );
		}

		return array( true, $contents );
	}

	/**
	 * Process blahtex output.
	 * Parse the output and fill the mathml field in the database. If
	 * blahtex has also generated a PNG image, then update the hash
	 * field as well move the PNG image to its final destination.
	 * @param $contents Blahtex output (string)
	 * @return HTML fragment with error message if an error
	 *    occurred, @c false otherwise (string or boolean)
	 */
	function processOutput( $results )
	{
		if ( isset( $results["blahtex:logicError"] ) ) {
			// Something went completely wrong
			return $this->error('math_unknown_error', ' '.$results["blahtex:logicError"]);

		} elseif ( isset( $results["blahtex:error:id"] ) ) {
			// There was a syntax error in the input
			return $this->blahtexError( $results, "blahtex:error" );

		} elseif ( isset( $results["blahtex:png:error:id"] ) ) {
			// There was an error while generating the PNG
			return $this->blahtexError( $results, "blahtex:png:error" );

		} elseif (isset($results["mathmlMarkup"]) || isset($results["blahtex:png:md5"])) {
			// We got some results
			if ( isset( $results["mathmlMarkup"] ) )
				$this->mr->mathml = $results['mathmlMarkup'];
			if ( isset( $results["blahtex:png:md5"] ) ) {
				$this->mr->hash = $results["blahtex:png:md5"];
			}
			return false;

		} elseif ( isset( $results["blahtex:mathml:error:id"] ) )  {
			// There was an error while generating the MathML
			return $this->blahtexError( $results, "blahtex:mathml:error" );

		} else {
			// This should not happen
			return $this->error( 'math_unknown_error' );
		}
	}

	/**
	 * Build an error message for blahtex.
	 * @param $results Parse tree as returned by
	 *    blahtexOutputParser::parse() .
	 * @param $node Node in the tree that the message is stored
	 *    under (string)
	 * @returns HTML fragment with the error message (string)
	 */
	function blahtexError( $results, $node ) {
		$id = 'math_' . $results[$node . ":id"];
		wfDebug("Blahtex blahtexError(): node = $node, id = $id\n");
		$fallback = $results[$node . ":message"];
		if ( isset( $results[$node . ":arg"] ) ) {
			if ( is_array( $results[$node . ":arg"] ) ) {
				// Error message has two or three arguments
				$arg1 = $results[$node . ":arg"][0];
				$arg2 = $results[$node . ":arg"][1];
				if ( count( $results[$node . ":arg"] > 2 ) )
					$arg3 = $results[$node . ":arg"][2];
				else
					$arg3 = '';
				return $this->error( $id, $arg1, $arg2, $arg3, $fallback );
			} else {
				// Error message has one argument
				$arg = $results[$node . ":arg"];
				return $this->error( $id, $arg, '', '', $fallback );
			}
		}
		else {
			// Error message without arguments
			return $this->error( $id, '', '', '', $fallback );
		}
	}

	/**
	 * Build an error message in HTML.
	 * Based on code in Math.php .
	 * @param $msg Lookup key for the message to be passed on to
	 * wfMsg() (string)
	 * @param $arg1 First argument for the message (string)
	 * @param $arg2 Second argument for the message (string)
	 * @param $arg3 Third argument for the message (string)
	 * @param $fallback Fallback message in case the lookup key in
	 *    $msg is not found (string)
	 * @return HTML fragment with the error message (string)
	 */
	function error( $msg, $arg1 = '', $arg2 = '', $arg3 = '', $fallback = NULL ) {
		wfDebug("Blahtex _error(): msg = $msg, arg1 = $arg1\n");
		$mf = htmlspecialchars( wfMsg( 'math_failure' ) );
		if ( $msg ) {
			if ( $fallback && wfMsg( $msg ) == '&lt;' . htmlspecialchars( $msg ) . '&gt;' )
				$errmsg = htmlspecialchars( $fallback );
			else
				$errmsg = htmlspecialchars( wfMsg( $msg, $arg1, $arg2, $arg3 ) );
		}
		else
			$errmsg = '';
		wfDebug("Blahtex _error(): errmsg = $errmsg\n");
		$source = htmlspecialchars( str_replace( "\n", ' ', $this->mr->tex ) );
		// Note: the str_replace above is because the return value must not contain newlines
		return "<strong class='error'>$mf ($errmsg): $source</strong>\n";
	}

}


/**
 * %Parser for the blahtex's output.
 */
class blahtexOutputParser  {
   var $parser;  /**< \private */
	var $stack;   /**< \private */
	var $results; /**< \private */

	function blahtexOutputParser()
	{
		$this->parser = xml_parser_create( "UTF-8" );
		$this->stack = array();
		$this->results = array();
		$this->prevCdata = false;

		xml_set_object( $this->parser, $this );
		xml_parser_set_option( $this->parser, XML_OPTION_CASE_FOLDING, 0 );
		xml_set_element_handler( $this->parser, "startElement", "stopElement" );
		xml_set_character_data_handler( $this->parser, "characterData" );
	}

	/**
	 * Main function, which parses blahtex's output.
	 * The format of blahtex's output is based on XML. This function
	 * parses the XML and returns an array representing the tree
	 * structure. For instance, if $retval denotes the return value,
	 * then $retval["blahtex"]["error"] contains the text within the
	 * <error> tag within the <blahtex> tag. If there is more than one
	 * <error> tag within a <blahtex> tag, then
	 * $retval["blahtex"]["error"] is an array of strings. As a special
	 * case, $retval["mathmlMarkup"] contains the segment between
	 * <markup> and </markup>.
	 * @param $data Output to be parsed (string)
	 * @return XML tree (array)
	 */
	function parse( $data )
	{
		// We splice out any segment between <markup> and </markup>
		// so that the XML parser doesn't have to deal with all the MathML tags.
		$markupBegin = strpos( $data, "<markup>" );
		if ( !( $markupBegin === false ) ) {
			$markupEnd = strpos( $data, "</markup>" );
			$this->results["mathmlMarkup"] =
				trim( substr( $data, $markupBegin + 8, $markupEnd - $markupBegin - 8 ) );
			$data = substr( $data, 0, $markupBegin + 8 ) . substr( $data, $markupEnd );
		}
		xml_parse( $this->parser, $data );
		return $this->results;
	}

	/** @privatesection */
	function startElement( $parser, $name, $attributes )
	{
		$this->prevCdata = false;
		if ( count( $this->stack ) == 0 )
			array_push( $this->stack, $name );
		else
			array_push( $this->stack, $this->stack[count( $this->stack ) - 1] . ":$name" );
	}

	function stopElement($parser, $name)
	{
		$this->prevCdata = false;
		array_pop( $this->stack );
	}

	function characterData($parser, $data)
	{
		$index = $this->stack[count( $this->stack ) - 1];
		if ( $this->prevCdata ) {
			// Merge subsequent CDATA blocks
			if ( is_array( $this->results[$index] ) )
				array_push( $this->results[$index],
					    array_pop( $this->results[$index] ) . $data);
			else
				$this->results[$index] .= $data;
		} else {
			if ( !isset( $this->results[$index] ) )
				$this->results[$index] = $data;
			elseif ( is_array( $this->results[$index] ) )
				array_push( $this->results[$index], $data );
			else
				$this->results[$index] = array( $this->results[$index], $data );
		}
		$this->prevCdata = true;
	}
}
