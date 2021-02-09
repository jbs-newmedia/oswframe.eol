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
 * Gibt den Inhalt einer GET/POST/FILES/COOKIE/SESSION/SERVER Variablen zurück oder initialisiert sie
 *
 * @access public
 * @param string Name der Variable
 * @param mixed Initialisierungswert sofern Variable nicht vorhanden ist
 * @param string Liste und Reihenfolge der Globals (g=GET, p=POST, c=COOKIE, s=SESSION, r=SERVER)
 * @param mixed wenn gesetzt, dann der Key des Arrays
 * @return mixed
 */
function _makeCurlFile($var) {
	if (!isset($var[0])) {
		return false;
	}
	if (!file_exists($var[0])) {
		return false;
	}
	$mime=mime_content_type($var[0]);
	$info=pathinfo($var[0]);
	$name=$info['basename'];
	$output=new CURLFile($var[0], $mime, $name);

	return $output;
}

?>