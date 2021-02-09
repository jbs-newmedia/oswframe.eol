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
class osW_JQuery2 extends osW_Object {

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
			$version='2.2.4';
		}
		if ($this->issetcore!==true) {
			$file=vOut('settings_abspath').'frame/resources/jquery2/jquery-'.$version.'.js';
			if (!file_exists($file)) {
				$version='current';
			}
			osW_Template::getInstance()->addJSFileHead('frame/resources/jquery2/jquery-'.$version.'.js');
			$this->issetcore=true;
		}
	}

	public function loadMigrate($version='current') {
		if ($version=='current') {
			$version='1.4.1';
		}
		if ($this->issetmigrate!==true) {
			$file=vOut('settings_abspath').'frame/resources/jquery2/jquery-migrate-'.$version.'.js';
			if (!file_exists($file)) {
				$version='current';
			}
			$file=vOut('settings_abspath').'frame/resources/jquery2/jquery-migrate-'.$version.'.js';
			if (file_exists($file)) {
				osW_Template::getInstance()->addJSFileHead('frame/resources/jquery2/jquery-migrate-'.$version.'.js');
				$this->issetmigrate=true;
			}
		}
	}

	public function loadPlugin($plugin_name, $plugin_option=[]) {
		if (isset($this->loaded_plugins[$plugin_name])) {
			return true;
		}

		$this->load();

		if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/jquery2.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/jquery2.inc.php');
		} elseif (file_exists(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/jquery2.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/jquery2.inc.php');
		} else {
			include(vOut('settings_abspath').'frame/autoloader/jquery2.inc.php');
		}
	}

	public function loadUI($skin='ui-lightness', $version='current') {
		if ($this->issetui!==true) {
			$file=vOut('settings_abspath').'frame/resources/jquery2/ui1/'.$version.'/jquery-ui.js';
			if (!file_exists($file)) {
				$version='current';
			}

			$file=vOut('settings_abspath').'frame/resources/jquery2/ui1/'.$version.'/themes/'.$skin.'/jquery-ui.css';
			if (!file_exists($file)) {
				$skin='ui-lightness';
			}

			osW_Template::getInstance()->addJSFileHead('frame/resources/jquery2/ui1/'.$version.'/jquery-ui.js');
			$file='jquery-ui_'.$skin.'_'.$version;
			if (osW_Cache::getInstance()->exists(__CLASS__, $file, '.css')!==true) {
				$cache_content=file_get_contents(vOut('settings_abspath').'frame/resources/jquery2/ui1/'.$version.'/themes/'.$skin.'/jquery-ui.css');
				$cache_content=str_replace('url(images/', 'url(__IMAGEOPTIMIZER_PATH__/frame/resources/jquery2/ui1/'.$version.'/themes/'.$skin.'/images/', $cache_content);
				$cache_content=str_replace('url("images/', 'url("__IMAGEOPTIMIZER_PATH__/frame/resources/jquery2/ui1/'.$version.'/themes/'.$skin.'/images/', $cache_content);
				osW_Cache::getInstance()->write(__CLASS__, $file, $cache_content, '.css');
			}
			osW_Template::getInstance()->addCSSFileHead('.caches/files/'.strtolower(__CLASS__).'/'.$file.'.css');
			$this->issetui=true;
		}
	}

	/**
	 *
	 * @return osW_JQuery2
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>