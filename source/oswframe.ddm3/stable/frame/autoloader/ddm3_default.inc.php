<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

$_path_module=vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/ddm3/'.$path.$file;
$_path_project=vOut('settings_abspath').'modules/'.vOut('project_default_module').'/ddm3/'.$path.$file;
$_path_frame=vOut('settings_abspath').'frame/ddm3/'.$path.$file;

if (file_exists($_path_frame)) {
	include $_path_frame;
} elseif (file_exists($_path_project)) {
	include $_path_project;
} elseif (file_exists($_path_module)) {
	include $_path_module;
}

?>