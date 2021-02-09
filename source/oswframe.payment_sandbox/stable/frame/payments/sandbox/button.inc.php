<?php

$fieldcheck=['currency_code', 'return_url', 'cancel_url', 'notify_url', 'item_amount', 'item_number', 'item_name', 'verifier'];

$error=false;
foreach ($fieldcheck as $field) {
	if (!isset($data[$field])) {
		$error=true;
	}
}

if ($error===true) {
	$output.='create button error';
} else {
	$abs_file=vOut('settings_abspath').'frame/payments/'.$paymodul.'/button.png';

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

	$output.='<form method="POST" name="gateway_form" action="'.osW_Template::getInstance()->buildhrefLink('payment_sandbox').'">';
	$output.='<input name="business" value="'.vOut('payment_sandbox_business').'" type="hidden">';
	$output.='<input name="currency_code" value="'.$data['currency_code'].'" type="hidden">';
	$output.='<input name="return_url" value="'.$data['return_url'].'" type="hidden">';
	$output.='<input name="cancel_url" value="'.$data['cancel_url'].'" type="hidden">';
	$output.='<input name="notify_url" value="'.$data['notify_url'].'" type="hidden">';
	$output.='<input name="item_amount" value="'.$data['item_amount'].'" type="hidden">';
	$output.='<input name="item_number" value="'.$data['item_number'].'" type="hidden">';
	$output.='<input name="item_name" value="'.$data['item_name'].'" type="hidden">';
	$output.='<input name="verifier" value="'.$data['verifier'].'" type="hidden">';
	$output.='<input src="static/'.vOut('settings_imageoptimizer').'/frame/payments/'.$paymodul.'/'.$new_filename.'" name="submit" alt="'.$paymodul.'" border="0" type="image">';
	$output.='</form>';
}

?>