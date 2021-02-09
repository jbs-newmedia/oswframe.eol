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

<?php if (osW_Settings::getInstance()->getAction()!='log'):?>
<?php if(($this->getCounter($ddm_group, 'add_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_add')!==true)&&($this->getCounter($ddm_group, 'search_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_search')!==true)):?>
<?php if(($this->getCounter($ddm_group, 'add_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_add')!==true)):?>
<a class="btn btn-default float-left" onclick="openDDM4Modal_<?php echo $ddm_group?>(this, '<?php echo $this->getGroupOption($ddm_group, 'add_title', 'messages')?>', 'add', <?php echo $this->getCounter($ddm_group, 'add_elements')?>)" title="<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'data_add'))?>" pageName="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=add&modal=1&'.$this->getDirectParameters($ddm_group))?>"><i class="fa fa-plus fa-fw"></i> <?php echo $this->getGroupOption($ddm_group, 'add_title', 'messages')?></a>
<?php endif?>
<?php if(($this->getCounter($ddm_group, 'search_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_search')!==true)):?>
<a id="ddm4_button_search_edit"<?php if($this->getParameter($ddm_group, 'ddm_search_data')==array()):?> style="display:none;"<?php endif?> class="btn btn-default float-right" onclick="openDDM4Modal_<?php echo $ddm_group?>(this, '<?php echo $this->getGroupOption($ddm_group, 'search_title', 'messages')?>', 'search_edit', <?php echo $this->getCounter($ddm_group, 'search_elements')?>)" title="<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'data_search'))?>" pageName="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=search&modal=1&'.$this->getDirectParameters($ddm_group))?>"><i class="fa fa-search fa-fw"></i> <?php echo $this->getGroupOption($ddm_group, 'edit_search_title', 'messages')?></a>
<a id="ddm4_button_search_submit"<?php if($this->getParameter($ddm_group, 'ddm_search_data')!=array()):?> style="display:none;"<?php endif?> class="btn btn-default float-right" onclick="openDDM4Modal_<?php echo $ddm_group?>(this, '<?php echo $this->getGroupOption($ddm_group, 'search_title', 'messages')?>', 'search', <?php echo $this->getCounter($ddm_group, 'search_elements')?>)" title="<?php echo h()->_outputString($this->getGroupMessage($ddm_group, 'data_search'))?>" pageName="<?php echo osW_Template::getInstance()->buildhrefLink($this->getDirectModule($ddm_group), 'action=search&modal=1&'.$this->getDirectParameters($ddm_group))?>"><i class="fa fa-search fa-fw"></i> <?php echo $this->getGroupOption($ddm_group, 'search_title', 'messages')?></a>
<?php endif?>
<div class="clearfix"></div><br/>
<?php endif?>
<?php endif?>

<table id="ddm4_datatables_<?php echo $ddm_group?>" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
<?php if($this->getCounter($ddm_group, 'list_view_elements')):?>
	<thead>
		<tr class="ddm_element_<?php echo $this->getViewElementValue($ddm_group, $element, 'id')?>">
<?php
foreach ($this->getListElements($ddm_group) as $element => $options) {
	$file=vOut('settings_abspath').'frame/ddm4/list/'.$options['module'].'/tpl/header.tpl.php';
	if (file_exists($file)) {
		include $file;
	}
}
?>
		</tr>
	</thead>
<?php endif?>
</table>