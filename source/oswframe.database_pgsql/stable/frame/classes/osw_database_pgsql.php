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
class osW_Database_pgsql extends osW_Database_Engine {

	/* PROPERTIES */
	private $password='';

	/* METHODS CORE */
	public function __construct($alias, $options) {
		parent::__construct($alias, $options);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function _connect() {
		$server=explode(':', $this->options['server']);
		if (!isset($server[1])) {
			$server[1]=5432;
		}

		return pg_connect('host='.$server[0].' port='.$server[1].' dbname='.$this->options['database'].' user='.$this->options['username'].' password='.$this->options['password'].'');
	}

	public function _pconnect() {
		$server=explode(':', $this->server);
		if (!isset($server[1])) {
			$server[1]=5432;
		}

		return pg_pconnect('host='.$server[0].' port='.$server[1].' dbname='.$this->options['database'].' user='.$this->options['username'].' password='.$this->options['password'].'');
	}

	public function _close($link) {
		return pg_close($link);
	}

	public function _select_db($database_name, $link) {
		//return mysql_select_db($database_name, $link);
	}

	public function _query($query, $link) {
		return pg_query($link, $query);
	}

	public function _error($link) {
		//return mysql_error($link);
	}

	public function _errno($link) {
		//return mysql_errno($link);
	}

	public function _escape_string($str, $link) {
		return pg_escape_string($link, $str);
	}

	public function _numberOfRows($resource) {
		return pg_num_rows($resource);
	}

	public function _next($resource) {
		return pg_fetch_assoc($resource);
	}

	public function _insert_id($resource) {
		//return mysql_insert_id($resource);
	}

	public function _affected_rows($resource) {
		//return mysql_affected_rows($resource);
	}

	/**
	 *
	 * @return osW_Database_pgsql
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>