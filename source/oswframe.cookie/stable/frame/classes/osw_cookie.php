<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_Cookie extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function setCookie($name, $value, $expire=0, $path='', $domain='', $secure=false, $httponly=false) {
		return $this->set($name, $value, $expire, $path, $domain, $secure, $httponly);
	}

	public function set($name, $value, $expire=0, $path='/', $domain='', $secure=false, $httponly=false) {
		if ($domain=='') {
			$domain=vOut('project_domain');
		}

		setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}

	public function remove($name) {
		$this->set($name, '', 0);
	}

	public function read($name) {
		if (isset($_COOKIE[$name])) {
			return $_COOKIE[$name];
		}

		return '';
	}

	/**
	 *
	 * @return osW_Cookie
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>