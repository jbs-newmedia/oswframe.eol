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

<div class="form-group<?php if(osW_Form::getInstance()->getFormError($element)):?> has-error<?php endif?> ddm_element_<?php echo $this->getDeleteElementValue($ddm_group, $element, 'id')?>">
	<label class="control-label"><?php echo h()->outputString($this->getDeleteElementValue($ddm_group, $element, 'title'))?><?php if($this->getDeleteElementOption($ddm_group, $element, 'required')===true):?><?php echo $this->getGroupMessage($ddm_group, 'form_title_required_icon')?><?php endif?><?php echo $this->getGroupMessage($ddm_group, 'form_title_closer')?></label>
		<?php $bitmask=$this->getDeleteElementStorage($ddm_group, $element);?>
		<?php $c=count($this->getDeleteElementOption($ddm_group, $element, 'data'))?>
		<?php $i=0;foreach($this->getDeleteElementOption($ddm_group, $element, 'data') as $key => $value):$i++;?>
			<div class="checkbox<?php if($i==1):?> ddm4-checkbox-first<?php endif?><?php if($i==$c):?> ddm4-checkbox-last<?php endif?>">
			<label class="ddm4-label-readonly">
			<?php if((isset($bitmask[$key]))&&($bitmask[$key]==1)):?>
				<?php echo '✔ '.h()->_outputString($value)?>
			<?php else:?>
				<?php echo '✘ '.h()->_outputString($value)?>
			<?php endif?>
			</label>
			<?php echo osW_Form::getInstance()->drawHiddenField($element.'_'.$key, $bitmask[$key], array())?>
			</div>
		<?php endforeach?>
	<?php if(osW_Form::getInstance()->getFormError($element)):?>
		<span class="help-block"><?php echo osW_Form::getInstance()->getFormErrorMessage($element)?></span>
	<?php elseif($this->getDeleteElementOption($ddm_group, $element, 'notice')!=''):?>
		<span class="help-block"><?php echo h()->outputString($this->getDeleteElementOption($ddm_group, $element, 'notice'))?></span>
	<?php endif?>
	<?php if($this->getDeleteElementOption($ddm_group, $element, 'buttons')!=''):?>
		<div class="button-group">
		<?php echo implode(' ', $this->getDeleteElementOption($ddm_group, $element, 'buttons'))?>
		</div>
	<?php endif?>
</div>