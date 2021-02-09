<?php

if($value_old==1) {
	$value_old=h()->_outputString($this->getEditElementOption($ddm_group, $element_name, 'text_yes'));
} else {
	$value_old=h()->_outputString($this->getEditElementOption($ddm_group, $element_name, 'text_no'));
}

if($value_new==1) {
	$value_new=h()->_outputString($this->getEditElementOption($ddm_group, $element_name, 'text_yes'));
} else {
	$value_new=h()->_outputString($this->getEditElementOption($ddm_group, $element_name, 'text_no'));
}

?>