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
class osW_MessageStack extends osW_Object {

	/* PROPERTIES */
	private $messages=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function add($class, $type='error', $paramter=[]) {
		$this->messages[$class][$type][]=$paramter;
	}

	public function reset($class='') {
		if ($class=='') {
			$this->messages=[];
		} elseif (isset($this->messages[$class])) {
			unset($this->messages[$class]);
		}
	}

	public function getMessages() {
		return $this->messages;
	}

	public function size($class, $type='') {
		if ($type!='') {
			if (isset($this->messages[$class][$type])) {
				return count($this->messages[$class][$type]);
			}
		} else {
			if (isset($this->messages[$class])) {
				return count($this->messages[$class]);
			}
		}

		return 0;
	}

	public function getClass($class) {
		return $this->getType($class);
	}

	public function getType($class, $type='') {
		if ($type!='') {
			if (isset($this->messages[$class][$type])) {
				return $this->messages[$class][$type];
			}
		} else {
			if (isset($this->messages[$class])) {
				return $this->messages[$class];
			}
		}

		return [];
	}

	public function addSession($class, $type='error', $paramter=[]) {
		if (osW_Session::getInstance()->exists('messageToStack')) {
			$messageToStack=osW_Session::getInstance()->value('messageToStack');
		} else {
			$messageToStack=[];
		}
		$messageToStack[$class][$type][]=$paramter;
		osW_Session::getInstance()->set('messageToStack', $messageToStack);
	}

	public function removeSession($class, $type='') {
		if (osW_Session::getInstance()->exists('messageToStack')) {
			$messageToStack=osW_Session::getInstance()->value('messageToStack');
			if ($type=='') {
				if (isset($messageToStack[$class])) {
					unset($messageToStack[$class]);
				}
			} else {
				if (isset($messageToStack[$class][$type])) {
					unset($messageToStack[$class][$type]);
				}
			}
			osW_Session::getInstance()->set('messageToStack', $messageToStack);
		}
	}

	public function loadFromSession() {
		if (osW_Session::getInstance()->exists('messageToStack')===true) {
			$messageToStack=osW_Session::getInstance()->value('messageToStack');
			foreach ($messageToStack as $class=>$ar_messages) {
				foreach ($ar_messages as $type=>$messages) {
					foreach ($messages as $message) {
						$this->add($class, $type, $message);
					}
				}
			}
		}
	}

	public function deleteFromSession($class='', $type='') {
		if ($class!='') {
			osW_Session::getInstance()->removeSession($class, $type);
		} else {
			osW_Session::getInstance()->remove('messageToStack');
		}
	}

	/**
	 *
	 * @return osW_MessageStack
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>