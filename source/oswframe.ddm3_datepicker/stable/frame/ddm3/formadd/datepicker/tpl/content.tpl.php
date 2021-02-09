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

	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getAddElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if ($this->getAddElementOption($ddm_group, $element, 'notice')!=''): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getAddElementValue($ddm_group, $element, 'title')) ?><?php if ($this->getAddElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php if (strlen($this->getAddElementStorage($ddm_group, $element))==8): ?><?php $date_format=$this->getAddElementOption($ddm_group, $element, 'date_format') ?><?php $date_format=str_replace('%', '%osw_tmp_ddm3_%', $date_format) ?><?php $date_format=str_replace('%osw_tmp_ddm3_%d', substr($this->getAddElementStorage($ddm_group, $element), 6, 2), $date_format) ?><?php $date_format=str_replace('%osw_tmp_ddm3_%m', substr($this->getAddElementStorage($ddm_group, $element), 4, 2), $date_format) ?><?php $date_format=str_replace('%osw_tmp_ddm3_%Y', substr($this->getAddElementStorage($ddm_group, $element), 0, 4), $date_format) ?><?php else: ?><?php $date_format=''; ?><?php endif ?>

			<?php if ($this->getAddElementOption($ddm_group, $element, 'readonly')===true): ?><?php echo h()->_outputString($date_format) ?><?php else: ?><?php echo osW_Form::getInstance()->drawTextField($element, $date_format, ['input_class'=>'table_ddm_col_form_date']) ?><?php endif ?>
		</td>
	</tr>

<?php if ($this->getAddElementOption($ddm_group, $element, 'notice')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getAddElementValue($ddm_group, $element, 'id') ?> ">
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_notice">
			<?php echo h()->outputString($this->getAddElementOption($ddm_group, $element, 'notice')) ?>
		</td>
	</tr>
<?php endif ?>