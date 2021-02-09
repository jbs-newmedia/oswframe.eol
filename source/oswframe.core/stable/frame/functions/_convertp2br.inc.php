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
function _convertP2BR($var) {
	$var[0]=str_replace('<p>', '', $var[0]);
	$var[0]=str_replace('</p>', '<br/>', $var[0]);

	return $var[0];
}

?>