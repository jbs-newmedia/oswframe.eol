<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

# CONFIG

$name='sync_slave';

$ar_conf=['check_name'=>$name, 'check_key'=>'', # 32stellen
	'check_sum'=>'', # 16stellen
	'check_pack'=>'gz', 'check_sync_index_seperator'=>';', 'check_sync_log'=>false, 'check_sync_log_file'=>vOut('settings_abspath').'modules/'.vOut('project_default_module').'/resources/ssync_'.$name.'.log'];

# CONFIG - END

include vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/actions/ssync_core.inc.php';

?>