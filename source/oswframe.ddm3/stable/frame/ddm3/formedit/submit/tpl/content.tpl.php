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

	<tr class="table_ddm_row table_ddm_row_highlight table_ddm_row_submit ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if ($this->getEditElementOption($ddm_group, $element, 'notice')!=''): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_required"><?php if ($this->getCounter($ddm_group, 'form_elements_required')>0): ?><?php if ($this->getCounter($ddm_group, 'form_elements_required')==1): ?><?php echo $this->getGroupMessage($ddm_group, 'form_required_notice') ?><?php else: ?><?php echo $this->getGroupMessage($ddm_group, 'form_required_notice_multi') ?><?php endif ?><?php endif ?>&nbsp;</td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_button">
			<?php if ($this->setLock($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))!==true): ?>
				<span style="color:red; font-weight:bold;"><?php echo h()->_setText($this->getGroupMessage($ddm_group, 'lock_error'), ['user'=>$this->getLockUser($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))]) ?></span>
			<?php else: ?><?php echo osW_Form::getInstance()->drawSubmit('btn_ddm_submit', $this->getGroupMessage($ddm_group, 'form_submit')) ?><?php echo osW_Form::getInstance()->drawReset('btn_ddm_reset', $this->getGroupMessage($ddm_group, 'form_reset')) ?><?php echo osW_Form::getInstance()->drawSubmit('btn_ddm_cancel', $this->getGroupMessage($ddm_group, 'form_cancel')) ?><?php endif ?>
		</td>
	</tr>

<?php if ($this->getEditElementOption($ddm_group, $element, 'notice')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_notice">
			<?php echo h()->outputString($this->getEditElementOption($ddm_group, $element, 'notice')) ?>
		</td>
	</tr>
<?php endif ?>