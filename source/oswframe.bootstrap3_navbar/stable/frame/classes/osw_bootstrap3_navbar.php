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
class osW_Bootstrap3_Navbar extends osW_Object {

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

	public function create() {
		$this->data['navbar']=[];
		$this->data['navbar']['elements']=[];
		$this->data['navbar']['more']=[];

		return true;
	}

	public function add($name, $link, $title, $order, $visible, $class=[], $target='', $options=[]) {
		$this->data['navbar']['elements'][$name]=['link'=>$link, 'title'=>$title, 'order'=>$order, 'target'=>$target, 'class'=>$class, 'class_colapse'=>[], 'visible'=>$visible, 'options'=>$options];

		return true;
	}

	public function addSub($name, $link, $title, $order, $visible, $class=[], $target='', $options=[]) {
		if (!isset($this->data['navbar']['elements'][$name])) {
			return false;
		}
		if (!isset($this->data['navbar']['elements'][$name]['elements'])) {
			$this->data['navbar']['elements'][$name]['elements']=[];
		}
		$this->data['navbar']['elements'][$name]['elements'][]=['link'=>$link, 'title'=>$title, 'order'=>$order, 'target'=>$target, 'class'=>$class, 'class_colapse'=>[], 'visible'=>$visible, 'options'=>$options];

		return true;
	}

	private function run() {
		usort($this->data['navbar']['elements'], [$this, "sort"]);

		foreach ($this->data['navbar']['elements'] as $id=>$nav) {
			if (is_array($nav['link'])) {
				if (!isset($nav['link']['module'])) {
					$nav['link']['module']='';
				}
				if (!isset($nav['link']['parameters'])) {
					$nav['link']['parameters']='';
				}

				$this->data['navbar']['elements'][$id]['link']=osW_Template::getInstance()->buildhrefLink($nav['link']['module'], $nav['link']['parameters']);
			} else {
				$this->data['navbar']['elements'][$id]['link']=$nav['link'];
			}

			if ((isset($nav['elements']))&&($nav['elements']!=[])) {
				foreach ($nav['elements'] as $id2=>$nav2) {
					if (is_array($nav2['link'])) {
						if (!isset($nav2['link']['module'])) {
							$nav2['link']['module']='';
						}
						if (!isset($nav2['link']['parameters'])) {
							$nav2['link']['parameters']='';
						}

						$this->data['navbar']['elements'][$id]['elements'][$id2]['link']=osW_Template::getInstance()->buildhrefLink($nav2['link']['module'], $nav2['link']['parameters']);
					} else {
						$this->data['navbar']['elements'][$id]['elements'][$id2]['link']=$nav2['link'];
					}
				}
			}

			foreach (['xs', 'sm', 'md', 'lg'] as $class) {
				if ((!in_array($class, $nav['visible']))&&(!in_array('hidden-'.$class, $this->data['navbar']['elements'][$id]['class']))) {
					$this->data['navbar']['elements'][$id]['class'][]='hidden-'.$class;
				}

				if (!in_array($class, $nav['visible'])) {
					$this->data['navbar']['more'][$class]='visible-'.$class.'-block';
				}

				if ((in_array($class, $nav['visible']))&&(!in_array('hidden-'.$class, $this->data['navbar']['elements'][$id]['class_colapse']))) {
					$this->data['navbar']['elements'][$id]['class_colapse'][]='hidden-'.$class;
				}
			}
		}
		if ($this->data['navbar']['more']==[]) {
			$this->data['navbar']['more']['h']='hidden';
		}

		return true;
	}

	public function get() {
		$this->run();

		return $this->data['navbar']['elements'];
	}

	public function getMore() {
		$this->run();

		return $this->data['navbar']['more'];
	}

	public function setMoreText($text) {
		$this->data['navbar']['moretext']=$text;
	}

	public function getMoreText() {
		if (isset($this->data['navbar']['moretext'])) {
			return $this->data['navbar']['moretext'];
		}

		return 'more';
	}

	private function sort($a, $b) {
		return $a["order"]>$b["order"];

	}

	/**
	 *
	 * @return osW_Bootstrap3_Navbar
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>