<?php

/**
 *
 * @author Juergen Schwind
 * @author Patrick Streibert
 * @copyright Copyright (c) 2011, Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_Captcha extends osW_Object {

	/* PROPERTIES */
	private $captchastring='';

	private $captcha=[];

	private $chars=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0, true);
		$this->setValidChars();
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function setValidChars() {
		$this->chars=[];
		$chars=vOut('captcha_chars');
		for ($i=0; $i<strlen($chars); $i++) {
			$this->chars[]=$chars[$i];
		}
	}

	public function init() {
		$this->captchastring='';
		$this->captcha=[];
	}

	function getCaptcha() {
		$this->init();
		$pos=0;
		for ($i=0; $i<(vOut('captcha_length')*2); $i++) {
			shuffle($this->chars);
			if (bcmod($i, 2)==0) {
				$this->captcha[$i]=['char'=>$this->chars[rand(0, count($this->chars)-1)], 'valid'=>1, 'position'=>$pos];
				$this->captchastring.=$this->captcha[$i]['char'];
				$pos++;
			} else {
				$this->captcha[$i]=['char'=>$this->chars[rand(0, count($this->chars)-1)], 'valid'=>0, 'position'=>0];
			}
		}
	}

	function getCaptchaDiv($name='captcha', $width=14) {
		$this->getCaptcha();
		$output='';
		$output.='<div class="container_div_captcha" id="'.$name.'check" style="height:'.$width.'px; width:'.($width*vOut('captcha_length')).'px">';

		shuffle($this->captcha);
		shuffle($this->captcha);
		shuffle($this->captcha);

		for ($i=0; $i<(vOut('captcha_length')*2); $i++) {
			if ($this->captcha[$i]['valid']===1) {
				$output.='<div class="'.$name.'checkchar" style="height:'.$width.'px; width:'.$width.'px; text-align:center; position:absolute; margin-left:'.($this->captcha[$i]['position']*$width).'px;">'.$this->captcha[$i]['char'].'</div>';
			} else {
				$output.='<div class="'.$name.'checkchar" style="height:'.$width.'px; width:'.$width.'px; text-align:center; position:absolute; margin-left:'.($i*$width).'px; display:none;">'.$this->captcha[$i]['char'].'</div>';
			}
		}

		$output.='<div style="clear:both"></div>';
		$output.='</div>';

		osW_Session::getInstance()->set('captchastring', $this->captchastring);

		return $output;
	}

	function checkCaptcha($name='captcha', $captcha='') {
		if ($captcha=='') {
			$captcha=h()->_catch($name, '', 'p');
		}
		$captcha=str_replace(' ', '', $captcha);
		if ($captcha==osW_Session::getInstance()->value('captchastring')) {
			return true;
		} else {
			return false;
		}
	}

	function addToSession($name='captcha') {
		osW_Session::getInstance()->set($name, true);
	}

	function getFromSession($name='captcha') {
		if (osW_Session::getInstance()->value($name)===true) {
			return true;
		}

		return false;
	}

	function deleteFromSession($name='captcha') {
		osW_Session::getInstance()->remove($name);
	}

	/**
	 *
	 * @return osW_Captcha
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>