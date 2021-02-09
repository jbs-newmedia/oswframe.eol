<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_Payment extends osW_Object {

	/* PROPERTIES */
	private $data=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0, true);
	}

	public function __destruct() {
		parent::__destruct();
	}

	public function getPaymentButton($paymodul, $data) {
		if (vOut('class_osw_payment_'.$paymodul.'_enabled')!==true) {
			return false;
		}

		$output='';
		$paymodulpart='button';
		if (file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'frame/autoloader/payment.inc.php')) {
			include settings_abspath.'frame/autoloader/payment.inc.php';
		}

		return $output;
	}

	public function writePayment($paymodul) {
		if (vOut('class_osw_payment_'.$paymodul.'_enabled')!==true) {
			return false;
		}

		$paymodulpart='writer';
		$payment_id=0;

		if (file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'frame/autoloader/payment.inc.php')) {
			include settings_abspath.'frame/autoloader/payment.inc.php';
		}

		return $payment_id;
	}

	public function verifyPayment($paymodul, $payment_id) {
		if (vOut('class_osw_payment_'.$paymodul.'_enabled')!==true) {
			return false;
		}

		$paymodulpart='verifier';
		$payment_verified=false;

		$payment=[];
		$QgetData=osW_Database::getInstance()->query('SELECT * FROM :table_payment: WHERE payment_id=:payment_id:');
		$QgetData->bindTable(':table_payment:', 'payment');
		$QgetData->bindInt(':payment_id:', $payment_id);
		$QgetData->execute();
		if ($QgetData->numberOfRows()==1) {
			$QgetData->next();
			$QgetData->result['payment_datafields']=unserialize($QgetData->result['payment_datafields']);
			$payment=$QgetData->result;
		} else {
			return false;
		}

		if ($payment['payment_verified']==1) {
			return true;
		}

		$QgetVerifierData=osW_Database::getInstance()->query('SELECT * FROM :table_payment_verifier: WHERE verifier_checksum=:verifier_checksum: AND verifier_amount=:verifier_amount:');
		$QgetVerifierData->bindTable(':table_payment_verifier:', 'payment_verifier');
		$QgetVerifierData->bindValue(':verifier_checksum:', $payment['payment_verifier_intern']);
		$QgetVerifierData->bindFloat(':verifier_amount:', $payment['payment_amount']);
		$QgetVerifierData->execute();
		if ($QgetVerifierData->numberOfRows()==1) {
			$QupdateData=osW_Database::getInstance()->query('UPDATE :table_payment: SET payment_verified_intern=:payment_verified_intern: WHERE payment_id=:payment_id:');
			$QupdateData->bindTable(':table_payment:', 'payment');
			$QupdateData->bindInt(':payment_id:', $payment['payment_id']);
			$QupdateData->bindInt(':payment_verified_intern:', 1);
			$QupdateData->execute();
		}

		if (file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'frame/autoloader/payment.inc.php')) {
			include settings_abspath.'frame/autoloader/payment.inc.php';
		}

		$QgetData=osW_Database::getInstance()->query('SELECT * FROM :table_payment: WHERE payment_id=:payment_id: AND payment_verified_intern=:payment_verified_intern: AND payment_verified_extern=:payment_verified_extern:');
		$QgetData->bindTable(':table_payment:', 'payment');
		$QgetData->bindInt(':payment_id:', $payment_id);
		$QgetData->bindInt(':payment_verified_intern:', 1);
		$QgetData->bindInt(':payment_verified_extern:', 1);
		$QgetData->execute();
		if ($QgetData->numberOfRows()==1) {
			$QupdateData=osW_Database::getInstance()->query('UPDATE :table_payment: SET payment_verified=:payment_verified: WHERE payment_id=:payment_id:');
			$QupdateData->bindTable(':table_payment:', 'payment');
			$QupdateData->bindInt(':payment_id:', $payment['payment_id']);
			$QupdateData->bindInt(':payment_verified:', 1);
			$QupdateData->execute();

			return true;
		}

		return false;
	}

	public function runSystem() {
		$paymodulpart='runsystem';
		if (file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php')) {
			include settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/payment.inc.php';
		} elseif (file_exists(settings_abspath.'frame/autoloader/payment.inc.php')) {
			include settings_abspath.'frame/autoloader/payment.inc.php';
		}
	}

	public function createVerifier($order_number, $verifier_amount, $verifier_datafields) {
		$verifier_checksum=md5(vOut('settings_protection_salt').'#'.$order_number.'#'.$verifier_amount.'#'.serialize($verifier_datafields).'#'.microtime(true));

		$QinsertData=osW_Database::getInstance()->query('INSERT INTO :table_payment_verifier: (order_number, verifier_checksum, verifier_time, verifier_amount, verifier_datafields) VALUES (:order_number:, :verifier_checksum:, :verifier_time:, :verifier_amount:, :verifier_datafields:)');
		$QinsertData->bindTable(':table_payment_verifier:', 'payment_verifier');
		$QinsertData->bindValue(':order_number:', $order_number);
		$QinsertData->bindValue(':verifier_checksum:', $verifier_checksum);
		$QinsertData->bindInt(':verifier_time:', time());
		$QinsertData->bindFloat(':verifier_amount:', $verifier_amount);
		$QinsertData->bindValue(':verifier_datafields:', serialize($verifier_datafields));
		$QinsertData->execute();

		return $verifier_checksum;
	}

	/**
	 *
	 * @return osW_Payment
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>