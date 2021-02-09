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
class osW_FPDI extends osW_Object {

	/* VALUES */
	static $pdf_pool=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(1, 0, true);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	static function create($pdf_alias) {
		if (!class_exists('TCPDF')) {
			require_once vOut('settings_abspath').'frame/classes/external/tcpdf/tcpdf.php';
		}

		$options=[];
		if (isset(self::$pdf_pool[$pdf_alias])) {
			$options=self::$pdf_pool[$pdf_alias];
		}

		$default_options=['orientation'=>'P', 'unit'=>'mm', 'format'=>'A4', 'unicode'=>true, 'encoding'=>'UTF-8', 'diskcache'=>false, 'pdfa'=>false];

		foreach ($default_options as $key=>$value) {
			if (!isset($options[$key])) {
				$options[$key]=$value;
			}
		}

		return new osW_FPDI_Bridge($options['orientation'], $options['unit'], $options['format'], $options['unicode'], $options['encoding'], $options['diskcache'], $options['pdfa']);
	}

	static function addOptions($pdf_alias, $pdf_options=[]) {
		self::$pdf_pool[$pdf_alias]=$pdf_options;
	}

	static $pdf_objects;

	/**
	 *
	 * @return FPDI
	 */
	static function getInstance($pdf_alias='') {
		if (!isset(self::$pdf_objects['obj_'.$pdf_alias])||!is_object(self::$pdf_objects['obj_'.$pdf_alias])) {
			osW_Object::checkIsEnabled(__CLASS__);
			self::$pdf_objects['obj_'.$pdf_alias]=self::create($pdf_alias);
		}

		return self::$pdf_objects['obj_'.$pdf_alias];
	}

	static function unsetInstance($pdf_alias='') {
		if (isset(self::$pdf_objects['obj_'.$pdf_alias])||!is_object(self::$pdf_objects['obj_'.$pdf_alias])) {
			self::$pdf_objects['obj_'.$pdf_alias]=null;
		}
	}

}

?>