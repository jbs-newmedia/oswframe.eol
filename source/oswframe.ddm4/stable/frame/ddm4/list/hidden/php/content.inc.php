<?php

if ((isset($options['name']))&&($options['name']!='')) {
	$_columns[$options['name']]=array(
		'name'=>$options['name'],
		'order'=>false,
		'search'=>false,
		'hidden'=>true,
	);
}

$this->incCounter($ddm_group, 'list_view_elements');

?>