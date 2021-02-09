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
 * Verschluesselt den Inhalt
 *
 * @access public
 */
function _mc_encrypt($var) {
	if (PHP_VERSION_ID<70200) {
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $var[1], base64_decode($var[0]), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	} else {
		h()->_encrypt($var[0], $var[1]);
	}
}

?>