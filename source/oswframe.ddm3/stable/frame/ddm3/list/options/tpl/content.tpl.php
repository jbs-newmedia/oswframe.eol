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

$_links=[];

if (is_array($this->getListElementOption($ddm_group, $element, 'links_before'))) {
	foreach ($this->getListElementOption($ddm_group, $element, 'links_before') as $__link) {
		$_links[]='<a'.((isset($__link['target']))?' target="'.$__link['target'].'"':'').' href="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module']))?$__link['module']:$this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')).((($__link['parameter']))?'&'.$__link['parameter']:'')).'">'.((($__link['text']))?h()->_outputString($__link['text']):'undefined').'</a>';
	}
}

if (($this->getCounter($ddm_group, 'edit_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_edit')!==true)) {
	$_links[]='<a href="'.osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=edit&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')).'&'.$this->getDirectParameters($ddm_group)).'">'.$this->getGroupMessage($ddm_group, 'data_edit').'</a>';
}

if (($this->getCounter($ddm_group, 'delete_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_delete')!==true)) {
	$_links[]='<a href="'.osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=delete&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')).'&'.$this->getDirectParameters($ddm_group)).'">'.$this->getGroupMessage($ddm_group, 'data_delete').'</a>';
}

if (($this->getGroupOption($ddm_group, 'enable_log')===true)&&($this->getListElementOption($ddm_group, $element, 'disable_log')!==true)) {
	$_links[]='<a target="_blank" href="'.osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=log&'.$this->getGroupOption($ddm_group, 'index', 'database').'='.$this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')).'&'.$this->getDirectParameters($ddm_group)).'">'.$this->getGroupMessage($ddm_group, 'data_log').'</a>';
}

if (is_array($this->getListElementOption($ddm_group, $element, 'links'))) {
	foreach ($this->getListElementOption($ddm_group, $element, 'links') as $__link) {
		$_links[]='<a'.((isset($__link['target']))?' target="'.$__link['target'].'"':'').' href="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module']))?$__link['module']:$this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')).((($__link['parameter']))?'&'.$__link['parameter']:'')).'">'.((($__link['text']))?h()->_outputString($__link['text']):'undefined').'</a>';
	}
}

if (is_array($this->getListElementOption($ddm_group, $element, 'links_after'))) {
	foreach ($this->getListElementOption($ddm_group, $element, 'links_after') as $__link) {
		$_links[]='<a'.((isset($__link['target']))?' target="'.$__link['target'].'"':'').' href="'.osW_Template::getInstance()->buildhrefLink(((isset($__link['module']))?$__link['module']:$this->getDirectModule($ddm_group)), $this->getGroupOption($ddm_group, 'index', 'database').'='.$this->getListStorageValue($ddm_group, $this->getGroupOption($ddm_group, 'index', 'database')).((($__link['parameter']))?'&'.$__link['parameter']:'')).'">'.((($__link['text']))?h()->_outputString($__link['text']):'undefined').'</a>';
	}
}

?>

<?php if ($_links!=[]): ?>
	<td class="table_ddm_col table_ddm_col_data ddm_element_<?php echo $this->getListElementValue($ddm_group, $element, 'id') ?>">
		<?php echo implode(' | ', $_links) ?>
	</td>
<?php endif ?>