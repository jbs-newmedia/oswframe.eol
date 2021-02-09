<?php

/*
 * Author: Juergen Schwind
 * Copyright: 2011 Juergen Schwind
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

if($this->getListElementOption($ddm_group, $element, 'show_output')===true) {
	$view_data[$this->getListElementValue($ddm_group, $element, 'name')]=$view_data[$this->getListElementValue($ddm_group, $element, 'name')];
} else {
	$count=strlen($view_data[$this->getListElementValue($ddm_group, $element, 'name')]);
	if($count==1) {
		$t=strlen($view_data[$this->getListElementValue($ddm_group, $element, 'name')]).' '.$this->getListElementOption($ddm_group, $element, 'text_char');
	} else {
		$t=strlen($view_data[$this->getListElementValue($ddm_group, $element, 'name')]).' '.$this->getListElementOption($ddm_group, $element, 'text_chars');
	}

	if($this->getListElementOption($ddm_group, $element, 'show_dialog')===true) {
		$view_data[$this->getListElementValue($ddm_group, $element, 'name')]='<a style="cursor:pointer;" onclick="openDDM4Dialog_'.$ddm_group.'(this);" pageTitle="'.$this->getListElementValue($ddm_group, $element, 'title').'" pageName="'.$view_data[$this->getListElementValue($ddm_group, $element, 'name')].'">'.$t.'</a>';
	} else {
		$view_data[$this->getListElementValue($ddm_group, $element, 'name')]=$t;
	}
}

?>