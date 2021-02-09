<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _checkProtectEmail($var) {
	$Quser=osW_Database::getInstance()->query('SELECT protectid FROM :table_protection WHERE protecttyp=2 AND protectvalue=:protectvalue');
	$Quser->bindTable(':table_protection', 'protection');
	$Quser->bindValue(':protectvalue', $var[0]);
	$Quser->execute();

	if ($Quser->numberOfRows()>0) {
		return ['status'=>1, 'type'=>'email_blocked', 'message'=>tnOut('email_block_error')];
	}

	$str=explode('@', $var[0]);
	$Quser=osW_Database::getInstance()->query('SELECT protectid FROM :table_protection WHERE protecttyp=1 AND protectvalue=:protectvalue');
	$Quser->bindTable(':table_protection', 'protection');
	$Quser->bindValue(':protectvalue', $str[1]);
	$Quser->execute();

	if ($Quser->numberOfRows()>0) {
		return ['status'=>2, 'type'=>'domain_blocked', 'message'=>tnOut('domain_block_error')];
	}

	return true;
}

?>