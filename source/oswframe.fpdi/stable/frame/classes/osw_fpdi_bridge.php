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
class osW_FPDI_Bridge extends FPDI {

	public $data=[];

	public function setPDFFile($file, $page=0) {
		$this->data['pdffile'][$page]=$file;
	}

	public function setPHPHeaderFile($file, $page=0) {
		$this->setPHPFile($file, $page, 'header');
	}

	public function setPHPFooterFile($file, $page=0) {
		$this->setPHPFile($file, $page, 'footer');
	}

	private function setPHPFile($file, $page=0, $position='header') {
		$this->data['phpfile'][$position][$page]=$file;
	}

	public function loadPDF($page=0) {
		if ((!isset($this->data['pdffile'][$page]))||(!file_exists($this->data['pdffile'][$page]))) {
			$page=0;
		}
		if ((isset($this->data['pdffile'][$page]))&&(file_exists($this->data['pdffile'][$page]))) {
			if (!isset($this->data['tplIdx'][$page])) {
				$this->setSourceFile($this->data['pdffile'][$page]);
				$this->data['tplIdx'][$page]=$this->importPage(1);
			}
			$this->useTemplate($this->data['tplIdx'][$page]);
		}
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

	public function mergeFiles($files) {
		foreach ($files as $id=>$file) {
			$count=$this->setSourceFile($file);
			for ($i=1; $i<=$count; $i++) {
				$template=$this->importPage($i);
				$size=$this->getTemplateSize($template);
				if ($size['h']>$size['w']) {
					$this->AddPage('P', [$size['w'], $size['h']]);
				} else {
					$this->AddPage('L', [$size['w'], $size['h']]);
				}
				$this->useTemplate($template);
			}
		}
	}

	public function Header() {
		$page=$this->PageNo();
		$this->loadPDF($page);
		$this->loadPHPHeader($page);
	}

	public function Footer() {
		$page=$this->PageNo();
		$this->loadPHPFooter($page);
	}

}

?>