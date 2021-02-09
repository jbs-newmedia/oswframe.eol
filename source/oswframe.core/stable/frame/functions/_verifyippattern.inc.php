<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c) 2011-2012, Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _verifyIPPattern($var) {
	if (!isset($var[0])) {
		return false;
	}
	if (filter_var($var[0], FILTER_VALIDATE_IP)) {
		return true;
	}

	return false;
}

?>