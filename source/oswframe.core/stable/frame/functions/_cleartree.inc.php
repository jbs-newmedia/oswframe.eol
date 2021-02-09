<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _clearTree($var) {
	$files=array_diff(scandir($var[0]), ['.', '..']);
	foreach ($files as $file) {
		if (is_dir($var[0].'/'.$file)) {
			h()->_delTree($var[0].'/'.$file);
		} else {
			if (file_exists($var[0].'/'.$file)) {
				unlink($var[0].'/'.$file);
			}
		}
	}

	return true;
}

?>