<?php

/**
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */

function _formatBytes($var) {
	if (!isset($var[0])) {
		$var[0]=0;
	}

	$data=[];
	$data['byte']=bcmod($var[0], 1024);
	$var[0]=bcdiv($var[0], 1024);
	if ($var[0]>0) {
		$data['kilobyte']=bcmod($var[0], 1024);
		$var[0]=bcdiv($var[0], 1024);
	}
	if ($var[0]>0) {
		$data['megabyte']=bcmod($var[0], 1024);
		$var[0]=bcdiv($var[0], 1024);
	}
	if ($var[0]>0) {
		$data['gigabyte']=bcmod($var[0], 1024);
		$var[0]=bcdiv($var[0], 1024);
	}
	if ($var[0]>0) {
		$data['terabyte']=bcmod($var[0], 1024);
		$var[0]=bcdiv($var[0], 1024);
	}
	if ($var[0]>0) {
		$data['petabyte']=bcmod($var[0], 1024);
		$var[0]=bcdiv($var[0], 1024);
	}
	if ($var[0]>0) {
		$data['exabyte']=bcmod($var[0], 1024);
		$var[0]=bcdiv($var[0], 1024);
	}
	if ($var[0]>0) {
		$data['zettabyte']=bcmod($var[0], 1024);
		$var[0]=bcdiv($var[0], 1024);
	}
	if ($var[0]>0) {
		$data['yottabyte']=bcmod($var[0], 1024);
	}

	if (isset($data['yottabyte'])) {
		return $data['yottabyte'].','.sprintf('%03d', $data['zettabyte']).' YottaByte';
	} elseif (isset($data['zettabyte'])) {
		return $data['zettabyte'].','.sprintf('%03d', $data['exabyte']).' ZettaByte';
	} elseif (isset($data['exabyte'])) {
		return $data['exabyte'].','.sprintf('%03d', $data['petabyte']).' ExaByte';
	} elseif (isset($data['petabyte'])) {
		return $data['petabyte'].','.sprintf('%03d', $data['terabyte']).' PetaByte';
	} elseif (isset($data['terabyte'])) {
		return $data['terabyte'].','.sprintf('%03d', $data['gigabyte']).' TeraByte';
	} elseif (isset($data['gigabyte'])) {
		return $data['gigabyte'].','.sprintf('%03d', $data['megabyte']).' GigaByte';
	} elseif (isset($data['megabyte'])) {
		return $data['megabyte'].','.sprintf('%03d', $data['kilobyte']).' MegaByte';
	} elseif (isset($data['kilobyte'])) {
		return $data['kilobyte'].','.sprintf('%03d', $data['byte']).' KiloByte';
	} elseif (isset($data['byte'])) {
		return $data['byte'].' Byte';
	}
}

?>