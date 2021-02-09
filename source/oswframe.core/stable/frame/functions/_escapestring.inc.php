<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

# http://php.net/manual/de/function.mysql-real-escape-string.php#98506
function _escapeString($var) {
	$search=["\\", "\0", "\n", "\r", "\x1a", "'", '"'];
	$replace=["\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'];

	return str_replace($search, $replace, $var[0]);
}

?>