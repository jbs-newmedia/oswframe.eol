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
class osW_ImageOptimizer extends osW_Object {

	/* PROPERTIES */
	private $image_type;

	private $image_options;

	private $optimizer_options=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
		$this->setOptimizerOptions();
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function getOutput($image) {
		$parts=pathinfo($image);
		$fileparts=explode('.', $parts['basename']);

		$count=count($fileparts);

		if (($count!=2)&&($count!=3)) {
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'Unsupported file structure ('.$image.')']);
			h()->_die();
		}

		if ($count==2) {
			$options=$this->getOptionsArrayFromString('');
			$filename=$parts['dirname'].'/'.$fileparts[0].'.'.$fileparts[1];
			$fileparts[2]='';
		}

		if ($count==3) {
			$options=$this->getOptionsArrayFromString($fileparts[1]);
			$filename=$parts['dirname'].'/'.$fileparts[0].'.'.$fileparts[2];
		}

		$rel_file=$filename;
		$abs_file=vOut('settings_abspath').$rel_file;
		if (!file_exists($abs_file)) {
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File not found ('.$rel_file.')']);
			h()->_die();
		}

		if ((strlen(vOut('imageoptimizer_allowed_dirs'))>0)||(strlen(vOut('imageoptimizer_allowed_dirs_custom'))>0)||(vOut('imageoptimizer_allowed_dirs_cache')===true)) {
			$allowed_dirs=[];
			if (strlen(vOut('imageoptimizer_allowed_dirs'))>0) {
				$allowed_dirs=array_merge($allowed_dirs, explode(',', vOut('imageoptimizer_allowed_dirs')));
			}
			if (strlen(vOut('imageoptimizer_allowed_dirs_custom'))>0) {
				$allowed_dirs=array_merge($allowed_dirs, explode(',', vOut('imageoptimizer_allowed_dirs_custom')));
			}
			if (vOut('imageoptimizer_allowed_dirs_cache')===true) {
				$allowed_dirs[]=substr(vOut('cache_path'), 0, -1);
			}
			$allowed_check=false;
			foreach ($allowed_dirs as $a_dir) {
				if (strpos(realpath($abs_file), realpath(vOut('settings_abspath').$a_dir))===0) {
					$allowed_check=true;
				}
			}
			if ($allowed_check!==true) {
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File out of allowed dir ('.$rel_file.')']);
				h()->_die();
			}
		}

		$path_filename=pathinfo($abs_file, PATHINFO_FILENAME);
		$path_extension=pathinfo($abs_file, PATHINFO_EXTENSION);

		if (vOut('imageoptimizer_protect_files')===true) {
			if (!isset($options['ps'])) {
				$options['ps']='';
			}
			$ps=substr(md5($path_filename.'.'.$path_extension.'#'.$this->getOptionsArrayToString($options, false).'#'.vOut('settings_protection_salt')), 3, 6);
			if ($ps!=$options['ps']) {
				$this->logMessage(__CLASS__, 'warning', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'Checksum not matched ('.$rel_file.')', 'filepart#1'=>$fileparts[0], 'filepart#2'=>$fileparts[1], 'filepart#3'=>$fileparts[2]]);
				h()->_die();
			}
		}

		$image_info=getimagesize($abs_file);
		$this->image_type=$image_info[2];
		switch ($this->image_type) {
			case IMAGETYPE_JPEG :
				header('Content-Type: image/jpg');
				$this->image_type='jpg';
				break;
			case IMAGETYPE_GIF :
				header('Content-Type: image/gif');
				$this->image_type='gif';
				break;
			case IMAGETYPE_PNG :
				header('Content-Type: image/png');
				$this->image_type='png';
				break;
			default :
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'Unsupported file type ('.$this->image_type.')']);
				h()->_die();
				break;
		}

		$filenamecache=md5($image).'.'.$this->image_type;

		if ((osW_Cache::getInstance()->exists(__CLASS__, $filenamecache, '')!==true)||((filemtime($abs_file)>osW_Cache::getInstance()->mtime(__CLASS__, $filenamecache, '')))&&(vOut('imageoptimizer_servercachecheck')===true)) {
			$generateContent=true;
		} else {
			$generateContent=false;
		}

		if (vOut('imageoptimizer_clientcache')===true) {
			if ($generateContent!==true) {
				$mtime=osW_Cache::getInstance()->mtime(__CLASS__, $filenamecache, '');
			} else {
				$mtime=filemtime($abs_file);
			}
			$mtimestr=h()->_gmdatestr($mtime);
		}

		if (h()->_catch('HTTP_IF_MODIFIED_SINCE', '', 'r')!=$mtimestr) {
			if (vOut('imageoptimizer_clientcache')===true) {
				header("Last-Modified: ".$mtimestr);
				header("Cache-Control: must-revalidate");
			} else {
				h()->_headerNoCache();
			}

			if ($generateContent===true) {
				$content=$this->getImageContent($abs_file, $options);
				if (osW_Cache::getInstance()->write(__CLASS__, $filenamecache, $content, '')!==true) {
					$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'Could not create cache file ('.$rel_file.')']);
				}

				header('Content-Length: '.strlen($content));
				echo $content;
			} else {
				header('Content-Length: '.osW_Cache::getInstance()->size(__CLASS__, $filenamecache, ''));
				echo osW_Cache::getInstance()->read(__CLASS__, $filenamecache, '');
			}
		} else {
			header("Last-Modified: ".$mtimestr);
			header("Cache-Control: must-revalidate");
			h()->_headerExit('304 Not Modified');
		}
	}

	public function getOptionsArrayFromString($str) {
		$options=[];
		$_options=explode('-', $str);
		foreach ($_options as $_option) {
			$_option=explode('_', $_option);
			if (count($_option)==2) {
				$options[$_option[0]]=$_option[1];
			}
		}

		return $this->getOptionsArrayFromArray($options);
	}

	public function getOptionsArrayFromArray($options) {
		$_options=[];
		foreach ($this->optimizer_options as $key=>$value) {
			if ((isset($options[$key]))&&($options[$key]!=$value)) {
				$_options[$key]=$options[$key];
			}
		}

		return $_options;
	}

	public function getOptionsArrayToString($options, $ps=true) {
		if (($ps!==true)&&isset($options['ps'])) {
			unset($options['ps']);
		}
		$str=[];
		foreach ($options as $key=>$value) {
			$str[]=$key.'_'.$value;
		}

		return implode('-', $str);
	}

	private function getImageContent($file, $options) {
		osW_ImageLib::getInstance()->load($file);

		if (isset($options['quality'])) {
			osW_ImageLib::getInstance()->setQuality($options['quality']);
		}

		if (isset($options['longest'])) {
			osW_ImageLib::getInstance()->resizeToLongest($options['longest']);
		} elseif (isset($options['scale'])) {
			osW_ImageLib::getInstance()->scale($options['scale']);
		} elseif (isset($options['cropr'])) {
			osW_ImageLib::getInstance()->cropRectangle();
		} elseif (isset($options['croprr'])) {
			osW_ImageLib::getInstance()->cropRectangleResized($options['croprr']);
		} elseif (isset($options['crops'])) {
			$size=explode('x', $options['crops']);
			if (count($size)==2) {
				$ratio=floatval(intval($size[0])/intval($size[1]));
				osW_ImageLib::getInstance()->cropSquare($ratio);
			} else {
				osW_ImageLib::getInstance()->cropSquare(1);
			}
		} elseif (isset($options['cropsr'])) {
			$size=explode('x', $options['cropsr']);
			if (count($size)==2) {
				osW_ImageLib::getInstance()->cropSquareResized(intval($size[0]), intval($size[1]));
			} else {
				osW_ImageLib::getInstance()->cropSquareResized(640, 480);
			}
		} elseif ((isset($options['width']))&&(isset($options['height']))) {
			osW_ImageLib::getInstance()->resize($options['width'], $options['height']);
		} elseif (isset($options['width'])) {
			osW_ImageLib::getInstance()->resizeToWidth($options['width']);
		} elseif (isset($options['height'])) {
			osW_ImageLib::getInstance()->resizeToHeight($options['height']);
		}

		osW_ImageLib::getInstance()->output(true, true);

		return osW_ImageLib::getInstance()->outputStream();
	}

	private function setOptimizerOptions() {
		$this->optimizer_options['longest']='';
		$this->optimizer_options['width']='';
		$this->optimizer_options['height']='';
		$this->optimizer_options['quality']='';
		$this->optimizer_options['scale']='';
		$this->optimizer_options['cropr']='';
		$this->optimizer_options['croprr']='';
		$this->optimizer_options['crops']='';
		$this->optimizer_options['cropsr']='';
		$this->optimizer_options['ps']='';
		// TODO: $this->optimizer_options['transparent']='transparent';
		// TODO: $this->optimizer_options['border']='border';
	}

	/**
	 *
	 * @return osW_ImageOptimizer
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>