<?php

$view=false;

if (($this->getCounter($ddm_group, 'edit_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_edit')!==true)) {
	$view=true;
}

if (($this->getCounter($ddm_group, 'delete_elements')>0)&&($this->getListElementOption($ddm_group, $element, 'disable_delete')!==true)) {
	$view=true;
}

if (($this->getGroupOption($ddm_group, 'enable_log')===true)&&($this->getListElementOption($ddm_group, $element, 'disable_log')!==true)) {
	$view=true;
}

if (is_array($this->getListElementOption($ddm_group, $element, 'links'))) {
	$view=true;
}

if ($view===true) {
	$this->incCounter($ddm_group, 'list_view_elements');
}

?>