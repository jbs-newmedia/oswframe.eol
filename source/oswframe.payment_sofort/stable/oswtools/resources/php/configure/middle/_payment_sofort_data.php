<?php

$this->data['settings']=array();

$this->data['settings']['data']=array(
	'page_title'=>'Payment-Sofort Settings',
);

$this->data['settings']['fields']['payment_sofort_user_id']=array(
	'default_name'=>'User-Id',
	'default_type'=>'text',
	'default_value'=>'',
	'valid_type'=>'integer',
	'valid_min_length'=>1,
	'valid_max_length'=>11,
	'configure_write'=>true,
);

$this->data['settings']['fields']['payment_sofort_project_id']=array(
	'default_name'=>'Project-Id',
	'default_type'=>'text',
	'default_value'=>'',
	'valid_type'=>'string',
	'valid_min_length'=>1,
	'valid_max_length'=>11,
	'configure_write'=>true,
);

$this->data['settings']['fields']['payment_sofort_project_password']=array(
	'default_name'=>'Password',
	'default_type'=>'text',
	'default_value'=>'',
	'valid_type'=>'string',
	'valid_min_length'=>0,
	'valid_max_length'=>32,
	'configure_write'=>true,
);

?>