<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c) 2011-2012, Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _verifyIP($var) {
	if (!isset($var[0])) {
		$var[0]='';
	}
	if (!isset($var[1])) {
		$var[1]='';
	}
	if (!isset($var[2])) {
		$var[2]='';
	}

	if (!filter_var($var[0], FILTER_VALIDATE_IP)) {
		return false;
	}
	if (!filter_var($var[1], FILTER_VALIDATE_IP)) {
		return false;
	}
	$ip1=explode('.', $var[0]);
	$ip2=explode('.', $var[1]);
	switch ($var[2]) {
		case 'x.x.x.x':
			if ((count($ip1)==4)&&(count($ip2)==4)&&($ip1[0]==$ip2[0])&&($ip1[1]==$ip2[1])&&($ip1[2]==$ip2[2])&&($ip1[3]==$ip2[3])) {
				return true;
			}
			break;
		case 'x.x.x':
			if ((count($ip1)==4)&&(count($ip2)==4)&&($ip1[0]==$ip2[0])&&($ip1[1]==$ip2[1])&&($ip1[2]==$ip2[2])) {
				return true;
			}
			break;
		case 'x.x':
			if ((count($ip1)==4)&&(count($ip2)==4)&&($ip1[0]==$ip2[0])&&($ip1[1]==$ip2[1])) {
				return true;
			}
			break;
		case 'x':
			if ((count($ip1)==4)&&(count($ip2)==4)&&($ip1[0]==$ip2[0])) {
				return true;
			}
			break;
	}

	return false;
}

?>