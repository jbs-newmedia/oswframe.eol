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
class osW_Seo extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function checkBaseUrl() {
		osW_Settings::getInstance()->seo_base_url='';

		if (osW_Settings::getInstance()->isSSLModule(vOut('frame_default_module'))===true) {
			osW_Settings::getInstance()->seo_base_url.='https://';
		} else {
			osW_Settings::getInstance()->seo_base_url.='http://';
		}

		$subbed=false;
		if (vOut('frame_current_language')!=vOut('project_default_language')) {
			osW_Settings::getInstance()->seo_base_url.=vOut('frame_current_language');
			$subbed=true;
		}

		if ((vOut('settings_mobile')===true)&&(vOut('frame_ismobileversion')===true)) {
			if ($subbed===true) {
				osW_Settings::getInstance()->seo_base_url.='-';
			}
			osW_Settings::getInstance()->seo_base_url.='m';
			$subbed=true;
		}

		if ($subbed===true) {
			osW_Settings::getInstance()->seo_base_url.='.';
		}

		if (strlen(vOut('project_subdomain'))>0) {
			osW_Settings::getInstance()->seo_base_url.=vOut('project_subdomain').'.';
		}

		osW_Settings::getInstance()->seo_base_url.=vOut('project_domain');

		if (osW_Settings::getInstance()->isSSLModule(vOut('frame_default_module'))===true) {
			if ((intval(vOut('settings_ssl_port'))>0)&&(vOut('settings_ssl_port')!=443)) {
				osW_Settings::getInstance()->seo_base_url.=':'.vOut('settings_ssl_port');
			}
		} else {
			if ((intval(vOut('settings_port'))>0)&&(vOut('settings_port')!=80)) {
				osW_Settings::getInstance()->seo_base_url.=':'.vOut('settings_port');
			}
		}

		if (strlen(vOut('project_path'))>0) {
			osW_Settings::getInstance()->seo_base_url.='/'.vOut('project_path');
		}

		osW_Settings::getInstance()->seo_base_url.='/';

		return true;
	}

	public function getBaseUrl() {
		return vOut('seo_base_url');
	}

	public function setIsCheckSeo($value) {
		if ($value===true) {
			$this->is_checkseo=true;
		} else {
			$this->is_checkseo=false;
		}
	}

	public function isCheckSeo() {
		return $this->is_checkseo;
	}

	public function checkCanonicalUrl() {
		if ($_SERVER['SERVER_PORT']==vOut('settings_ssl_port')) {
			$url='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		} else {
			$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}

		osW_Settings::getInstance()->frame_canonical_url=$this->validateUrl(vOut('frame_default_module'), $_SERVER['QUERY_STRING'], true);

		if ((vOut('seo_direct')===true)&&((vOut('frame_canonical_url')!=$url)&&($this->isCheckSeo()===true))) {
			h()->_direct(vOut('frame_canonical_url'), 301);
		}
	}

	public function validateUrl($module, $get_parameters, $seowrite_inpage=false) {
		$seo_base_uri='';
		$check_parameters=true;
		$rewrite_module=true;

		if ((defined('SID')===true)&&(strlen(SID)>0)) {
			$get_parameters.='&'.htmlspecialchars(SID);
		}

		$ar_parameters=[];
		if (strlen($get_parameters)>0) {
			$extend=explode('#', $get_parameters);
			$ar_temp=explode('&', $extend[0]);
			foreach ($ar_temp as $value) {
				if (strlen($value)>=3) {
					$temp=explode('=', $value);
					if ((strlen($temp[0])>0)&&(strlen($temp[1])>0)) {
						if (!isset($ar_parameters[$temp[0]])) {
							$ar_parameters[$temp[0]]=$temp[1];
						}
					}
				}
			}
		}

		if (isset($ar_parameters['page'])) {
			if ($ar_parameters['page']==1) {
				unset($ar_parameters['page']);
			}
		}

		$acceptable_spider_parameters=[];
		$acceptable_user_parameters=[vOut('session_name')];

		$go_default=true;

		if (file_exists(vOut('settings_abspath').'modules/'.$module.'/rewrite/rules.inc.php')) {
			include(vOut('settings_abspath').'modules/'.$module.'/rewrite/rules.inc.php');
		}

		if ((defined('SID')===true)&&(strlen(SID)==0)) {
			$id=array_search(vOut('session_name'), $acceptable_user_parameters);
			if ($id!==false) {
				unset($acceptable_user_parameters[$id]);
			}
		}

		if ($go_default===true) {
			if ($module!=vOut('project_default_module')) {
				if ($rewrite_module===true) {
					$seo_base_uri.=osW_Language::getInstance()->mod2nav($module).vOut('seo_extension');
				} else {
					$ar_parameters['module']=$module;
				}
			}

			if (osW_Session::getInstance()->isSpider()===true) {
				$acceptable_parameters=$acceptable_spider_parameters;
			} else {
				$acceptable_parameters=$acceptable_user_parameters;
			}

			if ($check_parameters===true) {
				$parameters=[];
				foreach ($acceptable_parameters as $parameter) {
					if (isset($ar_parameters[$parameter])) {
						if ($parameter==vOut('session_name')) {
							if ($ar_parameters[$parameter]==osW_Session::getInstance()->getId()) {
								$parameters[$parameter]=$ar_parameters[$parameter];
							} else {
								$parameters[$parameter]=osW_Session::getInstance()->getId();
							}
						} else {
							$parameters[$parameter]=$ar_parameters[$parameter];
						}
					}
				}
			} else {
				$parameters=$ar_parameters;
				if ($rewrite_module===true) {
					unset($parameters['module']);
				}
			}

			$seo_base_uri.='?';
			foreach ($parameters as $key=>$value) {
				$seo_base_uri.=$key.'='.$value.'&';
			}
			$seo_base_uri=substr($seo_base_uri, 0, -1);

			if (isset($extend[1])) {
				$seo_base_uri.='#'.$extend[1];
			}
		}

		$url=$this->getBaseUrl();

		$parsed_url=parse_url($url);

		$url='';
		if (osW_Settings::getInstance()->isSSLModule($module)===true) {
			$url.='https://';
		} else {
			$url.='http://';
		}

		if (isset($parsed_url['host'])) {
			$url.=$parsed_url['host'];
		}

		if (osW_Settings::getInstance()->isSSLModule($module)===true) {
			if ((intval(vOut('settings_ssl_port'))>0)&&(vOut('settings_ssl_port')!=443)) {
				$url.=':'.vOut('settings_ssl_port');
			}
		} else {
			if ((intval(vOut('settings_port'))>0)&&(vOut('settings_port')!=80)) {
				$url.=':'.vOut('settings_port');
			}
		}

		if (isset($parsed_url['path'])) {
			$url.=$parsed_url['path'];
		}

		return $url.$seo_base_uri;
	}

	public function getCanonicalUrl() {
		return str_replace('&', '&amp;', $this->stripSession(vOut('frame_canonical_url')));
	}

	public function stripSession($url) {
		$url=str_replace('?'.vOut('session_name').'='.osW_Session::getInstance()->getId(), '', $url);
		$url=str_replace('&'.vOut('session_name').'='.osW_Session::getInstance()->getId(), '', $url);

		return $url;
	}

	public function getSEOKeyWords() {
		// TODO
	}

	/**
	 *
	 * @return osW_Seo
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>