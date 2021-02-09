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
class osW_Settings extends osW_Object {

	/* VALUES */
	private $languages_available=[];

	private $sslmodules=[];

	private $frame_version=[];

	private $framemod_version=[];

	private $data=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function getAction() {
		return $this->action;
	}

	public function setAction($action_value) {
		$this->action=$action_value;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function setLanguage($language_value) {
		$this->language=$language_value;
	}

	public function setAvailableLanguages($languages_available) {
		$this->languages_available=$languages_available;
	}

	public function checkProjectConfig() {
		$this->frame_current_module=vOut('project_default_module');
		$this->setAvailableLanguages(explode(',', vOut('language_availablelanguages')));

		$domain='';
		if (strlen(vOut('project_subdomain'))>0) {
			$domain.=vOut('project_subdomain').'.';
		}

		$domain.=vOut('project_domain');

		if (vOut('settings_ssl_global')===true) {
			osW_Settings::getInstance()->project_domain_full='https://';
		} else {
			osW_Settings::getInstance()->project_domain_full='http://';
		}

		if (vOut('project_path')=='') {
			osW_Settings::getInstance()->project_domain_full=vOut('project_domain_full').$domain.'/';
		} else {
			osW_Settings::getInstance()->project_domain_full=vOut('project_domain_full').$domain.'/'.vOut('project_path').'/';
		}

		$_host='';
		if (isset($_SERVER['HTTP_HOST'])) {
			$_host=$_SERVER['HTTP_HOST'];
		}

		$domain=str_replace($domain, 'example.com', $_host);

		$splitted_domain=explode('.', $domain);

		if (count($splitted_domain)==3) {
			$splitted_subdomain=explode('-', $splitted_domain[0]);
			if ((isset($splitted_subdomain[0]))&&(in_array($splitted_subdomain[0], $this->languages_available))) {
				$this->frame_current_language=$splitted_subdomain[0];
			} else {
				$this->frame_current_language=vOut('project_default_language');
			}
			if ((isset($splitted_subdomain[1]))&&($splitted_subdomain[1]=='m')&&(vOut('settings_mobile')==true)) {
				$this->frame_ismobileversion=true;
			} elseif ((isset($splitted_subdomain[0]))&&($splitted_subdomain[0]=='m')&&(vOut('settings_mobile')==true)) {
				$this->frame_ismobileversion=true;
			} else {
				$this->frame_ismobileversion=false;
			}
		} else {
			$this->frame_current_language=vOut('project_default_language');
			$this->frame_ismobileversion=false;
		}

		osW_Language::getInstance()->initLanguage();
		$this->setSSLModules(vOut('settings_ssl_modules'));
		osW_Seo::getInstance()->setIsCheckSeo(true);

		$this->updatePackages();
	}

	public function getLanguageURLs() {
		foreach ($this->languages_available as $language) {
		}
		if (isset($this->language_config[$short][$value])) {
			return $this->language_config[$short][$value];
		}

		return '';
	}

	public function setSSLModules($str) {
		if ((vout('settings_ssl')===true)&&(osW_Session::getInstance()->isSpider()!==true)) {
			$sslmodules=explode(',', $str);
			foreach ($sslmodules as $module) {
				$this->sslmodules[]=trim($module);
			}
		}
	}

	public function isSSLModule($module) {
		if (vOut('settings_ssl_global')===true) {
			return true;
		}
		if (in_array($module, $this->sslmodules)) {
			return true;
		}

		return false;
	}

	public function isSessionModule($module) {
		if ($module==vOut('settings_errorlogger')) {
			return false;
		}
		if ($module==vOut('settings_imageoptimizer')) {
			return false;
		}
		if ($module==vOut('settings_scriptoptimizer')) {
			return false;
		}
		if ($module==vOut('settings_styleoptimizer')) {
			return false;
		}
		if (osW_Session::getInstance()->isDisabledModule($module)===true) {
			return false;
		}

		return true;
	}

	public function removeMagicQuotes() {
		$this->stripMagicQuotes($_GET);
		$this->stripMagicQuotes($_POST);
		$this->stripMagicQuotes($_COOKIE);
	}

	private function stripMagicQuotes(&$array) {
		if (!is_array($array)||(sizeof($array)<1)) {
			return false;
		}

		foreach ($array as $key=>$value) {
			if (is_array($value)) {
				$this->stripMagicQuotes($array[$key]);
			} else {
				$array[$key]=stripslashes($value);
			}
		}
	}

	public function updatePackages() {
		if ((vOut('settings_report_new_versions')===true)||(vOut('settings_install_new_versions')===true)) {
			if (osW_Lock::getInstance()->lock(__CLASS__, 'oswframeupdate')===true) {
				$lastcheck=intval(osW_Cache::getInstance()->read(__CLASS__, 'oswframeupdate'));
				if ($lastcheck<(time()-vOut('settings_check_new_versions_time'))) {
					$data=json_decode($this->getData(vOut('project_domain_full').'oswtools/packagemanager.stable/core.php', vOut('settings_updatetool_htaccess_login')), true);
					if ($data!=null) {
						if ($data['details']['count']==0) {
							// Nothing
						}

						if ($data['details']['count']>0) {
							if (vOut('settings_install_new_versions')===true) {
								$data_new=json_decode($this->getData(vOut('project_domain_full').'oswtools/packagemanager.stable/core.php?action=update_all', vOut('settings_updatetool_htaccess_login')), true);
								if ((isset($data_new['msg']))&&($data_new['msg']=='ok')) {
									$data_new=json_decode($this->getData(vOut('project_domain_full').'oswtools/packagemanager.stable/core.php', vOut('settings_updatetool_htaccess_login')), true);
									$this->sendUpdateReport('success', $data, $data_new);
								} else {
									$this->sendUpdateReport('error', $data, $data_new);
								}
							} elseif (vOut('settings_report_new_versions')===true) {
								$this->sendUpdateReport('report', $data);
							}
						}
					} else {
						$this->sendUpdateReport('connectionerror', []);
					}
					osW_Cache::getInstance()->write(__CLASS__, 'oswframeupdate', time());
				}
			}
			osW_Lock::getInstance()->unlock(__CLASS__, 'oswframeupdate');
		}
	}

	public function sendUpdateReport($mode, $data, $data_new=[]) {
		$subject=vOut('project_name').':';
		if ($mode=='success') {
			$subject.=' updated successfully';
		}
		if ($mode=='error') {
			$subject.=' update failed';
		}
		if ($mode=='report') {
			$subject.=' updates available';
		}
		if ($mode=='connectionerror') {
			$subject.=' connection error';
		}

		$mail_body=[];
		$mail_body[]=$subject;
		$mail_body[]='';
		$mail_body[]='';
		if (isset($data['list'])) {
			foreach ($data['list'] as $serverlist=>$packages) {
				$mail_body[]='Serverlist: '.$serverlist;
				$mail_body[]='================================================';
				$mail_body[]='';
				foreach ($packages as $package=>$package_data) {
					$mail_body[]='Package: '.$package;
					$mail_body[]='================================================';
					$mail_body[]='Name: '.$package_data['name'];
					$mail_body[]='Package: '.$package_data['package'];
					$mail_body[]='Release: '.$package_data['release'];
					$mail_body[]='------------------------------------------------';
					$mail_body[]='Version '.$package_data['version_installed'].' installed';
					$mail_body[]='Version '.$package_data['version'].' available';
					if (($mode=='success')&&(isset($data_new['list'][$serverlist][$package]))) {
						$mail_body[]='Version '.$data_new['list'][$serverlist][$package]['version_installed'].' updated';
					}
					$mail_body[]='';
				}
				$mail_body[]='';
			}
		} else {
			$mail_body[]='check the configure.project.php in modules!';
		}
		$mail='';
		foreach ($mail_body as $line) {
			$mail.=$line."\n";
		}

		osW_EMail::getInstance()->setFrom(vOut('project_email'));
		osW_EMail::getInstance()->addAddress(vOut('project_email_system'));
		osW_EMail::getInstance()->setSubject($subject);
		osW_EMail::getInstance()->setMessage($mail);
		osW_EMail::getInstance()->send();
		osW_EMail::getInstance()->clear();
	}

	public function getData($url, $login='') {
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		if (strlen($login)>0) {
			curl_setopt($ch, CURLOPT_USERPWD, $login);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response=curl_exec($ch);
		curl_close($ch);

		return $response;
	}

	public function checkSlowRunTime() {
		$this->page_parse_time=h()->_number_format((PAGE_PARSE_TIME_END-PAGE_PARSE_TIME_START), 5);

		if ((PAGE_PARSE_TIME_END-PAGE_PARSE_TIME_START)>vOut('settings_slowruntime')) {
			$this->logMessage(__CLASS__, 'slowruntime', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'runtime'=>vOut('page_parse_time'), 'script'=>$_SERVER['REQUEST_URI']]);
		}
	}

	public function getFrameClassPrefixArray() {
		$name=__FUNCTION__;

		if (!isset($this->data[$name])) {
			$this->data[$name]=array_filter(explode(',', vOut('settings_frame_class_prefixes').',,'.vOut('settings_frame_class_prefixes_custom')));
		}

		return $this->data[$name];
	}

	/**
	 *
	 * @return osW_Settings
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>