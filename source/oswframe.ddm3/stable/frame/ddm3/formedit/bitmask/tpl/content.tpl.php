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

<?php
$class=osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']);
?>

<?php if ($this->getEditElementOption($ddm_group, $element, 'ajax_enabled')===true): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php echo $class ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<td <?php if ($this->getEditElementOption($ddm_group, $element, 'notice')!=''): ?>rowspan="3" <?php else: ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getEditElementValue($ddm_group, $element, 'title')) ?><?php if ($this->getEditElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<ul class="table_ddm_list table_ddm_list_horizontal">
				<li class="table_ddm_list_element">
					<div><?php echo $this->getGroupMessage($ddm_group, 'text_search') ?>: <?php echo osW_Form::getInstance()->drawTextField('ddm_chk_search_'.$element, '', []) ?></div>
				</li>
				<li class="table_ddm_list_element">
					<div><?php echo $this->getGroupMessage($ddm_group, 'text_filter') ?>: <?php echo osW_Form::getInstance()->drawSelectField('ddm_chk_filter_'.$element, ['0'=>$this->getGroupMessage($ddm_group, 'text_all'), '1'=>$this->getGroupMessage($ddm_group, 'text_selected'), '2'=>$this->getGroupMessage($ddm_group, 'text_notselected')], $this->getEditElementOption($ddm_group, $element, 'default_filter'), []) ?></div>
				</li>
				<li class="table_ddm_list_element">
					<div><?php echo $this->getGroupMessage($ddm_group, 'text_action') ?>: <?php echo osW_Form::getInstance()->drawSelectField('ddm_chk_action_'.$element, ['0'=>$this->getGroupMessage($ddm_group, 'text_none'), '1'=>$this->getGroupMessage($ddm_group, 'text_selectall'), '2'=>$this->getGroupMessage($ddm_group, 'text_deselectall'), '3'=>$this->getGroupMessage($ddm_group, 'text_invertselection')], 0, []) ?></div>
				</li>
			</ul>
			<script>
				function ddm_chk_fuction_<?php echo $element?>(f) {
					var search = $('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> #ddm_chk_search_<?php echo $element?>').val().toLowerCase();
					var filter = $('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> #ddm_chk_filter_<?php echo $element?>').val();
					var action = $('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> #ddm_chk_action_<?php echo $element?>').val();

					if ((f == 'search') || (f == 'filter')) {
						$('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> input[id^="<?php echo $element?>"]').each(function (i, elem) {
							if (filter == 1) {
								if ($(this).prop('checked') == true) {
									$(this).closest('li').show();
									if ((search != '') && ($(this).attr("title").toLowerCase().indexOf(search) == -1)) {
										$(this).closest('li').hide();
									}
								} else {
									$(this).closest('li').hide();
								}
							}
							if (filter == 2) {
								if ($(this).prop('checked') !== true) {
									$(this).closest('li').show();
									if ((search != '') && ($(this).attr("title").toLowerCase().indexOf(search) == -1)) {
										$(this).closest('li').hide();
									}
								} else {
									$(this).closest('li').hide();
								}
							}
							if (filter == 0) {
								$(this).closest('li').show();
								if ((search != '') && ($(this).attr("title").toLowerCase().indexOf(search) == -1)) {
									$(this).closest('li').hide();
								}
							}
						});
					}

					if (f == 'action') {
						$('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> input[id^="<?php echo $element?>"]').each(function (i, elem) {
							if (action == 1) {
								if ($(this).prop('checked') !== true) {
									$(this).prop('checked', true);
								}
							}
							if (action == 2) {
								if ($(this).prop('checked') == true) {
									$(this).prop('checked', false);
								}
							}
							if (action == 3) {
								if ($(this).prop('checked') == true) {
									$(this).prop('checked', false);
								} else {
									$(this).prop('checked', true);
								}
							}
							$('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> #ddm_chk_action_<?php echo $element?>').val(0)
						});
					}
				}

				$(function () {
					$('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> #ddm_chk_search_<?php echo $element?>').on('keyup', function () {
						ddm_chk_fuction_<?php echo $element?>('search');
						console.log('ddm_chk_fuction_<?php echo $element?>(search)');
					});
					$('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> #ddm_chk_filter_<?php echo $element?>').on("change", function () {
						ddm_chk_fuction_<?php echo $element?>('filter');
					});
					$('.ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?> #ddm_chk_action_<?php echo $element?>').on("change", function () {
						ddm_chk_fuction_<?php echo $element?>('action');
					});
					ddm_chk_fuction_<?php echo $element?>('search');
				});
			</script>
		</td>
	</tr>
<?php endif ?>

	<tr class="table_ddm_row table_ddm_row_data <?php echo $class ?> <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<?php if ($this->getEditElementOption($ddm_group, $element, 'ajax_enabled')!==true): ?>
			<td <?php if ($this->getEditElementOption($ddm_group, $element, 'notice')!=''): ?>rowspan="2"<?php endif ?> class="table_ddm_col table_ddm_col_data table_ddm_col_title"><?php echo h()->outputString($this->getEditElementValue($ddm_group, $element, 'title')) ?><?php if ($this->getEditElementOption($ddm_group, $element, 'required')===true): ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon') ?><?php endif ?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer') ?></td>
		<?php endif ?>
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_form">
			<?php $bitmask=$this->getEditElementStorage($ddm_group, $element) ?>
			<ul class="table_ddm_list <?php if ($this->getEditElementOption($ddm_group, $element, 'orientation')=='horizontal'): ?><?php echo ' table_ddm_list_horizontal' ?><?php else: ?><?php echo 'table_ddm_list_vertical' ?><?php endif ?>">
				<?php foreach ($this->getEditElementOption($ddm_group, $element, 'data') as $key=>$value): ?>
					<li>
						<?php if ($this->getEditElementOption($ddm_group, $element, 'read_only')===true): ?><?php if ((isset($bitmask[$key]))&&($bitmask[$key]==1)): ?><?php echo '✔ '.h()->_outputString($value) ?><?php echo osW_Form::getInstance()->drawHiddenField($element.'_'.$key, 1, []) ?><?php else: ?><?php echo '✘ '.h()->_outputString($value) ?><?php echo osW_Form::getInstance()->drawHiddenField($element.'_'.$key, 0, []) ?><?php endif ?><?php else: ?><?php if (isset($bitmask[$key])): ?><?php echo osW_Form::getInstance()->drawCheckboxField($element.'_'.$key, '1', $bitmask[$key], ['input_parameter'=>'title="'.h()->_outputString($value).'"']) ?><?php echo h()->_outputString($value) ?><?php else: ?><?php echo osW_Form::getInstance()->drawCheckboxField($element.'_'.$key, '1', 0, ['input_parameter'=>'title="'.h()->_outputString($value).'"']) ?><?php echo h()->_outputString($value) ?><?php endif ?><?php endif ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</td>
	</tr>

<?php if ($this->getEditElementOption($ddm_group, $element, 'notice')!=''): ?>
	<tr class="table_ddm_row table_ddm_row_data <?php if (osW_Form::getInstance()->getFormError($element)===true): ?>table_ddm_row_error<?php endif ?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id') ?> ">
		<td class="table_ddm_col table_ddm_col_data table_ddm_col_notice">
			<?php echo h()->outputString($this->getEditElementOption($ddm_group, $element, 'notice')) ?>
		</td>
	</tr>
<?php endif ?>