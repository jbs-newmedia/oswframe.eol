<?php

if (!isset($plugin_option['theme'])) {
	$plugin_option['theme']='';
}

$plugin_option['theme']=strtolower($plugin_option['theme']);

$_themes=glob(vOut('settings_abspath').'frame/resources/bootstrap4/plugins/sbadmin2/sb-admin-2*.css');
$themes=array();
foreach ($_themes as $theme) {
	$theme=substr(basename($theme), 11, -4);
	if ($theme==false) {
		$theme='';
	}
	$themes[$theme]=$theme;
}

osW_Template::getInstance()->addJSFileHead('frame/resources/bootstrap4/plugins/sbadmin2/sb-admin-2.js');
osW_Template::getInstance()->addCSSFileHead('frame/resources/fonts/nunito/font.css');
if (isset($themes[$plugin_option['theme']])) {
	osW_Template::getInstance()->addCSSFileHead('frame/resources/bootstrap4/plugins/sbadmin2/sb-admin-2-'.$plugin_option['theme'].'.css');
} else {
	osW_Template::getInstance()->addCSSFileHead('frame/resources/bootstrap4/plugins/sbadmin2/sb-admin-2.css');
}

?>