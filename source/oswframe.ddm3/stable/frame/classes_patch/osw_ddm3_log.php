<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

# current version build
$cv=$this->_version;
$cb=$this->_build;

#============================================================================================================================
# check Tabelle#1
#============================================================================================================================
$table='ddm3_log';
$QreadData=osW_Database::getInstance()->query('SHOW TABLE STATUS FROM :database_db: LIKE :table:');
$QreadData->bindRaw(':database_db:', vOut('database_db'));
$QreadData->bindValue(':table:', vOut('database_prefix').$table);
$QreadData->execute();
if ($QreadData->numberOfRows()==1) {
	$QreadData->next();
	$avb_tbl=$QreadData->result['Comment'];
} else {
	$avb_tbl='0.0';
}

$avb_tbl=explode('.', $avb_tbl);
if (count($avb_tbl)==1) {
	$av_tbl=intval($avb_tbl[0]);
	$ab_tbl=0;
} elseif (count($avb_tbl)==2) {
	$av_tbl=intval($avb_tbl[0]);
	$ab_tbl=intval($avb_tbl[1]);
} else {
	$av_tbl=0;
	$ab_tbl=0;
}

if (($av_tbl==0)&&($ab_tbl==0)) {
	$QwriteData=osW_Database::getInstance()->query('
CREATE TABLE IF NOT EXISTS :table: (
  log_id int(11) unsigned NOT NULL,
  log_group varchar(64) NOT NULL,
  name_index varchar(128) NOT NULL,
  value_index varchar(128) NOT NULL,
  log_key varchar(64) NOT NULL,
  log_value_new text NOT NULL,
  log_value_old text NOT NULL,
  log_value_user_id_new int(11) unsigned NOT NULL,
  log_value_user_id_old int(11) unsigned NOT NULL,
  log_value_time_new int(11) unsigned NOT NULL,
  log_value_time_old int(11) unsigned NOT NULL
  ADD PRIMARY KEY (log_id),
  ADD KEY name_index (name_index),
  ADD KEY value_index (value_index),
  ADD KEY log_key (log_key),
  ADD KEY log_value_user_id_new (log_value_user_id_new),
  ADD KEY log_value_user_id_old (log_value_user_id_old),
  ADD KEY log_value_time_new (log_value_time_new),
  ADD KEY log_value_time_old (log_value_time_old),
) ENGINE='.vOut('database_engine').' DEFAULT CHARSET=utf8 COMMENT=\'1.0\';
');
	$QwriteData->bindTable(':table:', $table);
	$QwriteData->execute();
	$av_tbl=1;
	$ab_tbl=0;
}
#============================================================================================================================
# check Tabelle#1 - END
#============================================================================================================================

?>