<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

/* 
 * BASED ON
 * 
 * SmartOptimizer v1.8
 * SmartOptimizer enhances your website performance using techniques
 * such as compression, concatenation, minifying, caching, and embedding on demand.
 *
 * Copyright (c) 2006-2010 Ali Farhadi (http://farhadi.ir/)
 * Released under the terms of the GNU Public License.
 * See the GPL for details (http://www.gnu.org/licenses/gpl.html).
 *
 * Author: Ali Farhadi (a.farhadi@gmail.com)
 * Website: http://farhadi.ir/
 *
 */

function _headerNeverExpire() {
	header("Expires: ".h()->_gmdatestr(time()+315360000));
	header("Cache-Control: max-age=315360000, store, cache");
}

?>