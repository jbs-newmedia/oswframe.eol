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

<tr class="table_ddm_row table_ddm_row_sortorder ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id') ?>">
	<td class="table_ddm_col" colspan="<?php echo $this->getCounter($ddm_group, 'list_view_elements') ?>">
		<ul class="table_ddm_list table_ddm_list_horizontal">
			<li><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'sortorder_title')) ?><?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_closer')) ?></li>

			<?php if (is_array($this->getParameter($ddm_group, 'ddm_order'))): ?><?php foreach ($this->getParameter($ddm_group, 'ddm_order') as $key=>$order): ?>
				<li>
					<?php
					$key=explode('.', $key);
					$alias=$key[0];
					$element=$key[1];
					$title=$this->getOrderElementName($ddm_group, $element);
					if ($title=='') {
						$title=$this->getListElementValue($ddm_group, $element, 'title');
					}
					?>

					<?php echo h()->_outputString($title) ?> <?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_'.strtolower($order).'_icon')) ?>

					<a title="<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_sortorder_delete')) ?>" href="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'ddm_order='.$alias.'.'.$element.'__remove&'.$this->getDirectParameters($ddm_group)) ?>">
						<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'form_title_cancel_icon')) ?>
					</a>
				</li>
			<?php endforeach ?><?php endif ?>
		</ul>
	</td>
</tr>