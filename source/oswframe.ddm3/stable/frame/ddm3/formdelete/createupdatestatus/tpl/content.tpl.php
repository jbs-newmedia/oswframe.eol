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

?>

<?php if ($this->getDeleteElementValue($ddm_group, $element, 'title')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_highlight table_ddm_row_header ddm_element_<?php echo $this->getDeleteElementValue($ddm_group, $element, 'id') ?>">
		<td class="table_ddm_col table_ddm_col_data" colspan="2">
			<?php echo h()->outputString($this->getDeleteElementValue($ddm_group, $element, 'title')) ?>
		</td>
	</tr>
<?php endif ?>

<?php if ($this->getDeleteElementOption($ddm_group, $element, 'display_create_time')==true): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getDeleteElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')&&($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="3" <?php elseif (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')||($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getDeleteElementOption($ddm_group, $element, 'text_create_time')) ?><?php if ($this->getDeleteElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php if (($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_time')=='')||($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_time')=='0')): ?>
				---
			<?php else: ?><?php if ($this->getDeleteElementOption($ddm_group, $element, 'month_asname')===true): ?><?php echo strftime(str_replace('%m.', ' %B ', $this->getDeleteElementOption($ddm_group, $element, 'date_format')), $this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php else: ?><?php echo strftime($this->getDeleteElementOption($ddm_group, $element, 'date_format'), $this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php endif ?><?php endif ?>
		</td>
	</tr>
<?php endif ?>

<?php if ($this->getDeleteElementOption($ddm_group, $element, 'display_create_user')==true): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getDeleteElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')&&($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="3" <?php elseif (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')||($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getDeleteElementOption($ddm_group, $element, 'text_create_user')) ?><?php if ($this->getDeleteElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php if (($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_user_id')=='')||($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_user_id')=='0')||(osW_VIS::getInstance()->getUsernameById($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_user_id'))=='')): ?>
				---
			<?php else: ?><?php echo h()->_outputString(osW_VIS::getInstance()->getUsernameById($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'create_user_id'))) ?><?php endif ?>
		</td>
	</tr>
<?php endif ?>

<?php if ($this->getDeleteElementOption($ddm_group, $element, 'display_update_time')==true): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getDeleteElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')&&($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="3" <?php elseif (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')||($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getDeleteElementOption($ddm_group, $element, 'text_update_time')) ?><?php if ($this->getDeleteElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php if (($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_time')=='')||($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_time')=='0')): ?>
				---
			<?php else: ?><?php if ($this->getDeleteElementOption($ddm_group, $element, 'month_asname')===true): ?><?php echo strftime(str_replace('%m.', ' %B ', $this->getDeleteElementOption($ddm_group, $element, 'date_format')), $this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php else: ?><?php echo strftime($this->getDeleteElementOption($ddm_group, $element, 'date_format'), $this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_time')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'text_clock')) ?><?php endif ?><?php endif ?>
		</td>
	</tr>
<?php endif ?>

<?php if ($this->getDeleteElementOption($ddm_group, $element, 'display_update_user')==true): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getDeleteElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')&&($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="3" <?php elseif (($this->getDeleteElementOption($ddm_group, $element, 'buttons')!='')||($this->getDeleteElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getDeleteElementOption($ddm_group, $element, 'text_update_user')) ?><?php if ($this->getDeleteElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php if (($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_user_id')=='')||($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_user_id')=='0')||(osW_VIS::getInstance()->getUsernameById($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_user_id'))=='')): ?>
				---
			<?php else: ?><?php echo h()->_outputString(osW_VIS::getInstance()->getUsernameById(($this->getDeleteElementStorage($ddm_group, $this->getDeleteElementOption($ddm_group, $element, 'prefix').'update_user_id')))) ?><?php endif ?>
		</td>
	</tr>
<?php endif ?>