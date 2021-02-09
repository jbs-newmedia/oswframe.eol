<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _setTimezone() {
	if (tOut('language_timezone')!='language_timezone') {
		$time_zone=tOut('language_timezone');
	} else {
		$time_zone=vOut('project_timezone');
	}

	return date_default_timezone_set($time_zone);
}

?>