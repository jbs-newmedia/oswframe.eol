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
class osW_JSLib extends osW_Object {

	/* PROPERTIES */
	private $loaded_libs=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function init() {
		$this->loaded_libs=[];
	}

	public function load($lib_name, $lib_option=[]) {
		if (isset($this->loaded_libs[$lib_name])) {
			return true;
		}

		if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/jslib.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/jslib.inc.php');
		} elseif (file_exists(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/jslib.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/jslib.inc.php');
		} else {
			include(vOut('settings_abspath').'frame/autoloader/jslib.inc.php');
		}
	}

	/**
	 *
	 * @return osW_JSLib
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>