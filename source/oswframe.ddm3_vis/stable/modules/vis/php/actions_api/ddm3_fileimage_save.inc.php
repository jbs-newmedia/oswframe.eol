<?php

$element=h()->_catch('ddm_element', '', 'gp');

$element_data=osW_Session::getInstance()->value($element);
if (!isset($element_data['step'])) {
	$element_data['step']=[];
}

$a=h()->_catch('a', '', 'gp');

if (!in_array($a, ['getoptions', 'fit', 'scale', 'resize', 'crop'])) {
	$a='';
}

if ($a=='resize') {
	$height=intval(h()->_catch('height', 0, 'gp'));
	$width=intval(h()->_catch('width', 0, 'gp'));

	if ($aspect==0) {
		$aspect=0;
	} else {
		$aspect=1;
	}

	$element_data['step'][]=['enabled'=>true, 'a'=>$a, 'height'=>$height, 'width'=>$width];

	$element_data['image_options']['width']=$width;
	$element_data['image_options']['height']=$height;

	$a='fit';
}

if ($a=='crop') {
	$crop_x=intval(h()->_catch('crop_x', 0, 'gp'));
	$crop_y=intval(h()->_catch('crop_y', 0, 'gp'));
	$crop_w=intval(h()->_catch('crop_w', 0, 'gp'));
	$crop_h=intval(h()->_catch('crop_h', 0, 'gp'));

	if ($aspect==0) {
		$aspect=0;
	} else {
		$aspect=1;
	}

	$element_data['step'][]=['enabled'=>true, 'a'=>$a, 'crop_x'=>$crop_x, 'crop_y'=>$crop_y, 'crop_w'=>$crop_w, 'crop_h'=>$crop_h];

	$element_data['image_options']['width']=$crop_w;
	$element_data['image_options']['height']=$crop_h;

	$a='fit';
}

if ($a=='fit') {
	if (($element_data['image_options']['width']==0)||($element_data['image_options']['height']==0)) {
		$filename=vOut('settings_abspath').$element_data['storage'];
		osW_ImageLib::getInstance()->load($filename);
		$element_data['image_options']['width']=osW_ImageLib::getInstance()->getWidth();
		$element_data['image_options']['height']=osW_ImageLib::getInstance()->getHeight();
		osW_ImageLib::getInstance()->unload();
	}

	for ($scale=2000; $scale>=10; $scale=$scale-10) {
		if (($element_data['image_options']['width']/100*($scale/10)<770)&&(($element_data['image_options']['height']/100*($scale/10))<480)) {
			break;
		}
	}

	$element_data['image_options']['scale']=$scale;
	$element_data['image_options']['scale_width']=round(($element_data['image_options']['width']/100*($element_data['image_options']['scale']/10)));
	$element_data['image_options']['scale_height']=round(($element_data['image_options']['height']/100*($element_data['image_options']['scale']/10)));

	$a='';
}

if ($a=='scale') {
	$scale=intval(h()->_catch('scale', 0, 'p'));
	$scale_height=intval(h()->_catch('scale_height', 0, 'p'));
	$scale_width=intval(h()->_catch('scale_width', 0, 'p'));

	if (($element_data['image_options']['width']==0)||($element_data['image_options']['height']==0)) {
		$filename=vOut('settings_abspath').$element_data['storage'];
		osW_ImageLib::getInstance()->load($filename);
		$element_data['image_options']['width']=osW_ImageLib::getInstance()->getWidth();
		$element_data['image_options']['height']=osW_ImageLib::getInstance()->getHeight();
		osW_ImageLib::getInstance()->unload();
	}

	if ($scale>0) {
		$element_data['image_options']['scale']=$scale;
	}

	$element_data['image_options']['scale_width']=round(($element_data['image_options']['width']/100*($element_data['image_options']['scale']/10)));
	$element_data['image_options']['scale_height']=round(($element_data['image_options']['height']/100*($element_data['image_options']['scale']/10)));

	$a='';
}

if ($a=='getoptions') {
	if (($element_data['image_options']['width']==0)||($element_data['image_options']['height']==0)) {
		$filename=vOut('settings_abspath').$element_data['storage'];
		osW_ImageLib::getInstance()->load($filename);
		$element_data['image_options']['width']=osW_ImageLib::getInstance()->getWidth();
		$element_data['image_options']['height']=osW_ImageLib::getInstance()->getHeight();
		osW_ImageLib::getInstance()->unload();
	}

	$element_data['image_options']['width']=$element_data['image_options']['width'];
	$element_data['image_options']['height']=$element_data['image_options']['height'];

	$a='';
}

osW_Session::getInstance()->set($element, $element_data);

h()->_die(json_encode($element_data['image_options']));

?>