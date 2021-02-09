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
class osW_Stats extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function addValue($key, $unique_time=0) {
		$unique_time=intval($unique_time);
		if ($unique_time>0) {
			$unique=1;
		} else {
			$unique=0;
		}
		$QinsertData=osW_Database::getInstance()->query('INSERT INTO :table_stats_cache: (session_id, stat_day, stat_time, stat_key, stat_unique, stat_unique_time) VALUES (:session_id:, :stat_day:, :stat_time:, :stat_key:, :stat_unique:, :stat_unique_time:)');
		$QinsertData->bindTable(':table_stats_cache:', 'stats_cache');
		$QinsertData->bindValue(':session_id:', osW_Session::getInstance()->getId());
		$QinsertData->bindInt(':stat_day:', date('Ymd'));
		$QinsertData->bindInt(':stat_time:', date('His'));
		$QinsertData->bindValue(':stat_key:', $key);
		$QinsertData->bindInt(':stat_unique:', $unique);
		$QinsertData->bindInt(':stat_unique_time:', $unique_time);
		$QinsertData->execute();
		if ($QinsertData->query_handler===false) {
			$this->__initDB();
			$QinsertData->execute();
		}
		if ($QsaveData->query_handler!==false) {
			return true;
		}

		return true;
	}

	/**
	 *
	 * @return osW_Stats
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>