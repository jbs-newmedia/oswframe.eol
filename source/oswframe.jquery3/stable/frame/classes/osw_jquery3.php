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
class osW_JQuery3 extends osW_Object {

	/* PROPERTIES */
	private $issetcore=false;

	private $issetmigrate=false;

	private $loaded_plugins=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function init() {
		$this->issetcore=false;
		$this->issetmigrate=false;
		$this->loaded_plugins=[];
	}

	public function load($version='current') {
		if ($version=='current') {
			$version='3.3.1';
		}
		if ($this->issetcore!==true) {
			$file=vOut('settings_abspath').'frame/resources/jquery3/jquery-'.$version.'.js';
			if (!file_exists($file)) {
				$version='current';
			}
			osW_Template::getInstance()->addJSFileHead('frame/resources/jquery3/jquery-'.$version.'.js');
			$this->issetcore=true;
		}
	}

	public function loadSlim($version='current') {
		if ($version=='current') {
			$version='3.3.1';
		}
		if ($this->issetcore!==true) {
			$file=vOut('settings_abspath').'frame/resources/jquery3/jquery-'.$version.'.slim.js';
			if (!file_exists($file)) {
				$version='current';
			}
			osW_Template::getInstance()->addJSFileHead('frame/resources/jquery3/jquery-'.$version.'.slim.js');
			$this->issetcore=true;
		}
	}

	public function loadMigrate($version='current') {
		if ($version=='current') {
			$version='3.0.1';
		}
		if ($this->issetmigrate!==true) {
			$file=vOut('settings_abspath').'frame/resources/jquery3/jquery-migrate-'.$version.'.js';
			if (!file_exists($file)) {
				$version='current';
			}
			$file=vOut('settings_abspath').'frame/resources/jquery3/jquery-migrate-'.$version.'.js';
			if (file_exists($file)) {
				osW_Template::getInstance()->addJSFileHead('frame/resources/jquery3/jquery-migrate-'.$version.'.js');
				$this->issetmigrate=true;
			}
		}
	}

	public function loadPlugin($plugin_name, $plugin_option=[]) {
		if (isset($this->loaded_plugins[$plugin_name])) {
			return true;
		}

		$this->load();

		if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/jquery3.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/jquery3.inc.php');
		} elseif (file_exists(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/jquery3.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/jquery3.inc.php');
		} else {
			include(vOut('settings_abspath').'frame/autoloader/jquery3.inc.php');
		}
	}

	/**
	 *
	 * @return osW_JQuery3
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>