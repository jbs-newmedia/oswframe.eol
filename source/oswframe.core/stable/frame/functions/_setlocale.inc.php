<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _setLocale() {
	if (tOut('language_locale')!='language_locale') {
		$locale=tOut('language_locale');
	} else {
		$locale=vOut('project_locale');
	}

	return setlocale(LC_ALL, $locale);
}

?>