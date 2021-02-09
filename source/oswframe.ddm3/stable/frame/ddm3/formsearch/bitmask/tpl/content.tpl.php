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
			<?php $bitmask=$this->getSearchElementStorage($ddm_group, $element) ?>
			<ul class="table_ddm_list <?php if ($this->getSearchElementOption($ddm_group, $element, 'orientation')=='horizontal'): ?><?php echo ' table_ddm_list_horizontal' ?><?php else: ?><?php echo 'table_ddm_list_vertical' ?><?php endif ?>">
				<?php foreach ($this->getSearchElementOption($ddm_group, $element, 'data') as $key=>$value): ?>
					<li>
						<?php if (isset($bitmask[$key])): ?><?php echo osW_Form::getInstance()->drawCheckboxField($element.'_'.$key, '1', $bitmask[$key], []) ?><?php echo h()->_outputString($value) ?><?php else: ?><?php echo osW_Form::getInstance()->drawCheckboxField($element.'_'.$key, '1', 0, []) ?><?php echo h()->_outputString($value) ?><?php endif ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>

<?php if ($this->getSearchElementOption($ddm_group, $element, 'notice')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getSearchElementValue($ddm_group, $element, 'id') ?> ">
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_notice">
			<?php echo h()->outputString($this->getSearchElementOption($ddm_group, $element, 'notice')) ?>
		</td>
	</tr>
<?php endif ?>