<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/*
Moegliche Werte für type sind:

   "boolean" (oder seit PHP 4.2.0 "bool")
   "integer" (oder seit PHP 4.2.0 "int")
   "float" (erst seit PHP 4.2.0 möglich, benutzen Sie bei älteren Versionen die veraltete Variante "double")
   "string"
   "array"
   "object"
   "null" (seit PHP 4.2.0)
*/

function _settype($var) {
	if (!isset($var[1])) {
		$var[1]='string';
	}
	settype($var[0], $var[1]);

	return $var[0];
}

?>