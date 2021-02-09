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

<?php if ($this->getCounter($ddm_group, 'list_view_elements')): ?>

	<tr class="table_ddm_row table_ddm_row_highlight table_ddm_row_header ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id') ?>">

		<?php foreach ($this->getListElements($ddm_group) as $element=>$options): ?><?php echo $this->parseListHeaderElementTPL($ddm_group, $element, $options) ?><?php endforeach ?>

	</tr>

<?php endif ?>