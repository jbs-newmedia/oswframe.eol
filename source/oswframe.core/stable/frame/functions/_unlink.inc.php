<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _unlink($var) {
	if (!isset($var[0])) {
		return false;
	}
	if (!file_exists($var[0])) {
		return true;
	}
	if (@unlink($var[0])===true) {
		return true;
	} else {
		if (is_file($file)) {
			// ToDo: Cache doesn't work
			exec('DEL /F/Q "'.$var[0].'"');

			return true;
		}
	}

	return false;
}

?>