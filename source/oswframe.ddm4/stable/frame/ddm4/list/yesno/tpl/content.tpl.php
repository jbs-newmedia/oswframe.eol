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

if($view_data[$this->getListElementValue($ddm_group, $element, 'name')]==1) {
	$view_data[$this->getListElementValue($ddm_group, $element, 'name')]=h()->_outputString($this->getListElementOption($ddm_group, $element, 'text_yes'));
} else {
	$view_data[$this->getListElementValue($ddm_group, $element, 'name')]=h()->_outputString($this->getListElementOption($ddm_group, $element, 'text_no'));
}

?>