<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_FrameConnect extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function getStatsImage($type=0, $options=[]) {
		$session=substr(osW_Session::getInstance()->getId(), 0, 16);
		$checksum=substr(md5($session.vOut('frameconnect_apisalt')), 0, 8);

		// TODO ssl
		$prot='https://';
		if ((strlen(vOut('frameconnect_apisalt'))==16)&&(strlen(vOut('frameconnect_apikey'))==4)) {
			$img=$prot.'oswframe.com/osw-'.vOut('frameconnect_apikey').'-'.$session.'-'.$checksum.'.png';
		} else {
			$img=$prot.'oswframe.com/engine/';
		}

		switch ($type) {
			case 1 :
				break;
			case 2 :
				break;
			default :
				return '<a href="http://oswframe.com/" target="_blank"><img src="'.$img.'" alt="oswframe" title="osWFrame - PHP5 Framework"/></a>';
				break;
		}
	}

	/**
	 *
	 * @return osW_FrameConnect
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>