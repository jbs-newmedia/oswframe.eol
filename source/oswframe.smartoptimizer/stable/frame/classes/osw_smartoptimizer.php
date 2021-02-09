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

/*
 * SmartOptimizer v1.8 SmartOptimizer enhances your website performance using techniques such as compression, concatenation, minifying, caching, and embedding on demand. Copyright (c) 2006-2010 Ali Farhadi (http://farhadi.ir/) Released under the terms of the GNU Public License. See the GPL for details (http://www.gnu.org/licenses/gpl.html). Author: Ali Farhadi (a.farhadi@gmail.com) Website: http://farhadi.ir/
 */

class osW_SmartOptimizer extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function writeCacheFile($file, $data) {
		if (osW_Cache::getInstance()->exists(__CLASS__, $file, '')!==true) {
			osW_Cache::getInstance()->write(__CLASS__, $file, $data, '');
		}
	}

	private function filesmtime($files) {
		static $filesmtime;

		if ($filesmtime) {
			return $filesmtime;
		}

		$filesmtime=0;

		// Lade Framekonfiguration
		if ((file_exists(vOut('settings_abspath').'frame/configure.php'))&&(($current_filemtime=filemtime(vOut('settings_abspath').'frame/configure.php'))>$filesmtime)) {
			$filesmtime=$current_filemtime;
		}
		if ((file_exists(vOut('settings_abspath').'modules/configure.project-dev.php'))&&(($current_filemtime=filemtime(vOut('settings_abspath').'modules/configure.project-dev.php'))>$filesmtime)) {
			$filesmtime=$current_filemtime;
		}
		if ((file_exists(vOut('settings_abspath').'modules/configure.project.php'))&&(($current_filemtime=filemtime(vOut('settings_abspath').'modules/configure.project.php'))>$filesmtime)) {
			$filesmtime=$current_filemtime;
		}
		foreach ($files as $file) {
			$cfile=vOut('settings_abspath').$file;
			if (file_exists($cfile)) {
				$filesmtime=max(filemtime($cfile), $filesmtime);
			} else {
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File not found ('.$file.')']);
			}
		}

		return $filesmtime;
	}

	function getOutput($query_string, $filetype) {
		// Dateipfad erstellen
		$qfile=vOut('settings_abspath').'.caches/files/smartoptimizer_quick/'.$query_string;

		// Ueberpruefen ob die Cachedatei des Querystrings existiert
		if (osW_Cache::getInstance()->exists(__CLASS__, $query_string, '')!==true) {
			$msg='File not found ('.$query_string.')';
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>$msg]);
			h()->_die($msg);
		}

		// Dateiliste aus Cachedatei erzeugen
		$files=explode(',', osW_Cache::getInstance()->read(__CLASS__, $query_string, ''));

		// Fehlende Dateien ermitteln
		$missed_files=false;
		$missing_files=[];
		foreach ($files as $file) {
			$cfile=vOut('settings_abspath').$file;
			if (!file_exists($cfile)) {
				$missed_files=true;
				$missing_files[]=$file;
			}
		}

		if ($missed_files===true) {
			if (count($disallowed_files)>1) {
				$msg='Files not found ('.implode(',', $missing_files).')';
			} else {
				$msg='File not found ('.implode(',', $missing_files).')';
			}
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>$msg]);
			h()->_die($msg);
		}

		if ((strlen(vOut('smartoptimizer_allowed_dirs'))>0)||(strlen(vOut('smartoptimizer_allowed_dirs_custom'))>0)||(vOut('smartoptimizer_allowed_dirs_cache')===true)) {
			$allowed_dirs=[];
			if (strlen(vOut('smartoptimizer_allowed_dirs'))>0) {
				$allowed_dirs=array_merge($allowed_dirs, explode(',', vOut('smartoptimizer_allowed_dirs')));
			}
			if (strlen(vOut('smartoptimizer_allowed_dirs_custom'))>0) {
				$allowed_dirs=array_merge($allowed_dirs, explode(',', vOut('smartoptimizer_allowed_dirs_custom')));
			}
			if (vOut('smartoptimizer_allowed_dirs_cache')===true) {
				$allowed_dirs[]=substr(vOut('cache_path'), 0, -1);
			}
			$disallowed_files=[];
			foreach ($files as $file) {
				$allowed_check=false;
				foreach ($allowed_dirs as $a_dir) {
					if (strpos(realpath(vOut('settings_abspath').$file), realpath(vOut('settings_abspath').$a_dir))===0) {
						$allowed_check=true;
					}
				}
				if ($allowed_check!==true) {
					$disallowed_files[]=$file;
				}
			}
			if ($allowed_check!==true) {
				if (count($disallowed_files)>1) {
					$msg='Files out of allowed dir ('.implode(',', $disallowed_files).')';
				} else {
					$msg='File out of allowed dir ('.implode(',', $disallowed_files).')';
				}
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>$msg]);
				h()->_die($msg);
			}
		}

		switch ($filetype) {
			case 'css' :
				header('Content-Type: text/css; charset=utf-8');
				break;
			case 'js' :
				header('Content-Type: text/javascript; charset=utf-8');
				break;
			default :
				$msg='Unsupported file type ('.$filetype.')';
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>$msg]);
				h()->_die($msg);
				break;
		}

		if ((vOut('smartoptimizer_gzipcompression')===true)&&(!headers_sent())&&(!connection_aborted())) {
			osW_Settings::getInstance()->smartoptimizer_gzipcompression=true;
			header("Content-Encoding: gzip");
		} else {
			osW_Settings::getInstance()->smartoptimizer_gzipcompression=false;
		}

		$filename=vOut('smartoptimizer_cacheprefix').md5($query_string.(vOut('smartoptimizer_embed')?'embed1':'embed0').(vOut('smartoptimizer_stripoutput')?'stripoutput1':'stripoutput0')).'.'.$filetype.(vOut('smartoptimizer_gzipcompression')?'.gz':'');

		if ((osW_Cache::getInstance()->exists(__CLASS__, $filename, '')!==true)||(($this->filesmtime($files)>osW_Cache::getInstance()->mtime(__CLASS__, $filename, '')))&&(vOut('smartoptimizer_servercachecheck')===true)) {
			$generateContent=true;
		} else {
			$generateContent=false;
		}

		if (vOut('smartoptimizer_clientcache')===true) {
			if ($generateContent!==true) {
				$mtime=osW_Cache::getInstance()->mtime(__CLASS__, $filename, '');
			} else {
				$mtime=$this->filesmtime($files);
			}
			$mtimestr=h()->_gmdatestr($mtime);
		}

		if ((vOut('smartoptimizer_clientcache')!==true)||(h()->_catch('HTTP_IF_MODIFIED_SINCE', '', 'r')!=$mtimestr)) {
			if (vOut('smartoptimizer_clientcache')===true) {
				header("Last-Modified: ".$mtimestr);
				header("Cache-Control: must-revalidate");
			} else {
				h()->_headerNoCache();
			}

			$session_parameter='';
			if ((defined('SID')===true)&&(strlen(SID)>0)) {
				$session_parameter.='?'.SID;
			}

			if ($generateContent===true) {
				$content=[];
				foreach ($files as $file) {
					$ar_file=explode('/', $file);
					osW_Settings::getInstance()->frame_current_module=$ar_file[0];

					$__DIR__='../../';

					$cfile=vOut('settings_abspath').$file;
					if (file_exists($cfile)) {
						$content[]=$this->getOuputContent(file_get_contents($cfile), $__DIR__);
					} else {
						$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File not found ('.$file.')']);
					}
				}

				$content=implode("\n", $content);
				if (vOut('smartoptimizer_stripoutput')==true) {
					switch ($filetype) {
						case 'css' :
							$content=$this->minify_css($content);
							break;
						case 'js' :
							$content=$this->minify_js($content);
							break;
					}
				}

				if (vOut('smartoptimizer_gzipcompression')===true) {
					$content=gzencode($content, vOut('smartoptimizer_gzipcompression_level'));
				}

				if (osW_Cache::getInstance()->write(__CLASS__, $filename, $content, '')!==true) {
					$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'Could not create cache file('.$filename.')']);
				}

				if (strlen($session_parameter)>0) {
					str_ireplace('__PARAMETER__', $session_parameter, $content);
				}

				header('Content-Length: '.strlen($content));
				echo $content;
			} else {
				$content=osW_Cache::getInstance()->read(__CLASS__, $filename, '');

				if (strlen($session_parameter)>0) {
					str_ireplace('__PARAMETER__', $session_parameter, $content);
				}

				header('Content-Length: '.strlen($content));
				echo $content;
			}
		} else {
			header("Last-Modified: ".$mtimestr);
			header("Cache-Control: must-revalidate");
			h()->_headerExit('304 Not Modified');
		}
	}

	function getOutputSingle($query_string, $filetype) {
		$qfile=vOut('settings_abspath').$query_string;

		if (file_exists($qfile)!==true) {
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File not found ('.$query_string.')']);
			h()->_die();
		}

		if ((strlen(vOut('smartoptimizer_allowed_dirs'))>0)||(strlen(vOut('smartoptimizer_allowed_dirs_custom'))>0)||(vOut('smartoptimizer_allowed_dirs_cache')===true)) {
			$allowed_dirs=[];
			if (strlen(vOut('smartoptimizer_allowed_dirs'))>0) {
				$allowed_dirs=array_merge($allowed_dirs, explode(',', vOut('smartoptimizer_allowed_dirs')));
			}
			if (strlen(vOut('smartoptimizer_allowed_dirs_custom'))>0) {
				$allowed_dirs=array_merge($allowed_dirs, explode(',', vOut('smartoptimizer_allowed_dirs_custom')));
			}
			if (vOut('smartoptimizer_allowed_dirs_cache')===true) {
				$allowed_dirs[]=substr(vOut('cache_path'), 0, -1);
			}
			$allowed_check=false;
			foreach ($allowed_dirs as $a_dir) {
				if (strpos(realpath($qfile), realpath(vOut('settings_abspath').$a_dir))===0) {
					$allowed_check=true;
				}
			}
			if ($allowed_check!==true) {
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File out of allowed dir ('.$query_string.')']);
				h()->_die();
			}
		}

		switch ($filetype) {
			case 'css' :
				header('Content-Type: text/css; charset=utf-8');
				break;
			case 'js' :
				header('Content-Type: text/javascript; charset=utf-8');
				break;
			default :
				$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'Unsupported file type ('.$filetype.')']);
				h()->_die();
				break;
		}

		if ((vOut('smartoptimizer_gzipcompression')===true)&&(!headers_sent())&&(!connection_aborted())) {
			osW_Settings::getInstance()->smartoptimizer_gzipcompression=true;
			header("Content-Encoding: gzip");
		} else {
			osW_Settings::getInstance()->smartoptimizer_gzipcompression=false;
		}

		$filename=vOut('smartoptimizer_cacheprefix').md5($query_string.(vOut('smartoptimizer_embed')?'embed1':'embed0').(vOut('smartoptimizer_stripoutput')?'stripoutput1':'stripoutput0')).'.'.$filetype.(vOut('smartoptimizer_gzipcompression')?'.gz':'');

		$files=[str_replace(vOut('settings_abspath'), '', $qfile)];

		if ((osW_Cache::getInstance()->exists(__CLASS__, $filename, '')!==true)||(($this->filesmtime($files)>osW_Cache::getInstance()->mtime(__CLASS__, $filename, '')))&&(vOut('smartoptimizer_servercachecheck')===true)) {
			$generateContent=true;
		} else {
			$generateContent=false;
		}

		if (vOut('smartoptimizer_clientcache')===true) {
			if ($generateContent!==true) {
				$mtime=osW_Cache::getInstance()->mtime(__CLASS__, $filename, '');
			} else {
				$mtime=$this->filesmtime($files);
			}
			$mtimestr=h()->_gmdatestr($mtime);
		}

		if ((vOut('smartoptimizer_clientcache')!==true)||(h()->_catch('HTTP_IF_MODIFIED_SINCE', '', 'r')!=$mtimestr)) {
			if (vOut('smartoptimizer_clientcache')===true) {
				header("Last-Modified: ".$mtimestr);
				header("Cache-Control: must-revalidate");
			} else {
				h()->_headerNoCache();
			}

			$session_parameter='';
			if ((defined('SID')===true)&&(strlen(SID)>0)) {
				$session_parameter.='?'.SID;
			}

			if ($generateContent===true) {
				$content=[];
				$ar_file=explode('/', $query_string);
				osW_Settings::getInstance()->frame_current_module=$ar_file[0];

				$__DIR__='../../';
				for ($i=0; $i<count($ar_file)-1; $i++) {
					$__DIR__.='../';
				}

				$cfile=$qfile;
				if (file_exists($cfile)) {
					$content[]=$this->getOuputContent(file_get_contents($cfile), $__DIR__);
				} else {
					$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File not found ('.$file.')']);
				}

				$content=implode("\n", $content);
				if (vOut('smartoptimizer_stripoutput')==true) {
					switch ($filetype) {
						case 'css' :
							$content=$this->minify_css($content);
							break;
						case 'js' :
							$content=$this->minify_js($content);
							break;
					}
				}

				if (vOut('smartoptimizer_gzipcompression')===true) {
					$content=gzencode($content, vOut('smartoptimizer_gzipcompression_level'));
				}

				if (osW_Cache::getInstance()->write(__CLASS__, $filename, $content, '')!==true) {
					$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'Could not create cache file('.$filename.')']);
				}

				if (strlen($session_parameter)>0) {
					str_ireplace('__PARAMETER__', $session_parameter, $content);
				}

				header('Content-Length: '.strlen($content));
				echo $content;
			} else {
				$content=osW_Cache::getInstance()->read(__CLASS__, $filename, '');

				if (strlen($session_parameter)>0) {
					str_ireplace('__PARAMETER__', $session_parameter, $content);
				}

				header('Content-Length: '.strlen($content));
				echo $content;
			}
		} else {
			header("Last-Modified: ".$mtimestr);
			header("Cache-Control: must-revalidate");
			h()->_headerExit('304 Not Modified');
		}
	}

	public function getOuputContent($contentin, $dir) {
		if (vOut('imageoptimizer_protect_files')===true) {
			$images=[];

			preg_match_all('/(url\()([a-zA-Z0-9\@\_\/\.\-]+)(\))/', $contentin, $images);
			foreach ($images[2] as $image) {
				if ((stripos($contentin, '__IMAGEOPTIMIZER__')!==false)||(stripos($contentin, '__IMAGEOPTIMIZER_PATH__')!==false)) {
					$file=str_replace('/', '', strrchr($image, '/'));

					$fileparts=explode('.', $file);
					$count=count($fileparts);

					$options=osW_ImageOptimizer::getInstance()->getOptionsArrayFromString($fileparts[1]);

					if ($count==2) {
						$filename=$fileparts[0].'.ps_'.(substr(md5($fileparts[0].'.'.$fileparts[1].'#'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($options).'#'.vOut('settings_protection_salt')), 3, 6)).'.'.$fileparts[1];
					}

					if ($count==3) {
						$filename=$fileparts[0].'.'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($options).'-ps_'.(substr(md5($fileparts[0].'.'.$fileparts[2].'#'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($options).'#'.vOut('settings_protection_salt')), 3, 6)).'.'.$fileparts[2];
					}

					$contentin=str_replace('url('.$image.')', 'url('.str_replace($file, $filename, $image).')', $contentin);
				}
			}

			preg_match_all('/(url\()\"([a-zA-Z0-9\@\\_\/\.\-]+)\"(\))/', $contentin, $images);
			foreach ($images[2] as $image) {
				if ((stripos($contentin, '__IMAGEOPTIMIZER__')!==false)||(stripos($contentin, '__IMAGEOPTIMIZER_PATH__')!==false)) {
					$file=str_replace('/', '', strrchr($image, '/'));

					$fileparts=explode('.', $file);
					$count=count($fileparts);

					$options=osW_ImageOptimizer::getInstance()->getOptionsArrayFromString($fileparts[1]);

					if ($count==2) {
						$filename=$fileparts[0].'.ps_'.(substr(md5($fileparts[0].'.'.$fileparts[1].'#'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($options).'#'.vOut('settings_protection_salt')), 3, 6)).'.'.$fileparts[1];
					}

					if ($count==3) {
						$filename=$fileparts[0].'.'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($options).'-ps_'.(substr(md5($fileparts[0].'.'.$fileparts[2].'#'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($options).'#'.vOut('settings_protection_salt')), 3, 6)).'.'.$fileparts[2];
					}

					$contentin=str_replace('url("'.$image.'")', 'url("'.str_replace($file, $filename, $image).'")', $contentin);
				}
			}
		}

		$contentin=str_ireplace('__CURRENT_MODULE_PATH__', '__DIR__/modules/__CURRENT_MODULE__', $contentin);
		$contentin=str_ireplace('__DEFAULT_MODULE_PATH__', '__DIR__/modules/__DEFAULT_MODULE__', $contentin);
		$contentin=str_ireplace('__IMAGEOPTIMIZER_PATH__', '__DIR__/static/__IMAGEOPTIMIZER__', $contentin);
		$contentin=str_ireplace('__SCRIPTOPTIMIZER_PATH__', '__DIR__/static/__SCRIPTOPTIMIZER__', $contentin);
		$contentin=str_ireplace('__STYLEOPTIMIZER_PATH__', '__DIR__/static/__STYLEOPTIMIZER__', $contentin);
		$contentin=str_ireplace('__DIR__/', $dir, $contentin);
		$contentin=str_ireplace('__CURRENT_MODULE__', vOut('frame_current_module'), $contentin);
		$contentin=str_ireplace('__DEFAULT_MODULE__', vOut('project_default_module'), $contentin);
		$contentin=str_ireplace('__IMAGEOPTIMIZER__', vOut('settings_imageoptimizer'), $contentin);
		$contentin=str_ireplace('__SCRIPTOPTIMIZER__', vOut('settings_scriptoptimizer'), $contentin);
		$contentin=str_ireplace('__STYLEOPTIMIZER__', vOut('settings_styleoptimizer'), $contentin);

		return $contentin;
	}

	function convertUrl($url, $count) {
		global $settings, $mimeTypes, $fileDir;

		static $baseUrl='';

		$url=trim($url);

		if (preg_match('@^[^/]+:@', $url))
			return $url;

		$fileType=substr(strrchr($url, '.'), 1);
		if (isset($mimeTypes[$fileType])) {
			$mimeType=$mimeTypes[$fileType];
		} elseif (function_exists('mime_content_type')) {
			$mimeType=mime_content_type($url);
		} else {
			$mimeType=null;
		}

		if (!vOut('smartoptimizer_embed')||!file_exists($fileDir.$url)||(vOut('smartoptimizer_embed_maxsize')>0&&filesize($fileDir.$url)>vOut('smartoptimizer_embed_maxsize'))||!$fileType||in_array($fileType, explode(',', vOut('smartoptimizer_embed_exceptions')))||!$mimeType||$count>1) {
			if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME'].'?')===0||strpos($_SERVER['REQUEST_URI'], rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/').'/?')===0) {
				if (!$baseUrl)
					return $fileDir.$url;
			}

			return $baseUrl.$url;
		}

		$contents=file_get_contents($fileDir.$url);

		if ($fileType=='css') {
			$oldFileDir=$fileDir;
			$fileDir=rtrim(dirname($fileDir.$url), '\/').'/';
			$oldBaseUrl=$baseUrl;
			$baseUrl='http'.(@$_SERVER['HTTPS']?'s':'').'://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/').'/'.$fileDir;
			$contents=$this->minify_css($contents);
			$fileDir=$oldFileDir;
			$baseUrl=$oldBaseUrl;
		}

		$base64=base64_encode($contents);

		return 'data:'.$mimeType.';base64,'.$base64;
	}

	function minify_css($str) {
		$res='';
		$i=0;
		$inside_block=false;
		$current_char='';
		while ($i+1<strlen($str)) {
			if ($str[$i]=='"'||$str[$i]=="'") { // quoted string detected
				$res.=$quote=$str[$i++];
				$url='';
				while ($i<strlen($str)&&$str[$i]!=$quote) {
					if ($str[$i]=='\\') {
						$url.=$str[$i++];
					}
					$url.=$str[$i++];
				}
				if (strtolower(substr($res, -5, 4))=='url('||strtolower(substr($res, -9, 8))=='@import ') {
					$url=$this->convertUrl($url, substr_count($str, $url));
				}
				$res.=$url;
				$res.=$str[$i++];
				continue;
			} elseif (strtolower(substr($res, -4))=='url(') { // url detected
				$url='';
				do {
					if ($str[$i]=='\\') {
						$url.=$str[$i++];
					}
					$url.=$str[$i++];
				} while ($i<strlen($str)&&$str[$i]!=')');
				$url=$this->convertUrl($url, substr_count($str, $url));
				$res.=$url;
				$res.=$str[$i++];
				continue;
			} elseif ($str[$i].$str[$i+1]=='/*') { // css comment detected
				$i+=3;
				while ($i<strlen($str)&&$str[$i-1].$str[$i]!='*/')
					$i++;
				if ($current_char=="\n")
					$str[$i]="\n"; else
					$str[$i]=' ';
			}

			if (strlen($str)<=$i+1)
				break;

			$current_char=$str[$i];

			if ($inside_block&&$current_char=='}') {
				$inside_block=false;
			}

			if ($current_char=='{') {
				$inside_block=true;
			}

			if (preg_match('/[\n\r\t ]/', $current_char))
				$current_char=" ";

			if ($current_char==" ") {
				$pattern=$inside_block?'/^[^{};,:\n\r\t ]{2}$/':'/^[^{};,>+\n\r\t ]{2}$/';
				if (strlen($res)&&preg_match($pattern, $res[strlen($res)-1].$str[$i+1]))
					$res.=$current_char;
			} else
				$res.=$current_char;

			$i++;
		}
		if ($i<strlen($str)&&preg_match('/[^\n\r\t ]/', $str[$i]))
			$res.=$str[$i];

		return $res;
	}

	function minify_js($str) {
		$res='';
		$maybe_regex=true;
		$i=0;
		$current_char='';
		while ($i+1<strlen($str)) {
			if ($maybe_regex&&$str[$i]=='/'&&$str[$i+1]!='/'&&$str[$i+1]!='*'&&@$str[$i-1]!='*') { // regex detected
				if (strlen($res)&&$res[strlen($res)-1]==='/')
					$res.=' ';
				do {
					if ($str[$i]=='\\') {
						$res.=$str[$i++];
					} elseif ($str[$i]=='[') {
						do {
							if ($str[$i]=='\\') {
								$res.=$str[$i++];
							}
							$res.=$str[$i++];
						} while ($i<strlen($str)&&$str[$i]!=']');
					}
					$res.=$str[$i++];
				} while ($i<strlen($str)&&$str[$i]!='/');
				$res.=$str[$i++];
				$maybe_regex=false;
				continue;
			} elseif ($str[$i]=='"'||$str[$i]=="'") { // quoted string detected
				$quote=$str[$i];
				do {
					if ($str[$i]=='\\') {
						$res.=$str[$i++];
					}
					$res.=$str[$i++];
				} while ($i<strlen($str)&&$str[$i]!=$quote);
				$res.=$str[$i++];
				continue;
			} elseif ($str[$i].$str[$i+1]=='/*'&&@$str[$i+2]!='@') { // multi-line comment detected
				$i+=3;
				while ($i<strlen($str)&&$str[$i-1].$str[$i]!='*/')
					$i++;
				if ($current_char=="\n")
					$str[$i]="\n"; else
					$str[$i]=' ';
			} elseif ($str[$i].$str[$i+1]=='//') { // single-line comment detected
				$i+=2;
				while ($i<strlen($str)&&$str[$i]!="\n"&&$str[$i]!="\r")
					$i++;
			}

			$LF_needed=false;
			if (preg_match('/[\n\r\t ]/', $str[$i])) {
				if (strlen($res)&&preg_match('/[\n ]/', $res[strlen($res)-1])) {
					if ($res[strlen($res)-1]=="\n")
						$LF_needed=true;
					$res=substr($res, 0, -1);
				}
				while ($i+1<strlen($str)&&preg_match('/[\n\r\t ]/', $str[$i+1])) {
					if (!$LF_needed&&preg_match('/[\n\r]/', $str[$i]))
						$LF_needed=true;
					$i++;
				}
			}

			if (strlen($str)<=$i+1)
				break;

			$current_char=$str[$i];

			if ($LF_needed)
				$current_char="\n"; elseif ($current_char=="\t")
				$current_char=" ";
			elseif ($current_char=="\r")
				$current_char="\n";

			// detect unnecessary white spaces
			if ($current_char==" ") {
				if (strlen($res)&&(preg_match('/^[^(){}[\]=+\-*\/%&|!><?:~^,;"\']{2}$/', $res[strlen($res)-1].$str[$i+1])||preg_match('/^(\+\+)|(--)$/', $res[strlen($res)-1].$str[$i+1]))) // for example i+ ++j;
					$res.=$current_char;
			} elseif ($current_char=="\n") {
				if (strlen($res)&&(preg_match('/^[^({[=+\-*%&|!><?:~^,;\/][^)}\]=+\-*%&|><?:,;\/]$/', $res[strlen($res)-1].$str[$i+1])||(strlen($res)>1&&preg_match('/^(\+\+)|(--)$/', $res[strlen($res)-2].$res[strlen($res)-1]))||(strlen($str)>$i+2&&preg_match('/^(\+\+)|(--)$/', $str[$i+1].$str[$i+2]))||preg_match('/^(\+\+)|(--)$/', $res[strlen($res)-1].$str[$i+1]))) // || // for example i+ ++j;
					$res.=$current_char;
			} else
				$res.=$current_char;

			// if the next charachter be a slash, detects if it is a divide operator or start of a regex
			if (preg_match('/[({[=+\-*\/%&|!><?:~^,;]/', $current_char))
				$maybe_regex=true; elseif (!preg_match('/[\n ]/', $current_char))
				$maybe_regex=false;

			$i++;
		}
		if ($i<strlen($str)&&preg_match('/[^\n\r\t ]/', $str[$i]))
			$res.=$str[$i];

		return $res;
	}

	/**
	 *
	 * @return osW_SmartOptimizer
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>