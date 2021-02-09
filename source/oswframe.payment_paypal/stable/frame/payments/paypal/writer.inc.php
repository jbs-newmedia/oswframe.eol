<?php

$Qwrite=osW_Database::getInstance()->query('INSERT INTO :table_payment: (payment_paymodul, payment_time, payment_verifier_intern, payment_verified_intern, payment_verifier_extern, payment_verified_extern, payment_verified, payment_amount, payment_datafields) VALUES (:payment_paymodul:, :payment_time:, :payment_verifier_intern:, :payment_verified_intern:, :payment_verifier_extern:, :payment_verified_extern:, :payment_verified:, :payment_amount:, :payment_datafields:)');
$Qwrite->bindTable(':table_payment:', 'payment');
$Qwrite->bindValue(':payment_paymodul:', $paymodul);
$Qwrite->bindInt(':payment_time:', time());
$Qwrite->bindValue(':payment_verifier_intern:', $_POST['custom']);
$Qwrite->bindInt(':payment_verified_intern:', 0);
$Qwrite->bindValue(':payment_verifier_extern:', $_POST['verify_sign']);
$Qwrite->bindInt(':payment_verified_extern:', 0);
$Qwrite->bindInt(':payment_verified:', 0);
$Qwrite->bindFloat(':payment_amount:', $_POST['mc_gross']);
$Qwrite->bindValue(':payment_datafields:', serialize($_POST));
$Qwrite->execute();

$payment_id=$Qwrite->nextId();

?>