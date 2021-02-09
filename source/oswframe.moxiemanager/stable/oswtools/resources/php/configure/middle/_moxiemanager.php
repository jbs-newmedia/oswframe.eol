<?php

$this->data['settings']=array();

$this->data['settings']['data']=array(
	'page_title'=>'MoxieManager Settings',
);

$this->data['settings']['fields']['moxiemanager_license']=array(
	'default_name'=>'License',
	'default_type'=>'text',
	'default_value'=>'',
	'valid_type'=>'string',
	'valid_min_length'=>39,
	'valid_max_length'=>39,
	'configure_write'=>true,
);

?>