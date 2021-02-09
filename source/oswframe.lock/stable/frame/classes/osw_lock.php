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
class osW_Lock extends osW_Object {

	/* PROPERTIES */
	private $locks=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function lock($module, $lock) {
		$module=strtolower($module);

		if (!is_dir(vOut('settings_abspath').vOut('lock_path'))) {
			h()->_mkDir(vOut('settings_abspath').vOut('lock_path'));
		}
		h()->_protectDir(vOut('settings_abspath').vOut('lock_path'));

		$dir=vOut('settings_abspath').vOut('lock_path').$module.'/';

		if (!is_dir($dir)) {
			h()->_mkDir($dir);
		}

		$this->locks[$module.'_'.$lock]=fopen($dir.$lock.'.lock', "w+");
		if (flock($this->locks[$module.'_'.$lock], LOCK_EX)) {
			return true;
		} else {
			return false;
		}
	}

	public function unlock($module, $lock) {
		$module=strtolower($module);
		flock($this->locks[$module.'_'.$lock], LOCK_UN);
		fclose($this->locks[$module.'_'.$lock]);
	}

	/**
	 *
	 * @return osW_Lock
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>