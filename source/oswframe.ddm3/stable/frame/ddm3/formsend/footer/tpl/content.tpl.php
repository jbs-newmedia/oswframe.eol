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

<tr class="table_ddm_row table_ddm_row_highlight table_ddm_row_footer ddm_element_<?php echo $this->getSendElementValue($ddm_group, $element, 'id') ?>">
	<td class="table_ddm_col table_ddm_col_data" colspan="2">
		<?php echo h()->outputString($this->getSendElementValue($ddm_group, $element, 'title')) ?>
	</td>
</tr>