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

function _headerNoCache() {
	// already expired
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	// always modified
	header("Last-Modified: ".h()->_gmdatestr());

	// HTTP/1.1
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Cache-Control: max-age=0", false);

	//generate a unique Etag each time
	header('Etag: '.microtime());
}

?>