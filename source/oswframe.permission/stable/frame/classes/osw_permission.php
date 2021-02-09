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
class osW_Permission extends osW_Object {

	/* PROPERTIES */
	private $grouppermissions=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function checkPermission($module, $key, $groupids) {
		foreach ($groupids as $groupid) {
			if (isset($this->grouppermissions[$module][$groupid][$key])) {
				if ($this->grouppermissions[$module][$groupid][$key]===true) {
					return true;
				}
			}
		}

		return false;
	}

	public function readPermissions() {
		if (false===($this->grouppermissions=osW_Cache::getInstance()->readCacheArray('permission', 'groups'))) {
			$this->cachePermissions();
		}
	}

	public function cachePermissions() {
		$dir=vOut('settings_abspath').'modules/';
		if (is_dir($dir)) {
			if ($handle=opendir($dir)) {
				while (false!==($file=readdir($handle))) {
					if (($file!='.')&&($file!='..')) {
						if (is_dir($dir.$file.'/')) {
							$this->addPemFiles($dir.$file.'/');
						}
					}
				}
			}
		}
		// osW_Cache::getInstance()->writeCacheArray('permission', 'groups', $this->grouppermissions);
	}

	private function addPemFiles($dir) {
		$dir.='pem/';
		if (is_dir($dir)) {
			if ($handle=opendir($dir)) {
				while (false!==($file=readdir($handle))) {
					if (($file!='.')&&($file!='..')) {
						if (is_file($dir.$file)) {
							require($dir.$file);
						}
					}
				}
			}
		}
	}

	public function addPemFile($file, $keys) {
		$file=str_replace('\\', '/', $file);
		$dirs=explode('/', $file);
		$groupid=$dirs[count($dirs)-1];
		$groupid=str_replace('group_', '', $groupid);
		$groupid=str_replace('.inc.php', '', $groupid);
		$module=$dirs[count($dirs)-3];

		$this->grouppermissions[$module][$groupid]=$keys;
	}

	/**
	 *
	 * @return osW_Permission
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>