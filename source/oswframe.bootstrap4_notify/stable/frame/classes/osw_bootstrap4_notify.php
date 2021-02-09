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
class osW_Bootstrap4_Notify extends osW_Object {

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

	public function notify($msg, $type='success', $_options=[], $addfunction=true, $addJSHead=true) {
		switch ($type) {
			case 'info':
				$type='info';
				break;
			case 'warning':
				$type='warning';
				break;
			case 'error':
			case 'danger':
				$type='danger';
				break;
			case 'success':
			default:
				$type='success';
				break;
		}

		$options=[];
		$options['offset']['x']=20;
		$options['offset']['y']=60;
		$options['placement']['from']='top';
		$options['placement']['align']='center';
		$options['delay']=2500;
		$options['mouse_over']='pause';
		$options['type']=$type;

		$options=array_merge_recursive($options, $_options);
		$c='';
		if ($addfunction===true) {
			$c.='
$(function() {';
		}

		$c.='
	$.notify({
		message: \''.addslashes($msg).'\'
	},
		'.json_encode($options).'
	);';
		if ($addfunction===true) {
			$c.='
});';
		}

		if ($addJSHead===true) {
			osW_Template::getInstance()->addJSCodeHead($c);
		} else {
			return $c;
		}
	}

	/**
	 *
	 * @return osW_Bootstrap4_Notify
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>