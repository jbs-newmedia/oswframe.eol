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

class osW_Replacer extends osW_Object {

	/* VALUES */
	public $data=[];

	private $groupids=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */

	public function setReplace($key, $value) {
		$this->data['replace'][$key]=$value;
	}

	public function replace($content, $p2br=true) {
		if ((isset($this->data['replace']))&&($this->data['replace']!=[]))
			foreach ($this->data['replace'] as $key=>$value) {
				$content=str_replace('{{'.$key.'}}', $value, $content);
			}
		if ($p2br===true) {
			return h()->_convertP2BR($content);
		}

		return $content;
	}

	/**
	 *
	 * @return osW_Replacer
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>