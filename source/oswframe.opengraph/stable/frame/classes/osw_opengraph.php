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
class osW_OpenGraph extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function addData($property, $content, $unique_tag=false, $position=15) {
		osW_Template::getInstance()->addHeaderData('meta', ['property'=>'og:'.$property, 'content'=>$content], $unique_tag, $position);
		osW_Template::getInstance()->addHtmlAppend('opengraph', vOut('opengraph_html_append'));
	}

	/**
	 *
	 * @return osW_OpenGraph
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>