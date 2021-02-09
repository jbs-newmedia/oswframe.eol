<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _setCookie($var) {
	if (!isset($var[3])) {
		$var[3]='/';
	}
	if (!isset($var[4])) {
		$var[4]=vOut('project_domain');
	}
	setcookie($var[0], $var[1], (time()+(60*60*24*$var[2])), $var[3], $var[4]);
}

?>