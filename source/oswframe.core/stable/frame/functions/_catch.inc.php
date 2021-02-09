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
function _catch($var) {
	if (!isset($var[1])) {
		$var[1]='';
	}
	if (!isset($var[2])) {
		$var[2]='gpc';
	}
	for ($i=0; $i<strlen($var[2]); $i++) {
		switch ($var[2][$i]) {
			case 'g':
				if (isset($var[3])) {
					if (isset($_GET[$var[0]][$var[3]])) {
						return $_GET[$var[0]][$var[3]];
					}
				} else {
					if (isset($_GET[$var[0]])) {
						return $_GET[$var[0]];
					}
				}
				break;
			case 'p':
				if (isset($var[3])) {
					if (isset($_POST[$var[0]][$var[3]])) {
						return $_POST[$var[0]][$var[3]];
					}
				} else {
					if (isset($_POST[$var[0]])) {
						return $_POST[$var[0]];
					}
				}
				break;
			case 'f':
				if (isset($var[3])) {
					if (isset($_FILES[$var[0]][$var[3]])) {
						return $_FILES[$var[0]][$var[3]];
					}
				} else {
					if (isset($_FILES[$var[0]])) {
						return $_FILES[$var[0]];
					}
				}
				break;
			case 'c':
				if (isset($var[3])) {
					if (isset($_COOKIE[$var[0]][$var[3]])) {
						return $_COOKIE[$var[0]][$var[3]];
					}
				} else {
					if (isset($_COOKIE[$var[0]])) {
						return $_COOKIE[$var[0]];
					}
				}
				break;
			case 's':
				if (isset($var[3])) {
					if (isset($_SESSION[$var[0]][$var[3]])) {
						return $_SESSION[$var[0]][$var[3]];
					}
				} else {
					if (isset($_SESSION[$var[0]])) {
						return $_SESSION[$var[0]];
					}
				}
				break;
			case 'r':
				if (isset($var[3])) {
					if (isset($_SERVER[$var[0]][$var[3]])) {
						return $_SERVER[$var[0]][$var[3]];
					}
				} else {
					if (isset($_SERVER[$var[0]])) {
						return $_SERVER[$var[0]];
					}
				}
				break;
		}
	}

	return $var[1];
}

?>