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
class osW_ErrorHandler extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function handle($errno, $errstr, $errfile, $errline) {
		switch ($errno) {
			case E_ERROR :
			case E_USER_ERROR :
				$this->logMessage(__CLASS__, 'fatal', ['time'=>time(), 'errno'=>$errno, 'errstr'=>$errstr, 'errfile'=>$errfile, 'errline'=>$errline]);
				h()->_dieError('['.$errno.'] '.$errstr.'<br/>Fatal error in line '.$errline.' of file '.$errfile, 'Fatal error');
				break;
			case E_WARNING :
			case E_USER_WARNING :
				$this->logMessage(__CLASS__, 'warning', ['time'=>time(), 'errno'=>$errno, 'errstr'=>$errstr, 'errfile'=>$errfile, 'errline'=>$errline]);
				break;
			case E_NOTICE :
			case E_USER_NOTICE :
				$this->logMessage(__CLASS__, 'notice', ['time'=>time(), 'errno'=>$errno, 'errstr'=>$errstr, 'errfile'=>$errfile, 'errline'=>$errline]);
				break;
			default :
				$this->logMessage(__CLASS__, 'unknow', ['time'=>time(), 'errno'=>$errno, 'errstr'=>$errstr, 'errfile'=>$errfile, 'errline'=>$errline]);
				break;
		}
	}

	/**
	 *
	 * @return osW_ErrorHandler
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>