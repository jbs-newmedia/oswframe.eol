<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _protectDir($var) {
	if (!is_dir($var[0])) {
		return false;
	}
	if (file_exists($var[0].'.htaccess')) {
		return false;
	}

	file_put_contents($var[0].'.htaccess', 'Deny from all');
	h()->_chmod($var[0].'.htaccess');

	return true;
}

?>