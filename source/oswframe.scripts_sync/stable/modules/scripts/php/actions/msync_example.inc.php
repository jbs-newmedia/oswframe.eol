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

$name='sync_master';

$ar_conf=['check_name'=>$name, 'check_intervall'=>60*60, # Sekunden
	'check_key'=>'', # 32stellen
	'check_sum'=>'', # 16stellen
	'check_uploadurl'=>'', 'check_pack'=>'gz', 'check_pack_level'=>9, 'check_sync_data'=>true, 'check_sync_index'=>true, 'check_sync_index_seperator'=>';', 'check_sync_report_error'=>false, 'check_sync_report_success'=>false, 'check_sync_report_email_to'=>'', 'check_sync_report_email_from'=>'', 'check_sync_report_email_title_error'=>$name.' sync fehlerhaft', 'check_sync_report_email_title_success'=>$name.' sync erfolgreich', 'check_sync_log'=>false, 'check_sync_log_file'=>vOut('settings_abspath').'modules/'.vOut('project_default_module').'/resources/msync_'.$name.'.log'];

$ar_tables=[['tbl_instance'=>'', 'tbl_name'=>'table_1', 'tbl_index'=>'row_id', 'tbl_create'=>'field_create', 'tbl_update'=>'field_update', 'tbl_where'=>'1', 'tbl_included_fields'=>[], 'tbl_excluded_fields'=>['field_value_1', 'field_value_1'], 'tbl_time'=>'timestamp'], ['tbl_instance'=>'', 'tbl_name'=>'table_2', 'tbl_index'=>'row_id', 'tbl_create'=>'field_create', 'tbl_update'=>'field_update', 'tbl_where'=>'field_name LIKE \'%Name%\'', 'tbl_included_fields'=>['field_value_1'], 'tbl_excluded_fields'=>[], 'tbl_time'=>'timestamp']];

# CONFIG - END

include vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/actions/msync_core.inc.php';

?>