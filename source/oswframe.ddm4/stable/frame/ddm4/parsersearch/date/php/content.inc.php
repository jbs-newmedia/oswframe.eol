<?php

/*
 * Author: Juergen Schwind
 * Copyright: Juergen Schwind
 * Link: http://oswframe.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/gpl.html
 *
 */

if ((($this->getSearchElementStorage($ddm_group, $element.'___0')!='')&&(!strstr($this->getSearchElementStorage($ddm_group, $element.'___0'), '_')))||(($this->getSearchElementStorage($ddm_group, $element.'___1')!='')&&(!strstr($this->getSearchElementStorage($ddm_group, $element.'___1'), '_')))) {
	$_date=array();
	if ($this->getSearchElementStorage($ddm_group, $element.'___0')!='') {
		$_date[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.' >= \''.str_replace('\'', '\\\'', $this->getSearchElementStorage($ddm_group, $element.'___0')).'\'';
	}
	if ($this->getSearchElementStorage($ddm_group, $element.'___1')!='') {
		$_date[]=$this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.' <= \''.str_replace('\'', '\\\'', $this->getSearchElementStorage($ddm_group, $element.'___1')).'\'';
	}

	$this->setDataBaseElementStorage($ddm_group, $element, '('.implode(' AND ', $_date).')');
}

?>