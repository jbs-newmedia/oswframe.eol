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

<div class="form-group<?php if(osW_Form::getInstance()->getFormError($element)):?> has-error<?php endif?> ddm_element_<?php echo $this->getSendElementValue($ddm_group, $element, 'id')?>">
	<label for="<?php echo $element?>" class="control-label"><?php echo h()->outputString($this->getSendElementValue($ddm_group, $element, 'title'))?><?php if($this->getSendElementOption($ddm_group, $element, 'required')===true):?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon')?><?php endif?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer')?></label>
	<?php if($this->getSendElementOption($ddm_group, $element, 'read_only')===true):?>
		<?php echo osW_Form::getInstance()->drawHiddenField($element, $this->getSendElementStorage($ddm_group, $element), array())?>
		<div class="form-control readonly" style="height:auto;">
<?php if($this->getDoSendElementStorage($ddm_group, $element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix'))!=''):?>
<a target="_blank" href="<?php echo $this->getDoSendElementStorage($ddm_group, $element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix'))?>"><?php echo h()->_outputString($this->getSendElementOption($ddm_group, $element, 'text_file_view'))?></a><br/>
<?php endif?>
</div>
	<?php else:?>
<?php if($this->getDoSendElementStorage($ddm_group, $element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix'))!=''):?>
<a target="_blank" href="<?php echo $this->getDoSendElementStorage($ddm_group, $element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix'))?>"><?php echo h()->_outputString($this->getSendElementOption($ddm_group, $element, 'text_file_view'))?></a><br/>
<?php osW_Form::getInstance()->drawHiddenField($element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix'), $this->getDoSendElementStorage($ddm_group, $element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix')))?>
<?php osW_Form::getInstance()->drawHiddenField($element, $this->getDoSendElementStorage($ddm_group, $element))?>
<?php endif?>

<?php echo osW_Form::getInstance()->drawFileField($element, $this->getSendElementStorage($ddm_group, $element), array())?>

<?php if($this->getDoSendElementStorage($ddm_group, $element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix'))!=''):?>
<br/><?php echo osW_Form::getInstance()->drawCheckboxField($element.$this->getSendElementOption($ddm_group, $element, 'temp_suffix').$this->getSendElementOption($ddm_group, $element, 'delete_suffix'), 1, 0, array())?> <?php echo h()->_outputString($this->getSendElementOption($ddm_group, $element, 'text_file_delete'))?><br/>
<?php endif?>
	<?php endif?>
	<?php if(osW_Form::getInstance()->getFormError($element)):?>
		<span class="help-block"><?php echo osW_Form::getInstance()->getFormErrorMessage($element)?></span>
	<?php elseif($this->getSendElementOption($ddm_group, $element, 'notice')!=''):?>
		<span class="help-block"><?php echo h()->outputString($this->getSendElementOption($ddm_group, $element, 'notice'))?></span>
	<?php endif?>
	<?php if($this->getSendElementOption($ddm_group, $element, 'buttons')!=''):?>
		<div class="button-group">
		<?php echo implode(' ', $this->getSendElementOption($ddm_group, $element, 'buttons'))?>
		</div>
	<?php endif?>
</div>