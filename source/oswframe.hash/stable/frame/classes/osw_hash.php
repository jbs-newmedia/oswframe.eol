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
class osW_Hash extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function deleteHashbyFunction($user_id, $userhash_function) {
		if (intval($user_id)>0) {
			$Qdelete=osW_Database::getInstance()->query('DELETE FROM :table_user_hashes WHERE user_id=:user_id AND userhash_function=:userhash_function');
			$Qdelete->bindTable(':table_user_hashes', 'user_hashes');
			$Qdelete->bindInt(':user_id', $user_id);
			$Qdelete->bindValue(':userhash_function', $userhash_function);
			$Qdelete->execute();
			if ($Qdelete->query_handler===false) {
				$this->__initDB();
				$Qdelete->execute();
			}
		}
	}

	public function deleteHash($user_id, $userhash_value) {
		if (intval($user_id)>0) {
			$Qdelete=osW_Database::getInstance()->query('DELETE FROM :table_user_hashes WHERE user_id=:user_id AND userhash_value=:userhash_value');
			$Qdelete->bindTable(':table_user_hashes', 'user_hashes');
			$Qdelete->bindInt(':user_id', $user_id);
			$Qdelete->bindValue(':userhash_value', $userhash_value);
			$Qdelete->execute();
			if ($Qdelete->query_handler===false) {
				$this->__initDB();
				$Qdelete->execute();
			}
		}
	}

	public function setHash($user_id, $userhash_function) {
		if (intval($user_id)>0) {
			$hash=md5(time()+rand(99, 199)+rand(99, 199));
			$this->deleteHashbyFunction($user_id, $userhash_function);
			$Qinsert=osW_Database::getInstance()->query('INSERT INTO :table_user_hashes (user_id, userhash_value, userhash_function, userhash_create) VALUES (:user_id, :userhash_value, :userhash_function, :userhash_create)');
			$Qinsert->bindTable(':table_user_hashes', 'user_hashes');
			$Qinsert->bindInt(':user_id', $user_id);
			$Qinsert->bindValue(':userhash_value', $hash);
			$Qinsert->bindValue(':userhash_function', $userhash_function);
			$Qinsert->bindInt(':userhash_create', time());
			$Qinsert->execute();
			if ($Qinsert->query_handler===false) {
				$this->__initDB();
				$Qinsert->execute();
			}

			return $hash;
		}

		return '';
	}

	public function checkHash($user_hash, $user_id, $user_hashfunction, $delete_hash=true) {
		if (strlen($user_hash)==vOut('hash_length')) {
			$Qselect=osW_Database::getInstance()->query('SELECT user_id FROM :table_user_hashes WHERE user_id=:user_id AND userhash_value=:userhash_value AND userhash_function=:userhash_function AND userhash_create>=:userhash_create');
			$Qselect->bindTable(':table_user_hashes', 'user_hashes');
			$Qselect->bindInt(':user_id', $user_id);
			$Qselect->bindValue(':userhash_value', $user_hash);
			$Qselect->bindValue(':userhash_function', $user_hashfunction);
			$Qselect->bindInt(':userhash_create', (time()-vOut('hash_lifetime')));
			$Qselect->execute();
			if ($Qselect->query_handler===false) {
				$this->__initDB();
				$Qselect->execute();
			}
			if ($Qselect->numberOfRows()===1) {
				if ($delete_hash===true) {
					$this->deleteHashbyFunction($user_id, $user_hashfunction);
				}

				return true;
			}
		} else {
			return false;
		}
	}

	public function checkLifeTime($user_id, $user_hashfunction) {
		$Qselect=osW_Database::getInstance()->query('SELECT userhash_create FROM :table_user_hashes WHERE user_id=:user_id AND userhash_function=:userhash_function AND userhash_create>=:userhash_create');
		$Qselect->bindTable(':table_user_hashes', 'user_hashes');
		$Qselect->bindInt(':user_id', $user_id);
		$Qselect->bindValue(':userhash_function', $user_hashfunction);
		$Qselect->bindInt(':userhash_create', (time()-vOut('hash_lifetime')));
		$Qselect->execute();
		if ($Qselect->query_handler===false) {
			$this->__initDB();
			$Qselect->execute();
		}
		if ($Qselect->numberOfRows()===1) {
			$Qselect->next();

			return ($Qselect->Value('userhash_create')+vOut('hash_lifetime'));
		} else {
			return 0;
		}
	}

	public function getHash($userid, $userhashfunction) {
		$Qselect=osW_Database::getInstance()->query('SELECT userhash_value FROM :table_user_hashes WHERE user_id=:user_id AND userhash_function=:userhash_function AND userhash_create>=:userhash_create');
		$Qselect->bindTable(':table_user_hashes', 'user_hashes');
		$Qselect->bindInt(':user_id', $userid);
		$Qselect->bindValue(':userhash_function', $userhashfunction);
		$Qselect->bindInt(':userhash_create', (time()-vOut('hash_lifetime')));
		$Qselect->execute();
		if ($Qselect->query_handler===false) {
			$this->__initDB();
			$Qselect->execute();
		}
		if ($Qselect->numberOfRows()===1) {
			$Qselect->next();

			return $Qselect->Value('userhash_value');
		}

		return false;
	}

	/**
	 *
	 * @return osW_Hash
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>
