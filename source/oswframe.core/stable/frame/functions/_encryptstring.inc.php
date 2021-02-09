<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _encryptString($var) {
	$password='';
	for ($i=0; $i<10; $i++) {
		$password.=h()->_rand();
	}
	$salt=substr(md5($password), 0, 2);
	$password=md5($salt.$var[0]).':'.$salt;

	return $password;
}

?>