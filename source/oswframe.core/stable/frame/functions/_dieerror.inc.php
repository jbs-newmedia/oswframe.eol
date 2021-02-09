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
 * Gibt eine Fehlerwebseite aus und beendet das aktuelle Script
 *
 * @access public
 * @param string Textausgabe vor dem Beenden des Skripts
 * @param string Überschrift der Fehlermeldung
 */
function _dieError($var) {
	if (!isset($var[0])) {
		$var[0]='';
	}
	if (!isset($var[1])) {
		$var[1]='';
	}
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>'.$var[1].'</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="date" content="'.date('Y-m-d\TH:i:sO').'" />
	</head>
	<body>
		<h1>'.$var[1].'</h1>
		<p>'.$var[0].'</p>
		<p><a href="/">start</a></p>
	</body>
</html>';
	h()->_die();
}

?>