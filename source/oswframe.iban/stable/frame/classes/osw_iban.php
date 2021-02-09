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

class osW_IBAN extends osW_Object {

	// PROPERTIES

	private $obj_idna_convert;

	// METHODS CORE

	public function __construct() {
		parent::__construct(__CLASS__, 1, 0);
		$this->obj_iban=new IBAN();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// METHODS

	public function getObject() {
		if (is_object($this->obj_iban)) {
			return $this->obj_iban;
		}

		return null;
	}

	public function verify($iban) {
		return $this->getObject()->Verify($iban);
	}

	/**
	 *
	 * @return osW_IBAN
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>