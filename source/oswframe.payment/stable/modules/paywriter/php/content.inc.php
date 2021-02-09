<?php

if (!isset($_GET['paymodule'])) {
	$paymodul='undefined';
} else {
	$paymodul=$_GET['paymodule'];
}

$payment_id=osW_Payment::getInstance()->writePayment($paymodul);
osW_Payment::getInstance()->verifyPayment($paymodul, $payment_id);
osW_Payment::getInstance()->runSystem();

h()->_die('');

?>