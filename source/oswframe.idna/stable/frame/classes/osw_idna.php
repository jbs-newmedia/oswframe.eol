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

class osW_IDNA extends osW_Object {

	/*** PROPERTIES ***/

	private $obj_idna_convert;

	/*** METHODS CORE ***/

	public function __construct() {
		parent::__construct(__CLASS__, 1, 0);
		$this->obj_idna_convert=new idna_convert();
	}

	public function __destruct() {
		parent::__destruct();
	}

	/*** METHODS ***/

	public function getObject() {
		if (is_object($this->obj_idna_convert)) {
			return $this->obj_idna_convert;
		}

		return null;
	}

	public function setParameter($option, $value=false) {
		return $this->getObject()->set_parameter($option, $value);
	}

	public function decode($input, $one_time_encoding=false) {
		return $this->getObject()->decode($input, $one_time_encoding);
	}

	public function encode($decoded, $one_time_encoding=false) {
		return $this->getObject()->encode($decoded, $one_time_encoding);
	}

	public function encodeUri($uri) {
		return $this->getObject()->encode_uri($uri);
	}

	public function getLastError() {
		return $this->getObject()->get_last_error();
	}

	/**
	 *
	 * @return osW_IDNA
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>