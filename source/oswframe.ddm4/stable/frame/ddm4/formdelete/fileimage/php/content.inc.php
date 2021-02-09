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

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

if (osW_Settings::getInstance()->getAction()=='dodelete') {
	$this->setDoDeleteElementStorage($ddm_group, $element, h()->_settype(h()->_catch($element, '', 'p'), 'string'));
	$this->setDoDeleteElementStorage($ddm_group, $element.$this->getDeleteElementOption($ddm_group, $element, 'temp_suffix'), h()->_settype(h()->_catch($element.$this->getDeleteElementOption($ddm_group, $element, 'temp_suffix'), '', 'p'), 'string'));

	if (($this->getDeleteElementOption($ddm_group, $element, 'store_name')===true)||($this->getDeleteElementOption($ddm_group, $element, 'store_type')===true)||($this->getDeleteElementOption($ddm_group, $element, 'store_size')===true)||($this->getDeleteElementOption($ddm_group, $element, 'store_md5')===true)) {
		$Qselect=osW_Database::getInstance()->query('SELECT :elements: FROM :table: AS :alias: WHERE :name_index:=:value_index:');
		$Qselect->bindRaw(':elements:', implode(', ', array($this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'_name', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'_type', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'_size',$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'_md5')));
		$Qselect->bindTable(':table:', $this->getGroupOption($ddm_group, 'table', 'database'));
		$Qselect->bindRaw(':alias:', $this->getGroupOption($ddm_group, 'alias', 'database'));
		$Qselect->bindRaw(':name_index:', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$this->getGroupOption($ddm_group, 'index', 'database'));
		if ($this->getGroupOption($ddm_group, 'db_index_type', 'database')=='string') {
			$Qselect->bindValue(':value_index:', $this->getIndexElementStorage($ddm_group));
		} else {
			$Qselect->bindInt(':value_index:', $this->getIndexElementStorage($ddm_group));
		}
		$Qselect->execute();
		if ($Qselect->numberOfRows()==1) {
			$Qselect->next();
			$data_old=$Qselect->result;
		} else {
			$data_old=array();
			$data_old[$element.'_name']='';
			$data_old[$element.'_type']='';
			$data_old[$element.'_size']=0;
			$data_old[$element.'_md5']='';
		}
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_name')===true) {
		if ($this->getDeleteElementStorage($ddm_group, $element)!='') {
			$this->setDeleteElementStorage($ddm_group, $element.'_name', $data_old[$element.'_name']);
		}
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_type')===true) {
		if ($this->getDeleteElementStorage($ddm_group, $element)!='') {
			$this->setDeleteElementStorage($ddm_group, $element.'_type', $data_old[$element.'_type']);
		}
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_size')===true) {
		if ($this->getDeleteElementStorage($ddm_group, $element)!='') {
			$this->setDeleteElementStorage($ddm_group, $element.'_size', $data_old[$element.'_size']);
		}
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_md5')===true) {
		if ($this->getDeleteElementStorage($ddm_group, $element)!='') {
			$this->setDeleteElementStorage($ddm_group, $element.'_md5', $data_old[$element.'_md5']);
		}
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_name')===true) {
		$this->setDoDeleteElementStorage($ddm_group, $element.'_name', $data_old[$element.'_name']);
		osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_name', array(
			'module'=>'hidden',
			'name'=>$this->getDeleteElementValue($ddm_group, $element, 'name').'_name',
		));
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_type')===true) {
		$this->setDoDeleteElementStorage($ddm_group, $element.'_type', $data_old[$element.'_type']);
		osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_type', array(
			'module'=>'hidden',
			'name'=>$this->getDeleteElementValue($ddm_group, $element, 'name').'_type',
		));
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_size')===true) {
		$this->setDoDeleteElementStorage($ddm_group, $element.'_size', $data_old[$element.'_size']);
		osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_size', array(
			'module'=>'hidden',
			'name'=>$this->getDeleteElementValue($ddm_group, $element, 'name').'_size',
		));
	}

	if ($this->getDeleteElementOption($ddm_group, $element, 'store_md5')===true) {
		$this->setDoDeleteElementStorage($ddm_group, $element.'_md5', $data_old[$element.'_md5']);
		osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_md5', array(
			'module'=>'hidden',
			'name'=>$this->getDeleteElementValue($ddm_group, $element, 'name').'_md5',
		));
	}
}

?>