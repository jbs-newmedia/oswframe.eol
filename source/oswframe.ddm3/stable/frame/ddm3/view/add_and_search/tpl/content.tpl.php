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

<?php if (($this->getCounter($ddm_group, 'add_elements')>0)||(($this->getCounter($ddm_group, 'storage_view_elements')>0)&&($this->getCounter($ddm_group, 'search_elements')>0))): ?>
	<tr class="table_ddm_row table_ddm_row_line ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id') ?>">
		<td class="table_ddm_col" colspan="<?php echo $this->getCounter($ddm_group, 'list_view_elements') ?>">
			<?php if ($this->getCounter($ddm_group, 'add_elements')>0): ?>
				<span class="left"><a href="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=add&'.$this->getDirectParameters($ddm_group)) ?>"><?php echo $this->getGroupMessage($ddm_group, 'add_title') ?></a></span>
			<?php endif ?>
			<?php if (($this->getCounter($ddm_group, 'storage_view_elements')>0)&&($this->getCounter($ddm_group, 'search_elements')>0)): ?>
				<span class="right"><a href="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'ddm_search=1&'.$this->getDirectParameters($ddm_group)) ?>"><?php echo $this->getGroupMessage($ddm_group, 'search_title') ?></a></span>
			<?php endif ?>
		</td>
	</tr>
<?php endif ?>