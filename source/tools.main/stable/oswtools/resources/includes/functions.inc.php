<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package oswFrame - Tools
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function autoloader($class_name) {
	require abs_path.'resources/classes/'.strtolower($class_name).'.php';
}

spl_autoload_register('autoloader');

function outputString($str) {
	return $str;
}

?>