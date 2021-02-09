<?php

/*
 * Author: Juergen Schwind
 * Copyright: Juergen Schwind
 * Link: http://oswframe.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/gpl.html
 *
 */

$date_format=$this->getSearchElementOption($ddm_group, $element, 'date_format');
$date_format=str_replace('%Y', 'yy', $date_format);
$date_format=str_replace('%d', 'dd', $date_format);
$date_format=str_replace('%m', 'mm', $date_format);

osW_Template::getInstance()->addJSCodeHead('
	$(function(){
		$("#'.$element.'___0'.'").datepicker({
			autoSize: true,
			firstDay: '.$this->getSearchElementOption($ddm_group, $element, 'day_first').',
			changeYear: '.$this->getSearchElementOption($ddm_group, $element, 'year_change').',
			nextText: "&rarr;",
			prevText: "&larr;",
			yearRange: "'.$this->getSearchElementOption($ddm_group, $element, 'year_min').':'.$this->getSearchElementOption($ddm_group, $element, 'year_max').'",
			dateFormat: "'.$date_format.'",
			dayNamesMin: ["'.strftime('%a', 60*60*24*3).'", "'.strftime('%a', 60*60*24*4).'", "'.strftime('%a', 60*60*24*5).'", "'.strftime('%a', 60*60*24*6).'", "'.strftime('%a', 60*60*24*7).'", "'.strftime('%a', 60*60*24*8).'", "'.strftime('%a', 60*60*24*9).'"],
			monthNames: ["'.strftime('%B', mktime(12, 0, 0, 1, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 2, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 3, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 4, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 5, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 6, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 7, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 8, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 9, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 10, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 11, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 12, 1, 2000)).'"],
			showOn: "button",
			buttonText: "'.$this->getSearchElementOption($ddm_group, $element, 'text_button').'",
		});
	});
');

$_search='';
$data_old=h()->_settype(h()->_catch($element.'___0', '', 'p'), 'string');
$date_format=$this->getSearchElementOption($ddm_group, $element, 'date_format');
$pos=strpos($date_format, '%Y');
if ($pos!==false) {
	$year=sprintf('%04d', substr($data_old, $pos, 4));
	if ($year==0000) {
		$year='____';
	}
	$_search.=$year;
}
$pos=strpos($date_format, '%m');
if ($pos!==false) {
	$month=sprintf('%02d', substr($data_old, $pos, 2));
	if ($month==00) {
		$month='__';
	}
	$_search.=$month;
}
$pos=strpos($date_format, '%d');
if ($pos!==false) {
	$day=sprintf('%02d', substr($data_old, $pos, 2));
	if ($day==00) {
		$day='__';
	}
	$_search.=$day;
}
if ($_search=='________') {
	$_search='';
}

$this->setSearchElementStorage($ddm_group, $element.'___0', $_search);

$date_format=$this->getSearchElementOption($ddm_group, $element, 'date_format');
$date_format=str_replace('%Y', 'yy', $date_format);
$date_format=str_replace('%d', 'dd', $date_format);
$date_format=str_replace('%m', 'mm', $date_format);

osW_Template::getInstance()->addJSCodeHead('
	$(function(){
		$("#'.$element.'___1'.'").datepicker({
			autoSize: true,
			firstDay: '.$this->getSearchElementOption($ddm_group, $element, 'day_first').',
			changeYear: '.$this->getSearchElementOption($ddm_group, $element, 'year_change').',
			nextText: "&rarr;",
			prevText: "&larr;",
			yearRange: "'.$this->getSearchElementOption($ddm_group, $element, 'year_min').':'.$this->getSearchElementOption($ddm_group, $element, 'year_max').'",
			dateFormat: "'.$date_format.'",
			dayNamesMin: ["'.strftime('%a', 60*60*24*3).'", "'.strftime('%a', 60*60*24*4).'", "'.strftime('%a', 60*60*24*5).'", "'.strftime('%a', 60*60*24*6).'", "'.strftime('%a', 60*60*24*7).'", "'.strftime('%a', 60*60*24*8).'", "'.strftime('%a', 60*60*24*9).'"],
			monthNames: ["'.strftime('%B', mktime(12, 0, 0, 1, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 2, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 3, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 4, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 5, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 6, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 7, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 8, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 9, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 10, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 11, 1, 2000)).'", "'.strftime('%B', mktime(12, 0, 0, 12, 1, 2000)).'"],
			showOn: "button",
			buttonText: "'.$this->getSearchElementOption($ddm_group, $element, 'text_button').'",
		});
	});
');

$_search='';
$data_old=h()->_settype(h()->_catch($element.'___1', '', 'p'), 'string');
$date_format=$this->getSearchElementOption($ddm_group, $element, 'date_format');
$pos=strpos($date_format, '%Y');
if ($pos!==false) {
	$year=sprintf('%04d', substr($data_old, $pos, 4));
	if ($year==0000) {
		$year='____';
	}
	$_search.=$year;
}
$pos=strpos($date_format, '%m');
if ($pos!==false) {
	$month=sprintf('%02d', substr($data_old, $pos, 2));
	if ($month==00) {
		$month='__';
	}
	$_search.=$month;
}
$pos=strpos($date_format, '%d');
if ($pos!==false) {
	$day=sprintf('%02d', substr($data_old, $pos, 2));
	if ($day==00) {
		$day='__';
	}
	$_search.=$day;
}
if ($_search=='________') {
	$_search='';
}

$this->setSearchElementStorage($ddm_group, $element.'___1', $_search);

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

?>