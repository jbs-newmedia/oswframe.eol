<?php

$data=$this->getEditElementOption($ddm_group, $element_name, 'data');

if(isset($data[$value_old])) {
	$value_old=h()->_outputString($data[$value_old]);
}

if(isset($data[$value_new])) {
	$value_new=h()->_outputString($data[$value_new]);
}

?>