<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _strpos_r($var) {
	$seeks=[];
	while (($seek=strrpos($var[0], $var[1]))!==false) {
		array_push($seeks, $seek);
		$var[0]=substr($var[0], 0, $seek);
	}

	return $seeks;
}

?>