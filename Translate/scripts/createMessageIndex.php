<?php
/**
 * Creates a database of keys in all groups, so that namespace and key can be
 * used to get the group they belong to. This is used as a fallback when
 * loadgroup parameter is not provided in the request, which happens if someone
 * reaches a messages from somewhere else than Special:Translate.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008-2009, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

require( dirname( __FILE__ ) . '/cli.inc' );

MessageIndexRebuilder::execute();