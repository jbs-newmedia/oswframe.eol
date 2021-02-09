<?php

$seowrite_name='';

if ($seowrite_inpage==true) {
	$check_parameters=false;
} else {
	if (isset($ar_parameters['paymodul'])) {
		$seowrite_name=$ar_parameters['paymodul'];
	}
}

if (strlen($seowrite_name)>0) {
	$go_default=false;

	$acceptable_spider_parameters=[];
	$acceptable_user_parameters=[];

	if ($module!=vOut('project_default_module')) {
		$seo_base_uri.=osW_Language::getInstance()->mod2nav($module).vOut('seo_extension');
	}

	if ($module==vOut('project_default_module')) {
		$seo_base_uri.='/';
	}

	$seo_base_uri.='/'.$seowrite_name;
}

?>