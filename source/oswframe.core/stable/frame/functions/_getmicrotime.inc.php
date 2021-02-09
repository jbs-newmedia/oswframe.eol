<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _getMicroTime() {
	list($usec, $sec)=explode(' ', microtime());

	return ((float) $usec+(float) $sec);
}

?>