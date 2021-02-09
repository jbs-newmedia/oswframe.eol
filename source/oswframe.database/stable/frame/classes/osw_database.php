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
class osW_Database extends osW_Object {

	/* VALUES */
	static $db_pool=[];

	static $db_alias='';

	static $db_stats=[];

	/* METHODS CORE */
	public function __construct() {
		// not used by static functions only
	}

	public function __destruct() {
		// not used by static functions only
	}

	/* METHODS */
	static function connect($alias, $options) {
		$db_stats[$alias]['number_of_queries']=0;
		$db_stats[$alias]['time_of_queries']=0;
		switch ($options['type']) {
			case 'odbc' :
				return new osW_Database_odbc($alias, $options);
				break;
			case 'pqsql' :
				return new osW_Database_pgsql($alias, $options);
				break;
			case 'mysql' :
				return new osW_Database_mysql($alias, $options);
				break;
			case 'sqllite' :
				return new osW_Database_sqllite($alias, $options);
				break;
		}

		return false;
	}

	static function addDatabase($db_alias, $db_options=[]) {
		if (self::$db_alias=='') {
			self::$db_alias=$db_alias;
		}
		self::$db_pool[$db_alias]=$db_options;
	}

	/* INSTANCE */
	static $db_objects;

	/**
	 *
	 * @param string $db_alias
	 * @return osW_Database_Result
	 */
	static function getInstance($db_alias='') {
		if ($db_alias=='') {
			$db_alias=self::$db_alias;
		}
		if (!isset(self::$db_objects['obj_'.$db_alias])||!is_object(self::$db_objects['obj_'.$db_alias])) {
			osW_Object::checkIsEnabled(__CLASS__);
			self::$db_objects['obj_'.$db_alias]=osW_Database::connect($db_alias, self::$db_pool[$db_alias]);
		}

		return self::$db_objects['obj_'.$db_alias];
	}

}

?>