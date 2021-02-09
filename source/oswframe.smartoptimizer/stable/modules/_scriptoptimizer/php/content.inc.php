<?php

/*
 * Author: Juergen Schwind
 * Copyright: 2011 Juergen Schwind
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

$option=h()->_catch('option', '', 'g');

switch (strtolower($option)) {
	case 'single':
		osW_SmartOptimizer::getInstance()->getOutputSingle(h()->_catch('file_name', '', 'g'), 'js');
		break;
	default:
		osW_SmartOptimizer::getInstance()->getOutput(h()->_catch('file_name', '', 'g'), 'js');
		break;
}

h()->_die();

?>