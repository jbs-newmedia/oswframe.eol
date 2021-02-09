<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _outputUrlString($var) {
	$german_search=["Ä", "ä", "Ü", "ü", "Ö", "ö", "ß"];
	$german_replace=["Ae", "ae", "Ue", "ue", "Oe", "oe", "ss"];
	$var[0]=str_replace($german_search, $german_replace, $var[0]);
	$var[0]=preg_replace('/[^a-zA-Z0-9]/', ' ', $var[0]);
	$var[0]=preg_replace('/\s\s+/', ' ', $var[0]);
	$var[0]=str_replace(' ', '-', trim($var[0]));

	return urlencode($var[0]);
}

?>