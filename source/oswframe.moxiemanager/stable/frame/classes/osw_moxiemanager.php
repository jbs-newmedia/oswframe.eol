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
class osW_Moxiemanager extends osW_Object {

	/* PROPERTIES */
	private $issetcore=false;

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	private function load() {
		if ($this->issetcore!==true) {
			osW_JQuery2::getInstance()->load();
			osW_Template::getInstance()->addJSFileHead('frame/resources/moxiemanager/js/moxman.loader.min.js', false, false);
			$this->issetcore=true;
		}
	}

	public function draw($api='browse', $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		$this->load();
		switch ($api) {
			case 'browse':
			case 'upload':
			case 'edit':
			case 'view':
			case 'createDir':
			case 'createDoc':
				break;
			default:
				$api='browse';
				break;
		}

		if (count($tinymce_options_in)>0) {
			foreach ($tinymce_options_in as $key=>$value) {
				$tinymce_options[$key]=$value;
			}
		}

		$tinymce_plugin_options_in['general.license']=vOut('moxiemanager_license');
		if (!isset($tinymce_plugin_options_in['cache.connection'])) {
			h()->_mkdir(vOut('settings_abspath').'data/moxiemanager/storage/');
			h()->_protectDir(vOut('settings_abspath').'data/moxiemanager/storage/');
			$tinymce_plugin_options_in['cache.connection']='sqlite:../data/moxiemanager/storage/cache.s3db';
		}
		if (!isset($tinymce_plugin_options_in['filesystem.rootpath'])) {
			h()->_mkdir(vOut('settings_abspath').'data/moxiemanager/demo/');
			$tinymce_plugin_options_in['filesystem.rootpath']=vOut('settings_abspath').'data/moxiemanager/demo';
		}
		if (!isset($tinymce_plugin_options_in['general.temp_dir'])) {
			h()->_mkdir(vOut('settings_abspath').'data/moxiemanager/temp/');
			h()->_protectDir(vOut('settings_abspath').'data/moxiemanager/temp/');
			$tinymce_plugin_options_in['general.temp_dir']=vOut('settings_abspath').'data/moxiemanager/temp';
		}
		if (!isset($tinymce_plugin_options_in['log.path'])) {
			h()->_mkdir(vOut('settings_abspath').'data/moxiemanager/logs/');
			h()->_protectDir(vOut('settings_abspath').'data/moxiemanager/logs/');
			$tinymce_plugin_options_in['log.path']=vOut('settings_abspath').'data/moxiemanager/logs';
		}
		if (!isset($tinymce_plugin_options_in['storage.path'])) {
			h()->_mkdir(vOut('settings_abspath').'data/moxiemanager/storage/');
			h()->_protectDir(vOut('settings_abspath').'data/moxiemanager/storage/');
			$tinymce_plugin_options_in['storage.path']=vOut('settings_abspath').'data/moxiemanager/storage';
		}
		if (!isset($tinymce_plugin_options_in['general.language'])) {
			$tinymce_plugin_options_in['general.language']=vOut('frame_current_language');
		}
		if (!isset($tinymce_plugin_options_in['general.plugins'])) {
			$tinymce_plugin_options_in['general.plugins']='AutoFormat,AutoRenameFavorites,Ftp,History,Uploaded';
		}

		$moxiemanager_plugin_options=[];
		if (count($tinymce_plugin_options_in)>0) {
			foreach ($tinymce_plugin_options_in as $key=>$value) {
				$moxiemanager_plugin_options[$key]=$value;
			}
			unset($tinymce_plugin_options_in);
		}

		$tinymce_options_parsed=[];

		foreach ($tinymce_options as $key=>$value) {
			if (is_array($value)) {
				$tinymce_options_parsed[]=$key.': \''.implode(',', $value).'\'';
			} elseif (is_bool($value)) {
				if ($value===true) {
					$tinymce_options_parsed[]=$key.': true';
				} else {
					$tinymce_options_parsed[]=$key.': false';
				}
			} elseif (is_int($value)) {
				$tinymce_options_parsed[]=$key.': '.$value.'';
			} else {
				$tinymce_options_parsed[]=$key.': \''.$value.'\'';
			}
		}

		$token=md5(vOut('settings_protection_salt').serialize($moxiemanager_plugin_options).osW_Session::getInstance()->getId());

		osW_Session::getInstance()->set('moxiemanager_user_'.$token, md5($moxiemanager_plugin_options['filesystem.rootpath']));
		osW_Session::getInstance()->set('moxiemanager_login_'.$token, true);
		osW_Session::getInstance()->set('moxiemanager_options_'.$token, $moxiemanager_plugin_options);
		osW_Session::getInstance()->set('moxiemanager_token', $token);

		osW_Session::getInstance()->set('osw_token', md5(vOut('settings_protection_salt').session_id()));

		return 'moxman.'.$api.'({'.implode(',', $tinymce_options_parsed).'});';
	}

	public function drawBrowse($name='Browse', $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		return '<a href="javascript:;" onclick="'.$this->draw('browse', $tinymce_options_in, $tinymce_plugin_options_in).'">['.h()->_outputString($name).']</a>';
	}

	public function drawUpload($name='Upload', $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		return '<a href="javascript:;" onclick="'.$this->draw('upload', $tinymce_options_in, $tinymce_plugin_options_in).'">['.h()->_outputString($name).']</a>';
	}

	public function drawEdit($name='Edit', $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		return '<a href="javascript:;" onclick="'.$this->draw('edit', $tinymce_options_in, $tinymce_plugin_options_in).'">['.h()->_outputString($name).']</a>';
	}

	public function drawView($name='View', $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		return '<a href="javascript:;" onclick="'.$this->draw('view', $tinymce_options_in, $tinymce_plugin_options_in).'">['.h()->_outputString($name).']</a>';
	}

	public function drawCreateDir($name='CreateDir', $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		return '<a href="javascript:;" onclick="'.$this->draw('createDir', $tinymce_options_in, $tinymce_plugin_options_in).'">['.h()->_outputString($name).']</a>';
	}

	public function drawCreateDoc($name='CreateDoc', $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		return '<a href="javascript:;" onclick="'.$this->draw('createDoc', $tinymce_options_in, $tinymce_plugin_options_in).'">['.h()->_outputString($name).']</a>';
	}

	/**
	 *
	 * @return osW_Moxiemanager
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>