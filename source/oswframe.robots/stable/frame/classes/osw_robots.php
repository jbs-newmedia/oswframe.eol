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
class osW_Robots extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function output() {
		$output='';
		$output.='User-Agent: *
Allow: /';
		header("content-type: text/plain");
		echo $output;
		h()->_die();
	}

	/**
	 *
	 * @return osW_Robots
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>