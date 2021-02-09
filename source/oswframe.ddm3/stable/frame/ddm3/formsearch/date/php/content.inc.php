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

$date=[];
$date['day']=[];
$date['day']['00']='';
for ($i=1; $i<=31; $i++) {
	$date['day'][sprintf('%02d', $i)]=sprintf('%02d', $i);
}

$date['month']=[];
$date['month']['00']='';
for ($i=1; $i<=12; $i++) {
	if ($this->getSearchElementOption($ddm_group, $element, 'month_asname')===true) {
		$date['month'][sprintf('%02d', $i)]=strftime('%B', mktime(12, 0, 0, $i, 01, 2000));
	} else {
		$date['month'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
}

$date['year']=[];
$date['year']['0000']='';
if ($this->getSearchElementOption($ddm_group, $element, 'year_sortorder')=='desc') {
	for ($i=$this->getSearchElementOption($ddm_group, $element, 'year_max'); $i>=$this->getSearchElementOption($ddm_group, $element, 'year_min'); $i--) {
		$date['year'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
} else {
	for ($i=$this->getSearchElementOption($ddm_group, $element, 'year_min'); $i<=$this->getSearchElementOption($ddm_group, $element, 'year_max'); $i++) {
		$date['year'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
}

$this->setSearchElementOption($ddm_group, $element, 'data', $date);

$search='';
$day=sprintf('%02d', h()->_settype(h()->_catch($element.'_day___0', '', 'p'), 'integer'));
if ($day==00) {
	$day='__';
}
$month=sprintf('%02d', h()->_settype(h()->_catch($element.'_month___0', '', 'p'), 'integer'));
if ($month==00) {
	$month='__';
}
$year=sprintf('%02d', h()->_settype(h()->_catch($element.'_year___0', '', 'p'), 'integer'));
if ($year==0000) {
	$year='____';
}
$_search=$year.$month.$day;
if ($_search=='________') {
	$_search='';
}
$this->setSearchElementStorage($ddm_group, $element.'___0', $_search);

$search='';
$day=sprintf('%02d', h()->_settype(h()->_catch($element.'_day___1', '', 'p'), 'integer'));
if ($day==00) {
	$day='__';
}
$month=sprintf('%02d', h()->_settype(h()->_catch($element.'_month___1', '', 'p'), 'integer'));
if ($month==00) {
	$month='__';
}
$year=sprintf('%02d', h()->_settype(h()->_catch($element.'_year___1', '', 'p'), 'integer'));
if ($year==0000) {
	$year='____';
}
$_search=$year.$month.$day;
if ($_search=='________') {
	$_search='';
}
$this->setSearchElementStorage($ddm_group, $element.'___1', $_search);

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

?>