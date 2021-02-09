<?php

/**
 * TODO:
 * change store_temp_session() to #store_temp_session();
 * change restore_temp_session() to #restore_temp_session();
 */

define('OSW_ROOT_DIR', realpath(__DIR__.'/../../'));

if (!defined('OSW_TOKEN_NAME')) {
	define('OSW_TOKEN_NAME', 'osw_token');
}
if (!defined('OSW_START_SESSION')) {
	define('OSW_START_SESSION', true);
}
if (!defined('OSW_CHECK_SESSION')) {
	define('OSW_CHECK_SESSION', true);
}
if (!defined('OSW_VERIFY_SESSION')) {
	define('OSW_VERIFY_SESSION', true);
}

if (!function_exists('verifyFrameSession')) {
	function verifyFrameSession() {
		if ($_SESSION['useragent']!==(isset($_SERVER['HTTP_USER_AGENT'])?strtolower($_SERVER['HTTP_USER_AGENT']):'')) {
			return false;
		}
		if ($_SESSION['sessionlastcheck']<(time()-getFrameConfig('session_lifetime', 'integer'))) {
			return false;
		}

		return true;
	}
}
if (!function_exists('getFrameConfig')) {
	function getFrameConfig($var, $type='string') {
		if (file_exists(OSW_ROOT_DIR.'/modules/configure.project-dev.php')) {
			$config_files=[OSW_ROOT_DIR.'/modules/configure.project-dev.php', OSW_ROOT_DIR.'/frame/configure.php'];
		} else {
			$config_files=[OSW_ROOT_DIR.'/modules/configure.project.php', OSW_ROOT_DIR.'/frame/configure.php'];
		}
		$value='';
		foreach ($config_files as $file_name) {
			if (file_exists($file_name)) {
				$content=file_get_contents($file_name);
				switch ($type) {
					case 'integer':
					case 'int':
						preg_match('/osW_Settings::getInstance\(\)->'.$var.'=([0-9]+)/si', $content, $matches);
						break;
					case 'boolean':
					case 'bool':
						preg_match('/osW_Settings::getInstance\(\)->'.$var.'=(true|false){1,1}/si', $content, $matches);
						break;
					default:
						preg_match('/osW_Settings::getInstance\(\)->'.$var.'=\'([^;]*)\'/si', $content, $matches);
						break;
				}

				if (isset($matches[1])) {
					$value=$matches[1];

					return $value;
				}
			}
		}
	}
}

$cookie_domain='';
if (strlen(getFrameConfig('project_subdomain'))>0) {
	$cookie_domain.=getFrameConfig('project_subdomain').'.';
}

$cookie_domain.=getFrameConfig('project_domain');
session_save_path(realpath(OSW_ROOT_DIR.'/'.getFrameConfig('session_path')));
if (getFrameConfig('session_use_only_cookies', 'boolean')===true) {
	ini_set('session.use_only_cookies', 1);
} else {
	ini_set('session.use_only_cookies', 0);
}
session_set_cookie_params(0, '/', $cookie_domain, getFrameConfig('session_secure', 'boolean'), getFrameConfig('session_httponly', 'boolean'));
session_name(getFrameConfig('session_name'));

if (OSW_START_SESSION==true) {
	session_start();
}

if (OSW_VERIFY_SESSION==true) {
	if (verifyFrameSession()!==true) {
		die('Session error, please retry');
	}
}

if (OSW_CHECK_SESSION==true) {
	if ($_SESSION[OSW_TOKEN_NAME]!=md5(getFrameConfig('settings_protection_salt').session_id())) {
		die('Authentifikation error, please use cookies');
	}
}

?>