<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

# https://www.php.net/manual/en/function.openssl-encrypt.php#121545

function _decrypt($var) {
	$l=strlen($var[1]);
	if ($l<16) {
		$var[1]=str_repeat($var[1], ceil(16/$l));
	}

	if (function_exists('mcrypt_encrypt')) {
		$val=mcrypt_decrypt(MCRYPT_BLOWFISH, $var[1], $var[0], MCRYPT_MODE_ECB);
	} else {
		$val=openssl_decrypt($var[0], 'BF-ECB', $var[1], OPENSSL_RAW_DATA|OPENSSL_NO_PADDING);
	}

	return $val;
}

?>