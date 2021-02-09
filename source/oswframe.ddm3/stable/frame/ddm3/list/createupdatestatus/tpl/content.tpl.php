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

<?php if ($this->getListElementOption($ddm_group, $element, 'display_create_time')==true): ?>
	<td class="table_ddm_col table_ddm_col_data ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id').'_'.$this->getListElementOption($ddm_group, $element, 'prefix').'create_time' ?>">
		<?php if (($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_time')=='')||($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_time')=='0')): ?>
			---
		<?php else: ?><?php if ($this->getListElementOption($ddm_group, $element, 'month_asname')===true): ?><?php echo strftime(str_replace('%m.', ' %B ', $this->getListElementOption($ddm_group, $element, 'date_format')), $this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php else: ?><?php echo strftime($this->getListElementOption($ddm_group, $element, 'date_format'), $this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php endif ?><?php endif ?>
	</td>
<?php endif ?>

<?php if ($this->getListElementOption($ddm_group, $element, 'display_create_user')==true): ?>
	<td class="table_ddm_col table_ddm_col_data ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id').'_'.$this->getListElementOption($ddm_group, $element, 'prefix').'create_time' ?>">
		<?php if (($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_user_id')=='')||($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_user_id')=='0')||(osW_VIS::getInstance()->getUsernameById($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_user_id'))=='')): ?>
			---
		<?php else: ?><?php echo h()->_outputString(osW_VIS::getInstance()->getUsernameById($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'create_user_id'))) ?><?php endif ?>
	</td>
<?php endif ?>

<?php if ($this->getListElementOption($ddm_group, $element, 'display_update_time')==true): ?>
	<td class="table_ddm_col table_ddm_col_data ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id').'_'.$this->getListElementOption($ddm_group, $element, 'prefix').'update_time' ?>">
		<?php if (($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_time')=='')||($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_time')=='0')): ?>
			---
		<?php else: ?><?php if ($this->getListElementOption($ddm_group, $element, 'month_asname')===true): ?><?php echo strftime(str_replace('%m.', ' %B ', $this->getListElementOption($ddm_group, $element, 'date_format')), $this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php else: ?><?php echo strftime($this->getListElementOption($ddm_group, $element, 'date_format'), $this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php endif ?><?php endif ?>
	</td>
<?php endif ?>

<?php if ($this->getListElementOption($ddm_group, $element, 'display_update_user')==true): ?>
	<td class="table_ddm_col table_ddm_col_data ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id').'_'.$this->getListElementOption($ddm_group, $element, 'prefix').'update_time' ?>">
		<?php if (($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_user_id')=='')||($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_user_id')=='0')||(osW_VIS::getInstance()->getUsernameById($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_user_id'))=='')): ?>
			---
		<?php else: ?><?php echo h()->_outputString(osW_VIS::getInstance()->getUsernameById($this->getListStorageValue($ddm_group, $this->getListElementOption($ddm_group, $element, 'prefix').'update_user_id'))) ?><?php endif ?>
	</td>
<?php endif ?>