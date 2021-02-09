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

if (osW_Settings::getInstance()->getAction()=='doadd') {
	$date_new='';
	$data_old=h()->_settype(h()->_catch($element, '', 'p'), 'string');
	$format=$this->getAddElementOption($ddm_group, $element, 'format');
	$pos=strpos($format, '%Y');
	if ($pos!==false) {
		$date_new.=substr($data_old, $pos, 4);
	}
	$pos=strpos($format, '%y');
	if ($pos!==false) {
		$date_new.=substr($data_old, $pos, 2);
	}
	$pos=strpos($format, '%m');
	if ($pos!==false) {
		$date_new.=substr($data_old, $pos, 2);
	}
	$pos=strpos($format, '%d');
	if ($pos!==false) {
		$date_new.=substr($data_old, $pos, 2);
	}
	$this->setDoAddElementStorage($ddm_group, $element, $date_new);
}

$format=$this->getAddElementOption($ddm_group, $element, 'format');
$format=str_replace('%Y', 'yyyy', $format);
$format=str_replace('%y', 'yy', $format);
$format=str_replace('%d', 'dd', $format);
$format=str_replace('%m', 'mm', $format);

osW_Template::getInstance()->addJSCodeHead('
	$(function(){
		$("#'.$element.'").datepicker({
			orientation: "'.$this->getAddElementOption($ddm_group, $element, 'orientation').'",
			format: "'.$format.'",
			language: "'.vOut('frame_current_language').'",
			weekStart: "'.$this->getAddElementOption($ddm_group, $element, 'weekStart').'",
			startDate: "'.$this->getAddElementOption($ddm_group, $element, 'startDate').'",
			endDate: "'.$this->getAddElementOption($ddm_group, $element, 'endDate').'"
		});
	});
');

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

?>