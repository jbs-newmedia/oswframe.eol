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

if (!in_array($this->getSearchElementStorage($ddm_group, $element), ['%'])) {
	$this->setDataBaseElementStorage($ddm_group, $element, $this->getGroupOption($ddm_group, 'alias', 'database').'.'.$element.' LIKE \''.str_replace('\'', '\\\'', ($this->getSearchElementStorage($ddm_group, $element))).'\'');
}

?>