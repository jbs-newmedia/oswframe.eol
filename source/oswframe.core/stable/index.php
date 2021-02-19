<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * PHP Version prüfen.
 */
if ((!defined('PHP_VERSION_ID'))||(PHP_VERSION_ID<50600)) {
	die('This version of osWFrame requires PHP 5.6 or higher.<br/>You are currently running PHP '.phpversion().'.');
}

# set charset
header('Content-Type: text/html; charset=utf-8');

# get abspath to framework
define('settings_abspath', str_replace('\\', '/', dirname(__FILE__)).'/');

# start the timer for the page parse time log
define('PAGE_PARSE_TIME_START', microtime(true));

# set initlevel of error reporting
error_reporting(E_ALL);

# include functions (need __autoload)
require(settings_abspath.'frame/includes/functions.inc.php');

# setp abspath to framework
osW_Settings::getInstance()->settings_abspath=settings_abspath;

# Lade Framekonfiguration
if (file_exists(vOut('settings_abspath').'frame/configure.php')) {
	require(vOut('settings_abspath').'frame/configure.php');
} else {
	h()->_die('file frame/configure.php is missing!');
}

# Lade Benutzerkonfiguration
if (file_exists(vOut('settings_abspath').'modules/configure.project-dev.php')) {
	osW_Settings::getInstance()->settings_runmode='dev';
	require(vOut('settings_abspath').'modules/configure.project-dev.php');
} elseif (file_exists(vOut('settings_abspath').'modules/configure.project.php')) {
	osW_Settings::getInstance()->settings_runmode='live';
	require(vOut('settings_abspath').'modules/configure.project.php');
}

# Lade Konfiguration-Patch
if (file_exists(vOut('settings_abspath').'modules/configure.patch-dev.php')) {
	require(vOut('settings_abspath').'modules/configure.patch-dev.php');
} elseif (file_exists(vOut('settings_abspath').'modules/configure.patch.php')) {
	require(vOut('settings_abspath').'modules/configure.patch.php');
}

# include debuglib
if (vOut('debug_lib')===true) {
	$GLOBALS['DEBUGLIB_LVL']=vOut('debug_lib_lvl');
	$GLOBALS['DEBUGLIB_MAX_Y']=vOut('debug_lib_max_y');
	include(vOut('settings_abspath').'frame/includes/debuglib.inc.php');
}

# set level of error reporting
error_reporting(vOut('debug_apachelevel'));

# set locale
$setlocale=h()->_setLocale();

# set timezone
$settimezone=h()->_setTimezone();

# set new error_handler
set_error_handler([osW_ErrorHandler::getInstance(), 'handle']);

# Remove the magic quotes if set from the GPC Globals
if (get_magic_quotes_gpc()>0) {
	osW_Settings::getInstance()->removeMagicQuotes();
}

if (osW_Object::setIsEnabled('osW_Database')===true) {
	osW_Database::addDatabase('default', ['type'=>vOut('database_type'), 'database'=>vOut('database_db'), 'server'=>vOut('database_server'), 'username'=>vOut('database_username'), 'password'=>vOut('database_password'), 'pconnect'=>vOut('database_pconnect'), 'prefix'=>vOut('database_prefix')]);
}

osW_Settings::getInstance()->checkProjectConfig();

# set default frame module
osW_Settings::getInstance()->frame_default_module=osW_Language::getInstance()->nav2mod(h()->_catch('module', vOut('project_default_module'), 'g'));

# check session if spider
if (osW_Session::getInstance()->isSpider()!==true) {
	if (osW_Settings::getInstance()->isSessionModule(vOut('frame_default_module'))===true) {
		# check session
		osW_Session::getInstance()->checkSession();

		if (osW_Session::getInstance()->exists('user_id')===true) {
			if ((vOut('user_class')=='')||(vOut('user_class')=='pref')) {
				osW_User::getInstance()->setUserData(osW_Session::getInstance()->value('user_id'), explode(',', vOut('user_pref')));
			} else {
				osW_User::getInstance()->setData(osW_Session::getInstance()->value('user_id'));
			}
		} else {
			if ((vOut('user_class')=='')||(vOut('user_class')=='pref')) {
				osW_User::getInstance()->setUserData(osW_User::getInstance()->checkUserCookie(), explode(',', vOut('user_pref')));
			} else {
				osW_User::getInstance()->setData(osW_User::getInstance()->checkUserCookie());
			}
		}
	} else {
		if ((vOut('user_class')=='')||(vOut('user_class')=='pref')) {
			osW_User::getInstance()->setUserData(0);
		} else {
			osW_User::getInstance()->setData(0);
		}
	}
} else {
	if ((vOut('user_class')=='')||(vOut('user_class')=='pref')) {
		osW_User::getInstance()->setUserData(0);
	} else {
		osW_User::getInstance()->setData(0);
	}
}

# Seitenschutz
if ((vOut('project_protection_user')!='')&&(vOut('project_protection_password')!='')) {
	if ((osW_Session::getInstance()->value('project_protection_user')!=(sha1(vOut('project_protection_user'))))||(osW_Session::getInstance()->value('project_protection_password')!=(sha1(vOut('project_protection_password'))))) {
		if ((isset($_SERVER['PHP_AUTH_USER']))&&(isset($_SERVER['PHP_AUTH_PW']))) {
			osW_Session::getInstance()->set('project_protection_user', sha1($_SERVER['PHP_AUTH_USER']));
			osW_Session::getInstance()->set('project_protection_password', sha1($_SERVER['PHP_AUTH_PW']));
			if ((sha1($_SERVER['PHP_AUTH_USER'])!=(sha1(vOut('project_protection_user'))))||(sha1($_SERVER['PHP_AUTH_PW'])!=(sha1(vOut('project_protection_password'))))) {
				header('WWW-Authenticate: Basic realm="'.h()->outputString(vOut('project_name')).'"');
				header('HTTP/1.0 401 Unauthorized');
				die('<br/><br/><center><h1>Zugriff verweigert!</h1></center>');
			}
		} else {
			header('WWW-Authenticate: Basic realm="'.h()->outputString(vOut('project_name')).'"');
			header('HTTP/1.0 401 Unauthorized');
			die('<br/><br/><center><h1>Zugriff verweigert!</h1></center>');
		}
	}
}

osW_Permission::getInstance()->readPermissions();

# pagerestrictor, kill spammers and fakespider
if ((osW_Object::setIsEnabled('osW_PageRestrictor')===true)&&((osW_Session::getInstance()->isNewSession()===true)||(osW_Session::getInstance()->isSpider()===true))) {
	osW_PageRestrictor::getInstance()->handle();
}

# read messages from session, transferred messages
osW_MessageStack::getInstance()->loadFromSession();

# set default index template
osW_Template::getInstance()->setIndexFile('index', vOut('project_default_module'));

# set action
osW_Settings::getInstance()->setAction(h()->_catch('action', '', 'pg'));

/**********************************************************************************************************/
/************************************************* START **************************************************/
/**********************************************************************************************************/

# validate base-url

osW_Seo::getInstance()->checkBaseUrl();

osW_Settings::getInstance()->frame_current_module=vOut('project_default_module');
if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/header.inc.php')) {
	include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/header.inc.php');
}

osW_Settings::getInstance()->frame_engine=true;
osW_Settings::getInstance()->frame_currentruntime=0;

while (vOut('frame_engine')===true) {
	osW_Settings::getInstance()->frame_currentruntime++;

	if (vOut('frame_currentruntime')==vOut('settings_modules_runs')) {
		h()->_dieError('max runs !!!');
	}

	if (osW_Permission::getInstance()->checkPermission(vOut('frame_default_module'), 'view_content', osW_User::getInstance()->getGroupIds())!==true) {
		$_GET['error_status']=404;
		osW_Settings::getInstance()->frame_default_module=vOut('settings_errorlogger');
	}

	osW_Language::getInstance()->addLanguageVarsByFile('current', 'current', 'navigation', 'modules');

	osW_Settings::getInstance()->frame_current_module=vOut('project_default_module');
	osW_Language::getInstance()->addLanguageVarsByFile();

	osW_Settings::getInstance()->frame_current_module=vOut('frame_default_module');
	osW_Language::getInstance()->addLanguageVarsByFile();

	if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/conf.inc.php')) {
		include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/conf.inc.php');
	}

	# validate base-url
	osW_Seo::getInstance()->checkBaseUrl();

	if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/content.inc.php')) {
		osW_Settings::getInstance()->frame_engine=false;
		include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/content.inc.php');
		osW_Template::getInstance()->set('content', osW_Template::getInstance()->fetchFileIfExists('content', vOut('frame_current_module')));
	} else {
		$_GET['error_status']=404;
		osW_Settings::getInstance()->frame_default_module=vOut('settings_errorlogger');
	}
}

# validate seo-url
osW_Seo::getInstance()->checkCanonicalUrl();

osW_Settings::getInstance()->frame_current_module=vOut('project_default_module');
if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/footer.inc.php')) {
	include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/footer.inc.php');
}

/**********************************************************************************************************/
/************************************************** END ***************************************************/
/**********************************************************************************************************/

# stop the timer for the page parse time log
define('PAGE_PARSE_TIME_END', microtime(true));

osW_Settings::getInstance()->checkSlowRunTime();

# send page in gzip
if ((vOut('template_gzipcompression')===true)&&(!headers_sent())&&(!connection_aborted())&&(ob_get_length()==0)) {
	ini_set('zlib.output_compression_level', vOut('template_gzipcompression_level'));
	ob_start('ob_gzhandler');
}

if (vOut('debug_lib_used')===true) {
	osW_Template::getInstance()->addCSSFileHead('modules/'.vOut('frame_current_module').'/css/debuglib.css');
}

# strip content
if (vOut('template_stripoutput')===true) {
	$contents=osW_Template::getInstance()->strip(osW_Template::getInstance()->fetch(osW_Template::getInstance()->getIndexFile(), vOut('project_default_module')));
} else {
	$contents=osW_Template::getInstance()->fetch(osW_Template::getInstance()->getIndexFile(), vOut('project_default_module'));
}

# highlight words in body
osW_Template::getInstance()->setHighlightColors(['#FFFF66', '#A0FFFF', '#99FF99', '#FF9999', '#FF66FF', '#880000', '#00AA00', '#886800']);
if ((osW_Session::getInstance()->isSpider()!==true)&&(vOut('frame_highlight_words'))) {
	$contents=osW_Template::getInstance()->highlightWords($contents, $words);
}

# page output
h()->_die($contents);

?>