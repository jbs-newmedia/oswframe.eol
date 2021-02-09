<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _gmdatestr($var) {
	if (!isset($var[0])) {
		$var[0]=time();
	}

	return gmdate('D, d M Y H:i:s', $var[0]).' GMT';
}

?>