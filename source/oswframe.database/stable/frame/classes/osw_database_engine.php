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
class osW_Database_Engine extends osW_Object {

	/* PROPERTIES */
	public $alias='';

	public $link='';

	public $querytime=0;

	public $options=[];

	/* METHODS CORE */

	/**
	 *
	 * @return osW_Database_Engine
	 */
	public function __construct($alias, $options, $class, $version, $build) {
		osW_Object::checkIsEnabled($class);
		parent::__construct($class, $version, $build);
		$this->alias=$alias;
		$this->options=$options;
		$this->connect();
		$this->init();
	}

	public function __destruct() {
		$this->close();
		parent::__destruct();
	}

	/* METHODS */
	public function connect() {
		if ($this->options['pconnect']===true) {
			$this->link=$this->_pconnect();
		} else {
			$this->link=$this->_connect();
		}

		#unset($this->options['database']);
		unset($this->options['server']);
		unset($this->options['username']);
		unset($this->options['password']);

		if ($this->link===false) {
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>$this->error($this->link), 'errno'=>$this->errno($this->link)]);
			$this->setError($this->error($this->link), $this->errno($this->link));
			$this->dieError();
			//return false;
		}

		$this->setConnected(true);
		//return true;
	}

	public function dieError() {
		h()->_die('Database-Error: '.$this->error($this->link).' (No:'.$this->errno($this->link).')');
	}

	public function init() {
		$this->_init();

		return true;
	}

	public function close() {
		if ($this->isConnected()) {
			if ($this->_close($this->link)===true) {
				return true;
			}

			return false;
		} else {
			return true;
		}
	}

	public function setConnected($boolean) {
		if ($boolean===true) {
			$this->is_connected=true;

			return true;
		}
		$this->is_connected=false;

		return false;
	}

	public function isConnected() {
		if ($this->is_connected===true) {
			return true;
		}

		return false;
	}

	public function setError($error, $error_number='') {
		$this->error=$error;
		$this->error_number=$error_number;
	}

	public function isError() {
		if ($this->error===false) {
			return false;
		}

		return true;
	}

	public function getError() {
		if ($this->isError()) {
			$error='';
			if (!empty($this->error_number)) {
				$error.=$this->error_number.': ';
			}
			$error.=$this->error;

			return $error;
		} else {
			return false;
		}
	}

	private function freeQuery() {
		$this->query='';
		$this->query_handler=false;
		$this->rows=0;
		$this->affectedrows=0;
		$this->nextid=0;
		$this->resource='';
		$this->result=[];
	}

	public function query($query) {
		$osW_Database_Result=new osW_Database_Result($this);
		$osW_Database_Result->setQuery($query);

		return $osW_Database_Result;
	}

	public function simpleQuery($query) {
		if ($this->isConnected()) {
			$this->setError(false);
			$time_start=$this->getMicroTime();
			$resource=$this->_query($query, $this->link);
			$time_end=$this->getMicroTime();
			$this->querytime=number_format($time_end-$time_start, 5);
			if (!isset(osW_Database::$db_stats[osW_Database::$db_alias])) {
				osW_Database::$db_stats[$this->alias]=[];
			}
			if (!isset(osW_Database::$db_stats[$this->alias]['number_of_queries'])) {
				osW_Database::$db_stats[$this->alias]['number_of_queries']=0;
			}
			if (!isset(osW_Database::$db_stats[$this->alias]['time_of_queries'])) {
				osW_Database::$db_stats[$this->alias]['time_of_queries']=0;
			}
			osW_Database::$db_stats[$this->alias]['number_of_queries']++;
			osW_Database::$db_stats[$this->alias]['time_of_queries']+=$this->querytime;
			if ($resource!==false) {
				if (vOut('database_logqueries')===true) {
					$this->logMessage(__CLASS__, 'queries', ['querytime'=>$this->querytime, 'query'=>$query]);
				}
				if (vOut('database_slowquerytime')<=$this->querytime) {
					$this->logMessage(__CLASS__, 'slowquery', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'querytime'=>$this->querytime, 'query'=>$query]);
				}

				return $resource;
			} else {
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'querytime'=>$this->querytime, 'query'=>$query]);
				$this->setError($this->error($this->link), $this->errno($this->link));

				return false;
			}
		} else {
			return false;
		}
	}

	public function error() {
		return $this->_error($this->link);
	}

	public function errno() {
		return $this->_errno($this->link);
	}

	public function escape_string($str) {
		return $this->_escape_string($str, $this->link);
	}

	public function getMicroTime() {
		return h()->_getMicroTime();
	}

	public function numberOfQueries() {
		return $this->number_of_queries;
	}

	public function timeOfQueries() {
		return $this->time_of_queries;
	}

}

class osW_Database_Result extends osW_Object {

	/* PROPERTIES */
	public $db_connection='';

	public $result=[];

	public $query_handler=false;

	public $limitrows=[];

	public $query='';

	public $error='';

	/* METHODS CORE */
	public function __construct($db_connection) {
		$this->db_connection=$db_connection;
	}

	/* METHODS */
	public function setQuery($query) {
		$this->query=$query;
	}

	public function getQuery() {
		return $this->query;
	}

	public function value($column) {
		return $this->valueMixed($column);
	}

	public function valueProtected($column) {
		return $this->valueMixed($column, 'protected');
	}

	public function valueInt($column) {
		return $this->valueMixed($column, 'int');
	}

	public function valueDecimal($column) {
		return $this->valueMixed($column, 'decimal');
	}

	private function valueMixed($column, $type='string') {
		if (!isset($this->result[$column])) {
			return '';
		}
		switch ($type) {
			case 'protected' :
				return h()->_outputString($this->result[$column]);
				break;
			case 'int' :
				return intval($this->result[$column]);
				break;
			case 'decimal' :
				return floatval($this->result[$column]);
				break;
			case 'string' :
			default :
				return $this->result[$column];
		}
	}

	public function bindTable($place_holder, $value) {
		$this->bindValueMixed($place_holder, $this->db_connection->options['prefix'].$value, 'raw');
	}

	public function bindValue($place_holder, $value) {
		$this->bindValueMixed($place_holder, $value, 'string');
	}

	public function bindInt($place_holder, $value) {
		$this->bindValueMixed($place_holder, $value, 'int');
	}

	public function bindFloat($place_holder, $value) {
		$this->bindValueMixed($place_holder, $value, 'decimal');
	}

	public function bindDecimal($place_holder, $value) {
		$this->bindValueMixed($place_holder, $value, 'decimal');
	}

	public function bindRaw($place_holder, $value) {
		$this->bindValueMixed($place_holder, $value, 'raw');
	}

	public function bindCrypt($place_holder, $value) {
		$this->bindValueMixed($place_holder, h()->_encryptString($value), 'string');
	}

	public function setPrimaryKey($pkey) {
		$this->limitrows['primary_key']=$pkey;
	}

	public function bindLimit($max_rows=100, $page=0, $display_range=5, $page_holder='page') {
		if ($page==0) {
			$page=intval(h()->_catch($page_holder, 1, 'gp'));
		}
		if ($page<1) {
			$page=1;
		}
		$this->limitrows['current_page_number']=intval($page);
		$this->limitrows['number_of_pages']=1;
		$this->limitrows['number_of_rows']=0;
		$this->limitrows['number_of_rows_per_page']=$max_rows;
		$this->limitrows['number_of_rows_on_page']=0;
		$this->limitrows['display_range']=$display_range;
		if ((isset($this->limitrows['primary_key']))&&(strlen($this->limitrows['primary_key'])>0)) {
			$this->execute(preg_replace('/SELECT(.*)\ FROM/Uis', 'SELECT count('.$this->limitrows['primary_key'].') AS osWCounter_Temp FROM', $this->getQuery()));
		} else {
			$this->execute();
		}

		if ((isset($this->limitrows['primary_key']))&&(strlen($this->limitrows['primary_key'])>0)) {
			$this->next();
			$this->limitrows['number_of_rows']=$this->Value('osWCounter_Temp');
		} else {
			$this->limitrows['number_of_rows']=$this->numberOfRows();
		}
		$this->limitrows['number_of_pages']=ceil($this->limitrows['number_of_rows']/$this->limitrows['number_of_rows_per_page']);
		if ($this->limitrows['current_page_number']>$this->limitrows['number_of_pages']) {
			if ($this->limitrows['number_of_pages']>0) {
				$this->limitrows['current_page_number']=$this->limitrows['number_of_pages'];
			}
		}

		$offset=($this->limitrows['number_of_rows_per_page']*($this->limitrows['current_page_number']-1));
		if ($this->limitrows['current_page_number']==$this->limitrows['number_of_pages']) {
			$this->limitrows['number_of_rows_on_page']=$this->limitrows['number_of_rows']-$offset;
		} else {
			$this->limitrows['number_of_rows_on_page']=$this->limitrows['number_of_rows_per_page'];
		}
		$this->setQuery($this->getQuery().' LIMIT '.$offset.', '.$this->limitrows['number_of_rows_per_page']);
	}

	private function bindValueMixed($place_holder, $value, $type='string') {
		$value=trim($value);
		switch ($type) {
			case 'int' :
				$value=intval($value);
				break;
			case 'decimal' :
				$value=str_replace(',', '.', $value);
				$value=floatval($value);
				$value=''.str_replace(',', '.', $this->db_connection->_escape_string($value, $this->db_connection->link)).'';
			case 'raw' :
				break;
			case 'string' :
			default :
				$value='\''.$this->db_connection->_escape_string($value, $this->db_connection->link).'\'';
		}
		$this->bindReplace($place_holder, $value);
	}

	private function bindReplace($place_holder, $value) {
		$this->query=str_replace($place_holder, $value, $this->query);
	}

	public function next() {
		if (isset($this->query_handler)) {
			$this->result=$this->db_connection->_next($this->query_handler);
		} else {
			$this->result=[];
		}

		return $this->result;
	}

	public function numberOfRows() {
		if (isset($this->query_handler)) {
			$this->rows=$this->db_connection->_numberOfRows($this->query_handler);
		} else {
			$this->rows=0;
		}

		return $this->rows;
	}

	public function nextID() {
		if (isset($this->query_handler)) {
			$this->nextid=$this->db_connection->_insert_id($this->db_connection->link);
		} else {
			$this->nextid=0;
		}

		return $this->nextid;
	}

	public function affectedRows() {
		if (isset($this->query_handler)) {
			$this->affectedrows=$this->db_connection->_affected_rows($this->db_connection->link);
		} else {
			$this->affectedrows=0;
		}

		return $this->affectedrows;
	}

	public function isError() {
		if ($this->error===false) {
			return false;
		}

		return true;
	}

	public function getError() {
		return $this->error;
	}

	public function getResult() {
		return $this->result;
	}

	public function execute($query='') {
		if ($query=='') {
			$query=$this->query;
		}
		$this->query_handler=$this->db_connection->simpleQuery($query);
		if ($this->db_connection->getError()!==false) {
			$this->error=$this->db_connection->getError();
		}

		return $this->query_handler;
	}

	/**
	 *
	 * @return osW_Database_Result
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>