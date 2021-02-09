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

$date=array();
$date['day']=array();
$date['day']['00']='';
for($i=1;$i<=31;$i++) {
	$date['day'][sprintf('%02d', $i)]=sprintf('%02d', $i);
}

$date['month']=array();
$date['month']['00']='';
for($i=1;$i<=12;$i++) {
	if ($this->getSendElementOption($ddm_group, $element, 'month_asname')===true) {
		$date['month'][sprintf('%02d', $i)]=strftime('%B', mktime(12,0,0,$i,01,2000));
	} else {
		$date['month'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
}

$date['year']=array();
$date['year']['0000']='';
if ($this->getSendElementOption($ddm_group, $element, 'year_sortorder')=='desc') {
	for($i=$this->getSendElementOption($ddm_group, $element, 'year_max');$i>=$this->getSendElementOption($ddm_group, $element, 'year_min');$i--) {
		$date['year'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
} else {
	for($i=$this->getSendElementOption($ddm_group, $element, 'year_min');$i<=$this->getSendElementOption($ddm_group, $element, 'year_max');$i++) {
		$date['year'][sprintf('%02d', $i)]=sprintf('%02d', $i);
	}
}

$this->setSendElementOption($ddm_group, $element, 'data', $date);

if (osW_Settings::getInstance()->getAction()=='dosend') {
	$this->setDoSendElementStorage($ddm_group, $element, sprintf('%02d', h()->_settype(h()->_catch($element.'_year', '', 'p'), 'integer')).sprintf('%02d', h()->_settype(h()->_catch($element.'_month', '', 'p'), 'integer')).sprintf('%02d', h()->_settype(h()->_catch($element.'_day', '', 'p'), 'integer')));
}

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

?>