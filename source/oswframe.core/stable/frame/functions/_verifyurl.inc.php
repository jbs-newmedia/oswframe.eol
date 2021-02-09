<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _verifyUrl($var) {
	if (!isset($var[1])) {
		$var[1]=true;
	}
	if (filter_var($var[0], FILTER_VALIDATE_URL)) {
		return true;
	}

	return false;
}

?>