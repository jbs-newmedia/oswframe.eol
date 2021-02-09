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

<?php

$view=false;

if (($this->getCounter($ddm_group, 'edit_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_edit')!==true)) {
	$view=true;
}

if (($this->getCounter($ddm_group, 'delete_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_delete')!==true)) {
	$view=true;
}

if (is_array($this->getListElementOption($ddm_group, $element, 'links'))) {
	$view=true;
}
?>

<?php if ($view===true):?>
<th class="ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id')?>">
	<div style="text-align:center;"><?php echo h()->_outputString($this->getListElementValue($ddm_group, $element, 'title'))?></div>
</th>
<?php endif?>