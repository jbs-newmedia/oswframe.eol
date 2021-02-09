<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

$script=h()->_catch('script', '', 'gp');

$search_dirs=[];

$file=vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/scripts_header.inc.php';
if (file_exists($file)) {
	include($file);
}

$search_dirs[]='actions';

$found=false;
foreach ($search_dirs as $_dir) {
	if ($found===false) {
		$dir=realpath(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/php/'.$_dir);
		$file=$dir.'/'.$script.'.inc.php';

		if ((file_exists($file))&&(dirname(realpath($file))==$dir)) {
			include($file);
			$found=true;
		}
	}
}

$file=vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/scripts_footer.inc.php';
if (file_exists($file)) {
	include($file);
}

if ($found===true) {
	h()->_die();
} else {
	h()->_die($script.' not found');
}

?>