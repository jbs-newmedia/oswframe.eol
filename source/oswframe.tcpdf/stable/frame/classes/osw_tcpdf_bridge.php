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
class osW_TCPDF_Bridge extends TCPDF {

	public $data=[];

	public function setPHPHeaderFile($file, $page=0) {
		$this->setPHPFile($file, $page, 'header');
	}

	public function setPHPFooterFile($file, $page=0) {
		$this->setPHPFile($file, $page, 'footer');
	}

	private function setPHPFile($file, $page=0, $position='header') {
		$this->data['phpfile'][$position][$page]=$file;
	}

	public function loadPHPHeader($page=0) {
		return $this->loadPHP($page, 'header');
	}

	public function loadPHPFooter($page=0) {
		return $this->loadPHP($page, 'footer');
	}

	private function loadPHP($page=0, $position='header') {
		if ((!isset($this->data['phpfile'][$position][$page]))||(!file_exists($this->data['phpfile'][$position][$page]))) {
			$page=0;
		}
		if ((isset($this->data['phpfile'][$position][$page]))&&(file_exists($this->data['phpfile'][$position][$page]))) {
			include $this->data['phpfile'][$position][$page];
		}
	}

	public function Header() {
		$page=$this->PageNo();
		$this->loadPHPHeader($page);
	}

	public function Footer() {
		$page=$this->PageNo();
		$this->loadPHPFooter($page);
	}

}

?>