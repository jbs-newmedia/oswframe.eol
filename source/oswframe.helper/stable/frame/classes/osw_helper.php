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
class osW_Helper extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	public function __call($method_name, $params) {
		$method=strtolower($method_name);
		if ($method[0]!='_') {
			$_method='_'.$method;
		} else {
			$_method=$method;
		}

		if (function_exists($_method)) {
			return $_method($params);
		}
		try {
			if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/functions.inc.php')) {
				include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/functions.inc.php');
			} elseif (file_exists(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/functions.inc.php')) {
				include(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/functions.inc.php');
			} else {
				include(vOut('settings_abspath').'frame/autoloader/functions.inc.php');
			}
			if (function_exists($_method)) {
				return $_method($params);
			}
			throw new Exception('Method not implemented!');
		} catch (Exception $e) {
			$this->logMessage(__CLASS__, 'funcerror', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'method'=>$method_name, 'error'=>'method not found', 'paramters'=>serialize($params)]);
			echo '<strong>osWFrame Fatal error: undefined helper method</strong><br/>';
			echo '<br/>';
			echo 'Method:<br/>';
			echo '<strong>'.$method_name.'</strong><br/>';
			echo '<br/>';
			echo 'Parameter:<br/>';
			print_r($params);
			echo '<br/>';
			echo '<br/>';
			echo '<br/>';
			if ($method!='_die') {
				h()->_die();
			}
			die();
		}
	}

	/**
	 *
	 * @return osW_Helper
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>