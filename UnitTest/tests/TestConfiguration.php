<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @author		Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/*
 * Include PHPUnit dependencies
 */
require_once 'PHPUnit/Framework/IncompleteTestError.php';
require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/Runner/Version.php';
require_once 'PHPUnit/TextUI/TestRunner.php';
require_once 'PHPUnit/Util/Filter.php';

/*
 * This file contains custom options and constants for test configuration.
 */

/**
 * TESTS_MESSAGE_NOT_IMPLEMENTED
 *
 * Message for code that has not been implemented.
 */
define( 'TESTS_MESSAGE_NOT_IMPLEMENTED', 'Not implemented yet!' );

/**
 * TESTS_HOSTNAME
 *
 * The hostname for the system
 */
define( 'TESTS_HOSTNAME', 'localhost' );

/**
 * TESTS_EMAIL
 *
 * An email address to use in case test send mail
 */
define( 'TESTS_EMAIL', 'no-reply@example.org' );

