<?php

/*
 * Author: Juergen Schwind
 * Copyright: 2011 Juergen Schwind
 * Link: http://oswframe.com
 * 
 * This program is free software; you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
 * GNU General Public License for more details: 
 * http://www.gnu.org/licenses/gpl.html
 *
 */

function _validatePassword($var) {
	if ((h()->_notNull($var[0]))&&(h()->_notNull($var[1]))) {
		$stack=explode(':', $var[1]);
		if (sizeof($stack)!=2) {
			return false;
		}
		if (md5($stack[1].$var[0])==$stack[0]) {
			return true;
		}
	}

	return false;
}

?>