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
 * Leitet die aktuelle Seite unter Angabe des Statuscodes weiter
 *
 * @access public
 * @param string URL der Zielseite
 * @param integer Statuscode der Weiterleitung
 */
function _direct($var) {
	if (!isset($var[0])) {
		$var[0]='';
	}
	if (!isset($var[1])) {
		$var[1]=302;
	}
	$var[0]=str_replace('&amp;', '&', $var[0]);

	switch ($var[1]) {
		case 301:
			$_header='HTTP/1.1 301 Moved Permanently';
			break;
		case 302:
		default:
			$_header='HTTP/1.1 302 Found';
			break;
	}

	if (!headers_sent($filename, $linenum)) {
		header($_header);
		header('Location: '.$var[0]);
		header('Connection: close');
	} else {
		echo 'Header already sent in file <strong>'.$filename.'</strong> in line <strong>'.$linenum.'</strong>.<br/>';
		echo 'Redirect is not possible!';
		echo '<br/><br/>'.$_header.'<br/>';
		echo 'Location: <a href="'.$var[0].'">'.$var[0].'</a><br/>';
		echo 'Connection: close';
	}
	h()->_die();
}

?>