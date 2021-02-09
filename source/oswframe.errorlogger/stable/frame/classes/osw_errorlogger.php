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
class osW_ErrorLogger extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function getOutput($error_status) {
		switch ($error_status) {
			case '401' :
				header("HTTP/1.1 401 Unauthorized");
				break;
			case '402' :
				header("HTTP/1.1 402 Payment Required");
				break;
			case '403' :
				header("HTTP/1.1 403 Forbidden");
				break;
			case '404' :
				header("HTTP/1.1 404 Not Found");
				break;
			case '405' :
				header("HTTP/1.1 405 Method Not Allowed");
				break;
			case '406' :
				header("HTTP/1.1 406 Not Acceptable");
				break;
			case '407' :
				header("HTTP/1.1 407 Proxy Authentication Required");
				break;
			case '408' :
				header("HTTP/1.1 408 Request Timeout");
				break;
			case '409' :
				header("HTTP/1.1 409 Conflict");
				break;
			case '410' :
				header("HTTP/1.1 410 Gone");
				break;
			case '411' :
				header("HTTP/1.1 411 Length Required");
				break;
			case '412' :
				header("HTTP/1.1 412 Precondition Failed");
				break;
			case '413' :
				header("HTTP/1.1 413 Request Entity Too Large");
				break;
			case '414' :
				header("HTTP/1.1 414 Request-URI Too Long");
				break;
			case '415' :
				header("HTTP/1.1 415 Unsupported Media Type");
				break;
			case '416' :
				header("HTTP/1.1 416 Requested Range Not Satisfiable");
				break;
			case '417' :
				header("HTTP/1.1 417 Expectation Failed");
				break;
			case '400' :
			default :
				$error_status='400';
				header("HTTP/1.1 400 Bad Request");
				break;
		}

		$error_status=h()->_catch('error_status', '', 'gp');

		if (!isset($_SERVER['REDIRECT_URL'])) {
			$_SERVER['REDIRECT_URL']='';
		}

		if (!isset($_SERVER['HTTP_REFERER'])) {
			$_SERVER['HTTP_REFERER']='';
		}

		if (!isset($_SERVER['HTTP_USER_AGENT'])) {
			$_SERVER['HTTP_USER_AGENT']='';
		}

		$this->logMessage(__CLASS__, 'error_'.$error_status, ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error_status'=>$error_status, 'remote_addr'=>getenv('REMOTE_ADDR'), 'redirect_url'=>$_SERVER['REDIRECT_URL'], 'http_referer'=>$_SERVER['HTTP_REFERER'], 'http_user_agent'=>$_SERVER['HTTP_USER_AGENT']]);
		echo '<code>';
		echo '<h1>'.sprintf(tOut('title'), $error_status).'</h1>';
		echo tOut('request_uri').': '.h()->_outputString(getenv('REDIRECT_URL')).'<br/>';
		echo tOut('status').': '.tOut('error_msg_'.$error_status).'<br/>';
		echo '<br/>';
		echo '<a href="'.osW_Template::getInstance()->buildhrefLink('default').'">'.tOut('startpage').'</a>';
		echo '</code>';
	}

	/**
	 *
	 * @return osW_ErrorLogger
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>