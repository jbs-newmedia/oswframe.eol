<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

if ($paymodulpart=='runsystem') {
	$_path_module=vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/payments/'.$paymodulpart.'.inc.php';
	$_path_project=vOut('settings_abspath').'modules/'.vOut('project_default_module').'/payments/'.$paymodulpart.'.inc.php';
	$_path_frame=vOut('settings_abspath').'frame/payments/'.$paymodulpart.'.inc.php';

	if (file_exists($_path_module)) {
		include $_path_module;
	} elseif (file_exists($_path_project)) {
		include $_path_project;
	} elseif (file_exists($_path_frame)) {
		include $_path_frame;
	}
} else {
	$_path_frame=vOut('settings_abspath').'frame/payments/'.$paymodul.'/'.$paymodulpart.'.inc.php';
	$_path_project=vOut('settings_abspath').'modules/'.vOut('project_default_module').'/payments/'.$paymodul.'/'.$paymodulpart.'.inc.php';
	$_path_module=vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/payments/'.$paymodul.'/'.$paymodulpart.'.inc.php';

	if (file_exists($_path_frame)) {
		include $_path_frame;
	} elseif (file_exists($_path_project)) {
		include $_path_project;
	} elseif (file_exists($_path_module)) {
		include $_path_module;
	}
}

?>