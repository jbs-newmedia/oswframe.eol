<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 */

/*
 * Unterstuetzte Formate
 * Y = Jahr 4 stellig
 * m = Monat 2 stellig
 * d = Tag 2 stellig
 * H = Stunden 2 stellig
 * i = Minuten 2 stellig
 * s = Sekunden 2 stellig
 */

class osW_Date extends osW_Object {

	/* PROPERTIES */
	private $timestamps=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0, true);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function set($name, $value, $format='') {
		if ($format=='') {
			$this->timestamps[$name]=$value;

			return true;
		}
		// if (function_exists('date_create_from_format')) {
		// return $this->timestamps[$name]=date_create_from_format($format, $value);
		// } else {
		$date=strptime($value, $format);
		$this->timestamps[$name]=mktime($date['tm_hour'], $date['tm_min'], $date['tm_sec'], ($date['tm_mon']+1), ($date['tm_mday']), ($date['tm_year']+1900));

		return true;
		// }
	}

	public function get($name, $format='') {
		if ($format=='') {
			if (array_key_exists($name, $this->timestamps)) {
				return $this->timestamps[$name];
			} else {
				return 0;
			}
		}
		// if (date_format('date_format')) {
		// if (array_key_exists($name, $this->timestamps)) {
		// echo '+';
		// return date_format($format, $this->timestamps[$name]);
		// } else {
		// echo '-';
		// return date_format($format, 0);
		// }
		// } else {
		if (array_key_exists($name, $this->timestamps)) {
			return strftime($format, $this->timestamps[$name]);
		} else {
			return strftime($format, 0);
		}
		// }
	}

	public function setget($name, $value, $set_format='', $get_format='') {
		$this->set($name, $value, $set_format);

		return $this->get($name, $get_format);
	}

	/**
	 *
	 * @return osW_Date
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>