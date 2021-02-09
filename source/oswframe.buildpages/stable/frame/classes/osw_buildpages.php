<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_BuildPages extends osW_Object {

	// PROPERTIES

	public $ddm=[];

	// METHODS CORE

	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	public function byLimitRows($module, $paramters, $limitRows, $options=[], $template='default') {
		$output='';

		$file=vOut('settings_abspath').'frame/resources/buildpages/'.$template.'.php';
		if (file_exists($file)) {
			include($file);
		}

		return $output;
	}

	/**
	 *
	 * @return osW_BuildPages
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>