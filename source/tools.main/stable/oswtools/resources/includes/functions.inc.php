<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package oswFrame - Tools
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function __autoload($classname) {
	require abs_path.'resources/classes/'.strtolower($classname).'.php';
}

function outputString($str) {
	return $str;
}

?>