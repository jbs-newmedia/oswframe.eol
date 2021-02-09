<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

$file=vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/actions/msync_header.inc.php';
if (file_exists($file)) {
	include($file);
}

$ar_conf_check=['check_name'=>$name, 'check_intervall'=>60*60, # Sekunden
	'check_key'=>'', # 24stellen
	'check_sum'=>'', # 16stellen
	'check_uploadurl'=>'', 'check_pack'=>'gz', 'check_pack_level'=>9, 'check_sync_data'=>true, 'check_sync_index'=>true, 'check_sync_index_seperator'=>';', 'check_sync_report_error'=>false, 'check_sync_report_success'=>false, 'check_sync_report_email_to'=>'', 'check_sync_report_email_from'=>'', 'check_sync_report_email_title_error'=>$name.' sync fehlerhaft', 'check_sync_report_email_title_success'=>$name.' sync erfolgreich', 'check_sync_log'=>false, 'check_sync_log_file'=>vOut('settings_abspath').'modules/'.vOut('project_default_module').'/resources/msync_'.$name.'.log'];

foreach ($ar_conf_check as $key=>$value) {
	if (!isset($ar_conf[$key])) {
		$ar_conf[$key]=$value;
	}
}

$ar_conf['check_key']=substr($ar_conf['check_key'], 0, 24);

$sync_data=[];

foreach ($ar_tables as $tbl) {
	if (!isset($tbl['tbl_instance'])) {
		$tbl['tbl_instance']='';
	}
	if (!isset($tbl['tbl_name'])) {
		$tbl['tbl_name']='';
	}
	if (!isset($tbl['tbl_index'])) {
		$tbl['tbl_index']='';
	}
	if (!isset($tbl['tbl_create'])) {
		$tbl['tbl_create']='';
	}
	if (!isset($tbl['tbl_update'])) {
		$tbl['tbl_update']='';
	}
	if (!isset($tbl['tbl_where'])) {
		$tbl['tbl_where']='1';
	}
	if (!isset($tbl['tbl_included_fields'])) {
		$tbl['tbl_included_fields']=[];
	}
	if (!isset($tbl['tbl_excluded_fields'])) {
		$tbl['tbl_excluded_fields']=[];
	}
	if (!isset($tbl['tbl_time'])) {
		$tbl['tbl_time']='timestamp';
	}
	$sync_data[$tbl['tbl_name']]=[];

	if ($ar_conf['check_sync_data']===true) {
		$sync_data[$tbl['tbl_name']]['data']=[];
		$QgetData=osW_Database::getInstance($tbl['tbl_instance'])->query('SELECT :selected_fields: FROM :tbl_check: WHERE :tbl_check_where: AND (:time_query:)');
		if (count($tbl['tbl_included_fields'])>0) {
			$QgetData->bindRaw(':selected_fields:', implode(', ', $tbl['tbl_included_fields']));
		} else {
			$QgetData->bindRaw(':selected_fields:', '*');
		}
		$QgetData->bindTable(':tbl_check:', $tbl['tbl_name']);
		$QgetData->bindRaw(':tbl_check_where:', $tbl['tbl_where']);
		if (($tbl['tbl_create']!='')&&($tbl['tbl_update']!='')) {
			$QgetData->bindRaw(':time_query:', ':tbl_check_create:>:tbl_check_create_value: OR :tbl_check_update:>:tbl_check_update_value:');
		} elseif ($tbl['tbl_create']!='') {
			$QgetData->bindRaw(':time_query:', ':tbl_check_create:>:tbl_check_create_value:');
		} elseif ($tbl['tbl_update']!='') {
			$QgetData->bindRaw(':time_query:', ':tbl_check_update:>:tbl_check_update_value:');
		} else {
			$QgetData->bindRaw(':time_query:', '1');
		}
		$QgetData->bindRaw(':tbl_check_create:', $tbl['tbl_create']);
		$QgetData->bindRaw(':tbl_check_update:', $tbl['tbl_update']);
		switch ($tbl['tbl_time']) {
			case 'datetime':
				$QgetData->bindValue(':tbl_check_create_value:', date('Y-m-d H:i:s', (time()-($ar_conf['check_intervall']))));
				$QgetData->bindValue(':tbl_check_update_value:', date('Y-m-d H:i:s', (time()-($ar_conf['check_intervall']))));
				break;
			default:
				$QgetData->bindInt(':tbl_check_create_value:', (time()-($ar_conf['check_intervall'])));
				$QgetData->bindInt(':tbl_check_update_value:', (time()-($ar_conf['check_intervall'])));
				break;
		}
		$QgetData->execute();

		if ($QgetData->query_handler===false) {
			h()->_die('msync error');
		}
		if ($QgetData->numberOfRows()>0) {
			while ($QgetData->next()) {
				foreach ($tbl['tbl_excluded_fields'] as $_field) {
					unset($QgetData->result[$_field]);
				}
				$sync_data[$tbl['tbl_name']]['data'][]=$QgetData->result;
			}
		}
	}

	if ($ar_conf['check_sync_index']===true) {
		$sync_data[$tbl['tbl_name']]['index']=[];
		$QgetData=osW_Database::getInstance($tbl['tbl_instance'])->query('SELECT :tbl_index: FROM :tbl_check: WHERE 1');
		$QgetData->bindTable(':tbl_check:', $tbl['tbl_name']);
		$QgetData->bindRaw(':tbl_index:', $tbl['tbl_index']);
		$QgetData->execute();

		if ($QgetData->query_handler===false) {
			h()->_die('msync error');
		}
		if ($QgetData->numberOfRows()>0) {
			while ($QgetData->next()) {
				foreach ($tbl['tbl_excluded_fields'] as $_field) {
					unset($QgetData->result[$_field]);
				}
				$sync_data[$tbl['tbl_name']]['index']['data'][]=$QgetData->result[$tbl['tbl_index']];
			}
		}
		$sync_data[$tbl['tbl_name']]['index']['data']=implode($ar_conf['check_sync_index_seperator'], $sync_data[$tbl['tbl_name']]['index']['data']);
		$sync_data[$tbl['tbl_name']]['index']['name']=$tbl['tbl_index'];
	}
}

$sync_data=serialize($sync_data);
$md5=md5($sync_data.$ar_conf['check_sum']);

if ($ar_conf['check_pack']=='gz') {
	$sync_data=base64_encode(gzcompress($sync_data, intval($ar_conf['check_pack_level'])));
}

$data=base64_encode(h()->_encrypt($sync_data, $ar_conf['check_key']));
file_put_contents(vOut('settings_abspath').vOut('cache_path').$ar_conf['check_name'].'.data', $data);
$post=['data'=>h()->_makeCurlFile(vOut('settings_abspath').vOut('cache_path').$ar_conf['check_name'].'.data'), 'checksum'=>$md5];

if (!function_exists('curl_init')) {
	h()->_die('curl error');
}

$ch=curl_init();
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $ar_conf['check_uploadurl']);
if (substr($ar_conf['check_uploadurl'], 0, 5)=='https') {
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
}
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
$response=curl_exec($ch);

curl_close($ch);
unlink(vOut('settings_abspath').vOut('cache_path').$ar_conf['check_name'].'.data');
if ($response=='sync ok') {
	if ($ar_conf['check_sync_report_success']===true) {
		mail($ar_conf['check_sync_report_email_to'], $ar_conf['check_sync_report_email_title_success'], $response, 'From:'.$ar_conf['check_sync_report_email_from']);
	}
	if ($ar_conf['check_sync_log']===true) {
		file_put_contents($ar_conf['check_sync_log_file'], time());
	}
} else {
	if ($ar_conf['check_sync_report_error']===true) {
		mail($ar_conf['check_sync_report_email_to'], $ar_conf['check_sync_report_email_title_error'], $response, 'From:'.$ar_conf['check_sync_report_email_from']);
	}
}

$file=vOut('settings_abspath').'modules/'.vOut('frame_default_module').'/php/actions/msync_footer.inc.php';
if (file_exists($file)) {
	include($file);
}

if (strlen($response)==0) {
	h()->_die('connection error');
}

h()->_die($response);

?>