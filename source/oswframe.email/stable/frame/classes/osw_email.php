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
class osW_EMail extends osW_Object {

	/* PROPERTIES */
	private $data=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0, true);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function clear() {
		$this->data=[];
	}

	public function clearName($str) {
		$str=preg_replace('/[<>"]/', ' ', $str);
		$str=preg_replace('/\s\s+/', ' ', $str);

		return $str;
	}

	public function setFrom($address, $name='') {
		$this->data['from']=['address'=>$address, 'name'=>$name];
	}

	public function setReplyTo($address, $name='') {
		$this->data['replyto']=['address'=>$address, 'name'=>$name];
	}

	public function addAddress($address, $name='') {
		$this->data['to'][]=['address'=>$address, 'name'=>$name];
	}

	public function addCC($address, $name='') {
		$this->data['cc'][]=['address'=>$address, 'name'=>$name];
	}

	public function addBCC($address, $name='') {
		$this->data['bcc'][]=['address'=>$address, 'name'=>$name];
	}

	public function setSubject($subject) {
		$this->data['subject']=$subject;
	}

	public function setMessage($message) {
		$message=str_replace("\r\n", "\n", $message);
		$message=str_replace("\n\r", "\n", $message);
		$this->data['message']=$message;
	}

	private function makeAddress($address, $name='') {
		$name=$this->clearName($name);
		if (strlen($name)==0) {
			return $address;
		} else {
			return '"'.$name.'"<'.$address.'>';
		}
	}

	public function utf8_decode($string) {
		$tmp=$string;
		$count=0;
		while (mb_detect_encoding($tmp)=="UTF-8") {
			$tmp=utf8_decode($tmp);
			$count++;
		}

		for ($i=0; $i<$count-1; $i++) {
			$string=utf8_decode($string);
		}

		return $string;
	}

	public function send($charset='utf8') {
		if (!isset($this->data['to'])) {
			return false;
		}
		$headers='';
		$headers.='X-Mailer: PHP/'.phpversion()."\n";
		$headers.='X-Sender-IP: '.h()->_getIpAddress()."\n";
		if ($charset=='iso') {
			$headers='';
		} else {
			$headers.='Content-type: text/plain; charset=utf-8'."\n";
		}
		if (isset($this->data['from'])) {
			$headers.='From:'.$this->makeAddress($this->data['from']['address'], $this->data['from']['name'])."\n";
		}
		if (isset($this->data['replyto'])) {
			$headers.='Reply-To:'.$this->makeAddress($this->data['replyto']['address'], $this->data['replyto']['name'])."\n";
		}
		$to=[];
		foreach ($this->data['to'] as $address) {
			$to[]=$this->makeAddress($address['address'], $address['name']);
		}
		$to=implode(',', $to);

		if ((isset($this->data['cc']))&&(count($this->data['cc'])>0)) {
			$cc=[];
			foreach ($this->data['cc'] as $address) {
				$cc[]=$this->makeAddress($address['address'], $address['name']);
			}
			$headers.='Cc: '.implode(',', $cc)."\n";
		}
		if ((isset($this->data['bcc']))&&(count($this->data['bcc'])>0)) {
			$bcc=[];
			foreach ($this->data['bcc'] as $address) {
				$bcc[]=$this->makeAddress($address['address'], $address['name']);
			}
			$headers.='Bcc: '.implode(',', $bcc)."\n";
		}

		if ($charset=='iso') {
			mail(utf8_decode($to), utf8_decode($this->data['subject']), utf8_decode($this->data['message']), utf8_decode($headers));
		} else {
			mail($to, '=?utf-8?B?'.base64_encode($this->data['subject']).'?=', $this->data['message'], $headers);
		}

		return true;
	}

	/**
	 *
	 * @return osW_EMail
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>