<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _setText($var) {
	if (!isset($var[0])) {
		return '';
	}
	if (!isset($var[1])) {
		return $var[0];
	}
	if (!is_array($var[1])) {
		return $var[0];
	}
	foreach ($var[1] as $key=>$value) {
		if (!is_array($value)&&(!is_object($value))) {
			$var[0]=str_replace('$'.$key.'$', $value, $var[0]);
		}
	}

	return $var[0];
}

?>