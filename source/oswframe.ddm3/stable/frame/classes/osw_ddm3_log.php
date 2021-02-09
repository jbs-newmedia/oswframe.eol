<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

class osW_DDM3_Log extends osW_Object {

	// PROPERTIES

	public $elements=[];

	// METHODS CORE

	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	public function addValue($group, $key, $value_old, $value_new, $user_id_old=0, $time_old=0, $user_id_new=0, $time_new=0) {
		if (!isset($this->elements[$group])) {
			$this->elements[$group]=[];
		}

		$this->elements[$group][$key]=['key'=>$key, 'value_old'=>$value_old, 'value_new'=>$value_new, 'user_id_old'=>$user_id_old, 'time_old'=>$time_old, 'user_id_new'=>$user_id_new, 'time_new'=>$time_new];

		return true;
	}

	public function getValue($group, $key) {
		if (!isset($this->elements[$group])) {
			return false;
		}
		if (!isset($this->elements[$group][$key])) {
			return false;
		}

		return $this->elements[$group][$key];
	}

	public function getValues($group) {
		if (!isset($this->elements[$group])) {
			return false;
		}

		return $this->elements[$group];
	}

	public function writeValues($group, $index, $value) {
		if (!isset($this->elements[$group])) {
			return false;
		}

		foreach ($this->elements[$group] as $key=>$values) {
			$QsaveData=osW_Database::getInstance()->query('INSERT INTO :table_ddm3_log: (log_group, name_index, value_index, log_key, log_value_new, log_value_old, log_value_user_id_new, log_value_user_id_old, log_value_time_new, log_value_time_old) VALUES (:log_group:, :name_index:, :value_index:, :log_key:, :log_value_new:, :log_value_old:, :log_value_user_id_new:, :log_value_user_id_old:, :log_value_time_new:, :log_value_time_old:)');
			$QsaveData->bindTable(':table_ddm3_log:', 'ddm3_log');
			$QsaveData->bindValue(':log_group:', $group);
			$QsaveData->bindValue(':name_index:', $index);
			$QsaveData->bindValue(':value_index:', $value);
			$QsaveData->bindValue(':log_key:', $values['key']);
			$QsaveData->bindValue(':log_value_new:', $values['value_new']);
			$QsaveData->bindValue(':log_value_old:', $values['value_old']);
			$QsaveData->bindValue(':log_value_user_id_new:', $values['user_id_new']);
			$QsaveData->bindValue(':log_value_user_id_old:', $values['user_id_old']);
			$QsaveData->bindValue(':log_value_time_new:', $values['time_new']);
			$QsaveData->bindValue(':log_value_time_old:', $values['time_old']);
			$QsaveData->execute();
			if ($QsaveData->query_handler===false) {
				print_a($QsaveData);
			}
		}
	}

	/**
	 *
	 * @return osW_DDM3_Log
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>