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

$data_level=$this->getListElementOption($ddm_group, $element, 'data_level');
if (isset($data_level[$view_data['navigation_id']])) {
	if ($data_level[$view_data['navigation_id']]==0) {
		$view_data[$this->getListElementValue($ddm_group, $element, 'name')]=$view_data[$this->getListElementValue($ddm_group, $element, 'name')];
	} elseif ($data_level[$view_data['navigation_id']]==1) {
		$view_data[$this->getListElementValue($ddm_group, $element, 'name')]='&nbsp;&nbsp;➥ '.$view_data[$this->getListElementValue($ddm_group, $element, 'name')];
	} elseif ($data_level[$view_data['navigation_id']]==2) {
		$view_data[$this->getListElementValue($ddm_group, $element, 'name')]='&nbsp;&nbsp;&nbsp;&nbsp;➥ '.$view_data[$this->getListElementValue($ddm_group, $element, 'name')];
	}
} else {
	$view_data[$this->getListElementValue($ddm_group, $element, 'name')]='#ERROR# '.$view_data[$this->getListElementValue($ddm_group, $element, 'name')];
}

?>