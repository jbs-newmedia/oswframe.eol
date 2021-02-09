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
class osW_SEPA extends osW_Object {

	/* PROPERTIES */
	public $obj_sepa;

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(1, 0, true);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function getSEPAObject() {
		if (!is_object($this->obj_sepa)) {
			$this->obj_sepa=new KtoSepaSimple();
		}

		return $this->obj_sepa;
	}

	public function Add($aDatum, $aBetrag, $aName, $aIban, $aBic=null, $aCtgyPurp=null, $aPurp=null, $aRef=null, $aVerwend=null, $aSeqTp=null, $aMandatRef=null, $aMandatDate=null, $aOldMandatRef=null, $aOldName=null, $aOldCreditorId=null, $aOldIban=null, $aOldBic=null) {
		return $this->getSEPAObject()->Add($aDatum, $aBetrag, $aName, $aIban, $aBic, $aCtgyPurp, $aPurp, $aRef, $aVerwend, $aSeqTp, $aMandatRef, $aMandatDate, $aOldMandatRef, $aOldName, $aOldCreditorId, $aOldIban, $aOldBic);
	}

	public function GetXML($aType, $aMsgId, $aPmtInfId, $aInitgPty, $aAuftraggeber, $aIban, $aBic, $aCreditorId=null) {
		return $this->getSEPAObject()->GetXML($aType, $aMsgId, $aPmtInfId, $aInitgPty, $aAuftraggeber, $aIban, $aBic, $aCreditorId);
	}

	/**
	 *
	 * @return osW_SEPA
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>