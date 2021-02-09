<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _verifyEmailIDNAPattern($var) {
	if (!isset($var[0])) {
		return false;
	}

	list($user, $domain)=explode('@', $var[0]);
	$domain=osW_IDNA::getInstance()->encode($domain);
	$checkemail=$user.'@'.$domain;
	if (h()->_verifyEmailPattern($checkemail)===true) {
		return true;
	}

	return false;
}

?>