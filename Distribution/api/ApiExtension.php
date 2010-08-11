<?php

/**
 * API extension for Distribution that allows the querying of extension metadata.
 * This includes the different versions of the extension.
 * 
 * @file ApiExtensions.php
 * @ingroup Distribution
 * 
 * @author Jeroen De Dauw
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
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * Allows the querying of extension metadata, including the different versions.
 * 
 * @since 0.1
 *
 * @ingroup Distribution
 */
class ApiExtension extends ApiBase {
	
	/**
	 * Main method.
	 * 
	 * @since 0.1
	 */
	public function execute() {
		
	}	
	
	/**
	 * @since 0.1
	 */
	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}	
	
}