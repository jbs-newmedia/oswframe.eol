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
	$this->setDoSendElementStorage($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'create_time', $this->getSendElementOption($ddm_group, $element, 'time'));
	osW_DDM3::getInstance()->addSendElement($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'create_time', ['module'=>'hidden', 'name'=>$this->getSendElementOption($ddm_group, $element, 'prefix').'create_time']);
	$this->setDoSendElementStorage($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'create_user_id', $this->getSendElementOption($ddm_group, $element, 'user_id'));
	osW_DDM3::getInstance()->addSendElement($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'create_user_id', ['module'=>'hidden', 'name'=>$this->getSendElementOption($ddm_group, $element, 'prefix').'create_user_id']);
	$this->setDoSendElementStorage($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'update_time', $this->getSendElementOption($ddm_group, $element, 'time'));
	osW_DDM3::getInstance()->addSendElement($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'update_time', ['module'=>'hidden', 'name'=>$this->getSendElementOption($ddm_group, $element, 'prefix').'update_time']);
	$this->setDoSendElementStorage($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'update_user_id', $this->getSendElementOption($ddm_group, $element, 'user_id'));
	osW_DDM3::getInstance()->addSendElement($ddm_group, $this->getSendElementOption($ddm_group, $element, 'prefix').'update_user_id', ['module'=>'hidden', 'name'=>$this->getSendElementOption($ddm_group, $element, 'prefix').'update_user_id']);
}

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

?>