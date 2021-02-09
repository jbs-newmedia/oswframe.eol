<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _stripContent($var) {
	$var[0]=str_replace("\t", ' ', $var[0]);                // tabs
	$var[0]=str_replace("\n", ' ', $var[0]);                // returns
	$var[0]=str_replace("\r", ' ', $var[0]);                // returns
	$var[0]=preg_replace('/[ ]+/', ' ', $var[0]);            // double blanks
	$var[0]=preg_replace('/<!--[^-]*-->/', '', $var[0]);    // comments

	return $var[0];
}

?>