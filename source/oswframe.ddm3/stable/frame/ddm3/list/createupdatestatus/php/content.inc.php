<?php

$this->setOrderElementName($ddm_group, $this->getEditElementOption($ddm_group, $element, 'prefix').'create_time', $this->getEditElementOption($ddm_group, $element, 'text_create_time'));
$this->incCounter($ddm_group, 'list_view_elements');
$this->setOrderElementName($ddm_group, $this->getEditElementOption($ddm_group, $element, 'prefix').'create_user_id', $this->getEditElementOption($ddm_group, $element, 'text_create_user'));
$this->incCounter($ddm_group, 'list_view_elements');

$this->setOrderElementName($ddm_group, $this->getEditElementOption($ddm_group, $element, 'prefix').'update_time', $this->getEditElementOption($ddm_group, $element, 'text_update_time'));
$this->incCounter($ddm_group, 'list_view_elements');
$this->setOrderElementName($ddm_group, $this->getEditElementOption($ddm_group, $element, 'prefix').'update_user_id', $this->getEditElementOption($ddm_group, $element, 'text_update_user'));
$this->incCounter($ddm_group, 'list_view_elements');

?>