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
class osW_Database_sqllite extends osW_Database_Engine {

	/* METHODS CORE */
	public function __construct($alias, $options) {
		parent::__construct($alias, $options, __CLASS__, 1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function _connect() {
		$link=mysql_connect($this->options['server'], $this->options['username'], $this->options['password']);
		$this->_select_db($this->options['database'], $link);

		return $link;
	}

	public function _init() {
		// set UTF8 flags
		$setUTF8=$this->query('SET character_set_client="utf8"');
		$setUTF8->execute();
		$setUTF8=$this->query('SET character_set_connection="utf8"');
		$setUTF8->execute();
		$setUTF8=$this->query('SET character_set_results="utf8"');
		$setUTF8->execute();

		return true;
	}

	public function _pconnect() {
		$link=mysql_pconnect($this->options['server'], $this->options['username'], $this->options['password']);
		$this->_select_db($this->options['database'], $link);

		return $link;
	}

	public function _close($link) {
		return mysql_close($link);
	}

	public function _select_db($database_name, $link) {
		return mysql_select_db($database_name, $link);
	}

	public function _query($query, $link) {
		return mysql_query($query, $link);
	}

	public function _error($link) {
		return mysql_error($link);
	}

	public function _errno($link) {
		return mysql_errno($link);
	}

	public function _escape_string($str, $link) {
		return mysql_real_escape_string($str, $link);
	}

	public function _numberOfRows($resource) {
		return mysql_num_rows($resource);
	}

	public function _next($resource) {
		return @mysql_fetch_assoc($resource);
	}

	public function _insert_id($link) {
		return mysql_insert_id($link);
	}

	public function _affected_rows($link) {
		return mysql_affected_rows($link);
	}

	/**
	 *
	 * @return osW_Database_sqllite
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>