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


<?php //Send ?>

<?php if (osW_Settings::getInstance()->getAction()=='send'): ?>

	<?php echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), ['form_parameter'=>'enctype="multipart/form-data"']) ?>

	<table class="table_ddm table_ddm_form table_ddm_send">

		<?php foreach ($this->getSendElements($ddm_group) as $element=>$options): ?><?php echo $this->parseFormSendElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

	</table>

	<?php echo osW_Form::getInstance()->drawHiddenField('action', 'dosend') ?><?php echo osW_Form::getInstance()->formEnd() ?>

<?php endif ?>