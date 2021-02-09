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

/*
 *  status
 *  1 - password blank error
 *  2 - passwort short error
 */
function _checkPassword($var) {
	if (strlen($var[0])==0) {
		return ['status'=>1, 'message'=>tOut('password_isblank_error')];
	} elseif (strlen($var[0])<8) {
		return ['status'=>2, 'message'=>sprintf(tOut('password_istoshort_error'), vOut('USER_PASSWORDMIN'))];
	} else {
		return true;
	}
}

?>