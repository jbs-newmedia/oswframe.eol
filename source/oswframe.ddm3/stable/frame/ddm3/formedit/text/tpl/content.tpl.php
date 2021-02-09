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

	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if (($this->getEditElementOption($ddm_group, $element, 'buttons')!='')&&($this->getEditElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="3" <?php elseif (($this->getEditElementOption($ddm_group, $element, 'buttons')!='')||($this->getEditElementOption($ddm_group, $element, 'notice')!='')): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getEditElementValue($ddm_group, $element, 'title')) ?><?php if ($this->getEditElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php if ($this->getEditElementOption($ddm_group, $element, 'read_only')===true): ?><?php echo osW_Form::getInstance()->drawHiddenField($element, $this->getEditElementStorage($ddm_group, $element), []) ?><?php echo h()->outputString($this->getEditElementStorage($ddm_group, $element)) ?><?php else: ?><?php echo osW_Form::getInstance()->drawTextField($element, $this->getEditElementStorage($ddm_group, $element), []) ?><?php endif ?>
		</td>
	</tr>

<?php if ($this->getEditElementOption($ddm_group, $element, 'buttons')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_notice">
			<?php echo implode(' | ', $this->getEditElementOption($ddm_group, $element, 'buttons')) ?>
		</td>
	</tr>
<?php endif ?>

<?php if ($this->getEditElementOption($ddm_group, $element, 'notice')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_notice">
			<?php echo h()->outputString($this->getEditElementOption($ddm_group, $element, 'notice')) ?>
		</td>
	</tr>
<?php endif ?>