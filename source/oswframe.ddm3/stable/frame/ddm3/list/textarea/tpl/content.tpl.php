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
	<?php if ($this->getListElementOption($ddm_group, $element, 'show_output')===true): ?><?php echo h()->_outputString($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name'))) ?><?php else: ?>
<?php if ($this->getListElementOption($ddm_group, $element, 'show_dialog')===true): ?>
	<span class="ddm_tooltip_<?php echo $this->getListElementValue($ddm_group, $element, 'id') ?>_<?php echo $this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')); ?>" title="">
<?php endif ?><?php $count=strlen($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name'))); ?><?php if ($count==1): ?><?php echo strlen($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name'))); ?><?php echo h()->_outputString($this->getListElementOption($ddm_group, $element, 'text_char')) ?><?php else: ?><?php echo strlen($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name'))); ?><?php echo h()->_outputString($this->getListElementOption($ddm_group, $element, 'text_chars')) ?><?php endif ?><?php endif ?><?php if ($this->getListElementOption($ddm_group, $element, 'show_dialog')===true): ?>
</span>
	<span style="display:none;" class="ddm_tooltip_<?php echo $this->getListElementValue($ddm_group, $element, 'id') ?>_<?php echo $this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')); ?>_content"><?php echo h()->_outputString($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name'))) ?></span>
	<script>
		$(function () {
			$(".ddm_tooltip_<?php echo $this->getListElementValue($ddm_group, $element, 'id')?>_<?php echo $this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database'));?>").tooltip({
				open: function (event, ui) {
					ui.tooltip.css("max-width", "800px");
				},
				content: function () {
					return $(".ddm_tooltip_<?php echo $this->getListElementValue($ddm_group, $element, 'id')?>_<?php echo $this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database'));?>_content").html();
				}
			});
		});
	</script>

<?php endif ?>
</td>