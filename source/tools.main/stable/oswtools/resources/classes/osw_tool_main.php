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

class osW_Tool_Main extends osW_Tool_Object {

	public $data=array();

	function __construct() {
	}

	function __destruct() {
	}

	public function checkPackageList($packagelist) {
		$installed=array();
		foreach ($packagelist as $key=>$package) {
			$file=abs_path.'resources/json/package/'.$package['package'].'-'.$package['release'].'.json';

			if (isset($package['info']['name'])) {
				$packagelist[$key]['key']=$package['info']['name'].'-'.$key;
			} else {
				$packagelist[$key]['key']=$key;
			}

			if (file_exists($file)) {
				$info=json_decode(file_get_contents($file), true);
				$packagelist[$key]['version_installed']=$info['info']['version'];
				$installed[$info['info']['package']]=true;
			} else {
				$packagelist[$key]['version_installed']='0.0';
			}

			if (!isset($package['info']['group'])||(!in_array($package['info']['group'], array('tool')))||($package['package']=='tools.main')) {
				unset($packagelist[$key]);
			}
		}

		foreach ($packagelist as $key=>$package) {
			$packagelist[$key]['options']=array();
			$packagelist[$key]['options']['install']=false;
			$packagelist[$key]['options']['update']=false;
			$packagelist[$key]['options']['remove']=false;
			$packagelist[$key]['options']['blocked']=false;
			if ($packagelist[$key]['version_installed']=='0.0') {
				if (!isset($installed[$packagelist[$key]['package']])) {
					$packagelist[$key]['options']['install']=true;
				}
			} elseif (osW_Tool::getInstance()->checkVersion($packagelist[$key]['version_installed'], $packagelist[$key]['version'])) {
				$packagelist[$key]['options']['update']=true;
				$packagelist[$key]['options']['remove']=true;
			} else {
				$packagelist[$key]['options']['remove']=true;
			}
		}

		uasort($packagelist, array($this,'comparePackageList'));
		return $packagelist;
	}

	public function comparePackageList($a, $b) {
		return strcmp(strtolower($a['key']), strtolower($b['key']));
	}

	/**
	 *
	 * @return osW_Tool_Main
	 */
	public static function getInstance() {
		return parent::getInstance();
	}
}

?>