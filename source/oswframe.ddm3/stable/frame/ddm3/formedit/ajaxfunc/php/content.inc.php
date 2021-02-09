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

$ajax=$this->getEditElementOption($ddm_group, $element, 'data');

$js_code='';
$css_code='';
$css_init=[];
$js_ajax=[];
$js_ajax_init=[];
$js_rules=[];
$js_clear=[];
$_function_ajax=[];
$_function_elements=[];
$elements_ok=[];

foreach (osW_DDM3::getInstance()->getEditElements($ddm_group) as $element=>$options) {
	if (!in_array($element, $ajax['init'])) {
		$css_init[$element]='.ddm_element_'.$element.' {display:none;}';
		$js_clear[$element]='elements["'.$element.'"]=0;';
	} else {
		$elements_ok[$element]=$element;
	}
}

if (osW_Settings::getInstance()->getAction()=='doedit') {
	foreach ($ajax['logic'] as $group=>$group_data) {
		$ajax['logic'][$group]['jsrule']=[];

		$rule=true;
		foreach ($group_data['rule'] as $rule_key=>$rule_values) {
			$_rule=false;
			foreach ($rule_values as $rule_value) {
				$ajax['logic'][$group]['jsrule'][$rule_key][]=$rule_value;
				if ((string) $this->getDoEditElementStorage($ddm_group, $rule_key)==(string) $rule_value) {
					$_rule=true;
				}
			}

			if ($_rule!==true) {
				$rule=false;
			}
		}

		if ($rule===true) {
			foreach ($group_data['view'] as $view_value) {
				$js_ajax_init[$view_value]='$(".ddm_element_'.$view_value.'").fadeIn(0);';
				$elements_ok[$view_value]=$view_value;
			}
		}
	}

	foreach (osW_DDM3::getInstance()->getEditElements($ddm_group) as $element=>$options) {
		if (!isset($elements_ok[$element])) {
			$this->setEditElementValidation($ddm_group, $element, 'module', 'ajaxfunc');
			// ???????
			$this->setEditElementValue($ddm_group, $element, 'name', '');
		}
	}
} else {
	foreach ($ajax['logic'] as $group=>$group_data) {
		$ajax['logic'][$group]['jsrule']=[];

		$rule=true;
		foreach ($group_data['rule'] as $rule_key=>$rule_values) {
			$_rule=false;
			foreach ($rule_values as $rule_value) {
				$ajax['logic'][$group]['jsrule'][$rule_key][]=$rule_value;
				if ((string) $this->getEditElementStorage($ddm_group, $rule_key)==(string) $rule_value) {
					$_rule=true;
				}
			}

			if ($_rule!==true) {
				$rule=false;
			}
		}

		if ($rule===true) {
			foreach ($group_data['view'] as $view_value) {
				$js_ajax_init[$view_value]='$(".ddm_element_'.$view_value.'").fadeIn(0);';
			}
		}
	}
}

foreach ($ajax['logic'] as $group=>$group_data) {
	foreach ($group_data['rule'] as $rule_key=>$rule_value) {
		$this->parseElementPHP($ddm_group, 'datatableajax', $this->getEditElementValue($ddm_group, $rule_key, 'module'), ['module'=>$this->getEditElementValue($ddm_group, $rule_key, 'module'), 'rule_key'=>$rule_key, 'rule_value'=>$rule_value]);
		$datatableajax_rule=$this->getElementStorage($ddm_group, 'datatableajax_rule');
		$ajax['logic'][$group]['jsrule'][$rule_key]=$datatableajax_rule;
		$datatableajax_selected=$this->getElementStorage($ddm_group, 'datatableajax_selected');
		$js_ajax[$rule_key]=$datatableajax_selected;
	}

	$ajax['logic'][$group]['jsrule']='('.implode(' && ', $ajax['logic'][$group]['jsrule']).')';

	$_function_ajax[]='if ('.$ajax['logic'][$group]['jsrule'].') {';
	foreach ($ajax['logic'][$group]['view'] as $element) {
		$_function_elements[$element]='elements["'.$element.'"]=0;';
		$_function_ajax[]='	elements["'.$element.'"]=1;';
		if (isset($ajax['logic'][$group]['reset'])) {
			foreach ($ajax['logic'][$group]['reset'] as $reset_key) {
				$this->parseElementPHP($ddm_group, 'datatableajax', $this->getEditElementValue($ddm_group, $reset_key, 'module'), ['module'=>$this->getEditElementValue($ddm_group, $reset_key, 'module'), 'reset_key'=>$reset_key]);
				$_function_ajax[]=$this->getElementStorage($ddm_group, 'datatableajax_reset');
			}
		}
		if (isset($ajax['logic'][$group]['set'])) {
			foreach ($ajax['logic'][$group]['set'] as $set_key=>$set_value) {
				$this->parseElementPHP($ddm_group, 'datatableajax', $this->getEditElementValue($ddm_group, $set_key, 'module'), ['module'=>$this->getEditElementValue($ddm_group, $set_key, 'module'), 'set_key'=>$set_key, 'set_value'=>$set_value]);
				$_function_ajax[]=$this->getElementStorage($ddm_group, 'datatableajax_set');
			}
		}
	}
	$_function_ajax[]='}';
}

foreach ($css_init as $element=>$code) {
	if (!isset($js_ajax_init[$element])) {
		$css_code.=$code."\n";
	}
}

$js_code.='

function ddm3formular_'.$ddm_group.'() {
	var elements={};
	'.implode("\n	", $js_clear).'

	'.implode("\n	", $_function_ajax).'

	$.each(elements, function(key, value) {
		if (value==1) {
			$(".ddm_element_"+key).fadeIn(0);
		} else {
			$(".ddm_element_"+key).fadeOut(0);
		}
	});
}

$(window).load(function() {
	'.implode("\n	", $js_ajax).'
});

';

osW_Template::getInstance()->addJSCodeHead($js_code);
osW_Template::getInstance()->addCSSCodeHead($css_code);

?>