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
class osW_Bootstrap3 extends osW_Object {

	/* PROPERTIES */
	private $issetcore=false;

	private $loaded_plugins=[];

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
		$this->loaded_plugins=[];
	}

	public function load($version='current') {
		if ($version=='current') {
			$version='3.3.7';
		}
		if ($this->issetcore!==true) {
			osW_JQuery2::getInstance()->load();

			$file='bootstrap_'.$version;

			if (osW_Cache::getInstance()->exists(__CLASS__, $file, '.js')!==true) {
				$cache_content=file_get_contents(vOut('settings_abspath').'frame/resources/bootstrap3/'.$version.'/js/bootstrap.js');
				$cache_content=str_replace('url(\'../fonts/', 'url(\'__DIR__/frame/resources/bootstrap3/'.$version.'/fonts/', $cache_content);
				osW_Cache::getInstance()->write(__CLASS__, $file, $cache_content, '.js');
			}
			osW_Template::getInstance()->addJSFileHead('.caches/files/'.strtolower(__CLASS__).'/'.$file.'.js');

			if (osW_Cache::getInstance()->exists(__CLASS__, $file, '.css')!==true) {
				$cache_content=file_get_contents(vOut('settings_abspath').'frame/resources/bootstrap3/'.$version.'/css/bootstrap.css');
				$cache_content=str_replace('url(\'../fonts/', 'url(\'__DIR__/frame/resources/bootstrap3/'.$version.'/fonts/', $cache_content);
				osW_Cache::getInstance()->write(__CLASS__, $file, $cache_content, '.css');
			}
			osW_Template::getInstance()->addCSSFileHead('.caches/files/'.strtolower(__CLASS__).'/'.$file.'.css');

			$this->issetcore=true;
		}
	}

	public function loadPlugin($plugin_name, $plugin_option=[]) {
		if (isset($this->loaded_plugins[$plugin_name])) {
			return true;
		}

		$this->load();

		if (file_exists(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/bootstrap3.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('frame_current_module').'/autoloader/bootstrap3.inc.php');
		} elseif (file_exists(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/bootstrap3.inc.php')) {
			include(vOut('settings_abspath').'modules/'.vOut('project_default_module').'/autoloader/bootstrap3.inc.php');
		} else {
			include(vOut('settings_abspath').'frame/autoloader/bootstrap3.inc.php');
		}
	}

	public function makeResponsive($content) {
		$width='(width)(=\")([0-9]+)(\")';
		$height='(height)(=\")([0-9]+)(\")';

		preg_match_all('~<img(.*?)('.$height.'(.*?)'.$width.'|'.$width.'(.*?)'.$height.')(.*?)>~i', trim($content), $matches);

		foreach ($matches[0] as $id=>$value) {
			if ($matches[12][$id]=='width') {
				$match=str_replace($matches[2][$id], 'style="width:100%; max-width:'.$matches[14][$id].'px;"', $matches[0][$id]);
			} else {
				$match=str_replace($matches[2][$id], 'style="width:100%; max-width:'.$matches[19][$id].'px;"', $matches[0][$id]);
			}
			$content=str_replace($matches[0][$id], $match, $content);
		}

		return $content;
	}

	/**
	 *
	 * @return osW_Bootstrap3
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>