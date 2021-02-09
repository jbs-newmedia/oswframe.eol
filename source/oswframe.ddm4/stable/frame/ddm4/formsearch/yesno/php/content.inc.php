<?php

$this->incCounter($ddm_group, 'form_elements');
$this->incCounter($ddm_group, 'form_elements_required');

if ($this->getSearchElementStorage($ddm_group, $element)=='') {
	$this->setSearchElementStorage($ddm_group, $element, '%');
}

?>