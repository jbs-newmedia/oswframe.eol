<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

$_loader_project=vOut('settings_abspath').'modules/'.vOut('project_default_module').'/resources/jquery3/plugins/'.$plugin_name.'/loader.inc.php';
$_loader_frame=vOut('settings_abspath').'frame/resources/jquery3/plugins/'.$plugin_name.'/loader.inc.php';
if (file_exists($_loader_project)) {
	include($_loader_project);
	$this->loaded_plugins[$plugin_name]=true;

	return true;
} elseif (file_exists($_loader_frame)) {
	include($_loader_frame);
	$this->loaded_plugins[$plugin_name]=true;

	return true;
}

$_plugin_project='modules/'.vOut('project_default_module').'/resources/jquery3/plugins/'.$plugin_name.'/jquery.'.$plugin_name.'.js';
$_plugin_frame='frame/resources/jquery3/plugins/'.$plugin_name.'/jquery.'.$plugin_name.'.js';
if (file_exists($_plugin_project)) {
	osW_Template::getInstance()->addJSFileHead($_plugin_project);
	$this->loaded_plugins[$plugin_name]=true;

	return true;
} elseif (file_exists($_plugin_frame)) {
	osW_Template::getInstance()->addJSFileHead($_plugin_frame);
	$this->loaded_plugins[$plugin_name]=true;

	return true;
}

return false;

?>