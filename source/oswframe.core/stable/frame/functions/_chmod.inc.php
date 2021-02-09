<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _chmod($var) {
	if (!isset($var[0])) {
		return false;
	}

	if (!isset($var[1])) {
		if (is_dir($var[0])) {
			$var[1]=vOut('settings_chmod_dir');
		}
		if (is_file($var[0])) {
			$var[1]=vOut('settings_chmod_file');
		}
	}

	return chmod($var[0], $var[1]);
}

?>