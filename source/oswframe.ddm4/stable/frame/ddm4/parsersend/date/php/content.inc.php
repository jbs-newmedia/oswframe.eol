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

$fields=array();
$fields['element']=$element;
$fields['element_title']=$this->getSendElementValue($ddm_group, $element, 'title');
$this->setFilterElementStorage($ddm_group, $element, $fields);
$this->setFilterErrorElementStorage($ddm_group, $element, false);

if ($this->getSendElementOption($ddm_group, $element, 'required')===true) {
	if ((strlen($this->getDoSendElementStorage($ddm_group, $element))!=8)&&($this->getDoSendElementStorage($ddm_group, $element)=='00000000')) {
		osW_Form::getInstance()->addFormError($element);
		osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_element_miss'), $this->getFilterElementStorage($ddm_group, $element))));
		$this->setFilterErrorElementStorage($ddm_group, $element, true);
	}
}

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&($this->getDoSendElementStorage($ddm_group, $element)!='')&&($this->getDoSendElementStorage($ddm_group, $element)!='00000000')) {
	if(checkdate(substr($this->getDoSendElementStorage($ddm_group, $element), 4, 2), substr($this->getDoSendElementStorage($ddm_group, $element), 6, 2), substr($this->getDoSendElementStorage($ddm_group, $element), 0, 4))!==true) {
		osW_Form::getInstance()->addFormError($element);
		osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_element_incorrect'), $this->getFilterElementStorage($ddm_group, $element))));
		$this->setFilterErrorElementStorage($ddm_group, $element, true);
	}
}

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&($this->getSendElementValidation($ddm_group, $element, 'value_min')!='')) {
	if ($this->getDoSendElementStorage($ddm_group, $element)<$this->getSendElementValidation($ddm_group, $element, 'value_min')) {
		osW_Form::getInstance()->addFormError($element);
		osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_element_tosmall'), $this->getFilterElementStorage($ddm_group, $element))));
		$this->setFilterErrorElementStorage($ddm_group, $element, true);
	}
}

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&($this->getSendElementValidation($ddm_group, $element, 'value_max')!='')) {
	if ($this->getDoSendElementStorage($ddm_group, $element)>$this->getSendElementValidation($ddm_group, $element, 'value_max')) {
		osW_Form::getInstance()->addFormError($element);
		osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_element_tobig'), $this->getFilterElementStorage($ddm_group, $element))));
		$this->setFilterErrorElementStorage($ddm_group, $element, true);
	}
}

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&($this->getSendElementValidation($ddm_group, $element, 'preg')!='')) {
	if (!preg_match($this->getSendElementValidation($ddm_group, $element, 'preg'), $this->getDoSendElementStorage($ddm_group, $element))) {
		osW_Form::getInstance()->addFormError($element);
		osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_element_regerror'), $this->getFilterElementStorage($ddm_group, $element))));
		$this->setFilterErrorElementStorage($ddm_group, $element, true);
	}
}

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&(is_array($this->getSendElementValidation($ddm_group, $element, 'filter')))) {
	foreach ($this->getSendElementValidation($ddm_group, $element, 'filter') as $filter => $values) {
		if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)) {
			$values['module']=$filter;
			$this->parseFilterSendElementPHP($ddm_group, $element, $values);
		}
	}
}

?>