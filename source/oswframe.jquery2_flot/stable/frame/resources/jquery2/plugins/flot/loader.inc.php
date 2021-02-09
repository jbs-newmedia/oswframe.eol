<?php

osW_Template::getInstance()->addJSFileHead('frame/resources/jquery2/plugins/flot/jquery.flot.js');
if ((isset($plugin_option['plugins']))&&($plugin_option['plugins']!=array())) {
	foreach ($plugin_option['plugins'] as $plugin) {
		$dir=vOut('settings_abspath').'frame/resources/jquery2/plugins/flot';
		$file=$dir.'/jquery.flot.'.$plugin.'.js';

		if ((file_exists($file))&&(dirname(realpath($file))==$dir)) {
			osW_Template::getInstance()->addJSFileHead('frame/resources/jquery2/plugins/flot/jquery.flot.'.$plugin.'.js');
		}
	}
}

?>