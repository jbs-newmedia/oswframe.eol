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
class osW_Template extends osW_Object {

	/* PROPERTIES */
	public $variables=[];

	private $htmlappends=[];

	private $htmlheaders=[];

	private $metadata=[];

	private $highlight_colors=[];

	private $color_classes=[];

	private $textarea_used=false;

	private $textarea_mark_counter=0;

	private $textarea_mark_matches=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 1, true);
		$this->addHtmlAppend('template', vOut('template_html_append'));
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function setIndexFile($file, $module, $dir='modules') {
		if (vOut('frame_ismobileversion')===true) {
			$fetchfile=$file.'-mobile';
			if ($this->isfetchFile($fetchfile, $module, $dir)===true) {
				$this->index_file=vOut('settings_abspath').$dir.'/'.$module.'/tpl/'.$fetchfile.'.tpl.php';
			}

			return true;
		}

		$fetchfile=$file;
		if ($this->isfetchFile($fetchfile, $module, $dir)===true) {
			$this->index_file=vOut('settings_abspath').$dir.'/'.$module.'/tpl/'.$fetchfile.'.tpl.php';

			return true;
		}

		$this->index_file='';

		return false;
	}

	public function getIndexFile() {
		return $this->index_file;
	}

	public function isUsedTextareas() {
		if ($this->textarea_used===true) {
			return true;
		}

		return false;
	}

	public function setUsedTextAreas($textarea_used) {
		if ($textarea_used===true) {
			$this->textarea_used=true;
		} else {
			$this->textarea_used=false;
		}
	}

	public function set($name, $value) {
		$this->variables[$name]=$value;
	}

	private function callback_marktextarea($matches) {
		$this->textarea_mark_matches[]=$matches[0];

		return '<<<OSW_STRIP_REPLACE_TEXTAREA_MARKER_'.$this->textarea_mark_counter++.'>>>';
	}

	public function strip($c) {
		if ($this->isUsedTextareas()===true) {
			$c=preg_replace_callback('/<textarea [^>]*>.*<\/textarea>/Uis', [$this, 'callback_marktextarea'], $c);
		}

		$c=h()->_stripContent($c);

		if ($this->isUsedTextareas()===true) {
			foreach ($this->textarea_mark_matches as $key=>$val) {
				$c=preg_replace('/<<<OSW_STRIP_REPLACE_TEXTAREA_MARKER_'.$key.'>>>/', $this->textarea_mark_matches[$key], $c);
			}
		}

		return $c;
	}

	public function isfetchFile($file, $module, $dir='modules') {
		if (file_exists(vOut('settings_abspath').$dir.'/'.$module.'/tpl/'.$file.'.tpl.php')===true) {
			return true;
		}

		return false;
	}

	public function fetchFileIfExists($file, $module, $dir='modules') {
		if (vOut('frame_ismobileversion')===true) {
			$fetchfile=$file.'-mobile';
			if ($this->isfetchFile($fetchfile, $module, $dir)===true) {
				return $this->fetch(vOut('settings_abspath').$dir.'/'.$module.'/tpl/'.$fetchfile.'.tpl.php');
			}
		}
		$fetchfile=$file;
		if ($this->isfetchFile($fetchfile, $module, $dir)===true) {
			return $this->fetch(vOut('settings_abspath').$dir.'/'.$module.'/tpl/'.$fetchfile.'.tpl.php');
		}

		return '';
	}

	public function fetchFile($file, $module, $dir='modules') {
		return $this->fetch(vOut('settings_abspath').$dir.'/'.$module.'/tpl/'.$file.'.tpl.php');
	}

	public function fetch($file) {
		extract($this->variables);
		ob_start();
		include($file);
		$contents=ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	public function highlightWords($text, $a_word) {
		$i=0;
		while (list(, $word)=each($a_word)) {
			if (strlen($word)>=3) {
				$text=preg_replace('/('.preg_quote($word, '/').')(?=([^>]*(\<|$)))/i', '<strong style="color:black; background-color:'.$this->highlight_colors[$i++%count($this->highlight_colors)].'">$1</strong>', $text);
			}
		}

		return $text;
	}

	public function setHighlightColors($highlight_colors) {
		$this->highlight_colors=$highlight_colors;
	}

	public function hrefLink($page='', $parameters='', $options=[]) {
		$paramter='';
		if (vOut('frame_default_module')==$page) {
			$paramter.=' class="active"';
		}

		return '<a href="'.$this->buildhrefLink($page, $parameters).'"'.$paramter.'>'.tOut($page, 'navigation').'</a>';
	}

	public function buildhrefLink($module='', $parameters='', $replace_amp=true) {
		if (($module=='')||($module=='default')) {
			$module=vOut('project_default_module');
		}
		if ($module=='current') {
			$module=vOut('frame_current_module');
		}

		if ($replace_amp===true) {
			return str_replace('&', '&amp;', osW_Seo::getInstance()->validateUrl($module, $parameters));
		} else {
			return osW_Seo::getInstance()->validateUrl($module, $parameters);
		}
	}

	private function addHeader($type, $position, $value, $combinable=true, $static=true) {
		if ($combinable===true) {
			$this->htmlheaders[$type][$position][]=$value;
		} else {
			if ($static===true) {
				$this->htmlheaders[$type.'_notcombinable'][$position]['static'][]=$value;
			} else {
				$this->htmlheaders[$type.'_notcombinable'][$position]['notstatic'][]=$value;
			}
		}
	}

	private function getHeaders($type, $position) {
		if ((isset($this->htmlheaders[$type]))&&(isset($this->htmlheaders[$type][$position]))) {
			return $this->htmlheaders[$type][$position];
		}

		return [];
	}

	private function clearHeaders($type, $position) {
		if ((isset($this->htmlheaders[$type]))&&(isset($this->htmlheaders[$type][$position]))) {
			$this->htmlheaders[$type][$position]=[];
		}

		return true;
	}

	private function emptyHeaders($type, $position) {
		if ((empty($this->htmlheaders[$type][$position]))&&(empty($this->htmlheaders[$type.'_notcombinable'][$position]))) {
			return true;
		}

		return false;
	}

	public function setJSVar($var, $value, $type='integer') {
		switch ($type) {
			case 'string' :
				$this->htmlheaders['js_vars'][$var]='\''.$value.'\'';
				break;
			default :
				$this->htmlheaders['js_vars'][$var]=$value;
				break;
		}
	}

	public function addJSCodeHead($js) {
		$this->addHeader('js_code', 'head', $js);
	}

	public function getJSCodeHead() {
		if (($this->emptyHeaders('js_code', 'head')===true)&&(empty($this->htmlheaders['js_vars']))) {
			return '';
		}
		$out='';
		$out.='<script type="text/javascript">'."\n";
		if (!empty($this->htmlheaders['js_vars'])) {
			foreach ($this->htmlheaders['js_vars'] as $var=>$value) {
				$out.='var '.$var.'='.$value.';'."\n";
			}
		}
		if (!$this->emptyHeaders('js_code', 'head')===true) {
			$out.=implode("\n", $this->getHeaders('js_code', 'head'));
		}
		$out.='</script>'."\n";

		if (vOut('template_stripoutput')===true) {
			return osW_SmartOptimizer::getInstance()->minify_js($out);
		} else {
			return $out;
		}
	}

	public function clearJSCodeHead() {
		$this->clearHeaders('js_code', 'head');
	}

	public function addJSCodeBody($js) {
		$this->addHeader('js_code', 'body', $js);
	}

	public function getJSCodeBody() {
		if ($this->emptyHeaders('js_code', 'body')===true) {
			return '';
		}
		$out='';
		$out.='<script type="text/javascript">'."\n";
		if (!$this->emptyHeaders('js_code', 'body')===true) {
			$out.=implode("\n", $this->getHeaders('js_code', 'body'));
		}
		$out.='</script>'."\n";

		if (vOut('template_stripoutput')===true) {
			return osW_SmartOptimizer::getInstance()->minify_js($out);
		} else {
			return $out;
		}
	}

	public function clearJSCodeBody() {
		$this->clearHeaders('js_code', 'body');
	}

	public function addJSFileHeadIfExists($js, $combinable=true, $static=true) {
		if (file_exists(vOut('settings_abspath').$js)) {
			$this->addJSFileHead($js, $combinable, $static);
		}
	}

	public function addJSFileHead($js, $combinable=true, $static=true) {
		$this->addHeader('js_file', 'head', $js, $combinable, $static);
	}

	public function getJSFileHead() {
		if ($this->emptyHeaders('js_file', 'head')===true) {
			return '';
		}
		$out='';
		if (vOut('smartoptimizer_combine_files')===true) {
			$str=implode(',', $this->getHeaders('js_file', 'head'));
			$filename=md5($str).'.js';

			osW_SmartOptimizer::getInstance()->writeCacheFile($filename, $str);

			$out.='<script type="text/javascript" src="';
			if (vOut('template_versionnumber')=='') {
				$out.='static/'.vOut('settings_scriptoptimizer').'/'.$filename;
			} elseif (vOut('template_versionnumber')=='cachetime') {
				$out.='static/'.vOut('settings_scriptoptimizer').'/'.$filename.'?v='.$this->filesmtime($this->getHeaders('js_file', 'head'), true);
			} else {
				$out.='static/'.vOut('settings_scriptoptimizer').'/'.$filename.'?v='.vOut('template_versionnumber');
			}
			$out.='"></script>'."\n";
		} else {
			$elements=$this->getHeaders('js_file_notcombinable', 'head');

			foreach ($this->getHeaders('js_file', 'head') as $element) {
				if (strstr($element, '?')) {
					$c='&';
				} else {
					$c='?';
				}
				if (vOut('template_versionnumber')=='') {
					$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.'"></script>'."\n";
				} elseif (vOut('template_versionnumber')=='cachetime') {
					$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.$this->filesmtime($element).'"></script>'."\n";
				} else {
					$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.vOut('template_versionnumber').'"></script>'."\n";
				}
			}
		}
		if (!$this->emptyHeaders('js_file_notcombinable', 'head')===true) {
			$elements=$this->getHeaders('js_file_notcombinable', 'head');
			if (isset($elements['static'])) {
				foreach ($elements['static'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.'"></script>'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.$this->filesmtime($element).'"></script>'."\n";
					} else {
						$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.vOut('template_versionnumber').'"></script>'."\n";
					}
				}
			}
			if (isset($elements['notstatic'])) {
				foreach ($elements['notstatic'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<script type="text/javascript" src="'.$element.'"></script>'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<script type="text/javascript" src="'.$element.$c.'v='.$this->filesmtime($element).'"></script>'."\n";
					} else {
						$out.='<script type="text/javascript" src="'.$element.$c.'v='.vOut('template_versionnumber').'"></script>'."\n";
					}
				}
			}
		}

		return $out;
	}

	public function clearJSFileHead() {
		$this->clearHeaders('js_file', 'head');
	}

	public function addJSFileBodyIfExists($js, $combinable=true, $static=true) {
		if (file_exists(vOut('settings_abspath').$js)) {
			$this->addHeader($js, $combinable);
		}
	}

	public function addJSFileBody($js, $combinable=true, $static=true) {
		$this->addHeader('js_file', 'body', $js, $combinable, $static);
	}

	public function getJSFileBody() {
		if ($this->emptyHeaders('js_file', 'body')===true) {
			return '';
		}
		$out='';
		if (vOut('smartoptimizer_combine_files')===true) {
			$str=implode(',', $this->getHeaders('js_file', 'body'));
			$filename=md5($str).'.js';

			osW_SmartOptimizer::getInstance()->writeCacheFile($filename, $str);

			$out.='<script type="text/javascript" src="';
			if (vOut('template_versionnumber')=='') {
				$out.='static/'.vOut('settings_scriptoptimizer').'/'.$filename;
			} elseif (vOut('template_versionnumber')=='cachetime') {
				$out.='static/'.vOut('settings_scriptoptimizer').'/'.$filename.'?v='.$this->filesmtime($this->getHeaders('js_file', 'body'), true);
			} else {
				$out.='static/'.vOut('settings_scriptoptimizer').'/'.$filename.'?v='.vOut('template_versionnumber');
			}
			$out.='"></script>'."\n";
		} else {
			foreach ($this->getHeaders('js_file', 'body') as $element) {
				if (strstr($element, '?')) {
					$c='&';
				} else {
					$c='?';
				}
				if (vOut('template_versionnumber')=='') {
					$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.'"></script>'."\n";
				} elseif (vOut('template_versionnumber')=='cachetime') {
					$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.$this->filesmtime($element).'"></script>'."\n";
				} else {
					$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.vOut('template_versionnumber').'"></script>'."\n";
				}
			}
		}
		if (!$this->emptyHeaders('js_file_notcombinable', 'body')===true) {
			$elements=$this->getHeaders('js_file_notcombinable', 'body');
			if (isset($elements['static'])) {
				foreach ($elements['static'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.'"></script>'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.$this->filesmtime($element).'"></script>'."\n";
					} else {
						$out.='<script type="text/javascript" src="static/'.vOut('settings_scriptoptimizer').'/'.$element.$c.'v='.vOut('template_versionnumber').'"></script>'."\n";
					}
				}
			}
			if (isset($elements['notstatic'])) {
				foreach ($elements['notstatic'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<script type="text/javascript" src="'.$element.'"></script>'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<script type="text/javascript" src="'.$element.$c.'v='.$this->filesmtime($element).'"></script>'."\n";
					} else {
						$out.='<script type="text/javascript" src="'.$element.$c.'v='.vOut('template_versionnumber').'"></script>'."\n";
					}
				}
			}
		}

		return $out;
	}

	public function clearJSFileBody() {
		$this->clearHeaders('js_file', 'body');
	}

	public function addCSSCodeHead($css) {
		$this->addHeader('css_code', 'head', $css);
	}

	public function getCSSCodeHead() {
		if ($this->emptyHeaders('css_code', 'head')===true) {
			return '';
		}
		$out='';
		$out.='<style type="text/css">'."\n";
		if (!$this->emptyHeaders('css_code', 'head')===true) {
			$out.=implode("\n", $this->getHeaders('css_code', 'head'));
		}
		$out.='</style>'."\n";

		if (vOut('template_stripoutput')===true) {
			return osW_SmartOptimizer::getInstance()->minify_css($out);
		} else {
			return $out;
		}
	}

	public function clearCSSCodeHead() {
		$this->clearHeaders('css_code', 'head');
	}

	public function addCSSCodeBody($css) {
		$this->addHeader('css_code', 'body', $css);
	}

	public function getCSSCodeBody() {
		if ($this->emptyHeaders('css_code', 'body')===true) {
			return '';
		}
		$out='';
		$out.='<style type="text/css">'."\n";
		if (!$this->emptyHeaders('css_code', 'body')===true) {
			$out.=implode("\n", $this->getHeaders('css_code', 'body'));
		}
		$out.='</style>'."\n";

		if (vOut('template_stripoutput')===true) {
			return osW_SmartOptimizer::getInstance()->minify_css($out);
		} else {
			return $out;
		}
	}

	public function clearCSSCodeBody() {
		$this->clearHeaders('css_code', 'body');
	}

	public function addCSSFileHeadIfExists($css, $combinable=true, $static=true) {
		if (file_exists(vOut('settings_abspath').$css)) {
			$this->addHeader('css_file', 'head', $css, $combinable, $static);
		}
	}

	public function addCSSFileHead($css, $combinable=true, $static=true) {
		$this->addHeader('css_file', 'head', $css, $combinable, $static);
	}

	public function getCSSFileHead() {
		if ($this->emptyHeaders('css_file', 'head')===true) {
			return '';
		}
		$out='';
		if (vOut('smartoptimizer_combine_files')===true) {
			$str=implode(',', $this->getHeaders('css_file', 'head'));
			$filename=md5($str).'.css';

			osW_SmartOptimizer::getInstance()->writeCacheFile($filename, $str);

			$out.='<link rel="stylesheet" type="text/css" href="';
			if (vOut('template_versionnumber')=='') {
				$out.='static/'.vOut('settings_styleoptimizer').'/'.$filename;
			} elseif (vOut('template_versionnumber')=='cachetime') {
				$out.='static/'.vOut('settings_styleoptimizer').'/'.$filename.'?v='.$this->filesmtime($this->getHeaders('css_file', 'head'), true);
			} else {
				$out.='static/'.vOut('settings_styleoptimizer').'/'.$filename.'?v='.vOut('template_versionnumber');
			}
			$out.='" />'."\n";
		} else {
			foreach ($this->getHeaders('css_file', 'head') as $element) {
				if (strstr($element, '?')) {
					$c='&';
				} else {
					$c='?';
				}
				if (vOut('template_versionnumber')=='') {
					$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'" />'."\n";
				} elseif (vOut('template_versionnumber')=='cachetime') {
					$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.$c.'v='.$this->filesmtime($element).'" />'."\n";
				} else {
					$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.$c.'v='.vOut('template_versionnumber').'" />'."\n";
				}
			}
		}
		if (!$this->emptyHeaders('css_file_notcombinable', 'head')===true) {
			$elements=$this->getHeaders('css_file_notcombinable', 'head');
			if (isset($elements['static'])) {
				foreach ($elements['static'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'" />'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.$c.'v='.$this->filesmtime($element).'" />'."\n";
					} else {
						$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.$c.'v='.vOut('template_versionnumber').'" />'."\n";
					}
				}
			}
			if (isset($elements['notstatic'])) {
				foreach ($elements['notstatic'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<link rel="stylesheet" type="text/css" href="'.$element.'" />'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<link rel="stylesheet" type="text/css" href="'.$element.$c.'v='.$this->filesmtime($element).'" />'."\n";
					} else {
						$out.='<link rel="stylesheet" type="text/css" href="'.$element.$c.'v='.vOut('template_versionnumber').'" />'."\n";
					}
				}
			}
		}

		return $out;
	}

	public function clearCSSFileHead() {
		$this->clearHeaders('css_file', 'head');
	}

	public function addCSSFileBodyIfExists($css, $combinable=true, $static=true) {
		if (file_exists(vOut('settings_abspath').$css)) {
			$this->addHeader('css_file', 'body', $css, $combinable, $static);
		}
	}

	public function addCSSFileBody($css, $combinable=true, $static=true) {
		$this->addHeader('css_file', 'body', $css, $combinable, $static);
	}

	public function getCSSFileBody() {
		if ($this->emptyHeaders('css_file', 'body')===true) {
			return '';
		}
		$out='';
		if (vOut('smartoptimizer_combine_files')===true) {
			$str=implode(',', $this->getHeaders('css_file', 'body'));
			$filename=md5($str).'.css';

			osW_SmartOptimizer::getInstance()->writeCacheFile($filename, $str);

			$out.='<link rel="stylesheet" type="text/css" href="';
			if (vOut('template_versionnumber')=='') {
				$out.='static/'.vOut('settings_styleoptimizer').'/'.$filename;
			} elseif (vOut('template_versionnumber')=='cachetime') {
				$out.='static/'.vOut('settings_styleoptimizer').'/'.$filename.'?v='.$this->filesmtime($this->getHeaders('css_file', 'body'), true);
			} else {
				$out.='static/'.vOut('settings_styleoptimizer').'/'.$filename.'?v='.vOut('template_versionnumber');
			}
			$out.='" />'."\n";
		} else {
			foreach ($this->getHeaders('css_file', 'body') as $element) {
				if (strstr($element, '?')) {
					$c='&';
				} else {
					$c='?';
				}
				if (vOut('template_versionnumber')=='') {
					$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'" />'."\n";
				} elseif (vOut('template_versionnumber')=='cachetime') {
					$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'?v='.$this->filesmtime($element).'" />'."\n";
				} else {
					$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'?v='.vOut('template_versionnumber').'" />'."\n";
				}
			}
		}
		if (!$this->emptyHeaders('css_file_notcombinable', 'body')===true) {
			$elements=$this->getHeaders('css_file_notcombinable', 'body');
			if (isset($elements['static'])) {
				foreach ($elements['static'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'" />'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'?v='.$this->filesmtime($element).'" />'."\n";
					} else {
						$out.='<link rel="stylesheet" type="text/css" href="static/'.vOut('settings_styleoptimizer').'/'.$element.'?v='.vOut('template_versionnumber').'" />'."\n";
					}
				}
			}
			if (isset($elements['notstatic'])) {
				foreach ($elements['notstatic'] as $element) {
					if (strstr($element, '?')) {
						$c='&';
					} else {
						$c='?';
					}
					if (vOut('template_versionnumber')=='') {
						$out.='<link rel="stylesheet" type="text/css" href="'.$element.'" />'."\n";
					} elseif (vOut('template_versionnumber')=='cachetime') {
						$out.='<link rel="stylesheet" type="text/css" href="'.$element.$c.'v='.$this->filesmtime($element).'" />'."\n";
					} else {
						$out.='<link rel="stylesheet" type="text/css" href="'.$element.$c.'v='.vOut('template_versionnumber').'" />'."\n";
					}
				}
			}
		}

		return $out;
	}

	public function clearCSSFileBody() {
		$this->clearHeaders('css_file', 'body');
	}

	public function getImagePath($module, $filename) {
		if ($module=='default') {
			$module=vOut('project_default_module');
		}
		if ($module=='current') {
			$module=vOut('frame_current_module');
		}

		return 'modules/'.$module.'/img/'.$filename;
	}

	public function getOptimizedImagePath($module, $filename) {
		if ($module=='default') {
			$module=vOut('project_default_module');
		}
		if ($module=='current') {
			$module=vOut('frame_current_module');
		}

		return 'modules/'.$module.'/img/'.$filename;
	}

	public function getOptimizedImage($filename, $options=[]) {
		if (!isset($options['module'])) {
			$options['module']='';
		}
		if (!isset($options['path'])) {
			if (($options['module']=='')||($options['module']=='default')) {
				$options['module']=vOut('project_default_module');
			}
			if ($options['module']=='current') {
				$options['module']=vOut('frame_current_module');
			}

			$options['path']='modules/'.$options['module'].'/img/';
		}

		if (isset($options['subdir'])) {
			$options['path'].=$options['subdir'].'/';
		}

		$rel_file=$options['path'].$filename;
		$abs_file=vOut('settings_abspath').$rel_file;
		if (!file_exists($abs_file)) {
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>'File not found ('.$rel_file.')']);

			return '';
		}

		$opt_options=osW_ImageOptimizer::getInstance()->getOptionsArrayFromArray($options);

		$path_filename=pathinfo($abs_file, PATHINFO_FILENAME);
		$path_extension=pathinfo($abs_file, PATHINFO_EXTENSION);

		if (!isset($options['alt'])) {
			$options['alt']=$path_filename;
		}

		if (!isset($options['title'])) {
			$options['title']='';
		}

		if (!isset($options['parameter'])) {
			$options['parameter']='';
		}

		if (vOut('imageoptimizer_protect_files')===true) {
			$opt_options['ps']=substr(md5($path_filename.'.'.$path_extension.'#'.osW_ImageOptimizer::getInstance()->getOptionsArrayToString($opt_options).'#'.vOut('settings_protection_salt')), 3, 6);
		}

		$imgopt=[];
		foreach ($opt_options as $key=>$value) {
			if (strlen($value)>0) {
				$imgopt[]=$key.'_'.$value;
			}
		}

		if (!empty($imgopt)) {
			$new_filename=$path_filename.'.'.implode('-', $imgopt).'.'.$path_extension;
		} else {
			$new_filename=$path_filename.'.'.$path_extension;
		}

		$out='';
		$out.='<img '.$options['parameter'].' src="static/'.vOut('settings_imageoptimizer').'/'.$options['path'].$new_filename;
		# TODO: height/width ermitteln und angeben
		$out.='" alt="'.h()->_outputString($options['alt']).'" title="'.h()->_outputString($options['title']).'" />';

		return $out;
	}

	// TODO: Deprecated
	public function getStaticImage($filename, $options=[]) {
		$options['static']=true;

		return $this->getImage($filename, $options);
	}

	public function getImage($filename, $options=[]) {
		if (!isset($options['module'])) {
			$options['module']=vOut('frame_current_module');
		}

		$file=$this->getImagePath($options['module'], $filename);

		if (!isset($options['alt'])) {
			$options['alt']=$filename;
		}
		if (!isset($options['title'])) {
			$options['title']='';
		}
		if (!isset($options['parameter'])) {
			$options['parameter']='';
		}
		if (!isset($options['static'])) {
			$options['static']=false;
		}

		if ((!isset($options['height']))||((!isset($options['width'])))) {
			if (file_exists($file)) {
				list($width, $height)=getimagesize($file);

				if (!isset($options['height'])) {
					$options['height']=$height;
				} else {
					$options['height']=intval($img_info['height']);
				}
				if (!isset($options['width'])) {
					$options['width']=$width;
				} else {
					$options['width']=intval($options['width']);
				}
			} else {
				$options['height']='';
				$options['width']='';
			}
		}
		$out='';
		if ($options['static']===true) {
			$out.='<img '.$options['parameter'].' src="static/'.vOut('settings_imageoptimizer').'/'.$this->getImagePath($options['module'], $filename);
			$out.='" alt="'.h()->_outputString($options['alt']).'" title="'.h()->_outputString($options['title']).'" height="'.h()->_outputString($options['height']).'" width="'.h()->_outputString($options['width']).'" />';
		} else {
			$out.='<img '.$options['parameter'].' src="'.$this->getImagePath($options['module'], $filename).'" alt="'.h()->_outputString($options['alt']).'" title="'.h()->_outputString($options['title']).'" height="'.h()->_outputString($options['height']).'" width="'.h()->_outputString($options['width']).'" />';
		}

		return $out;
	}

	public function getColorClass($name, $colors) {
		$count=count($colors);
		if ($count==0) {
			return '';
		}
		if ($count==1) {
			return $colors[0];
		}
		if (!isset($this->color_classes[$name])) {
			$this->color_classes[$name]=0;
		} else {
			$this->color_classes[$name]++;
		}

		return $colors[bcmod($this->color_classes[$name], $count)];
	}

	public function addHeaderData($tag, $content, $unique_tag=false, $position=10) {
		if (is_array($content)===true) {
			$header_data='<'.$tag.' ';
			foreach ($content as $key=>$value) {
				$header_data.=$key.'="'.h()->_stripContent($value).'" ';
			}
			$header_data.='/>';
			if ($unique_tag===true) {
				$this->metadata[$position][$tag]=[];
				$this->metadata[$position][$tag][0]=$header_data;
			} else {
				$this->metadata[$position][$tag][]=$header_data;
			}
		} else {
			$header_data='<'.$tag.'>'.h()->_stripContent($content).'</'.$tag.'>';
			if ($unique_tag===true) {
				$this->metadata[$position][$tag]=[];
				$this->metadata[$position][$tag][0]=$header_data;
			} else {
				$this->metadata[$position][$tag][]=$header_data;
			}
		}
		ksort($this->metadata);
	}

	public function getHeaderData() {
		$out='';
		foreach ($this->metadata as $position=>$tags) {
			foreach ($tags as $data_array) {
				foreach ($data_array as $tag) {
					$out.=$tag."\n";
				}
			}
		}

		return $out;
	}

	public function addMetaData($name, $value) {
		$this->addHeaderData('meta', ['name'=>$name, 'content'=>$value]);
	}

	public function addLinkData($name, $value) {
		$this->addHeaderData('link', ['rel'=>$name, 'href'=>$value]);
	}

	private function filesmtime($files, $check_conf=false) {
		$filesmtime=0;

		if (is_string($files)) {
			$files=[$files];
		}

		if ($check_conf===true) {
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

	/** @deprecated 01.01.2016 * */
	public function addHtmlAppend($module, $content='') {
		$this->htmlappends[$module]=$content;
	}

	/** @deprecated 01.01.2016 * */
	public function getHtmlOpener() {
		$out='<html';
		foreach ($this->htmlappends as $content) {
			if (strlen($content)>0) {
				$out.=' '.$content;
			}
		}
		$out.='>';

		return $out;
	}

	/**
	 *
	 * @return osW_Template
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>