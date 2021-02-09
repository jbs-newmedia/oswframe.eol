<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/*
 *  status
 *  1 - email syntax error
 *  2 - serverdomain dns error
 *  3 - protect email error
 */
function _verifyEmail($var) {
	if (!isset($var[1])) {
		$var[1]=false;
	}
	if (!isset($var[2])) {
		$var[2]=false;
	}

	if (strlen($var[0])==0) {
		return ['status'=>4, 'message'=>tOut('email_isblank_error')];
	}

	if (filter_var($var[0], FILTER_VALIDATE_EMAIL)) {
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