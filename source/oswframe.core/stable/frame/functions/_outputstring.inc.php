<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * Der String wird zur Ausgabe auf dem Browser kodiert.
 *
 * @access public
 * @param string String der zur Browserausgabe kodiert wird
 * @return string
 */
function _outputString($var) {
	if (!isset($var[1])) {
		$var[1]=true;
	}
	if ($var[1]===true) {
		return nl2br(htmlentities($var[0], ENT_COMPAT, 'UTF-8'));
	} else {
		return htmlentities($var[0], ENT_COMPAT, 'UTF-8');
	}
}

?>