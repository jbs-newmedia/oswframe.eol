<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _notNull($var) {
	if (is_array($var[0])) {
		if (sizeof($var[0])>0) {
			return true;
		} else {
			return false;
		}
	} else {
		if (($var[0]!='')&&(strtolower($var[0])!='null')&&(strlen(trim($var[0]))>0)) {
			return true;
		} else {
			return false;
		}
	}
}

?>