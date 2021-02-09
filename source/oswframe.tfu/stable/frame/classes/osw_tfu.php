<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c) 2010-2012, Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_TFU extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function draw($name, $flashvars=[], $params=[], $config=[]) {
		if (!is_array($flashvars)) {
			$flashvars=[];
		}
		if (!is_array($params)) {
			$params=[];
		}
		if (!is_array($config)) {
			$config=[];
		}

		$config['file_chmod']=vOut('settings_chmod_file');
		$config['dir_chmod']=vOut('settings_chmod_dir');

		if ((!isset($flashvars['size'])||((isset($flashvars['size']))&&(strlen($flashvars['size'])==0)))) {
			$flashvars['size']='w650';
		}
		if ((isset($flashvars['id']))&&(strlen($flashvars['id'])>0)) {
			$flashvars['id']='id="'.$flashvars['id'].'" ';
		}
		if ((isset($flashvars['class']))&&(strlen($flashvars['class'])>0)) {
			$flashvars['class']='class="'.$flashvars['class'].'" ';
		}
		if (($flashvars['size'][0]!='w')&&($flashvars['size'][0]!='h')) {
			$sizeorientation='w';
		} else {
			$sizeorientation=$flashvars['size'][0];
		}
		$flashvars['size'][0]=0;
		$size=intval($flashvars['size']);
		if (intval($size)<=0) {
			$size=650;
		}
		if ($sizeorientation=='h') {
			$width=intval(round($size/340*650));
			$height=$size;
		} else {
			$width=$size;
			$height=intval(round($size/650*340));
		}
		$flashvars['width']=$width;
		$flashvars['height']=$height;
		unset($flashvars['size']);

		$options_string='';
		if ((defined('SID')===true)&&(strlen(SID)>0)) {
			$options_string.=SID;
		}

		osW_Session::getInstance()->set('tfu_flashvars', $flashvars);
		osW_Session::getInstance()->set('tfu_params', $params);
		osW_Session::getInstance()->set('tfu_config', $config);

		osW_Session::getInstance()->set('tfu_token', md5(vOut('settings_protection_salt').osW_Session::getInstance()->getId()));

		return '<iframe '.(isset($flashvars['id'])?$flashvars['id']:'').(isset($flashvars['class'])?$flashvars['class']:'').'src="frame/resources/tfu/index.php?'.$options_string.'" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:'.$flashvars['width'].'px; height:'.$flashvars['height'].'px"></iframe>';
	}

	/**
	 *
	 * @return osW_TFU
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>