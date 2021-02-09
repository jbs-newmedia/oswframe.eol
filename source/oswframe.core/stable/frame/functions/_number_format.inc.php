<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _number_format($var) {
	$locale=localeconv();
	if (!isset($var[1])) {
		$var[1]=$locale['frac_digits'];
	}
	if (!isset($var[2])) {
		$var[2]=$locale['decimal_point'];
	}
	if (!isset($var[3])) {
		$var[3]=$locale['thousands_sep'];
	}

	return number_format(floatval($var[0]), $var[1], $var[2], $var[3]);
}

?>