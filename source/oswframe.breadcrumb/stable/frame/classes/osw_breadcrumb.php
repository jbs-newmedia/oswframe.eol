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
class osW_BreadCrumb extends osW_Object {

	/* PROPERTIES */
	private $data=[];

	private $count=0;

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0, true);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function add($name='', $module='', $parameters='', $options=[]) {
		if (($module=='')||($module=='default')) {
			$module=vOut('project_default_module');
		}
		if ($module=='current') {
			$module=vOut('frame_current_module');
		}
		$this->data[]=['name'=>$name, 'module'=>$module, 'parameters'=>$parameters, 'options'=>$options];
		$this->addCount();
	}

	public function clear() {
		$this->data=[];
	}

	public function removePosition($i) {
		if (isset($this->data[$i])) {
			unset($this->data[$i]);

			return true;
		}

		return false;
	}

	public function get($id=0) {
		$id=intval($id);
		if ($id>0) {
			if (isset($this->data[$id])) {
				return $this->data[$id];
			} else {
				return false;
			}
		}

		return $this->data;
	}

	public function getReverse() {
		$r_array=$this->data;
		krsort($r_array);

		return $r_array;
	}

	private function addCount() {
		$this->count++;
	}

	private function clearCount() {
		$this->count=0;
	}

	public function getCount() {
		return $this->count;
	}

	/**
	 *
	 * @return osW_BreadCrumb
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>