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

<tr class="table_ddm_row table_ddm_row_highlight table_ddm_row_pages ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id') ?>">
	<td class="table_ddm_col" colspan="<?php echo $this->getCounter($ddm_group, 'list_view_elements') ?>">
		<?php if ($this->getCounter($ddm_group, 'storage_view_elements')>0): ?>
			<div class="left">
				<?php echo osW_BuildPages::getInstance()->byLimitRows('current', $this->getDirectParameters($ddm_group), $this->ddm[$ddm_group]['storage']['view']['limitrows'], ['ddm_group'=>$ddm_group], 'ddm3') ?>
			</div>
			<div class="right">
				<ul class="table_ddm_list table_ddm_list_horizontal">
					<li><span>
			<?php if ($this->getCounter($ddm_group, 'storage_view_elements')>1): ?><?php echo h()->_setText($this->getGroupMessage($ddm_group, 'form_title_counter_multi'), ['elements_from'=>(1+(($this->ddm[$ddm_group]['storage']['view']['limitrows']['current_page_number']-1)*$this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows_per_page'])), 'elements_to'=>($this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows_on_page']+(($this->ddm[$ddm_group]['storage']['view']['limitrows']['current_page_number']-1)*$this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows_per_page'])), 'elements_all'=>($this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows'])]) ?><?php else: ?><?php echo h()->_setText($this->getGroupMessage($ddm_group, 'form_title_counter_single'), ['elements_from'=>(1+(($this->ddm[$ddm_group]['storage']['view']['limitrows']['current_page_number']-1)*$this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows_per_page'])), 'elements_to'=>($this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows_on_page']+(($this->ddm[$ddm_group]['storage']['view']['limitrows']['current_page_number']-1)*$this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows_per_page'])), 'elements_all'=>($this->ddm[$ddm_group]['storage']['view']['limitrows']['number_of_rows'])]) ?><?php endif ?>
					</span></li>
				</ul>
			</div>
		<?php else: ?>
			&nbsp;
		<?php endif ?>

	</td>
</tr>