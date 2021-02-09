<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _remove_magic_quotes($array) {
	if (!is_array($array)||(sizeof($array)<1)) {
		return false;
	}

	foreach ($array as $key=>$value) {
		if (is_array($value)) {
			h()->_remove_magic_quotes($array[$key]);
		} else {
			$array[$key]=stripslashes($value);
		}
	}
}

?>