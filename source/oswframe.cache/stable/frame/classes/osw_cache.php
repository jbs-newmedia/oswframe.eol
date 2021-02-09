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
class osW_Cache extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function setTest($var) {
		$this->var=$var;
	}

	public function getTest() {
		return $this->var;
	}

	private function getFileName($module, $file, $extention='.cache') {
		return vOut('settings_abspath').vOut('cache_path').'files/'.strtolower($module).'/'.strtolower($file.$extention);
	}

	private function getDirName($module) {
		return vOut('settings_abspath').vOut('cache_path').'files/'.strtolower($module).'/';
	}

	public function writeCache($module, $file, $data, $extention='.cache') {
		return $this->write($module, $file, $data, $extention);
	}

	public function write($module, $file, $data, $extention='.cache') {
		$dirname=$this->getDirName($module);
		h()->_mkDir($dirname);
		$filename=$this->getFileName($module, $file, $extention);
		if (file_put_contents($filename, $data)!==false) {
			h()->_chmod($filename);

			return true;
		}

		return false;
	}

	public function writeCacheArray($module, $file, $data) {
		$this->writeCache($module, $file, serialize($data));
	}

	public function readCache($module, $file, $expire=0, $extention='.cache') {
		return $this->read($module, $file, $extention, $expire);
	}

	public function read($module, $file, $extention='.cache', $expire=0) {
		$filename=$this->getFileName($module, $file, $extention);
		if (file_exists($filename)) {
			if (($expire==0)||(filemtime($filename)>=(time()-$expire))) {
				return file_get_contents($filename);
			}
		}

		return false;
	}

	public function readCacheArray($module, $file, $expire=0) {
		if (false!==($data=$this->readCache($module, $file, $expire))) {
			return unserialize($data);
		}

		return false;
	}

	public function deleteCache($module, $file, $extention='.cache') {
		return $this->delete($module, $file, $extention);
	}

	public function delete($module, $file, $extention='.cache') {
		$filename=$this->getFileName($module, $file, $extention);
		if (file_exists($filename)) {
			if (h()->_unlink($filename)===true) {
				return true;
			}

			return false;
		}

		return true;
	}

	public function existsCache($module, $file, $extention='.cache') {
		return $this->exists($module, $file, $extention);
	}

	public function exists($module, $file, $extention='.cache') {
		$filename=$this->getFileName($module, $file, $extention);
		if (file_exists($filename)) {
			return true;
		}

		return false;
	}

	public function mtime($module, $file, $extention='.cache') {
		$filename=$this->getFileName($module, $file, $extention);
		if (file_exists($filename)) {
			return filemtime($filename);
		}

		return false;
	}

	public function size($module, $file, $extention='.cache') {
		$filename=$this->getFileName($module, $file, $extention);
		if (file_exists($filename)) {
			return filesize($filename);
		}

		return false;
	}

	public function clear($module, $expire, $extention='.cache') {
		$dir=$this->getDirName($module);
		$oldertime=time()-$expire;

		$dir_a=scandir($dir);
		foreach ($dir_a as $filename) {
			if ($filename!='.'&&$filename!='..') {
				$name=str_replace($extention, '', $filename);
				if ($filename!=$name&&@filemtime($dir.$filename)<$oldertime) {
					@unlink($dir.$filename);
				}
			}
		}
	}

	/**
	 *
	 * @return osW_Cache
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>