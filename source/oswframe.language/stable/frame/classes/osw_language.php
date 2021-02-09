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
class osW_Language extends osW_Object {

	/* VALUES */
	private $ar_language=[];

	private $nav2mod=[];

	private $mod2nav=[];

	private $language_config=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function initLanguage() {
		$ar_lang=[];
		if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/lng/rewrite/'.vOut('frame_current_language').'.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/lng/rewrite/'.vOut('frame_current_language').'.inc.php');
		} elseif (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/lng/rewrite/'.vOut('project_default_language').'.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/lng/rewrite/'.vOut('project_default_language').'.inc.php');
		}
		$this->addLanguageReWrite($ar_lang);
	}

	public function addLanguageReWrite($ar_lang) {
		foreach ($ar_lang as $var=>$value) {
			$this->mod2nav[$var]=$value;
			$this->nav2mod[$value]=$var;
		}
	}

	public function addLanguageVarsByFile($language='current', $module='current', $prefix='', $dir='') {
		if (($language=='')||($language=='default')) {
			$language=vOut('project_default_language');
		}
		if ($language=='current') {
			$language=vOut('frame_current_language');
		}
		if (($module=='')||($module=='default')) {
			$module=vOut('project_default_module');
		}
		if ($module=='current') {
			$module=vOut('frame_current_module');
		}
		if (strlen($dir)>0) {
			$dir.='/';
		}
		$ar_lang=[];
		if (file_exists(vOut('settings_abspath').'modules/'.$module.'/lng/'.$dir.$language.'.inc.php')) {
			include(vOut('settings_abspath').'modules/'.$module.'/lng/'.$dir.$language.'.inc.php');
		} elseif (file_exists(vOut('settings_abspath').'modules/'.$module.'/lng/'.$dir.vOut('project_default_language').'.inc.php')) {
			include(vOut('settings_abspath').'modules/'.$module.'/lng/'.$dir.vOut('project_default_language').'.inc.php');
		}
		$this->addLanguageVars($ar_lang, $prefix);
	}

	public function addLanguageVars($ar_vars, $prefix='') {
		foreach ($ar_vars as $var=>$value) {
			$this->addLanguageVar($var, $value, $prefix);
		}
	}

	public function addLanguageVar($var, $value, $prefix='') {
		if (strlen($prefix)>0) {
			$prefix=$prefix.'_';
		}
		$this->ar_language[strtolower($prefix.$var)]=$value;
	}

	public function getLanguageVar($var, $prefix='') {
		if (strlen($prefix)>0) {
			$prefix=$prefix.'_';
		}
		if (isset($this->ar_language[strtolower($prefix.$var)])) {
			return $this->ar_language[strtolower($prefix.$var)];
		} else {
			return $prefix.$var;
		}
	}

	public function mod2nav($mod) {
		if (isset($this->mod2nav[$mod])) {
			return $this->mod2nav[$mod];
		} else {
			return $mod;
		}
	}

	public function nav2mod($nav) {
		if (isset($this->nav2mod[$nav])) {
			return $this->nav2mod[$nav];
		} else {
			return $nav;
		}
	}

	/**
	 *
	 * @return osW_Language
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>