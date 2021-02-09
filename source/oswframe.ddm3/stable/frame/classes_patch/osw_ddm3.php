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
$table='ddm3_cache';
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
	cache_id varchar(32) NOT NULL,
	cache_lastuse int(10) unsigned NOT NULL,
	cache_data longtext NOT NULL,
	KEY cache_id (cache_id),
	KEY cache_lastuse (cache_lastuse)
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

#============================================================================================================================
# check Tabelle#2
#============================================================================================================================
$table='ddm3_lock';
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
	lock_toolid int(11) unsigned NOT NULL,
	lock_group varchar(64) NOT NULL,
	lock_key varchar(64) NOT NULL,
	lock_value varchar(64) NOT NULL,
	user_id int(11) unsigned NOT NULL,
	lock_time int(11) unsigned NOT NULL
) ENGINE='.vOut('database_engine').' DEFAULT CHARSET=utf8 COMMENT=\'1.0\';
');
	$QwriteData->bindTable(':table:', $table);
	$QwriteData->execute();
	$av_tbl=1;
	$ab_tbl=0;

	$QwriteData=osW_Database::getInstance()->query('
	ALTER TABLE :table:
	ADD UNIQUE KEY lock_unique (lock_toolid,lock_group,lock_key,lock_value),
	ADD KEY lock_toolid (lock_toolid),
	ADD KEY lock_group (lock_group),
	ADD KEY lock_key (lock_key),
	ADD KEY lock_value (lock_value),
	ADD KEY user_id (user_id),
	ADD KEY lock_time (lock_time);
	');
	$QwriteData->bindTable(':table:', $table);
	$QwriteData->execute();
	$av_tbl=1;
	$ab_tbl=0;
}
#============================================================================================================================
# check Tabelle#2 - END
#============================================================================================================================

?>