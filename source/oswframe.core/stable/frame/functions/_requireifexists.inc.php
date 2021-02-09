<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _requireIfExists($var) {
	if (!isset($var[0])) {
		return false;
	}

	if (file_exists($var[0])===true) {
		require($var[0]);

		return true;
	}

	return false;
}

?>