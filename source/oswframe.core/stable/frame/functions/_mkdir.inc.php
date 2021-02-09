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
 * creates the inputpath an set permissions
 *
 * @access public
 * @param string path to create
 * @return bool
 */
function _mkDir($var) {
	clearstatcache();

	if (is_dir($var[0])===true) {
		return true;
	}

	if (!isset($var[1])) {
		$var[1]=vOut('settings_chmod_dir');
	}

	if (mkdir($var[0], $var[1], true)!==true) {
		return false;
	}

	$list=explode('/', str_replace(vOut('settings_abspath'), '', $var[0]));
	$dir=vOut('settings_abspath');
	foreach ($list as $_dir) {
		if ($_dir!='') {
			$dir.=$_dir.'/';
			h()->_chmod($dir, $var[1]);
		}
	}
	clearstatcache();

	return true;
}

?>