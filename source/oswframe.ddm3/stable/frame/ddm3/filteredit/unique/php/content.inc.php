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

if (strlen($this->getDoEditElementStorage($ddm_group, $element))>0) {
	$QcheckData=osW_Database::getInstance()->query('SELECT :formdata_name: FROM :table: WHERE :formdata_name: LIKE :value:');
	$QcheckData->bindTable(':table:', $this->getGroupOption($ddm_group, 'table', 'database'));
	$QcheckData->bindRaw(':formdata_name:', $this->getEditElementValue($ddm_group, $element, 'name'));
	$QcheckData->bindValue(':value:', $this->getDoEditElementStorage($ddm_group, $element));
	$QcheckData->execute();
	if ($QcheckData->numberOfRows()>=2) {
		osW_Form::getInstance()->addFormError($element);
		osW_MessageStack::getInstance()->add('form', 'error', ['msg'=>h()->_setText($this->getGroupMessage($ddm_group, 'validation_element_unique'), $this->getFilterElementStorage($ddm_group, $element))]);
		$this->setFilterErrorElementStorage($ddm_group, $element, true);
	}
}

?>