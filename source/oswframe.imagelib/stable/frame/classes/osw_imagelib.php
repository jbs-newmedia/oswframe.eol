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
class osW_ImageLib extends osW_Object {

	/* PROPERTIES */
	private $image;

	private $options;

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 1, true);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function load($filename) {
		$_options=getimagesize($filename);
		$this->options['image']=[];
		$this->options['image']['width']=$_options[0];
		$this->options['image']['height']=$_options[1];
		$this->options['image']['type']=$_options[2];
		$this->options['image']['bits']=$_options['bits'];
		$this->options['image']['mime']=$_options['mime'];

		$this->options['options']=[];
		$this->options['options']['width']=$this->options['image']['width'];
		$this->options['options']['height']=$this->options['image']['height'];
		$this->setQuality(vOut('imagelib_quality'));
		$this->options['options']['type']=$this->options['image']['type'];
		$this->options['options']['alphablending']=false;
		$this->options['options']['savealpha']=true;

		if ($this->options['image']['type']==IMAGETYPE_JPEG) {
			$this->image=imagecreatefromjpeg($filename);
		} elseif ($this->options['image']['type']==IMAGETYPE_GIF) {
			$this->image=imagecreatefromgif($filename);
		} elseif ($this->options['image']['type']==IMAGETYPE_PNG) {
			$this->image=imagecreatefrompng($filename);
		}
	}

	public function unload() {
		imagedestroy($this->image);
	}

	public function save($filename) {
		imagealphablending($this->image, $this->options['options']['alphablending']);
		imagesavealpha($this->image, $this->options['options']['savealpha']);

		if ($this->options['options']['type']==IMAGETYPE_JPEG) {
			imagejpeg($this->image, $filename, $this->options['options']['quality']);
		} elseif ($this->options['options']['type']==IMAGETYPE_GIF) {
			imagegif($this->image, $filename);
		} elseif ($this->options['options']['type']==IMAGETYPE_PNG) {
			imagepng($this->image, $filename, 9);
		}
		h()->_chmod($filename);
	}

	public function output($header=true, $die=false) {
		imagealphablending($this->image, $this->options['options']['alphablending']);
		imagesavealpha($this->image, $this->options['options']['savealpha']);

		if ($this->options['options']['type']==IMAGETYPE_JPEG) {
			if ($header===true) {
				header('Content-Type: image/jpg');
			}
			/*
			 * 0 (worst quality, smaller file) to 100 (best quality, biggest file)
			 */
			imagejpeg($this->image, null, $this->options['options']['quality']);
		} elseif ($this->options['options']['type']==IMAGETYPE_GIF) {
			if ($header===true) {
				header('Content-Type: image/gif');
			}
			imagegif($this->image, null);
		} elseif ($this->options['options']['type']==IMAGETYPE_PNG) {
			if ($header===true) {
				header('Content-Type: image/png');
			}
			/*
			 * quality 0-9 0 is NO COMPRESSION at all, 1 is FASTEST but produces larger files, 9 provides the best compression (smallest files) but takes a long time to compress, and -1 selects the default compiled into the zlib library.
			 */
			imagepng($this->image, null, 9);
		}
		if ($die===true) {
			die();
		}
	}

	public function outputStream() {
		ob_start();
		$this->output(false);
		$image=ob_get_contents();
		ob_end_clean();

		return $image;
	}

	public function setQuality($quality) {
		$quality=intval($quality);
		if (($quality<0)||($quality>100)) {
			$this->options['options']['quality']=vOut('imagelib_quality');
		} else {
			$this->options['options']['quality']=$quality;
		}
	}

	public function getWidth() {
		return $this->getImageWidth();
	}

	public function getHeight() {
		return $this->getImageHeight();
	}

	public function getImageWidth() {
		return imagesx($this->image);
	}

	public function getImageHeight() {
		return imagesy($this->image);
	}

	public function resize($width, $height) {
		$this->options['options']['width']=intval($width);
		$this->options['options']['height']=intval($height);
		$this->checkSizeLimits();
		$new_image=imagecreatetruecolor($width, $height);

		imagealphablending($new_image, $this->options['options']['alphablending']);
		imagesavealpha($new_image, $this->options['options']['savealpha']);

		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getImageWidth(), $this->getImageHeight());
		$this->image=$new_image;
	}

	public function resizeToHeight($height) {
		$height=intval($height);
		$ratio=$height/$this->getImageHeight();
		$width=intval(round($this->getImageWidth()*$ratio));
		$this->resize($width, $height);
	}

	public function resizeToWidth($width) {
		$width=intval($width);
		$ratio=$width/$this->getImageWidth();
		$height=intval(round($this->getImageHeight()*$ratio));
		$this->resize($width, $height);
	}

	public function resizeToLongest($size) {
		$ratio_w=$size/$this->getImageWidth();
		$ratio_h=$size/$this->getImageHeight();
		if ($ratio_h>$ratio_w) {
			$width=$this->getImageWidth()*$ratio_w;
			$height=$this->getImageHeight()*$ratio_w;
		} else {
			$width=$this->getWidth()*$ratio_h;
			$height=$this->getImageHeight()*$ratio_h;
		}
		$this->resize($width, $height);
	}

	private function checkSizeLimits() {
		// TODO
	}

	public function scale($scale) {
		$width=$this->getWidth()*$scale/100;
		$height=$this->getheight()*$scale/100;
		$this->resize($width, $height);

		return true;
	}

	public function cut($x, $y, $width, $height) {
		$new_image=imagecreatetruecolor($width, $height);

		imagealphablending($new_image, $this->options['options']['alphablending']);
		imagesavealpha($new_image, $this->options['options']['savealpha']);

		imagecopyresampled($new_image, $this->image, 0, 0, $x, $y, $width, $height, $width, $height);
		$this->image=$new_image;

		return true;
	}

	public function cropSquare() {
		$img_width=$this->getWidth();
		$img_height=$this->getheight();
		if ($img_width>$img_height) {
			$div=bcdiv(($img_width-$img_height), 2);
			$this->cut($div, 0, $img_height, $img_height);
		} elseif ($img_height>$img_width) {
			$div=bcdiv(($img_height-$img_width), 2);
			$this->cut(0, $div, $img_width, $img_width);
		}

		return true;
	}

	public function cropSquareResized($size) {
		$this->cropSquare();
		$this->resize($size, $size);

		return true;
	}

	public function cropRectangle($ratio) {
		if ($ratio==1) {
			$this->cropSquare();

			return true;
		}
		$img_width=$this->getWidth();
		$img_height=$this->getheight();
		$img_ratio=floatval($img_width/$img_height);
		if ($ratio>$img_ratio) {
			$width_new=$img_width;
			$height_new=round($width_new/$ratio);
			$this->cut(0, bcdiv(($img_height-$height_new), 2), $width_new, $height_new);

			return true;
		} else {
			$height_new=$img_height;
			$width_new=round($height_new*$ratio);
			$this->cut(bcdiv(($img_width-$width_new), 2), 0, $width_new, $height_new);

			return true;
		}
	}

	public function cropRectangleResized($width, $height) {
		if ($width==$height) {
			$this->cropSquareResized($height);

			return true;
		}
		$ratio=floatval($width/$height);
		$this->cropRectangle($ratio);
		if ($width>$height) {
			$this->resizeToLongest($width);
		} else {
			$this->resizeToLongest($height);
		}

		return true;
	}

	/**
	 *
	 * @return osW_ImageLib
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>