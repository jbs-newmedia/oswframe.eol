<?php

/**
 * http://php.net/manual/de/function.random-bytes.php#118932
 */

function _randomtoken($var) {
	if ((!isset($var[0]))||($var[0]<8)) {
		$var[0]=32;
	}
	if (function_exists('random_bytes')) {
		return bin2hex(random_bytes($var[0]));
	}
	if (function_exists('mcrypt_create_iv')) {
		return bin2hex(mcrypt_create_iv($var[0], MCRYPT_DEV_URANDOM));
	}
	if (function_exists('openssl_random_pseudo_bytes')) {
		return bin2hex(openssl_random_pseudo_bytes($var[0]));
	}
}

?>