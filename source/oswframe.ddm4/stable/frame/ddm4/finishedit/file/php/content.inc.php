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

if ($this->getDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix'))!='') {
	rename(vOut('settings_abspath').$this->getDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix')), vOut('settings_abspath').$this->getDoEditElementStorage($ddm_group, $element));
	if (($this->getEditElementStorage($ddm_group, $element)!='')&&($this->getEditElementStorage($ddm_group, $element)!=$this->getDoEditElementStorage($ddm_group, $element))) {
		h()->_unlink(vOut('settings_abspath').$this->getEditElementStorage($ddm_group, $element));
		$this->setEditElementStorage($ddm_group, $element, '');
	}
} elseif (h()->_catch($element.$this->getEditElementOption($ddm_group, $element, 'delete_suffix'), '', 'p')==1) {
	if ($this->getDoEditElementStorage($ddm_group, $element)!='') {
		h()->_unlink(vOut('settings_abspath').$this->getDoEditElementStorage($ddm_group, $element));
		$this->setDoEditElementStorage($ddm_group, $element, '');

		if ($this->getEditElementOption($ddm_group, $element, 'store_name')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_name', '');
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_name', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_name',
			));
		}

		if ($this->getEditElementOption($ddm_group, $element, 'store_type')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_type', '');
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_type', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_type',
			));
		}

		if ($this->getEditElementOption($ddm_group, $element, 'store_size')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_size', 0);
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_size', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_size',
			));
		}

		if ($this->getEditElementOption($ddm_group, $element, 'store_md5')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_md5', 0);
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_md5', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_md5',
			));
		}
	}
}

?>