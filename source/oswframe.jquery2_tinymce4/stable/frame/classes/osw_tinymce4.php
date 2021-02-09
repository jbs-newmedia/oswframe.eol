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
class osW_TinyMCE4 extends osW_Object {

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
			osW_JQuery2::getInstance()->loadPlugin('tinymce4');
			$this->issetcore=true;
			$this->issetcore=true;
		}
	}

	public function draw($name, $insert_value='', $options=[], $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		$this->load();
		$tinymce_options=[];
		$tinymce_plugin_options=[];

		$tinymce_options['script_url']='/frame/resources/jquery2/plugins/tinymce4/tinymce.min.js';

		if (isset($tinymce_options_in['language'])) {
			$tinymce_options['language']=$tinymce_options_in['language'];
			unset($tinymce_options_in['language']);
		} else {
			$tinymce_options['language']=vOut('frame_current_language');
		}
		if (isset($tinymce_options_in['forced_root_block'])) {
			$tinymce_options['forced_root_block']=$tinymce_options_in['forced_root_block'];
			unset($tinymce_options_in['forced_root_block']);
		} else {
			$tinymce_options['forced_root_block']=false;
		}
		if (isset($tinymce_options_in['width'])) {
			$tinymce_options['width']=$tinymce_options_in['width'];
			unset($tinymce_options_in['width']);
		} else {
			$tinymce_options['width']=740;
		}
		if (isset($tinymce_options_in['height'])) {
			$tinymce_options['height']=$tinymce_options_in['height'];
			unset($tinymce_options_in['height']);
		} else {
			$tinymce_options['height']=340;
		}
		if (isset($tinymce_options_in['resize'])) {
			$tinymce_options['resize']=$tinymce_options_in['resize'];
			unset($tinymce_options_in['resize']);
		} else {
			$tinymce_options['resize']='both';
		}
		if (isset($tinymce_options_in['selector'])) {
			$tinymce_options['selector']=$tinymce_options_in['selector'];
			unset($tinymce_options_in['selector']);
		} else {
			$tinymce_options['selector']='textarea';
		}
		if (isset($tinymce_options_in['plugins'])) {
			$tinymce_options['plugins']=$tinymce_options_in['plugins'];
			unset($tinymce_options_in['plugins']);
		} else {
			$tinymce_options['plugins']='advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table contextmenu paste';
		}
		if (isset($tinymce_options_in['toolbar'])) {
			$tinymce_options['toolbar']=$tinymce_options_in['toolbar'];
			unset($tinymce_options_in['toolbar']);
		} else {
			$tinymce_options['toolbar']='insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image';
		}
		if (isset($tinymce_options_in['relative_urls'])) {
			$tinymce_options['relative_urls']=$tinymce_options_in['relative_urls'];
			unset($tinymce_options_in['relative_urls']);
		} else {
			$tinymce_options['relative_urls']=false;
		}

		if (count($tinymce_options_in)>0) {
			foreach ($tinymce_options_in as $key=>$value) {
				$tinymce_options[$key]=$value;
			}
		}

		if (osW_Object::setIsEnabled('osW_Moxiemanager')===true) {
			$tinymce_options['external_plugins']['moxiemanager']='/frame/resources/moxiemanager/plugin.min.js';
			$tinymce_options['plugins'].=' moxiemanager link image';
			$tinymce_plugin_options_in['moxiemanager']['general.license']=vOut('moxiemanager_license');

			if (!isset($tinymce_plugin_options_in['moxiemanager']['cache.connection'])) {
				h()->_mkdir(vOut('settings_abspath').'data/moxiemanager/storage/');
				h()->_protectDir(vOut('settings_abspath').'data/moxiemanager/storage/');
				$tinymce_plugin_options_in['cache.connection']='sqlite:../data/moxiemanager/storage/cache.s3db';
			}

			if (!isset($tinymce_plugin_options_in['moxiemanager']['filesystem.rootpath'])) {
				$tinymce_plugin_options_in['moxiemanager']['filesystem.rootpath']=vOut('settings_abspath').'data/moxiemanager/demo';
			}
			h()->_mkdir($tinymce_plugin_options_in['moxiemanager']['filesystem.rootpath']);

			if (!isset($tinymce_plugin_options_in['moxiemanager']['general.temp_dir'])) {
				$tinymce_plugin_options_in['moxiemanager']['general.temp_dir']=vOut('settings_abspath').'data/moxiemanager/temp';
			}
			h()->_mkdir($tinymce_plugin_options_in['moxiemanager']['general.temp_dir']);
			h()->_protectDir($tinymce_plugin_options_in['moxiemanager']['general.temp_dir']);

			if (!isset($tinymce_plugin_options_in['moxiemanager']['log.path'])) {
				$tinymce_plugin_options_in['moxiemanager']['log.path']=vOut('settings_abspath').'data/moxiemanager/logs';
			}
			h()->_mkdir($tinymce_plugin_options_in['moxiemanager']['log.path']);
			h()->_protectDir($tinymce_plugin_options_in['moxiemanager']['log.path']);

			if (!isset($tinymce_plugin_options_in['moxiemanager']['storage.path'])) {
				$tinymce_plugin_options_in['moxiemanager']['storage.path']=vOut('settings_abspath').'data/moxiemanager/storage';
			}
			h()->_mkdir($tinymce_plugin_options_in['moxiemanager']['storage.path']);
			h()->_protectDir($tinymce_plugin_options_in['moxiemanager']['storage.path']);

			if (!isset($tinymce_plugin_options_in['moxiemanager']['general.language'])) {
				$tinymce_plugin_options_in['moxiemanager']['general.language']='de';
			}
			if (!isset($tinymce_plugin_options_in['moxiemanager']['general.plugins'])) {
				$tinymce_plugin_options_in['moxiemanager']['general.plugins']='AutoFormat,AutoRenameFavorites,Ftp,History,Uploaded';
			}
		}

		$moxiemanager_plugin_options=[];
		if (count($tinymce_plugin_options_in)>0) {
			if (osW_Object::setIsEnabled('osW_Moxiemanager')===true) {
				if (isset($tinymce_plugin_options_in['moxiemanager'])) {
					foreach ($tinymce_plugin_options_in['moxiemanager'] as $key=>$value) {
						$moxiemanager_plugin_options[$key]=$value;
					}
					unset($tinymce_plugin_options_in['moxiemanager']);
				}
			}
			if ((is_array($tinymce_plugin_options_in))&&($tinymce_plugin_options_in!=[])) {
				foreach ($tinymce_plugin_options_in as $key=>$value) {
					$tinymce_plugin_options[$key]=$value;
				}
			}
		}

		osW_Template::getInstance()->addJSCodeHead('
$().ready(function() {
	$(\'#'.$name.'\').tinymce('.json_encode($tinymce_options, JSON_UNESCAPED_SLASHES+JSON_PRETTY_PRINT).');
});
		');

		$token=md5(vOut('settings_protection_salt').serialize($tinymce_plugin_options).osW_Session::getInstance()->getId());
		osW_Session::getInstance()->set('tinymce4_user_'.$token, md5($tinymce_options['script_url']));
		osW_Session::getInstance()->set('tinymce4_login_'.$token, true);
		osW_Session::getInstance()->set('tinymce4_options_'.$token, $tinymce_plugin_options);
		osW_Session::getInstance()->set('tinymce4_token', $token);

		if (osW_Object::setIsEnabled('osW_Moxiemanager')===true) {
			$token=md5(vOut('settings_protection_salt').serialize($moxiemanager_plugin_options).osW_Session::getInstance()->getId());
			osW_Session::getInstance()->set('moxiemanager_user_'.$token, md5($tinymce_plugin_options_in['moxiemanager']['filesystem.rootpath']));
			osW_Session::getInstance()->set('moxiemanager_login_'.$token, true);
			osW_Session::getInstance()->set('moxiemanager_options_'.$token, $moxiemanager_plugin_options);
			osW_Session::getInstance()->set('moxiemanager_token', $token);
		}

		return osW_Form::getInstance()->drawTextareaField($name, $insert_value, $options);
	}

	/**
	 *
	 * @return osW_TinyMCE4
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>