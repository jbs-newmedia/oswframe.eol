<?php

$hash='';

if (isset($payment['payment_datafields']['hash'])) {
	$hash=$payment['payment_datafields']['hash'];
	unset($payment['payment_datafields']['hash']);
}

if (isset($payment['payment_datafields']['email_recipient'])) {
	unset($payment['payment_datafields']['email_recipient']);
}

$hash_new=sha1(implode('|', $payment['payment_datafields']).'|'.vOut('payment_sofort_project_password'));

if ($hash==$hash_new) {
	$QupdateData=osW_Database::getInstance()->query('UPDATE :table_payment: SET payment_verified_extern=:payment_verified_extern: WHERE payment_id=:payment_id:');
	$QupdateData->bindTable(':table_payment:', 'payment');
	$QupdateData->bindInt(':payment_id:', $payment['payment_id']);
	$QupdateData->bindInt(':payment_verified_extern:', 1);
	$QupdateData->execute();
}

?>