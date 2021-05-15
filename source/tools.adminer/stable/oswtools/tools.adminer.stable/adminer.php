<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package oswFrame - Tools
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/*
 * TOOL - Changelog
 */

define('abs_path', str_replace('\\', '/', str_replace(basename(dirname(__FILE__)), '', dirname(__FILE__))));

define('serverlist', 'oswframe');
define('package', 'tools.adminer');
define('release', 'stable');

include abs_path.'resources/includes/header.inc.php';

function adminer_object() {
	// required to run any plugin
	include_once abs_path.'resources/php/adminer/plugins/plugin.php';

	// autoloader
	foreach (glob(abs_path.'resources/php/adminer/plugins/*.php') as $filename) {
		include_once $filename;
	}

	$_designs=glob(abs_path.'resources/php/adminer/designs/*');
	$designs=[];
	foreach ($_designs as $design) {
		$designs[basename($design)]=basename($design);
	}

	$plugins=[// specify enabled plugins here
		new AdmineroswTools, new AdminerFrames, new FillLoginForm('server', osW_Tool::getInstance()->getFrameConfig('database_server'), osW_Tool::getInstance()->getFrameConfig('database_username'), osW_Tool::getInstance()->getFrameConfig('database_password'), osW_Tool::getInstance()->getFrameConfig('database_db')), new AdminerDesigns($designs), new AdminerTableHeaderScroll()];

	#	osW_Settings::getInstance()->database_type='mysql';

	return new AdminerPlugin($plugins);
}

include abs_path.'resources/php/adminer/adminer-4.8.1.php';
die();

?>