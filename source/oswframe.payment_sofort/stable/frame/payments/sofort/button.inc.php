<?php

$fieldcheck=['currency_code', 'item_amount', 'item_number', 'item_name', 'verifier'];

$error=false;
foreach ($fieldcheck as $field) {
	if (!isset($data[$field])) {
		$error=true;
	}
}

if ($error===true) {
	$output.='create button error';
} else {
	$abs_file=vOut('settings_abspath').'frame/payments/sofort/button.png';

	$options=[];
	$options['longest']=150;
	$opt_options=osW_ImageOptimizer::getInstance()->getOptionsArrayFromArray($options);

	$path_filename=pathinfo($abs_file, PATHINFO_FILENAME);
	$path_extension=pathinfo($abs_file, PATHINFO_EXTENSION);

	if (vOut('imageoptimizer_protect_files')===true) {
		$opt_options['ps']=substr(md5($path_filename.'.'.$path_extension.'#'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($opt_options).'#'.vOut('settings_protection_salt')), 3, 6);
	}

	$imgopt=[];
	foreach ($opt_options as $key=>$value) {
		if (strlen($value)>0) {
			$imgopt[]=$key.'_'.$value;
		}
	}

	if (!empty($imgopt)) {
		$new_filename=$path_filename.'.'.implode('-', $imgopt).'.'.$path_extension;
	} else {
		$new_filename=$path_filename.'.'.$path_extension;
	}

	osW_Settings::getInstance()->payment_sofort_userid=66879;
	osW_Settings::getInstance()->payment_sofort_project_id=163668;
	osW_Settings::getInstance()->payment_sofort_project_password='X]NkoqfVX8L#zo{8aywj';

	$hash_blank=vOut('payment_sofort_user_id').'|'.vOut('payment_sofort_project_id').'|||||'.$data['item_amount'].'|'.$data['currency_code'].'|'.$data['item_name'].'|'.$data['item_number'].'|'.$data['verifier'].'||||||';
	$data['hash']=sha1($hash_blank.vOut('payment_sofort_project_password'));

	$output.='<form method="post" action="https://www.sofort.com/payment/start">';
	$output.='<input name="amount" type="hidden" value="'.$data['item_amount'].'"/>';
	$output.='<input name="currency_id" type="hidden" value="'.$data['currency_code'].'"/>';
	$output.='<input name="reason_1" type="hidden" value="'.$data['item_name'].'"/>';
	$output.='<input name="reason_2" type="hidden" value="'.$data['item_number'].'"/>';
	$output.='<input name="user_id" type="hidden" value="'.vOut('payment_sofort_user_id').'"/>';
	$output.='<input name="project_id" type="hidden" value="'.vOut('payment_sofort_project_id').'"/>';
	$output.='<input name="user_variable_0" type="hidden" value="'.$data['verifier'].'"/>';
	$output.='<input name="hash" type="hidden" value="'.$data['hash'].'"/>';
	$output.='<input src="static/'.vOut('settings_imageoptimizer').'/frame/payments/sofort/'.$new_filename.'" name="submit" alt="Sofort Überweisung" border="0" type="image">';
	$output.='</form>';
}

?>