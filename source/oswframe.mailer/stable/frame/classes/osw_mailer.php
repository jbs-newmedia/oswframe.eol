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
class osW_Mailer extends osW_Object {

	/* PROPERTIES */
	public $obj_mailer;

	public $obj_template;

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 2, true);
		$this->obj_template=new osW_Template();
		$this->clearMailer();
		$this->setCharSet('utf-8');
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function getMailerObject() {
		if (!is_object($this->obj_mailer)) {
			$this->obj_mailer=new PHPMailer(false);
		}

		return $this->obj_mailer;
	}

	public function setSMTPDebug($value) {
		$this->getMailerObject()->SMTPDebug=$value;
	}

	public function setSMTPAutoTLS($value) {
		$this->getMailerObject()->SMTPAutoTLS=$value;
	}

	public function setHost($value) {
		$this->getMailerObject()->Host=$value;
	}

	public function setPort($value) {
		$this->getMailerObject()->Port=intval($value);
	}

	public function setCharSet($value) {
		$this->getMailerObject()->CharSet=$value;
	}

	public function setEncoding($value) {
		$this->getMailerObject()->Encoding=$value;
	}

	public function setUsername($value) {
		$this->getMailerObject()->Username=$value;
	}

	public function setPassword($value) {
		$this->getMailerObject()->Password=$value;
	}

	public function setSMTPAuth($value) {
		if ($value===true) {
			$this->getMailerObject()->SMTPAuth=true;
		} else {
			$this->getMailerObject()->SMTPAuth=false;
		}
	}

	public function setSMTPSecure($value) {
		switch ($value) {
			case 'ssl':
				$this->getMailerObject()->SMTPSecure='ssl';
				break;
			case 'tls':
				$this->getMailerObject()->SMTPSecure='tls';
				break;
			default:
				$this->getMailerObject()->SMTPSecure='';
				break;
		}
	}

	public function set($name, $value) {
		return $this->getMailerObject()->set($name, $value);
	}

	public function addCustomHeader($value) {
		$this->getMailerObject()->addCustomHeader($value);
	}

	public function setSubject($value) {
		$this->getMailerObject()->Subject=$value;
	}

	public function MsgHTML($message) {
		$this->isHTML(true);

		return $this->getMailerObject()->MsgHTML($message);
	}

	public function setBody($value) {
		$this->getMailerObject()->Body=$value;
	}

	public function setAltBody($value) {
		$this->getMailerObject()->AltBody=$this->html2plain($value);
	}

	public function isMail() {
		$this->getMailerObject()->IsMail();
	}

	public function isSMTP() {
		$this->getMailerObject()->IsSMTP();
	}

	public function isHTML($ishtml=true) {
		$this->getMailerObject()->IsHTML($ishtml);
	}

	public function isSendmail() {
		$this->getMailerObject()->IsSendmail();
	}

	public function isQmail() {
		$this->getMailerObject()->IsQmail();
	}

	public function setFrom($address, $name='') {
		return $this->getMailerObject()->SetFrom($address, $name);
	}

	public function addAddress($address, $name='') {
		return $this->getMailerObject()->AddAddress($address, $name);
	}

	public function addCC($address, $name='') {
		return $this->getMailerObject()->AddCC($address, $name);
	}

	public function addBCC($address, $name='') {
		return $this->getMailerObject()->AddBCC($address, $name);
	}

	public function addReplyTo($address, $name='') {
		return $this->getMailerObject()->AddReplyTo($address, $name);
	}

	public function send() {
		$return=$this->getMailerObject()->Send();
		if ($this->getMailerObject()->ErrorInfo!='') {
			$this->logMessage(__CLASS__, 'error', ['time'=>time(), 'line'=>__LINE__, 'function'=>__FUNCTION__, 'error'=>$this->getMailerObject()->ErrorInfo, 'to'=>$this->getMailerObject()->addrAppend('To', $this->getMailerObject()->getToAddresses()), 'cc'=>$this->getMailerObject()->addrAppend('Cc', $this->getMailerObject()->getCcAddresses()), 'bcc'=>$this->getMailerObject()->addrAppend('Bcc', $this->getMailerObject()->getBccAddresses()), 'reply-to'=>$this->getMailerObject()->addrAppend('Reply-To', $this->getMailerObject()->getReplyToAddresses()), 'subject'=>$this->getMailerObject()->encodeHeader($this->getMailerObject()->secureHeader($this->getMailerObject()->Subject))]);
		}

		return $return;
	}

	public function addAttachment($path, $name='', $encoding='base64', $type='application/octet-stream') {
		return $this->getMailerObject()->AddAttachment($path, $name, $encoding, $type);
	}

	public function addStringAttachment($string, $filename, $encoding='base64', $type='', $disposition='attachment') {
		return $this->getMailerObject()->addStringAttachment($string, $filename, $encoding, $type, $disposition);
	}

	public function addEmbeddedImage($path, $cid, $name='', $encoding='base64', $type='application/octet-stream') {
		return $this->getMailerObject()->AddEmbeddedImage($path, $cid, $name, $encoding, $type);
	}

	public function clearAddresses() {
		$this->getMailerObject()->ClearAddresses();
	}

	public function clearCCs() {
		$this->getMailerObject()->ClearCCs();
	}

	public function clearBCCs() {
		$this->getMailerObject()->ClearBCCs();
	}

	public function clearReplyTos() {
		$this->getMailerObject()->ClearReplyTos();
	}

	public function clearAllRecipients() {
		$this->getMailerObject()->ClearAllRecipients();
	}

	public function clearAttachments() {
		$this->getMailerObject()->ClearAttachments();
	}

	public function clearCustomHeaders() {
		$this->getMailerObject()->ClearCustomHeaders();
	}

	public function clearMailer() {
		$this->getMailerObject()->ErrorInfo='';
		$this->setSubject('');
		$this->setAltBody('');
		$this->setBody('');
		$this->ClearAddresses();
		$this->ClearCCs();
		$this->ClearBCCs();
		$this->ClearReplyTos();
		$this->ClearAllRecipients();
		$this->ClearAttachments();
		$this->ClearCustomHeaders();
	}

	public function html2plain($text) {
		$text=preg_replace('/<a[^<]*href="([^"]+)"[^<]*<\/a>/', "\\1", $text);
		$text=str_replace('&amp;', '&', $text);
		$text=str_replace('<br/>', '
', $text);
		$text=str_replace('<br/>', '
', $text);

		return strip_tags($text);
	}

	/**
	 *
	 * @return osW_Mailer
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>