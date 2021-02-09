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
 * returns the client ip-address
 *
 * @access public
 * @return string
 */
function _getIpAddress() {
	return getenv('REMOTE_ADDR');
}

?>