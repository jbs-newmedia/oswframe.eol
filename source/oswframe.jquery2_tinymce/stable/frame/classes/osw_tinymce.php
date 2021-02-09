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
class osW_TinyMCE extends osW_Object {

	/* PROPERTIES */
	private $issetcore=false;

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function load() {
		if ($this->issetcore!==true) {
			osW_JQuery2::getInstance()->load();
			osW_JQuery2::getInstance()->loadPlugin('tinymce');
			$this->issetcore=true;
		}
	}

	public function draw($name, $insert_value='', $options=[], $tinymce_options_in=[], $tinymce_plugin_options_in=[]) {
		$this->load();
		$tinymce_options=[];
		$tinymce_plugin_options=[];

		$tinymce_options['script_url']='/frame/resources/jquery2/plugins/tinymce/tiny_mce.js';

		if (isset($tinymce_options_in['language'])) {
			$tinymce_options['language']=$tinymce_options_in['language'];
			unset($tinymce_options_in['language']);
		} else {
			$tinymce_options['language']=vOut('frame_current_language');
		}
		if (isset($tinymce_options_in['mode'])) {
			$tinymce_options['mode']=$tinymce_options_in['mode'];
			unset($tinymce_options_in['mode']);
		} else {
			$tinymce_options['mode']='textareas';
		}
		if (isset($tinymce_options_in['theme'])) {
			$tinymce_options['theme']=$tinymce_options_in['theme'];
			unset($tinymce_options_in['theme']);
		} else {
			$tinymce_options['theme']='advanced';
		}
		if (isset($tinymce_options_in['skin'])) {
			$tinymce_options['skin']=$tinymce_options_in['skin'];
			unset($tinymce_options_in['skin']);
		} else {
			$tinymce_options['skin']='default';
		}
		if (isset($tinymce_options_in['skin_variant'])) {
			$tinymce_options['skin_variant']=$tinymce_options_in['skin_variant'];
			unset($tinymce_options_in['skin_variant']);
		} else {
			$tinymce_options['skin_variant']='';
		}
		if (isset($tinymce_options_in['plugins'])) {
			$tinymce_options['plugins']=$tinymce_options_in['plugins'];
			unset($tinymce_options_in['plugins']);
		} else {
			$tinymce_options['plugins']=['autolink', 'lists', 'spellchecker', 'pagebreak', 'style', 'layer', 'table', 'save', 'advhr', 'advimage', 'advlink', 'emotions', 'iespell', 'inlinepopups', 'insertdatetime', 'preview', 'media', 'searchreplace', 'print', 'contextmenu', 'paste', 'directionality', 'fullscreen', 'noneditable', 'visualchars', 'nonbreaking', 'xhtmlxtras', 'template'];
		}
		if (vOut('tinymce_filemanager_enabled')===true) {
			$tinymce_options['plugins'][]='filemanager';
		}
		if (vOut('tinymce_imagemanager_enabled')===true) {
			$tinymce_options['plugins'][]='imagemanager';
		}
		if (isset($tinymce_options_in['theme_advanced_buttons1'])) {
			$tinymce_options['theme_advanced_buttons1']=$tinymce_options_in['theme_advanced_buttons1'];
			unset($tinymce_options_in['theme_advanced_buttons1']);
		} else {
			$tinymce_options['theme_advanced_buttons1']=['save', 'newdocument', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', '|', 'styleselect', 'formatselect', 'fontselect', 'fontsizeselect'];
		}
		if (isset($tinymce_options_in['theme_advanced_buttons2'])) {
			$tinymce_options['theme_advanced_buttons2']=$tinymce_options_in['theme_advanced_buttons2'];
			unset($tinymce_options_in['theme_advanced_buttons2']);
		} else {
			$tinymce_options['theme_advanced_buttons2']=['cut', 'copy', 'paste', 'pastetext', 'pasteword', '|', 'search', 'replace', '|', 'bullist', 'numlist', '|', 'outdent', 'indent', 'blockquote', '|', 'undo', 'redo', '|', 'link', 'unlink', 'anchor', 'image', 'cleanup', 'help', 'code', '|', 'insertdate', 'inserttime', 'preview', '|', 'forecolor', 'backcolor'];
		}
		if (isset($tinymce_options_in['theme_advanced_buttons3'])) {
			$tinymce_options['theme_advanced_buttons3']=$tinymce_options_in['theme_advanced_buttons3'];
			unset($tinymce_options_in['theme_advanced_buttons3']);
		} else {
			$tinymce_options['theme_advanced_buttons3']=['tablecontrols', '|', 'hr', 'removeformat', 'visualaid', '|', 'sub', 'sup', '|', 'charmap', 'emotions', 'iespell', 'media', 'advhr', '|', 'print', '|', 'ltr', 'rtl', '|', 'fullscreen'];
		}
		if (isset($tinymce_options_in['theme_advanced_buttons4'])) {
			$tinymce_options['theme_advanced_buttons4']=$tinymce_options_in['theme_advanced_buttons4'];
			unset($tinymce_options_in['theme_advanced_buttons4']);
		} else {
			$tinymce_options['theme_advanced_buttons4']=['insertlayer', 'moveforward', 'movebackward', 'absolute', '|', 'styleprops', 'spellchecker', '|', 'cite', 'abbr', 'acronym', 'del', 'ins', 'attribs', '|', 'visualchars', 'nonbreaking', 'template', 'blockquote', 'pagebreak', '|', 'insertfile', 'insertimage', 'inupload'];
		}
		if (isset($tinymce_options_in['theme_advanced_toolbar_location'])) {
			$tinymce_options['theme_advanced_toolbar_location']=$tinymce_options_in['theme_advanced_toolbar_location'];
			unset($tinymce_options_in['theme_advanced_toolbar_location']);
		} else {
			$tinymce_options['theme_advanced_toolbar_location']='top';
		}
		if (isset($tinymce_options_in['theme_advanced_toolbar_align'])) {
			$tinymce_options['theme_advanced_toolbar_align']=$tinymce_options_in['theme_advanced_toolbar_align'];
			unset($tinymce_options_in['theme_advanced_toolbar_align']);
		} else {
			$tinymce_options['theme_advanced_toolbar_align']='left';
		}
		if (isset($tinymce_options_in['theme_advanced_statusbar_location'])) {
			$tinymce_options['theme_advanced_statusbar_location']=$tinymce_options_in['theme_advanced_statusbar_location'];
			unset($tinymce_options_in['theme_advanced_statusbar_location']);
		} else {
			$tinymce_options['theme_advanced_statusbar_location']='bottom';
		}
		if (isset($tinymce_options_in['theme_advanced_resizing'])) {
			$tinymce_options['theme_advanced_resizing']=$tinymce_options_in['theme_advanced_resizing'];
			unset($tinymce_options_in['theme_advanced_resizing']);
		} else {
			$tinymce_options['theme_advanced_resizing']=true;
		}
		if (isset($tinymce_options_in['force_br_newlines'])) {
			$tinymce_options['force_br_newlines']=$tinymce_options_in['force_br_newlines'];
			unset($tinymce_options_in['force_br_newlines']);
		} else {
			$tinymce_options['force_br_newlines']=true;
		}
		if (isset($tinymce_options_in['force_p_newlines'])) {
			$tinymce_options['force_p_newlines']=$tinymce_options_in['force_p_newlines'];
			unset($tinymce_options_in['force_p_newlines']);
		} else {
			$tinymce_options['force_p_newlines']=false;
		}
		if (isset($tinymce_options_in['forced_root_block'])) {
			$tinymce_options['forced_root_block']=$tinymce_options_in['forced_root_block'];
			unset($tinymce_options_in['forced_root_block']);
		} else {
			$tinymce_options['forced_root_block']='';
		}
		if (isset($tinymce_options_in['content_css'])) {
			$tinymce_options['content_css']=$tinymce_options_in['content_css'];
			unset($tinymce_options_in['content_css']);
		} else {
			$tinymce_options['content_css']='';
		}
		if (isset($tinymce_options_in['template_external_list_url'])) {
			$tinymce_options['template_external_list_url']=$tinymce_options_in['template_external_list_url'];
			unset($tinymce_options_in['template_external_list_url']);
		} else {
			$tinymce_options['template_external_list_url']='';
		}
		if (isset($tinymce_options_in['external_link_list_url'])) {
			$tinymce_options['external_link_list_url']=$tinymce_options_in['external_link_list_url'];
			unset($tinymce_options_in['external_link_list_url']);
		} else {
			$tinymce_options['external_link_list_url']='';
		}
		if (isset($tinymce_options_in['external_image_list_url'])) {
			$tinymce_options['external_image_list_url']=$tinymce_options_in['external_image_list_url'];
			unset($tinymce_options_in['external_image_list_url']);
		} else {
			$tinymce_options['external_image_list_url']='';
		}
		if (isset($tinymce_options_in['media_external_list_url'])) {
			$tinymce_options['media_external_list_url']=$tinymce_options_in['media_external_list_url'];
			unset($tinymce_options_in['media_external_list_url']);
		} else {
			$tinymce_options['media_external_list_url']='';
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

		if (count($tinymce_options_in)>0) {
			foreach ($tinymce_options_in as $key=>$value) {
				$tinymce_options[$key]=$value;
			}
		}

		if (vOut('tinymce_filemanager_enabled')===true) {
			if (!isset($tinymce_plugin_options_in['filemanager']['filesystem.local.file_mask'])) {
				$tinymce_plugin_options_in['filemanager']['filesystem.local.file_mask']=vOut('settings_chmod_file');
			}
			if (!isset($tinymce_plugin_options_in['filemanager']['filesystem.local.directory_mask'])) {
				$tinymce_plugin_options_in['filemanager']['filesystem.local.directory_mask']=vOut('settings_chmod_dir');
			}
		}
		if (vOut('tinymce_imagemanager_enabled')===true) {
			if (!isset($tinymce_plugin_options_in['imagemanager']['filesystem.local.file_mask'])) {
				$tinymce_plugin_options_in['imagemanager']['filesystem.local.file_mask']=vOut('settings_chmod_file');
			}
			if (!isset($tinymce_plugin_options_in['imagemanager']['filesystem.local.directory_mask'])) {
				$tinymce_plugin_options_in['imagemanager']['filesystem.local.directory_mask']=vOut('settings_chmod_dir');
			}
		}

		if (count($tinymce_plugin_options_in)>0) {
			foreach ($tinymce_plugin_options_in as $key=>$value) {
				$tinymce_plugin_options[$key]=$value;
			}
		}

		osW_Session::getInstance()->set('tinymce_plugin_options', $tinymce_plugin_options);

		$tinymce_options_parsed=[];

		foreach ($tinymce_options as $key=>$value) {
			if (is_array($value)) {
				$tinymce_options_parsed[]=$key.': "'.implode(',', $value).'"';
			} elseif (is_bool($value)) {
				if ($value===true) {
					$tinymce_options_parsed[]=$key.': true';
				} else {
					$tinymce_options_parsed[]=$key.': false';
				}
			} else {
				$tinymce_options_parsed[]=$key.': "'.$value.'"';
			}
		}

		osW_Template::getInstance()->addJSCodeHead('
$().ready(function() {
	$(\'#'.$name.'\').tinymce({
		'.implode(',
		', $tinymce_options_parsed).'
	});
});
');

		osW_Session::getInstance()->set('tinymce_token', md5(vOut('settings_protection_salt').osW_Session::getInstance()->getId()));

		return osW_Form::getInstance()->drawTextareaField($name, $insert_value, $options);
	}

	/**
	 *
	 * @return osW_TinyMCE
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>