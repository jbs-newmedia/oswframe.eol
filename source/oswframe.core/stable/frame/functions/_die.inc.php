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
 * Gibt den Inhalt aus und beendet das aktuelle Script
 *
 * @access public
 * @param string Textausgabe vor dem Beenden des Skripts
 */
function _die($var) {
	if (!isset($var[0])) {
		$var[0]='';
	}
	osW_Debug::getInstance()->logMessages();
	die($var[0]);
}

?>