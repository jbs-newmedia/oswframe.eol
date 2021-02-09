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

	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getSearchElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if ($this->getSearchElementOption($ddm_group, $element, 'notice')!=''): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getSearchElementValue($ddm_group, $element, 'title')) ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php $data=$this->getSearchElementOption($ddm_group, $element, 'data') ?>

			<?php $date_format=$this->getSearchElementOption($ddm_group, $element, 'date_format') ?>
			<?php $date_format=str_replace('%', '%osw_tmp_ddm3_%', $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%d', osW_Form::getInstance()->drawSelectField($element.'_day___0', $data['day'], substr($this->getSearchElementStorage($ddm_group, $element.'___0'), 6, 2), []), $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%m', osW_Form::getInstance()->drawSelectField($element.'_month___0', $data['month'], substr($this->getSearchElementStorage($ddm_group, $element.'___0'), 4, 2), []), $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%Y', osW_Form::getInstance()->drawSelectField($element.'_year___0', $data['year'], substr($this->getSearchElementStorage($ddm_group, $element.'___0'), 0, 4), []), $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%y', osW_Form::getInstance()->drawSelectField($element.'_year___0', $data['year'], substr($this->getSearchElementStorage($ddm_group, $element.'___0'), 0, 4), []), $date_format) ?>
			<?php echo $date_format; ?>

			-

			<?php $date_format=$this->getSearchElementOption($ddm_group, $element, 'date_format') ?>
			<?php $date_format=str_replace('%', '%osw_tmp_ddm3_%', $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%d', osW_Form::getInstance()->drawSelectField($element.'_day___1', $data['day'], substr($this->getSearchElementStorage($ddm_group, $element.'___1'), 6, 2), []), $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%m', osW_Form::getInstance()->drawSelectField($element.'_month___1', $data['month'], substr($this->getSearchElementStorage($ddm_group, $element.'___1'), 4, 2), []), $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%Y', osW_Form::getInstance()->drawSelectField($element.'_year___1', $data['year'], substr($this->getSearchElementStorage($ddm_group, $element.'___1'), 0, 4), []), $date_format) ?>
			<?php $date_format=str_replace('%osw_tmp_ddm3_%y', osW_Form::getInstance()->drawSelectField($element.'_year___1', $data['year'], substr($this->getSearchElementStorage($ddm_group, $element.'___1'), 0, 4), []), $date_format) ?>
			<?php echo $date_format; ?>
		</td>
	</tr>

<?php if ($this->getSearchElementOption($ddm_group, $element, 'notice')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getSearchElementValue($ddm_group, $element, 'id') ?> ">
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_notice">
			<?php echo h()->outputString($this->getSearchElementOption($ddm_group, $element, 'notice')) ?>
		</td>
	</tr>
<?php endif ?>