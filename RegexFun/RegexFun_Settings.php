<?php

/**
 * File defining the settings for the 'Regex Fun' extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Regex_Fun#Configuration
 *
 * NOTICE:
 * =======
 * Changing one of these settings can be done by copying and placing
 * it in LocalSettings.php, AFTER the inclusion of 'Regex Fun'.
 *
 * @file RegexFun_Settings.php
 * @ingroup RegexFun
 * @since 1.0.1
 *
 * @author Daniel Werner
 */

/**
 * Allows to define functions which should not be available within the wiki.
 * 
 * @example
 * # disable '#regexall' and '#regex_var' functions:
 * $egRegexFunDisabledFunctions = array( 'regexall', 'regex_var' );
 * 
 * @since 1.0.1
 * @var array
 */
$egRegexFunDisabledFunctions = array();


/**
 * Defines the maximum regular expression executions per parser process. This
 * counts all executed regular expression usages by this extension. The counter
 * will be increased by '#regex', '#regexall' and '#regex_var' if a reference
 * string is given but not if only a index is requested. '#regexquote' is not
 * affected. When the limit is exceeded, a '#iferror' catchable error message
 * will be put out instead of the result of the function.
 * The limit can be set to -1 to disable the limit (default).
 * 
 * @since 1.0.1
 * @var integer
 */
$egRegexFunMaxRegexPerParse = -1;
