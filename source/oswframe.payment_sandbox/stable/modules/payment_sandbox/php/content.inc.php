<?php

if ((isset($_POST['action']))&&($_POST['action']=='verify')) {
	unset($_POST['action']);

	if (!isset($_POST['hash'])) {
		h()->_die('INVALID');
	}
	$hash=$_POST['hash'];
	unset($_POST['hash']);

	if ($hash!==md5(vOut('settings_protection_salt').'#'.serialize($_POST))) {
		h()->_die('INVALID');
	}
	h()->_die('VERIFIED');
} elseif ((isset($_GET['action']))&&($_GET['action']=='pay')) {
	$data=$_GET;
} elseif ((isset($_GET['action']))&&($_GET['action']=='cancel')) {
	$data=$_GET;
} else {
	$data=$_POST;
}

$fieldcheck=['business', 'currency_code', 'return_url', 'cancel_url', 'notify_url', 'item_amount', 'item_number', 'item_name', 'verifier'];

$error=[];
foreach ($fieldcheck as $field) {
	if (!isset($data[$field])) {
		$error[]=$field;
	}
}

if (count($error)>0) {
	h()->_die('<h3>Payment-Error: Missing _POST ('.implode(', ', $error).')</h3>');
}

if ((isset($_GET['action']))&&($_GET['action']=='pay')) {
	echo '<h3>Payment successfully:</h3>';
} elseif ((isset($_GET['action']))&&($_GET['action']=='cancel')) {
	echo '<h3>Payment canceled:</h3>';
} else {
	echo '<h3>SandBox Payment:</h3>';
}

echo 'amount: '.$data['item_amount'].' '.$data['currency_code'].'<br/>';
echo 'item_number: '.$data['item_number'].'<br/>';
echo 'item_name: '.$data['item_name'].'<br/>';
echo 'custom: '.$data['verifier'].'<br/>';
echo 'business: '.$data['business'].'<br/>';
echo 'notify_url: '.$data['notify_url'].'<br/>';
echo '<br/>';

if ((isset($_GET['action']))&&($_GET['action']=='pay')) {
	echo '<a href="'.$data['return_url'].'">Back to Website</a>';
	$notify_url=$data['notify_url'];
	unset($data['module']);
	unset($data['action']);
	unset($data['return_url']);
	unset($data['cancel_url']);
	unset($data['notify_url']);

	$data['hash']=md5(vOut('settings_protection_salt').'#'.serialize($data));

	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $notify_url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result=curl_exec($ch);
	curl_close($ch);
} elseif ((isset($_GET['action']))&&($_GET['action']=='cancel')) {
	echo '<a href="'.$data['cancel_url'].'">Back to Website</a>';
} else {
	$url_string=http_build_query($data);
	echo '<a href="'.osW_Template::getInstance()->buildhrefLink('current', 'action=pay&'.$url_string, '', '&').'">Pay</a> | <a href="'.osW_Template::getInstance()->buildhrefLink('current', 'action=cancel&'.$url_string, '', '&').'">Cancel</a>';
}

h()->_die();

?>