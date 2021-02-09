<?php

$element=h()->_catch('ddm_element', '', 'gp');

$element_data=osW_Session::getInstance()->value($element);

if ((!isset($element_data['layout']))||($element_data['layout']=='')) {
	$element_data['layout']='default';
}

$layout='frame/ddm3/style/'.$element_data['layout'].'/css/layout.css';
osW_Template::getInstance()->addCSSFileHead($layout);

foreach (glob(vOut('settings_abspath').'frame/ddm3/style/'.$element_data['layout'].'/css/*.css') as $filename) {
	$filename=str_replace(vOut('settings_abspath'), '', $filename);
	if ($filename!=$layout) {
		osW_Template::getInstance()->addCSSFileHead($filename);
	}
}

osW_Template::getInstance()->addCSSFileHead('modules/'.vOut('frame_current_module').'/css/ddm3_fileimage_edit.css');
osW_Template::getInstance()->addJSFileHead('modules/'.vOut('frame_current_module').'/js/ddm3_fileimage_edit.js');

osW_JQuery2::getInstance()->load();
osW_JQuery2::getInstance()->loadPlugin('jcrop');
osW_JQuery2::getInstance()->loadUI('ddm3');

if ((isset($element_data['element']['validation']['width_min']))&&($element_data['element']['validation']['width_min']!='')) {
	osW_Template::getInstance()->addJSCodeHead('var width_min='.$element_data['element']['validation']['width_min'].';');
}
if ((isset($element_data['element']['validation']['width_max']))&&($element_data['element']['validation']['width_max']!='')) {
	osW_Template::getInstance()->addJSCodeHead('var width_max='.$element_data['element']['validation']['width_max'].';');
}
if ((isset($element_data['element']['validation']['height_min']))&&($element_data['element']['validation']['height_min']!='')) {
	osW_Template::getInstance()->addJSCodeHead('var height_min='.$element_data['element']['validation']['height_min'].';');
}
if ((isset($element_data['element']['validation']['height_max']))&&($element_data['element']['validation']['height_max']!='')) {
	osW_Template::getInstance()->addJSCodeHead('var height_max='.$element_data['element']['validation']['height_max'].';');
}
if (((isset($element_data['element']['options']['edit_crop_x']))&&($element_data['element']['options']['edit_crop_x']!=''))&&((isset($element_data['element']['options']['edit_crop_y']))&&($element_data['element']['options']['edit_crop_y']!=''))) {
	osW_Template::getInstance()->addJSCodeHead('var aspectRatio_x='.$element_data['element']['options']['edit_crop_x'].';');
	osW_Template::getInstance()->addJSCodeHead('var aspectRatio_y='.$element_data['element']['options']['edit_crop_y'].';');
}

osW_Template::getInstance()->addJSCodeHead('
var ddm_group="'.$element_data['ddm_group'].'";
var ddm_element="'.$element_data['ddm_element'].'";

var image_url_save="'.osW_Template::getInstance()->buildhrefLink('current', 'vistool='.osW_VIS::getInstance()->getTool().'&vispage=vis_api&action=ddm3_fileimage_save&ddm_element='.$element_data['ddm_group'].'_'.$element_data['ddm_element'], false).'";
var image_url_view="'.osW_Template::getInstance()->buildhrefLink('current', 'vistool='.osW_VIS::getInstance()->getTool().'&vispage=vis_api&action=ddm3_fileimage&ddm_element='.$element_data['ddm_group'].'_'.$element_data['ddm_element'], false).'";

');

osW_Template::getInstance()->set('element', $element);
osW_Template::getInstance()->set('element_data', $element_data);

?>