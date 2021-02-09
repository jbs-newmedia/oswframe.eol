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
 *  1 - email syntax error
 *  2 - serverdomain dns error
 *  3 - protect email error
 */
function _validateEmailIDNA($var) {
	if (!isset($var[1])) {
		$var[1]=false;
	}
	if (!isset($var[2])) {
		$var[2]=false;
	}

	if (strlen($var[0])==0) {
		return ['status'=>4, 'message'=>tOut('email_isblank_error')];
	}

	if (h()->_verifyEmailIDNAPattern($var[0])) {
		if ($var[2]===true) {
			$domain=explode('@', $var[0]);
			if (!checkdnsrr($domain[1], "MX")&&!checkdnsrr($domain[1], "A")) {
				return ['status'=>2, 'message'=>tnOut('email_serverdomain_error')];
			}
		}
		if ($var[1]===true) {
			if (($result=h()->_checkProtectEmail($var[0]))!==true) {
				return ['status'=>3, 'message'=>$result];
			}
		}

		return true;
	} else {
		return ['status'=>1, 'message'=>tnOut('email_syntax_error')];
	}
}

?>