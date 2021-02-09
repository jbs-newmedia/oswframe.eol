<?php

$element=h()->_catch('ddm_element', '', 'gp');
$a=h()->_catch('a', '', 'gp');

$element_data=osW_Session::getInstance()->value($element);

$filename=vOut('settings_abspath').$element_data['storage'];

if ($a=='save') {
	if ($element_data['element']['options']['edit_store_org']===true) {
		$path_parts=pathinfo($filename);
		$file=$path_parts['dirname'].'/'.$path_parts['filename'].'.org.'.$path_parts['extension'];
		copy($filename, $file);
		h()->_chmod($file);
	}
}

osW_ImageLib::getInstance()->load($filename);

if ($element_data['step']!=[]) {
	foreach ($element_data['step'] as $step) {
		if ($step['enabled']===true) {
			switch ($step['a']) {
				case 'resize':
					osW_ImageLib::getInstance()->resize($step['width'], $step['height']);
					break;
				case 'crop':
					osW_ImageLib::getInstance()->cut($step['crop_x'], $step['crop_y'], $step['crop_w'], $step['crop_h']);
					break;
			}
		}
	}
}

if ($a=='save') {
	if ($element_data['element']['options']['edit_del_files']!=[]) {
		foreach ($element_data['element']['options']['edit_del_files'] as $file) {
			$_filename=vOut('settings_abspath').$file;
			if (file_exists($_filename)) {
				unlink($_filename);
			}
		}
	}
	if ($element_data['element']['options']['edit_clear_dirs']!=[]) {
		foreach ($element_data['element']['options']['edit_clear_dirs'] as $dir) {
			h()->_clearTree(vOut('settings_abspath').$dir);
		}
	}
	osW_ImageLib::getInstance()->save($filename);
} else {
	if ((isset($element_data['image_options']['scale_width']))&&(isset($element_data['image_options']['scale_height']))) {
		osW_ImageLib::getInstance()->resize($element_data['image_options']['scale_width'], $element_data['image_options']['scale_height']);
	}
	osW_ImageLib::getInstance()->output(true, true);
}

?>