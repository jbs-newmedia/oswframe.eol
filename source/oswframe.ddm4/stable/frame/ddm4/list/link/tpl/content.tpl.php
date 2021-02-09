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

$__link=$this->getListElementOption($ddm_group, $element, 'link');

$_link='<a'.((isset($__link['target'])) ? ' target="'.$__link['target'].'"' : '').' href="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module'])) ? $__link['module'] : $this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')).((isset($__link['parameter'])) ? '&'.$__link['parameter'] : '')).'">'.(h()->_outputString($this->getListStorageValue($ddm_group, $this->getListElementValue($ddm_group, $element, 'name')))).'</a>';

?>

<td class="table_ddm_col table_ddm_col_data ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id')?>">
	<?php echo $_link;?>
</td>