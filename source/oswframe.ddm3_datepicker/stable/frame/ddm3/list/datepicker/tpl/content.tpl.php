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
	<?php if (($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name'))=='')||($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name'))=='00000000')): ?>
		---
	<?php else: ?><?php if ($this->getListElementOption($ddm_group, $element, 'month_asname')===true): ?><?php echo strftime(str_replace('%m.', ' %B ', $this->getListElementOption($ddm_group, $element, 'date_format')), mktime(12, 0, 0, substr($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name')), 4, 2), substr($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name')), 6, 2), substr($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name')), 0, 4))) ?><?php else: ?><?php echo strftime($this->getListElementOption($ddm_group, $element, 'date_format'), mktime(12, 0, 0, substr($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name')), 4, 2), substr($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name')), 6, 2), substr($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name')), 0, 4))) ?><?php endif ?><?php endif ?>
</td>