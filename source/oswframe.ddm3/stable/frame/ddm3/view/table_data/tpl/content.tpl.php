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

if (($status_keys=$this->getGroupOption($ddm_group, 'status_keys'))!='') {
	if (!is_array($status_keys)) {
		$status_keys=[];
	}
}

?>

<?php if ($this->getCounter($ddm_group, 'storage_view_elements')>0): ?>

	<?php foreach ($this->ddm[$ddm_group]['storage']['view']['data'] as $data): ?><?php
		$class_add=[];
		if ((is_array($status_keys))&&($status_keys!=[])) {
			foreach ($status_keys as $key=>$value) {
				if (isset($data[$key])) {
					$class_add[]='ddm_element_'.$value.$data[$key];
				}
			}
		}
		$class_add=' '.implode(' ', $class_add);
		?>

		<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id') ?><?php echo $class_add ?>">

			<?php foreach ($this->getListElements($ddm_group) as $_element=>$options): ?><?php $this->setListStorageValues($ddm_group, $data) ?><?php echo $this->parseListElementTPL($ddm_group, $_element, $options) ?><?php endforeach ?>

		</tr>

	<?php endforeach ?>

<?php else: ?>

	<tr class="table_ddm_row table_ddm_row_data <?php echo osW_Template::getInstance()->getColorClass('table_ddm_rows', ['table_ddm_row_cella', 'table_ddm_row_cellb']) ?> ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id') ?>">
		<td class="table_ddm_col table_ddm_col_data" colspan="<?php echo $this->getCounter($ddm_group, 'list_view_elements') ?>">
			<?php echo $this->getGroupMessage($ddm_group, 'data_noresults') ?>
		</td>
	</tr>

<?php endif ?>