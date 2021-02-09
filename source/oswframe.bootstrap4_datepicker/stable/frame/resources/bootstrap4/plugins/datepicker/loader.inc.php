<?php

osW_Template::getInstance()->addJSFileHead('frame/resources/bootstrap4/plugins/datepicker/js/bootstrap-datepicker.js');
$filename=vOut('settings_abspath').'frame/resources/bootstrap4/plugins/datepicker/locales/bootstrap-datepicker.'.vOut('frame_current_language').'.min.js';
if (file_exists($filename)) {
	osW_Template::getInstance()->addJSFileHead('frame/resources/bootstrap4/plugins/datepicker/locales/bootstrap-datepicker.'.vOut('frame_current_language').'.min.js');
}
osW_Template::getInstance()->addCSSFileHead('frame/resources/bootstrap4/plugins/datepicker/css/bootstrap-datepicker.css');

?>