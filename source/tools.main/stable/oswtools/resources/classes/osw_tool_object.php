<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package oswFrame - Tools
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_Tool_Object {

	private static $instances=array();

	function __construct() {
	}

	function __destruct() {
	}

	public static function getInstance() {
		$class=get_called_class();
		if (array_key_exists($class, self::$instances)===false) {
			self::$instances[$class]=new $class();
		}
		return self::$instances[$class];
	}
}

?>