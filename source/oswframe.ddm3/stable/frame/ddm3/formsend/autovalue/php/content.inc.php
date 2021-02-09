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

if (osW_Settings::getInstance()->getAction()=='dosend') {
	$database_where_string='';
	if ($this->getSendElementOption($ddm_group, $element, 'filter_use')===true) {
		$ddm_filter_array=$this->getGroupOption($ddm_group, 'filter', 'database');
		if (!empty($ddm_filter_array)) {
			$ddm_filter=[];
			foreach ($ddm_filter_array as $filter_data) {
				$ar_values=[];
				foreach ($filter_data as $filter_logic=>$filter_elements) {
					foreach ($filter_elements as $filter_element) {
						$ar_values[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$filter_element['key'].$filter_element['operator'].$filter_element['value'];
					}
				}
				$ddm_filter[]='('.implode(' '.strtoupper($filter_logic).' ', $ar_values).')';
			}
			$database_where_string.=' AND ('.implode(' OR ', $ddm_filter).')';
		}
	}

	if ($this->getSendElementOption($ddm_group, $element, 'default_value')!='') {
		$database_where_string.=' AND ('.$this->getSendElementValue($ddm_group, $element, 'name').'>='.$this->getSendElementOption($ddm_group, $element, 'default_value').')';
	}

	$QcheckData=osW_Database::getInstance()->query('SELECT :formdata_name: FROM :table: AS :alias: WHERE 1 :where: ORDER BY :formdata_name: DESC LIMIT 1');
	$QcheckData->bindTable(':table:', $this->getGroupOption($ddm_group, 'table', 'database'));
	$QcheckData->bindRaw(':alias:', $this->getGroupOption($ddm_group, 'alias', 'database'));
	$QcheckData->bindRaw(':formdata_name:', $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$this->getSendElementValue($ddm_group, $element, 'name'));
	$QcheckData->bindRaw(':where:', $database_where_string);
	$QcheckData->execute();
	if ($QcheckData->numberOfRows()==1) {
		$QcheckData->next();
		$this->setDoSendElementStorage($ddm_group, $element, ($QcheckData->result[$this->getSendElementValue($ddm_group, $element, 'name')]+1));
	} else {
		$this->setDoSendElementStorage($ddm_group, $element, $this->getSendElementOption($ddm_group, $element, 'default_value'));
	}
}

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

?>