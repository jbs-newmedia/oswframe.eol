<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

$_loader_project=vOut('settings_abspath').'modules/'.vOut('project_default_module').'/resources/js/lib/'.$lib_name.'/loader.inc.php';
$_loader_frame=vOut('settings_abspath').'frame/resources/js/lib/'.$lib_name.'/loader.inc.php';
if (file_exists($_loader_project)) {
	include($_loader_project);
	$this->loaded_libs[$lib_name]=true;

	return true;
} elseif (file_exists($_loader_frame)) {
	include($_loader_frame);
	$this->loaded_libs[$lib_name]=true;

	return true;
}

$_lib_project='modules/'.vOut('project_default_module').'/resources/js/lib/'.$lib_name.'/'.$lib_name.'.js';
$_lib_frame='frame/resources/js/lib/'.$lib_name.'/'.$lib_name.'.js';
if (file_exists($_lib_project)) {
	osW_Template::getInstance()->addJSFileHead($_lib_project);
	$this->loaded_libs[$lib_name]=true;

	return true;
} elseif (file_exists($_lib_frame)) {
	osW_Template::getInstance()->addJSFileHead($_lib_frame);
	$this->loaded_libs[$lib_name]=true;

	return true;
}

return false;

?>