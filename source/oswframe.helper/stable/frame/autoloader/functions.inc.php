<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

if (file_exists(settings_abspath.'frame/functions/'.$method.'.inc.php')) {
	include settings_abspath.'frame/functions/'.$method.'.inc.php';
} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/functions/'.$method.'.inc.php')) {
	include settings_abspath.'modules/'.vOut('project_default_module').'/functions/'.$method.'.inc.php';
} elseif (file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/functions/'.$method.'.inc.php')) {
	include settings_abspath.'modules/'.vOut('frame_current_module').'/functions/'.$method.'.inc.php';
}

?>