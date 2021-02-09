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

$this->setDoAddElementStorage($ddm_group, $element.'_double', h()->_settype(h()->_catch($element.'_double', '', 'p'), 'string'));

if ($this->getDoAddElementStorage($ddm_group, $element)!=$this->getDoAddElementStorage($ddm_group, $element.'_double')) {
	osW_Form::getInstance()->addFormError($element.'_double');
	osW_MessageStack::getInstance()->add('form', 'error', ['msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_element_double'), $this->getFilterElementStorage($ddm_group, $element))]);
	$this->setFilterErrorElementStorage($ddm_group, $element, true);
}

?>