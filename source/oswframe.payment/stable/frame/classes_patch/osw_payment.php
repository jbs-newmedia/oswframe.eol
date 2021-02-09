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
$table='payment';
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
	payment_id int(11) unsigned NOT NULL AUTO_INCREMENT,
	payment_paymodul varchar(16) NOT NULL,
	payment_time int(11) unsigned NOT NULL,
	payment_verifier_intern varchar(32) NOT NULL,
	payment_verified_intern tinyint(1) unsigned NOT NULL,
	payment_verifier_extern varchar(64) NOT NULL,
	payment_verified_extern tinyint(1) unsigned NOT NULL,
	payment_verified tinyint(1) unsigned NOT NULL,
	payment_amount double NOT NULL,
	payment_status tinyint(1) unsigned NOT NULL,
	payment_datafields text NOT NULL,
	PRIMARY KEY (payment_id),
	UNIQUE KEY payment_verifier (payment_verifier_intern,payment_verifier_extern),
	KEY payment_paymodul (payment_paymodul),
	KEY payment_time (payment_time),
	KEY payment_verifier_intern (payment_verifier_intern),
	KEY payment_verified_intern (payment_verified_intern),
	KEY payment_verifier_extern (payment_verifier_extern),
	KEY payment_verified_extern (payment_verified_extern),
	KEY payment_verified (payment_verified),
	KEY payment_amount (payment_amount)
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
$table='payment_verifier';
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
  verifier_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  order_number varchar(32) NOT NULL,
  verifier_checksum varchar(32) NOT NULL,
  verifier_time int(11) unsigned NOT NULL,
  verifier_amount double NOT NULL,
  verifier_datafields text NOT NULL,
  PRIMARY KEY (verifier_id),
  KEY verifier_checksum (verifier_checksum),
  KEY verifier_time (verifier_time),
  KEY verifier_amount (verifier_amount),
  KEY order_id (order_number)
) ENGINE='.vOut('database_engine').' DEFAULT CHARSET=utf8 COMMENT=\'1.0\';
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