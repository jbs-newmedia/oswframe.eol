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

?>

<?php


$_links=array();

if (is_array($this->getListElementOption($ddm_group, $element, 'links_before'))) {
	foreach ($this->getListElementOption($ddm_group, $element, 'links_before') as $__link) {
		if ((isset($__link['modal']))&&($__link['modal']==true)) {
			$_links[]='<a onclick="openDDM4Modal_'.$ddm_group.'(this, \''.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'\', \''.((($__link['type'])) ? $__link['type'] : '<i class="fa fa-fw"></i>').'\', 12)" title="'.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'" class="ddm4_button_option" pageName="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].((($__link['parameter'])) ? '&'.$__link['parameter'] : '').'&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].'&modal=1&'.$this->getDirectParameters($ddm_group)).'">'.((($__link['content'])) ? $__link['content'] : '<i class="fa fa-fw"></i>').'</a>';
		} else {
			$_links[]='<a'.((isset($__link['target'])) ? ' class="ddm4_button_option" target="'.$__link['target'].'"' : '').' href="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].((($__link['parameter'])) ? '&'.$__link['parameter'] : '')).'" title="'.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'">'.((($__link['content'])) ? $__link['content'] : '<i class="fa fa-fw"></i>').'</a>';
		}
	}
}

if (($this->getCounter($ddm_group, 'edit_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_edit')!==true)) {
	$_links[]='<a onclick="openDDM4Modal_'.$ddm_group.'(this, \''.osW_DDM4::getInstance()->getGroupOption($ddm_group, 'edit_title', 'messages').'\', \'edit\', '.$this->getCounter($ddm_group, 'edit_elements').')" title="'.h()->_outputString($this->getGroupMessage($ddm_group, 'data_edit')).'" class="ddm4_button_option" pageName="'.osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=edit&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].'&modal=1&'.$this->getDirectParameters($ddm_group)).'"><i class="fa fa-pencil fa-fw"></i></a>';
}

if (($this->getCounter($ddm_group, 'delete_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_delete')!==true)) {
	$_links[]='<a onclick="openDDM4Modal_'.$ddm_group.'(this, \''.osW_DDM4::getInstance()->getGroupOption($ddm_group, 'delete_title', 'messages').'\', \'delete\', '.$this->getCounter($ddm_group, 'delete_elements').')" title="'.h()->_outputString($this->getGroupMessage($ddm_group, 'data_delete')).'" class="ddm4_button_option" pageName="'.osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=delete&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].'&modal=1&'.$this->getDirectParameters($ddm_group)).'"><i class="fa fa-trash fa-fw"></i></a>';
}

if (($this->getGroupOption($ddm_group, 'enable_log')===true)&&($this->getListElementOption($ddm_group, $element, 'disable_log')!==true)) {
	$_links[]='<a onclick="openDDM4Modal_'.$ddm_group.'(this, \''.osW_DDM4::getInstance()->getGroupOption($ddm_group, 'log_title', 'messages').'\', \'log\', '.$this->getCounter($ddm_group, 'delete_elements').')" title="'.h()->_outputString($this->getGroupMessage($ddm_group, 'data_log')).'" class="ddm4_button_option" pageName="'.osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=log&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].'&modal=1&'.$this->getDirectParameters($ddm_group)).'"><i class="fa fa-book fa-fw"></i></a>';
}

if (is_array($this->getListElementOption($ddm_group, $element, 'links'))) {
	foreach ($this->getListElementOption($ddm_group, $element, 'links') as $__link) {
		if ((isset($__link['modal']))&&($__link['modal']==true)) {
			$_links[]='<a onclick="openDDM4Modal_'.$ddm_group.'(this, \''.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'\', \''.((($__link['type'])) ? $__link['type'] : '<i class="fa fa-fw"></i>').'\', 12)" title="'.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'" class="ddm4_button_option" pageName="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].((($__link['parameter'])) ? '&'.$__link['parameter'] : '').'&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].'&modal=1&'.$this->getDirectParameters($ddm_group)).'">'.((($__link['content'])) ? $__link['content'] : '<i class="fa fa-fw"></i>').'</a>';
		} else {
			$_links[]='<a'.((isset($__link['target'])) ? ' class="ddm4_button_option" target="'.$__link['target'].'"' : '').' href="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].((($__link['parameter'])) ? '&'.$__link['parameter'] : '')).'" title="'.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'">'.((($__link['content'])) ? $__link['content'] : '<i class="fa fa-fw"></i>').'</a>';
		}
	}
}

if (is_array($this->getListElementOption($ddm_group, $element, 'links_after'))) {
	foreach ($this->getListElementOption($ddm_group, $element, 'links_after') as $__link) {
		if ((isset($__link['modal']))&&($__link['modal']==true)) {
			$_links[]='<a onclick="openDDM4Modal_'.$ddm_group.'(this, \''.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'\', \''.((($__link['type'])) ? $__link['type'] : '<i class="fa fa-fw"></i>').'\', 12)" title="'.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'" class="ddm4_button_option" pageName="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].((($__link['parameter'])) ? '&'.$__link['parameter'] : '').'&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].'&modal=1&'.$this->getDirectParameters($ddm_group)).'">'.((($__link['content'])) ? $__link['content'] : '<i class="fa fa-fw"></i>').'</a>';
		} else {
			$_links[]='<a'.((isset($__link['target'])) ? ' class="ddm4_button_option" target="'.$__link['target'].'"' : '').' href="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$view_data[$this->getGroupOption($ddm_group, 'index', 'database')].((($__link['parameter'])) ? '&'.$__link['parameter'] : '')).'" title="'.((($__link['text'])) ? h()->_outputString($__link['text']) : 'undefined').'">'.((($__link['content'])) ? $__link['content'] : '<i class="fa fa-fw"></i>').'</a>';
		}
	}
}

$view_data[$element]='<div style="text-align:center; white-space:nowrap;">'.implode(' ', $_links).'</div>';

?>