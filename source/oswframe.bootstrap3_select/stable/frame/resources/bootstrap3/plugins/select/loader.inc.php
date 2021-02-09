<?php
if (tOut('language_locale')!='language_locale') {
	$locale=tOut('language_locale');
} else {
	$locale=vOut('project_locale');
}

osW_Template::getInstance()->addJSFileHead('frame/resources/bootstrap3/plugins/select/bootstrap-select.js');

$filename=vOut('settings_abspath').'frame/resources/bootstrap3/plugins/select/i18n/defaults-'.$locale.'.js';
if (file_exists($filename)) {
	osW_Template::getInstance()->addJSFileHead('frame/resources/bootstrap3/plugins/select/i18n/defaults-'.$locale.'.js');
} else {
	$filename=vOut('settings_abspath').'frame/resources/bootstrap3/plugins/select/i18n/defaults-'.substr($locale, 0, strpos($locale, '.')).'.js';
	if (file_exists($filename)) {
		osW_Template::getInstance()->addJSFileHead('frame/resources/bootstrap3/plugins/select/i18n/defaults-'.substr($locale, 0, strpos($locale, '.')).'.js');
	}
}
osW_Template::getInstance()->addCSSFileHead('frame/resources/bootstrap3/plugins/select/bootstrap-select.css');

?>