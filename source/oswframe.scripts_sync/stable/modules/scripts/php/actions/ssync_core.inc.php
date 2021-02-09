<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

$file=vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/actions/ssync_header.inc.php';
if (file_exists($file)) {
	include($file);
}

$ar_conf_check=['check_name'=>$name, 'check_key'=>'', # 32stellen
	'check_sum'=>'', # 16stellen
	'check_pack'=>'gz', 'check_sync_index_seperator'=>';', 'check_sync_log'=>false, 'check_sync_log_file'=>vOut('settings_abspath').'modules/'.vOut('project_default_module').'/resources/ssync_'.$name.'.log'];

foreach ($ar_conf_check as $key=>$value) {
	if (!isset($ar_conf[$key])) {
		$ar_conf[$key]=$value;
	}
}

$ar_conf['check_key']=substr($ar_conf['check_key'], 0, 24);

$sync_error=false;
$content=file_get_contents($_FILES['data']['tmp_name']);
$sync_data=base64_decode(file_get_contents($_FILES['data']['tmp_name']));
$sync_data=h()->_decrypt($sync_data, $ar_conf['check_key']);

if ($ar_conf['check_pack']=='gz') {
	$sync_data=gzuncompress(base64_decode($sync_data));
}

$sync_data=unserialize($sync_data);
if ($sync_data===false) {
	$sync_data=[];
}

if (md5(serialize($sync_data).$ar_conf['check_sum'])!=h()->_catch('checksum', '', 'p')) {
	h()->_die('error checksum');
}

foreach ($sync_data as $table=>$rows) {
	if (isset($rows['data'])) {
		foreach ($rows['data'] as $row) {
			$i=0;
			$key_name='';
			$key_value='';
			$row_update_values=[];
			$row_insert_names=[];
			$row_insert_values=[];
			foreach ($row as $key=>$value) {
				if ($i==0) {
					$key_name=$key;
					$key_value=$value;
				} else {
					$row_update_values[]=$key.'='."'".addslashes($value)."'";
				}
				$row_insert_names[]=$key;
				$row_insert_values[]="'".addslashes($value)."'";
				$i++;
			}

			$QsetData=osW_Database::getInstance()->query('
				INSERT INTO :table_row: (:row_insert_names:) VALUES (:row_insert_values:)
				ON DUPLICATE KEY UPDATE :row_update_values:
			');

			$QsetData->bindTable(':table_row:', $table);
			$QsetData->bindRaw(':row_index_name:', $key_name);
			$QsetData->bindValue(':row_index_value:', $key_value);
			$QsetData->bindRaw(':row_update_values:', implode(',', $row_update_values));
			$QsetData->bindRaw(':row_insert_names:', implode(',', $row_insert_names));
			$QsetData->bindRaw(':row_insert_values:', implode(',', $row_insert_values));
			$QsetData->execute();

			if ($QsetData->query_handler===false) {
				$sync_error=true;
			}
		}
	}

	if (isset($rows['index'])) {
		$QdelData=osW_Database::getInstance()->query('
			DELETE FROM :table_row: WHERE :tbl_index: NOT IN (:index_values:)
		');
		$QdelData->bindTable(':table_row:', $table);
		$QdelData->bindRaw(':tbl_index:', $rows['index']['name']);
		$QdelData->bindRaw(':index_values:', str_replace($ar_conf['check_sync_index_seperator'], ',', $rows['index']['data']));
		$QdelData->execute();
	}
}

if ($ar_conf['check_sync_log']===true) {
	file_put_contents(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/resources/ssync_'.$ar_conf['check_name'].'.log', time());
}

$file=vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/actions/ssync_footer.inc.php';
if (file_exists($file)) {
	include($file);
}

if ($sync_error===true) {
	h()->_die('ssync error');
} else {
	h()->_die('sync ok');
}

?>