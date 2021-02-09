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
class osW_FontAwesome4 extends osW_Object {

	/* PROPERTIES */
	private $issetcore=false;

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(1, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function init() {
		$this->issetcore=false;
	}

	public function load($version='current') {
		if ($version=='current') {
			$version='4.7.0';
		}
		if ($this->issetcore!==true) {
			$file='fontawesome_'.$version;

			if (osW_Cache::getInstance()->exists(__CLASS__, $file, '.css')!==true) {
				$cache_content=file_get_contents(vOut('settings_abspath').'frame/resources/fontawesome4/'.$version.'/css/font-awesome.css');
				$cache_content=str_replace('url(\'../fonts/', 'url(\'__DIR__/frame/resources/fontawesome4/'.$version.'/fonts/', $cache_content);
				osW_Cache::getInstance()->write(__CLASS__, $file, $cache_content, '.css');
			}
			osW_Template::getInstance()->addCSSFileHead('.caches/files/'.strtolower(__CLASS__).'/'.$file.'.css');

			$this->issetcore=true;
		}
	}

	/**
	 *
	 * @return osW_FontAwesome4
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>