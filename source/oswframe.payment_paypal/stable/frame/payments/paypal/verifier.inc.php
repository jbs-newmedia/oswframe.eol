<?php

$payment['payment_datafields']['cmd']='_notify-validate';

$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr');
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