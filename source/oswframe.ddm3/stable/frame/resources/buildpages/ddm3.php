<?php

$output='';
$output.='<ul class="table_ddm_list table_ddm_list_horizontal">';

if ($limitRows['number_of_pages']>1) {
	$output.='<li><span>'.osW_DDM3::getInstance()->getGroupMessage($options['ddm_group'], 'form_title_pages_multi').':</span></li>';
} else {
	$output.='<li><span>'.osW_DDM3::getInstance()->getGroupMessage($options['ddm_group'], 'form_title_pages_single').':</span></li>';
}

if ($limitRows['current_page_number']>1) {
	$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&ddm_page=1').'"><span>&lt;&lt;</span></a></li>';
	$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&ddm_page='.($limitRows['current_page_number']-1)).'"><span>&lt;</span></a></li>';
	for ($i=($limitRows['current_page_number']-$limitRows['display_range']); $i<($limitRows['current_page_number']); $i++) {
		if ($i>0) {
			$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&ddm_page='.$i).'"><span>'.$i.'</span></a></li>';
		}
	}
} else {
	$output.='<li><span>&lt;&lt;</span></li>';
	$output.='<li><span>&lt;</span></li>';
}
$output.='<li><span>'.$limitRows['current_page_number'].'</span></li>';

if ($limitRows['current_page_number']<$limitRows['number_of_pages']) {
	for ($i=($limitRows['current_page_number']+1); $i<($limitRows['current_page_number']+$limitRows['display_range']); $i++) {
		if ($i<=$limitRows['number_of_pages']) {
			$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&ddm_page='.$i).'"><span>'.$i.'</span></a></li>';
		}
	}

	$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&ddm_page='.($limitRows['current_page_number']+1)).'"><span>&gt;</span></a></li>';
	$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&ddm_page='.$limitRows['number_of_pages']).'"><span>&gt;&gt;</span></a></li>';
} else {
	$output.='<li><span>&gt;</span></li>';
	$output.='<li><span>&gt;&gt;</span></li>';
}
$output.='</ul>';

?>