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

$file_name=$this->getDoSendElementStorage($ddm_group, $element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix'));

if ($this->getSendElementOption($ddm_group, $element, 'required')===true) {
	if ((strlen($file_name)==0)||(filesize(vOut('settings_abspath').$file_name)==0)) {
		osW_Form::getInstance()->addFormError($element);
		osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_image_miss'), $this->getFilterElementStorage($ddm_group, $element))));
		$this->setFilterErrorElementStorage($ddm_group, $element, true);
	}
}

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&($this->getFilterErrorElementStorage($ddm_group, $element.'_upload_error')==true)) {
	osW_Form::getInstance()->addFormError($element);
	osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_file_uploaderror'), $this->getFilterElementStorage($ddm_group, $element))));
	$this->setFilterErrorElementStorage($ddm_group, $element, true);
	$this->setFilterErrorElementStorage($ddm_group, $element.'_upload_error', false);
}

if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&(strlen($file_name)>0)) {

	if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&(is_array($this->getSendElementValidation($ddm_group, $element, 'types')))&&(count($this->getSendElementValidation($ddm_group, $element, 'types'))>0)) {
		$finfo=finfo_open(FILEINFO_MIME_TYPE);
		if (!in_array(finfo_file($finfo, vOut('settings_abspath').$file_name), $this->getSendElementValidation($ddm_group, $element, 'types'))) {
			osW_Form::getInstance()->addFormError($element);
			osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_file_typeerror'), $this->getFilterElementStorage($ddm_group, $element))));
			$this->setFilterErrorElementStorage($ddm_group, $element, true);
		}
	}

	if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&(is_array($this->getSendElementValidation($ddm_group, $element, 'extensions')))&&(count($this->getSendElementValidation($ddm_group, $element, 'extensions'))>0)) {
		if (!in_array(pathinfo(vOut('settings_abspath').$file_name, PATHINFO_EXTENSION), $this->getSendElementValidation($ddm_group, $element, 'extensions'))) {
			osW_Form::getInstance()->addFormError($element);
			osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_file_extensionerror'), $this->getFilterElementStorage($ddm_group, $element))));
			$this->setFilterErrorElementStorage($ddm_group, $element, true);
		}
	}

	if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&($this->getSendElementValidation($ddm_group, $element, 'size_min')!='')) {
		if (filesize(vOut('settings_abspath').$file_name)<$this->getSendElementValidation($ddm_group, $element, 'size_min')) {
			osW_Form::getInstance()->addFormError($element);
			osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_file_tosmall'), $this->getFilterElementStorage($ddm_group, $element))));
			$this->setFilterErrorElementStorage($ddm_group, $element, true);
		}
	}

	if (($this->getFilterErrorElementStorage($ddm_group, $element)!==true)&&($this->getSendElementValidation($ddm_group, $element, 'size_max')!='')) {
		if (filesize(vOut('settings_abspath').$file_name)>$this->getSendElementValidation($ddm_group, $element, 'size_max')) {
			osW_Form::getInstance()->addFormError($element);
			osW_MessageStack::getInstance()->add('form', 'error', array('msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_file_tobig'), $this->getFilterElementStorage($ddm_group, $element))));
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
}

?>