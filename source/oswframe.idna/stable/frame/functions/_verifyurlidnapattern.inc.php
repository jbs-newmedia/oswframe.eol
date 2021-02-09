<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _verifyUrlIDNAPattern($var) {
	if (!isset($var[0])) {
		return false;
	}
	if (h()->_verifyURLPattern(osW_IDNA::getInstance()->encode($var[0]))===true) {
		return true;
	}

	return false;
}

?>