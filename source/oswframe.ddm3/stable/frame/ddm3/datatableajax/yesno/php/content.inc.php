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

$datatableajax_rule='($("input[name=\''.$values['rule_key'].'\']:checked").val()=='.implode(' || $("input[name=\''.$values['rule_key'].'\']:checked").val()==', $values['rule_value']).')';
$this->setElementStorage($ddm_group, 'datatableajax_rule', $datatableajax_rule);

$datatableajax_selected='$("input[name=\''.$values['rule_key'].'\']").change(function(){ddm3formular_'.$ddm_group.'();});';
$this->setElementStorage($ddm_group, 'datatableajax_selected', $datatableajax_selected);

?>