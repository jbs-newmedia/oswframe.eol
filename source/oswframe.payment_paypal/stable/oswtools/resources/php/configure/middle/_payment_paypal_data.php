<?php

$this->data['settings']=array();

$this->data['settings']['data']=array(
	'page_title'=>'Payment-PayPal Settings',
);

$this->data['settings']['fields']['payment_paypal_business']=array(
	'default_name'=>'E-Mail',
	'default_type'=>'text',
	'default_value'=>'',
	'valid_type'=>'string',
	'valid_min_length'=>2,
	'valid_max_length'=>32,
	'valid_function'=>'check_email',
	'configure_write'=>true,
);

?>