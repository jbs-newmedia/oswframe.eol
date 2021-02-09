<?php

$output='';
$output.='<div class="pages">';
$output.='<span>Seite(n):</span>';

$output.='<ul>';
if ($limitRows['current_page_number']>1) {
	$output.='<li class="first_element"><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&page=1').'">|&lt;</a></li>';
	$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&page='.($limitRows['current_page_number']-1)).'">&lt;</a></li>';

	for ($i=($limitRows['current_page_number']-$limitRows['display_range']); $i<($limitRows['current_page_number']); $i++) {
		if ($i>0) {
			$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&page='.$i).'">'.$i.'</a></li>';
		}
	}
} else {
	$output.='<li class="first_element">|&lt;</li>';
	$output.='<li>&lt;</li>';
}

$output.='<li>'.$limitRows['current_page_number'].'</li>';

if ($limitRows['current_page_number']<$limitRows['number_of_pages']) {
	for ($i=($limitRows['current_page_number']+1); $i<($limitRows['current_page_number']+$limitRows['display_range']); $i++) {
		if ($i<=$limitRows['number_of_pages']) {
			$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&page='.$i).'">'.$i.'</a></li>';
		}
	}

	$output.='<li><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&page='.($limitRows['current_page_number']+1)).'">&gt;</a></li>';
	$output.='<li class="last_element"><a href="'.osW_Template::getInstance()->buildhrefLink($module, $paramters.'&page='.$limitRows['number_of_pages']).'">&gt;|</a></li>';
} else {
	$output.='<li>&gt;</li>';
	$output.='<li class="last_element">&gt;|</li>';
}
$output.='</ul>';
$output.='</div>';

?>