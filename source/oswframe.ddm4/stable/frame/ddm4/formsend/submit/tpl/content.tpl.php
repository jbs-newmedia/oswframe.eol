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
	<?php echo osW_Form::getInstance()->drawSubmit('btn_ddm_submit', $this->getGroupMessage($ddm_group, 'form_send'), array('input_class'=>'btn btn-primary'))?>
	<?php echo osW_Form::getInstance()->drawReset('btn_ddm_reset', $this->getGroupMessage($ddm_group, 'form_reset'), array('input_class'=>'btn btn-default'))?>
</div>