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

$fields=[];
$fields['element']=$element;
$fields['element_title']=$this->getAddElementValue($ddm_group, $element, 'title');
$this->setFilterElementStorage($ddm_group, $element, $fields);
$this->setFilterErrorElementStorage($ddm_group, $element, false);

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&(is_array($this->getAddElementValidation($ddm_group, $element, 'filter')))) {
	foreach ($this->getAddElementValidation($ddm_group, $element, 'filter') as $filter=>$values) {
		if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)) {
			$values['module']=$filter;
			if ((!isset($values['enabled']))||($values['enabled']===true)) {
				$this->parseFilterAddElementPHP($ddm_group, $element, $values);
			}
		}
	}
}

?>