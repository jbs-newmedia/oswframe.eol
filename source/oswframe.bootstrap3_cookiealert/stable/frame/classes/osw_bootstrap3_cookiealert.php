<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 * @copyright https://github.com/Wruczek/Bootstrap-Cookie-Alert
 */
class osW_Bootstrap3_CookieAlert extends osW_Object {

	/*** VALUES ***/

	public $data=[];

	/*** METHODS CORE ***/

	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/*** METHODS ***/

	public function getDiv($text='', $button='', $link='', $link_button='') {
		if ($text=='') {
			$text='Diese Website verwendet Cookies. Wenn Sie die Website weiter nutzen, stimmen Sie der Verwendung von Cookies zu.';
		}
		if ($button=='') {
			$button='OK!';
		}
		if ($link_button=='') {
			$link_button='Mehr ...';
		}
		$output='';
		$output.='<div class="alert alert-dismissible text-center cookiealert" role="alert">';
		$output.='<div class="cookiealert-container">';
		$output.=h()->_outputString($text);
		$output.='<button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">'.h()->_outputString($button).'</button>';
		if ($link!='') {
			$output.='&nbsp;<a href="'.$link.'" class="btn btn-primary btn-sm" role="button">'.h()->_outputString($link_button).'</a>';
		}
		$output.='</div>';
		$output.='</div>';

		return $output;
	}

	/**
	 *
	 * @return osW_Bootstrap3_CookieAlert
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>