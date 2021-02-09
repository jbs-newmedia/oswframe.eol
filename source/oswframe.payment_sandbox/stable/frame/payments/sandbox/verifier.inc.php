<?php

$payment['payment_datafields']['action']='verify';

$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, osW_Template::getInstance()->buildhrefLink('payment_sandbox'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payment['payment_datafields']);
$result=curl_exec($ch);
curl_close($ch);

if ($result=='VERIFIED') {
	$QupdateData=osW_Database::getInstance()->query('UPDATE :table_payment: SET payment_verified_extern=:payment_verified_extern: WHERE payment_id=:payment_id:');
	$QupdateData->bindTable(':table_payment:', 'payment');
	$QupdateData->bindInt(':payment_id:', $payment['payment_id']);
	$QupdateData->bindInt(':payment_verified_extern:', 1);
	$QupdateData->execute();
}

?>