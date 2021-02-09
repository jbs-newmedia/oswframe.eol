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
$table='user';
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
CREATE TABLE :table: (
  user_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  user_email varchar(64) NOT NULL,
  user_password varchar(35) NOT NULL,
  user_status tinyint(1) unsigned NOT NULL,
  user_groupids varchar(128) NOT NULL,
  user_isadmin tinyint(1) unsigned NOT NULL,
  user_cookielevel tinyint(1) unsigned NOT NULL,
  user_language varchar(3) NOT NULL,
  user_cookie varchar(32) NOT NULL,
  user_apicookie varchar(32) NOT NULL,
  PRIMARY KEY (user_id),
  KEY user_status (user_status),
  KEY user_cookie (user_cookie),
  KEY user_email (user_email)
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