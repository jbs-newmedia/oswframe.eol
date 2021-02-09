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

if (osW_Settings::getInstance()->getAction()=='doedit') {
	$this->setDoEditElementStorage($ddm_group, $element, h()->_settype(h()->_catch($element, '', 'p'), 'string'));
	$this->setDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix'), h()->_settype(h()->_catch($element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix'), '', 'p'), 'string'));

	if (($this->getEditElementOption($ddm_group, $element, 'store_name')===true)||($this->getEditElementOption($ddm_group, $element, 'store_type')===true)||($this->getEditElementOption($ddm_group, $element, 'store_size')===true)||($this->getEditElementOption($ddm_group, $element, 'store_md5')===true)) {
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

	if ($this->getEditElementOption($ddm_group, $element, 'store_name')===true) {
		if ($this->getEditElementStorage($ddm_group, $element)!='') {
			$this->setEditElementStorage($ddm_group, $element.'_name', $data_old[$element.'_name']);
		}
	}

	if ($this->getEditElementOption($ddm_group, $element, 'store_type')===true) {
		if ($this->getEditElementStorage($ddm_group, $element)!='') {
			$this->setEditElementStorage($ddm_group, $element.'_type', $data_old[$element.'_type']);
		}
	}

	if ($this->getEditElementOption($ddm_group, $element, 'store_size')===true) {
		if ($this->getEditElementStorage($ddm_group, $element)!='') {
			$this->setEditElementStorage($ddm_group, $element.'_size', $data_old[$element.'_size']);
		}
	}

	if ($this->getEditElementOption($ddm_group, $element, 'store_md5')===true) {
		if ($this->getEditElementStorage($ddm_group, $element)!='') {
			$this->setEditElementStorage($ddm_group, $element.'_md5', $data_old[$element.'_md5']);
		}
	}

	if ((isset($_FILES[$element]))&&($_FILES[$element]['error']==0)) {
		if ($this->getEditElementStorage($ddm_group, $element)=='') {
			if ($this->getDoEditElementStorage($ddm_group, $element)!='') {
				h()->_unlink(vOut('settings_abspath').$this->getDoEditElementStorage($ddm_group, $element));
			}
			if ($this->getDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix'))!='') {
				h()->_unlink(vOut('settings_abspath').$this->getDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix')));
			}
		}

		$dir=str_replace('//', '/', vOut('settings_abspath').$this->getEditElementOption($ddm_group, $element, 'file_dir').'/');
		$dir_tmp=str_replace('//', '/', vOut('settings_abspath').$this->getEditElementOption($ddm_group, $element, 'file_dir').'/'.$this->getEditElementOption($ddm_group, $element, 'file_dir_tmp').'/');

		$file_parts=pathinfo($_FILES[$element]['name']);

		if ($this->getEditElementOption($ddm_group, $element, 'store_name')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_name', ($_FILES[$element]['name']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_name', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_name',
			));
		}

		if ($this->getEditElementOption($ddm_group, $element, 'store_type')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_type', ($_FILES[$element]['type']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_type', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_type',
			));
		}

		if ($this->getEditElementOption($ddm_group, $element, 'store_size')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_size', ($_FILES[$element]['size']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_size', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_size',
			));
		}

		if ($this->getEditElementOption($ddm_group, $element, 'store_md5')===true) {
			$this->setDoEditElementStorage($ddm_group, $element.'_md5', md5_file($_FILES[$element]['tmp_name']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_md5', array(
				'module'=>'hidden',
				'name'=>$this->getEditElementValue($ddm_group, $element, 'name').'_md5',
			));
		}

		$file_name='';
		switch ($this->getEditElementOption($ddm_group, $element, 'file_name')) {
			case 'time+rand':
				$file_name=time().rand(100,999).'.'.$file_parts['extension'];
				break;
			case 'name_rand':
				$file_name=$file_parts['filename'].'_'.rand(100,999).'.'.$file_parts['extension'];
				break;
			case 'original':
				$file_name=$_FILES[$element]['name'];
				break;
			default:
				$file_name=$this->getEditElementOption($ddm_group, $element, 'file_name');
				break;
		}

		$file=$dir.$file_name;
		$file_tmp=$dir_tmp.$file_name;
		h()->_mkdir($dir);
		h()->_mkdir($dir_tmp);
		move_uploaded_file($_FILES[$element]['tmp_name'], $file_tmp);
		h()->_chmod($file_tmp);
		$this->setDoEditElementStorage($ddm_group, $element, str_replace(vOut('settings_abspath'), '', $file));
		$this->setDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix'), str_replace(vOut('settings_abspath'), '', $file_tmp));
	} elseif ((isset($_FILES[$element]))&&($_FILES[$element]['error']==4)) {
	} else {
		$this->setFilterErrorElementStorage($ddm_group, $element.'_upload_error', true);
	}

	if (h()->_catch($element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix').$this->getEditElementOption($ddm_group, $element, 'delete_suffix'), '', 'p')==1) {
		if ($this->getDoEditElementStorage($ddm_group, $element)!='') {
			h()->_unlink(vOut('settings_abspath').$this->getDoEditElementStorage($ddm_group, $element));
			$this->setDoEditElementStorage($ddm_group, $element, '');
		}
		if ($this->getDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix'))!='') {
			h()->_unlink(vOut('settings_abspath').$this->getDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix')));
			$this->setDoEditElementStorage($ddm_group, $element.$this->getEditElementOption($ddm_group, $element, 'temp_suffix'), '');
		}
	}
}

?>