<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/**
 * Gibt einen Zufallswert zurueck, sofern angegeben zwischen einem linken und einem rechten Rand
 *
 * @access public
 * @param integer Linker Rand
 * @param integer Rechter Rand
 * @return integer
 */
function _rand($var) {
	static $seeded;
	if (!isset($seeded)) {
		mt_srand((double) microtime()*1000000);
		$seeded=true;
	}
	if (isset($var[0])&&isset($var[1])) {
		if ($var[0]>=$var[1]) {
			return $var[0];
		} else {
			return mt_rand($var[0], $var[1]);
		}
	} else {
		return mt_rand();
	}
}

?>