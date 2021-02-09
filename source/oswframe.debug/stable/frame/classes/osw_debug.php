<?php

/**
 *
 * @author Juergen Schwind
 * @author Patrick Streibert
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_Debug extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */

	private function deleteMessages() {
		$dir=vOut('settings_abspath').vOut('debug_path');
		$handle=opendir($dir);
		while (($subdir=readdir($handle))!==false) {
			if ($subdir=='.'||$subdir=='..') {
				continue;
			}
			if (is_dir($dir.$subdir)) {
				$subhandle=opendir($dir.$subdir);
				while (($file=readdir($subhandle))!==false) {
					if ($file=='.'||$file=='..') {
						continue;
					}
					$time=intval(substr($file, 0, 8));
					if (($time>0)&&($time<date('Ymd', (mktime(date('h'), date('i'), date('s'), date('m'), (date('d')-vOut('debug_maxdays')), date('Y')))))) {
						unlink($dir.$subdir.'/'.$file);
					}
				}
				closedir($subhandle);
				if (h()->_isDirEmpty($dir.$subdir)===true) {
					rmdir($dir.$subdir);
				}
			}
		}
		closedir($handle);
	}

	public function logMessages() {
		if (vOut('debug_write_logs')===true) {
			if (vOut('debug_gc_probability')===true) {
				$nr=h()->_rand(1, vOut('debug_gc_divisor'));
				$h=round(vOut('debug_gc_divisor')/2);
				if ($nr==$h) {
					$this->deleteMessages();
				}
			}

			if (!is_dir(vOut('settings_abspath').vOut('debug_path'))) {
				h()->_mkDir(vOut('settings_abspath').vOut('debug_path'));
			}
			h()->_protectDir(vOut('settings_abspath').vOut('debug_path'));
			foreach (osW_MessageStack::getInstance()->getMessages() as $key=>$types) {
				if (($key!='form')&&($key!='session')) {
					if (!is_dir(vOut('settings_abspath').vOut('debug_path').$key.'/')) {
						h()->_mkDir(vOut('settings_abspath').vOut('debug_path').$key.'/');
					}
					foreach ($types as $type=>$messages) {
						if (($key=='database')&&($type=='notice')) {
						} else {
							$logfile=vOut('settings_abspath').vOut('debug_path').$key.'/'.date('Ymd', time()).'_'.$type.'.csv';
							if (file_exists($logfile)&&(filesize($logfile)>vOut('debug_maxsize'))) {
								$i=0;
								$find=false;
								while ($find==false) {
									$logfile=vOut('settings_abspath').vOut('debug_path').$key.'/'.date('Ymd', time()).'_'.$type.'-'.$i.'.csv';
									if (file_exists($logfile)&&(filesize($logfile)>vOut('debug_maxsize'))) {
										$i++;
									} else {
										$find=true;
									}
								}
							}

							if (!file_exists($logfile)) {
								$ar_header=array_flip($messages[0]);
								$csv_data='"'.implode('";"', $ar_header).'"';
								error_log($csv_data."\n", 3, $logfile);
							}
							foreach ($messages as $message) {
								$csv_data='"'.implode('";"', $message).'"';
								error_log($csv_data."\n", 3, $logfile);
							}
						}
					}
				}
			}
		}
	}

	/* Gibt Daten zum Client zurück */
	public function getClientData() {
		$client['ip']=$_SERVER['REMOTE_ADDR'];
		$client['hostaddress']=gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$client['useragent']=$_SERVER['HTTP_USER_AGENT'];
		$client['referer']=$_SERVER['HTTP_REFERER'];

		return $client;
	}

	/**
	 *
	 * @return osW_Debug
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>