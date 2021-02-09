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

if (osW_Settings::getInstance()->getAction()=='dodelete') {
	$multicheckbox=array();
	$data=$this->getDeleteElementOption($ddm_group, $element, 'data');
	ksort($data);
	foreach($data as $key => $value) {
		$_value=h()->_catch($element.'_'.$key, 0, 'p');
		if ($_value==1) {
			$multicheckbox[]=$key;
		}
	}
	$this->setDoDeleteElementStorage($ddm_group, $element, implode($this->getDeleteElementOption($ddm_group, $element, 'separator'), $multicheckbox), 'string');
}

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

?>