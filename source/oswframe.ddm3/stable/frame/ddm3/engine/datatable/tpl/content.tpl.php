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

<?php //ADD ?>

<?php if (osW_Settings::getInstance()->getAction()=='add'): ?>

	<?php echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), ['form_parameter'=>'enctype="multipart/form-data"']) ?>

	<table class="table_ddm table_ddm_form table_ddm_add">

		<?php foreach ($this->getAddElements($ddm_group) as $element=>$options): ?><?php echo $this->parseFormAddElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

	</table>

	<?php echo osW_Form::getInstance()->drawHiddenField('action', 'doadd') ?><?php echo osW_Form::getInstance()->drawHiddenField($this->getGroupOption($ddm_group, 'index', 'database'), $this->getIndexElementStorage($ddm_group)) ?><?php echo osW_Form::getInstance()->formEnd() ?>

<?php endif ?>


<?php //EDIT?>

<?php if (osW_Settings::getInstance()->getAction()=='edit'): ?>

	<?php

	osW_Template::getInstance()->addJSCodeHead('
run=true;

function checkDMM3() {
	if (run===true) {
		url="'.osW_Template::getInstance()->buildhrefLink('current', $this->getDirectParameters($ddm_group)).'";
		$.post(url, {
			action: "dolock",
			'.$this->getGroupOption($ddm_group, 'index', 'database').': "'.$this->getIndexElementStorage($ddm_group).'"
		}, function(data){});
		setTimeout(checkDMM3, 5000);
	}
}

$(function() {
	checkDMM3();
});

');

	?>

	<?php echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), ['form_parameter'=>'enctype="multipart/form-data"']) ?>

	<table class="table_ddm table_ddm_form table_ddm_edit">

		<?php if ($this->setLock($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))!==true): ?>
			<tr class="table_ddm_row table_ddm_row_navigation ddm_element_lock_error">
				<td class="table_ddm_col" colspan="2"><span style="color:red; font-weight:bold;">
		<?php echo h()->_setText($this->getGroupMessage($ddm_group, 'lock_error'), ['user'=>$this->getLockUser($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))]) ?>
	</span></td>
			</tr>
		<?php endif ?>

		<?php foreach ($this->getEditElements($ddm_group) as $element=>$options): ?><?php echo $this->parseFormEditElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

	</table>

	<?php echo osW_Form::getInstance()->drawHiddenField('action', 'doedit') ?><?php echo osW_Form::getInstance()->drawHiddenField($this->getGroupOption($ddm_group, 'index', 'database'), $this->getIndexElementStorage($ddm_group)) ?><?php echo osW_Form::getInstance()->formEnd() ?>

<?php endif ?>


<?php //DELETE?>

<?php if (osW_Settings::getInstance()->getAction()=='delete'): ?>

	<?php

	osW_Template::getInstance()->addJSCodeHead('
run=true;

function checkDMM3() {
	if (run===true) {
		url="'.osW_Template::getInstance()->buildhrefLink('current', $this->getDirectParameters($ddm_group)).'";
		$.post(url, {
			action: "dolock",
			'.$this->getGroupOption($ddm_group, 'index', 'database').': "'.$this->getIndexElementStorage($ddm_group).'"
		}, function(data){});
		setTimeout(checkDMM3, 5000);
	}
}

$(function() {
	checkDMM3();
});

');

	?>

	<?php echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), ['form_parameter'=>'enctype="multipart/form-data"']) ?>

	<table class="table_ddm table_ddm_form table_ddm_delete">

		<?php if ($this->setLock($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))!==true): ?>
			<tr class="table_ddm_row table_ddm_row_navigation ddm_element_lock_error">
				<td class="table_ddm_col" colspan="2"><span style="color:red; font-weight:bold;">
		<?php echo h()->_setText($this->getGroupMessage($ddm_group, 'lock_error'), ['user'=>$this->getLockUser($ddm_group, h()->_catch($this->getGroupOption($ddm_group, 'index', 'database')))]) ?>
	</span></td>
			</tr>
		<?php endif ?>

		<?php foreach ($this->getDeleteElements($ddm_group) as $element=>$options): ?><?php echo $this->parseFormDeleteElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

	</table>

	<?php echo osW_Form::getInstance()->drawHiddenField('action', 'dodelete') ?><?php echo osW_Form::getInstance()->drawHiddenField($this->getGroupOption($ddm_group, 'index', 'database'), $this->getIndexElementStorage($ddm_group)) ?><?php echo osW_Form::getInstance()->formEnd() ?>

<?php endif ?>


<?php //DATA ?>

<?php if (osW_Settings::getInstance()->getAction()==''): ?>

	<?php if ($this->getPreViewElements($ddm_group)!=[]): ?>

		<table class="table_ddm table_ddm_view">

			<?php foreach ($this->getPreViewElements($ddm_group) as $element=>$options): ?><?php echo $this->parseViewElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

		</table>

	<?php endif ?>

	<?php if ($this->getParameter($ddm_group, 'ddm_search')==1): ?>

		<?php echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group)) ?>

		<table class="table_ddm table_ddm_form table_ddm_search">

			<?php foreach ($this->getSearchElements($ddm_group) as $element=>$options): ?><?php echo $this->parseFormSearchElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

		</table>

		<?php echo osW_Form::getInstance()->drawHiddenField('ddm_search', '1') ?><?php echo osW_Form::getInstance()->formEnd() ?>

	<?php endif ?>

	<?php if ($this->getViewElements($ddm_group)!=[]): ?>

		<table class="table_ddm table_ddm_view">

			<?php foreach ($this->getViewElements($ddm_group) as $element=>$options): ?><?php echo $this->parseViewElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

		</table>

	<?php endif ?>

<?php endif ?>