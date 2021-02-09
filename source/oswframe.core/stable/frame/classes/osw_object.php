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
class osW_Object {

	/* PROPERTIES */
	private static $instances=[];

	protected $_class='';

	protected $_version=0;

	protected $_build=0;

	protected $_multiple_instances=false;

	static $_classes=[];

	/* METHODS */
	public function dumpVars($option_string='max_y:500') {
		if (USE_DEBUGLIB===true) {
			print_a($this->vars, $option_string);
		} else {
			echo '<pre>';
			ksort($this->vars);
			print_r($this->vars);
			echo '</pre>';
		}
	}

	public function dumpInfo() {
		if ($this->isClassEnabled()===true) {
			$enabled='yes';
		} else {
			$enabled='no';
		}
		if ($this->useMultipleInstances()===true) {
			$multipleinstances='yes';
		} else {
			$multipleinstances='no';
		}
		echo $this->_class.' -  v'.$this->_version.'.'.$this->_build.' - enabled('.$enabled.') - multipleinstances('.$multipleinstances.')<br/>';
	}

	public function useMultipleInstances($class='') {
		if ($class=='') {
			$class=$this->_class;
		}
		if ($this->_multiple_instances===true) {
			return true;
		}

		return false;
	}

	public function isClassEnabled($class='') {
		if ($class=='') {
			$class=$this->_class;
		}
		if (self::$_classes[$class]===true) {
			return true;
		}

		return false;
	}

	public function outputDisabledError($class) {
		die('class '.$class.' is disabled...');
	}

	public function logMessage($class, $type='error', $paramter=[]) {
		if (count($paramter)>0) {
			foreach ($paramter as $id=>$value) {
				$value=str_replace("\t", ' ', $value);
				$value=str_replace("\n", ' ', $value);
				$value=str_replace("\r", ' ', $value);
				$value=preg_replace('/[ ]+/', ' ', $value);
				$paramter[$id]=trim($value);
			}
		}
		osW_MessageStack::getInstance()->add(strtolower(trim($class)), strtolower(trim($type)), $paramter);
	}

	public function log($data) {
		$debug_string=date('d.m.Y H:i:s').' - '.str_replace("\n", "", $data)."\n";
		$debug_string.='Request: '.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."\n";
		foreach (debug_backtrace() as $element) {
			$debug_string.='Stack: file('.basename($element['file']).'), line('.$element['line'].'), function('.$element['function'].')';
			foreach ($element['args'] as $par) {
				if (is_array($par)) {
					$par=str_replace("\n", "", print_r($par, true));
				}
				$debug_string.=', args('.substr($par, 0, 100).')';
			}
			$debug_string.="\n";
		}
		if (function_exists("memory_get_usage")) {
			$debug_string.='Current memory usage: '.floor(memory_get_usage()/1024).' KB'."\n";
		}
		$debug_string.="======================================================================================\n";
		error_log($debug_string, 3, vOut('settings_abspath').vOut('debug_path').'oswframe.log');
	}

	/* CORE */
	protected $vars=[];

	public function __construct($c, $v, $b=false, $i=false) {
		if ((is_bool($b))&&(is_bool($i))) {
			$class=get_called_class();
			$version=$c;
			$build=$v;
			$multiple_instances=$b;
		} else {
			$class=$c;
			$version=$v;
			$build=$b;
			$multiple_instances=$i;
		}

		$this->_class=$class;
		$this->_version=$version;
		$this->_build=$build;
		$this->_multiple_instances=$multiple_instances;
	}

	public function __destruct() {
	}

	public function __initDB() {
		$class=strtolower($this->_class);
		$frame_class=false;
		if (substr($class, 0, 4)==='osw_') {
			$frame_class=true;
		}
		$class_name=$class;
		if (($class=='osw_object')||($class=='osw_settings')) {
			include settings_abspath.'frame/classes_patch/'.$class.'.php';
		} elseif ((strlen(vOut('frame_default_module'))>0)&&(file_exists(settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/classes_patch.inc.php'))) {
			include settings_abspath.'modules/'.vOut('frame_current_module').'/autoloader/classes_patch.inc.php';
		} elseif (file_exists(settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/classes_patch.inc.php')) {
			include settings_abspath.'modules/'.vOut('project_default_module').'/autoloader/classes_patch.inc.php';
		} else {
			include settings_abspath.'frame/autoloader/classes_patch.inc.php';
		}
	}

	public function __set($name, $value) {
		$this->vars[$name]=$value;
	}

	public function __get($name) {
		if ((strlen($name)>0)&&(isset($this->vars[$name]))) {
			return $this->vars[$name];
		}

		return null;
	}

	static function setIsEnabled($class) {
		$class=strtolower($class);
		if (isset(self::$_classes[$class])) {
			return self::$_classes[$class];
		}
		if ($class=='osw_settings') {
			self::$_classes[$class]=true;
		} else {
			if ((vOut('settings_check_classes')===true)&&(vOut(strtolower('class_'.$class.'_enabled'))===true)) {
				self::$_classes[$class]=true;
			} elseif ((vOut('settings_check_classes')!==true)&&((vOut(strtolower('class_'.$class.'_enabled'))===true)||(vOut(strtolower(substr($class, 4, strlen($class)).'_enabled'))===true))) {
				self::$_classes[$class]=true;
			} else {
				self::$_classes[$class]=false;
			}
		}

		return self::$_classes[$class];
	}

	static function checkIsEnabled($class) {
		if (self::setIsEnabled($class)!==true) {
			osW_Object::outputDisabledError($class);
		}
	}

	public static function getInstance($alias='default') {
		$class_name=get_called_class();
		$class=strtolower($class_name);
		osW_Object::checkIsEnabled($class_name);
		if ((!isset(self::$instances[$class][$alias]))||((isset(self::$instances[$class][$alias]))&&(!is_object(self::$instances[$class][$alias])))) {
			self::$instances[$class][$alias]=new $class();
		}
		if ((self::$instances[$class][$alias]->useMultipleInstances()!==true)&&($alias!='default')) {
			die('class '.$class_name.' does not support multiple instances...');
		}

		return self::$instances[$class][$alias];
	}

	public static function unsetInstance($alias='default') {
		$class_name=get_called_class();
		$class=strtolower($class_name);
		if (is_object(self::$instances[$class][$alias])) {
			unset(self::$instances[$class][$alias]);
			self::$instances[$class][$alias]=null;
		}
	}

}

?>