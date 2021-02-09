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

if (osW_Settings::getInstance()->getAction()=='doadd') {
	$this->setDoAddElementStorage($ddm_group, $element, h()->_settype(h()->_catch($element, '', 'p'), 'string'));
	$this->setDoAddElementStorage($ddm_group, $element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix'), h()->_settype(h()->_catch($element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix'), '', 'p'), 'string'));

	if ((isset($_FILES[$element]))&&($_FILES[$element]['error']==0)) {
		if ($this->getDoAddElementStorage($ddm_group, $element)!='') {
			h()->_unlink(vOut('settings_abspath').$this->getDoAddElementStorage($ddm_group, $element));
		}
		if ($this->getDoAddElementStorage($ddm_group, $element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix'))!='') {
			h()->_unlink(vOut('settings_abspath').$this->getDoAddElementStorage($ddm_group, $element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix')));
		}

		$dir=str_replace('//', '/', vOut('settings_abspath').$this->getAddElementOption($ddm_group, $element, 'file_dir').'/');
		$dir_tmp=str_replace('//', '/', vOut('settings_abspath').$this->getAddElementOption($ddm_group, $element, 'file_dir').'/'.$this->getAddElementOption($ddm_group, $element, 'file_dir_tmp').'/');

		$file_parts=pathinfo($_FILES[$element]['name']);

		if ($this->getAddElementOption($ddm_group, $element, 'store_name')===true) {
			$this->setDoAddElementStorage($ddm_group, $element.'_name', ($_FILES[$element]['name']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_name', array(
				'module'=>'hidden',
				'name'=>$this->getAddElementValue($ddm_group, $element, 'name').'_name',
			));
		}

		if ($this->getAddElementOption($ddm_group, $element, 'store_type')===true) {
			$this->setDoAddElementStorage($ddm_group, $element.'_type', ($_FILES[$element]['type']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_type', array(
				'module'=>'hidden',
				'name'=>$this->getAddElementValue($ddm_group, $element, 'name').'_type',
			));
		}

		if ($this->getAddElementOption($ddm_group, $element, 'store_size')===true) {
			$this->setDoAddElementStorage($ddm_group, $element.'_size', ($_FILES[$element]['size']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_size', array(
				'module'=>'hidden',
				'name'=>$this->getAddElementValue($ddm_group, $element, 'name').'_size',
			));
		}

		if ($this->getAddElementOption($ddm_group, $element, 'store_md5')===true) {
			$this->setDoAddElementStorage($ddm_group, $element.'_md5', md5_file($_FILES[$element]['tmp_name']));
			osW_DDM4::getInstance()->addDataElement($ddm_group, $element.'_md5', array(
				'module'=>'hidden',
				'name'=>$this->getAddElementValue($ddm_group, $element, 'name').'_md5',
			));
		}

		$file_name='';
		switch ($this->getAddElementOption($ddm_group, $element, 'file_name')) {
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
				$file_name=$this->getAddElementOption($ddm_group, $element, 'file_name');
				break;
		}

		$file=$dir.$file_name;
		$file_tmp=$dir_tmp.$file_name;
		h()->_mkdir($dir);
		h()->_mkdir($dir_tmp);
		move_uploaded_file($_FILES[$element]['tmp_name'], $file_tmp);
		h()->_chmod($file_tmp);
		$this->setDoAddElementStorage($ddm_group, $element, str_replace(vOut('settings_abspath'), '', $file));
		$this->setDoAddElementStorage($ddm_group, $element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix'), str_replace(vOut('settings_abspath'), '', $file_tmp));
	} elseif ((isset($_FILES[$element]))&&($_FILES[$element]['error']==4)) {
	} else {
		$this->setFilterErrorElementStorage($ddm_group, $element.'_upload_error', true);
	}

	if (h()->_catch($element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix').$this->getAddElementOption($ddm_group, $element, 'delete_suffix'), '', 'p')==1) {
		if ($this->getDoAddElementStorage($ddm_group, $element)!='') {
			h()->_unlink(vOut('settings_abspath').$this->getDoAddElementStorage($ddm_group, $element));
			$this->setDoAddElementStorage($ddm_group, $element, '');
		}
		if ($this->getDoAddElementStorage($ddm_group, $element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix'))!='') {
			h()->_unlink(vOut('settings_abspath').$this->getDoAddElementStorage($ddm_group, $element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix')));
			$this->setDoAddElementStorage($ddm_group, $element.$this->getAddElementOption($ddm_group, $element, 'temp_suffix'), '');
		}
	}
}

?>