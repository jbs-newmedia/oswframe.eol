<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _isDirEmpty($var) {
	clearstatcache();

	if (is_dir($var[0])!==true) {
		return null;
	}

	if (is_readable($var[0])!==true) {
		return null;
	}

	if (count(scandir($var[0]))==2) {
		return true;
	}

	return false;
}

?>