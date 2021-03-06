<?php

/*
 * Author: Juergen Schwind
 * Copyright: 2011 Juergen Schwind
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

<td class="table_ddm_col table_ddm_col_data ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id') ?>">
	<?php echo h()->_outputString($this->getListElementValue($ddm_group, $element, 'title')) ?>
	<?php if ($this->getListElementOption($ddm_group, $element, 'order')==true): ?><?php if ($this->getParameter($ddm_group, 'ddm_order_last')==$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'__asc'): ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_sort_spacer')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_asc_icon')) ?><?php else: ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_sort_spacer')) ?>
		<a title="<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_asc')) ?>" href="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'ddm_order='.$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'__asc&'.$this->getDirectParameters($ddm_group)) ?>">
			<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_asc_icon')) ?>
		</a>
	<?php endif ?><?php if ($this->getParameter($ddm_group, 'ddm_order_last')==$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'__desc'): ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_sort_spacer')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_desc_icon')) ?><?php else: ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_sort_spacer')) ?>
		<a title="<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_desc')) ?>" href="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'ddm_order='.$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.'__desc&'.$this->getDirectParameters($ddm_group)) ?>">
			<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_desc_icon')) ?>
		</a>
	<?php endif ?><?php endif ?>
</td>