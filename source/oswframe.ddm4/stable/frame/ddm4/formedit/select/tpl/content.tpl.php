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

<div class="form-group<?php if(osW_Form::getInstance()->getFormError($element)):?> has-error<?php endif?> ddm_element_<?php echo $this->getEditElementValue($ddm_group, $element, 'id')?>">
	<label<?php if($this->getEditElementOption($ddm_group, $element, 'read_only')!==true):?> for="<?php echo $element?>"<?php endif?> class="control-label"><?php echo h()->outputString($this->getEditElementValue($ddm_group, $element, 'title'))?><?php if($this->getEditElementOption($ddm_group, $element, 'required')===true):?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon')?><?php endif?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer')?></label>
	<?php if($this->getEditElementOption($ddm_group, $element, 'read_only')===true):?>
		<?php echo osW_Form::getInstance()->drawHiddenField($element, $this->getEditElementStorage($ddm_group, $element), array())?>
		<?php if($this->getEditElementOption($ddm_group, $element, 'blank_value')===true):?>
			<?php $data=array(''=>'')+$this->getEditElementOption($ddm_group, $element, 'data');?>
		<?php else:?>
			<?php $data=$this->getEditElementOption($ddm_group, $element, 'data');?>
		<?php endif?>
		<?php if(isset($data[$this->getEditElementStorage($ddm_group, $element)])):?>
			<div class="form-control readonly"><?php echo h()->_outputString($data[$this->getEditElementStorage($ddm_group, $element)])?></div>
		<?php else:?>
			<div class="form-control readonly">&nbsp;</div>
		<?php endif?>
	<?php else:?>
		<?php if($this->getEditElementOption($ddm_group, $element, 'blank_value')===true):?>
			<?php echo osW_Form::getInstance()->drawSelectField($element, array(''=>'')+$this->getEditElementOption($ddm_group, $element, 'data'), $this->getEditElementStorage($ddm_group, $element), array('input_class'=>'form-control selectpicker'))?>
		<?php else:?>
			<?php echo osW_Form::getInstance()->drawSelectField($element, $this->getEditElementOption($ddm_group, $element, 'data'), $this->getEditElementStorage($ddm_group, $element), array('input_class'=>'form-control selectpicker'))?>
		<?php endif?>
	<?php endif?>
	<?php if(osW_Form::getInstance()->getFormError($element)):?>
		<span class="help-block"><?php echo osW_Form::getInstance()->getFormErrorMessage($element)?></span>
	<?php elseif($this->getEditElementOption($ddm_group, $element, 'notice')!=''):?>
		<span class="help-block"><?php echo h()->outputString($this->getEditElementOption($ddm_group, $element, 'notice'))?></span>
	<?php endif?>
	<?php if($this->getEditElementOption($ddm_group, $element, 'buttons')!=''):?>
		<div class="button-group">
		<?php echo implode(' ', $this->getEditElementOption($ddm_group, $element, 'buttons'))?>
		</div>
	<?php endif?>
</div>