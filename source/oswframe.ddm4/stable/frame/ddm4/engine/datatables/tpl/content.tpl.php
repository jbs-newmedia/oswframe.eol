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

# search
if(osW_Settings::getInstance()->getAction()=='search') {
	osW_Template::getInstance()->addJSCodeHead('
function submitDDM4(del) {
	if (del===true) {
		$("input[name=ddm4_search_delete]").val(1);
	}
	$("form").submit();
}
function resetDDM4() {
	$("form").trigger("reset");
	$(".selectpicker").selectpicker("render");
};
');
	echo '<div class="page-wrapper-color">';
	echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), array('form_parameter'=>'enctype="multipart/form-data"'));
	foreach ($this->getSearchElements($ddm_group) as $element => $options) {
		echo $this->parseFormSearchElementTPL($ddm_group, $element, $options);
	}
	echo osW_Form::getInstance()->drawHiddenField('action', 'dosearch');
	echo osW_Form::getInstance()->drawHiddenField('ddm4_search_delete', 0);
	echo osW_Form::getInstance()->drawHiddenField($this->getGroupOption($ddm_group, 'index', 'database'), $this->getIndexElementStorage($ddm_group));
	echo osW_Form::getInstance()->formEnd();
	echo '</div>';
}

# add
if(osW_Settings::getInstance()->getAction()=='add') {
	osW_Template::getInstance()->addJSCodeHead('
function submitDDM4() {
	$("form").submit();
}
function resetDDM4() {
	$("form").trigger("reset");
	$(".selectpicker").selectpicker("render");
};
');
	echo '<div><div class="page-wrapper-color">';
	echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), array('form_parameter'=>'enctype="multipart/form-data"'));
	foreach ($this->getAddElements($ddm_group) as $element => $options) {
		echo $this->parseFormAddElementTPL($ddm_group, $element, $options);
	}
	echo osW_Form::getInstance()->drawHiddenField('action', 'doadd');
	echo osW_Form::getInstance()->drawHiddenField($this->getGroupOption($ddm_group, 'index', 'database'), $this->getIndexElementStorage($ddm_group));
	echo osW_Form::getInstance()->formEnd();
	echo '</div></div>';
}

# edit
if(osW_Settings::getInstance()->getAction()=='edit') {
	osW_Template::getInstance()->addJSCodeHead('
function submitDDM4() {
	$("form").submit();
}
function resetDDM4() {
	$("form").trigger("reset");
	$(".selectpicker").selectpicker("render");
};
');
	echo '<div class="page-wrapper-color">';
	echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), array('form_parameter'=>'enctype="multipart/form-data"'));
	foreach ($this->getEditElements($ddm_group) as $element => $options) {
		echo $this->parseFormEditElementTPL($ddm_group, $element, $options);
	}
	echo osW_Form::getInstance()->drawHiddenField('action', 'doedit');
	echo osW_Form::getInstance()->drawHiddenField($this->getGroupOption($ddm_group, 'index', 'database'), $this->getIndexElementStorage($ddm_group));
	echo osW_Form::getInstance()->formEnd();
	echo '</div>';
}

# delete
if(osW_Settings::getInstance()->getAction()=='delete') {
	osW_Template::getInstance()->addJSCodeHead('
function submitDDM4() {
	$("form").submit();
}
function resetDDM4() {
	$("form").trigger("reset");
	$(".selectpicker").selectpicker("render");
};
');
	echo '<div class="page-wrapper-color">';
	echo osW_Form::getInstance()->formStart($ddm_group, 'current', $this->getDirectParameters($ddm_group), array('form_parameter'=>'enctype="multipart/form-data"'));
	foreach ($this->getDeleteElements($ddm_group) as $element => $options) {
		echo $this->parseFormDeleteElementTPL($ddm_group, $element, $options);
	}
	echo osW_Form::getInstance()->drawHiddenField ('action', 'dodelete');
	echo osW_Form::getInstance()->drawHiddenField ($this->getGroupOption($ddm_group, 'index', 'database'), $this->getIndexElementStorage($ddm_group));
	echo osW_Form::getInstance()->formEnd();
	echo '</div>';
}

# data
if(in_array(osW_Settings::getInstance()->getAction(), array('', 'log'))) {
	if (osW_Settings::getInstance()->getAction()!='') {
		$ddm_group.='_'.osW_Settings::getInstance()->getAction();
		echo '<div class="page-wrapper-color">';
	}
	if($this->getPreViewElements($ddm_group)!=array()) {
		foreach ($this->getPreViewElements($ddm_group) as $element => $options) {
			$file=vOut('settings_abspath').'frame/ddm4/view/'.$options['module'].'/tpl/content.tpl.php';
			if (file_exists($file)) {
				include $file;
			}
		}
	}

	if($this->getViewElements($ddm_group)!=array()) {
		foreach ($this->getViewElements($ddm_group) as $element => $options) {
			$file=vOut('settings_abspath').'frame/ddm4/view/'.$options['module'].'/tpl/content.tpl.php';
			if (file_exists($file)) {
				include $file;
			}
		}
	}
	if (osW_Settings::getInstance()->getAction()!='') {
		echo '</div>';
	}

?>

<div class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" style="max-width:95%; max-height:95%;">
		<div class="modal-content">
			<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">32424234</h4></div>
			<div class="modal-body" style="padding:0px; margin:0px; overflow:hidden;"></div>
			<div class="modal-footer">
				<button onclick="submitDDM4Modal();" name="ddm4_button_submit" type="button" class="btn btn-primary ddm4_btn_search"><?php echo $this->getGroupMessage($ddm_group, 'form_search')?></button>
				<button onclick="submitDDM4Modal();" name="ddm4_button_submit" type="button" class="btn btn-primary ddm4_btn_add"><?php echo $this->getGroupMessage($ddm_group, 'form_add')?></button>
				<button onclick="submitDDM4Modal();" name="ddm4_button_submit" type="button" class="btn btn-primary ddm4_btn_edit"><?php echo $this->getGroupMessage($ddm_group, 'form_edit')?></button>
				<button onclick="submitDDM4Modal(true);" name="ddm4_button_delete" type="button" class="btn btn-danger ddm4_btn_delete"><?php echo $this->getGroupMessage($ddm_group, 'form_delete')?></button>
				<button onclick="resetDDM4Modal();" name="ddm4_button_reset" type="button" class="btn btn-default ddm4_btn_reset"><?php echo $this->getGroupMessage($ddm_group, 'form_reset')?></button>
				<button name="ddm4_button_close" type="button" class="btn btn-default ddm4_btn_close" data-dismiss="modal"><?php echo $this->getGroupMessage($ddm_group, 'form_close')?></button>
				<button name="ddm4_button_cancel" type="button" class="btn btn-default ddm4_btn_cancel" data-dismiss="modal"><?php echo $this->getGroupMessage($ddm_group, 'form_cancel')?></button>
			</div>
		</div>
	</div>
</div>

<?php
osW_Template::getInstance()->addJSCodeHead('
function openDDM4Modal(elem, title, mode, count) {
	if (!mode) {
		mode="";
	}
	if (!count) {
		count=0;
	}
	width=800;
	height=600;
	if ((count>0)&&(count<7)) {
		height=count*85;
	}

	if (mode=="add") {
		$(".modal-footer .ddm4_btn_search").hide();
		$(".modal-footer .ddm4_btn_add").show();
		$(".modal-footer .ddm4_btn_edit").hide();
		$(".modal-footer .ddm4_btn_delete").hide();
		$(".modal-footer .ddm4_btn_reset").show();
		$(".modal-footer .ddm4_btn_close").hide();
		$(".modal-footer .ddm4_btn_cancel").show();
	} else if (mode=="edit") {
		$(".modal-footer .ddm4_btn_search").hide();
		$(".modal-footer .ddm4_btn_add").hide();
		$(".modal-footer .ddm4_btn_edit").show();
		$(".modal-footer .ddm4_btn_delete").hide();
		$(".modal-footer .ddm4_btn_reset").show();
		$(".modal-footer .ddm4_btn_close").hide();
		$(".modal-footer .ddm4_btn_cancel").show();

	} else if (mode=="delete") {
		$(".modal-footer .ddm4_btn_search").hide();
		$(".modal-footer .ddm4_btn_add").hide();
		$(".modal-footer .ddm4_btn_edit").hide();
		$(".modal-footer .ddm4_btn_delete").show();
		$(".modal-footer .ddm4_btn_reset").hide();
		$(".modal-footer .ddm4_btn_close").hide();
		$(".modal-footer .ddm4_btn_cancel").show();

	} else if (mode=="search") {
		$(".modal-footer .ddm4_btn_search").show();
		$(".modal-footer .ddm4_btn_add").hide();
		$(".modal-footer .ddm4_btn_edit").hide();
		$(".modal-footer .ddm4_btn_delete").hide();
		$(".modal-footer .ddm4_btn_reset").show();
		$(".modal-footer .ddm4_btn_close").hide();
		$(".modal-footer .ddm4_btn_cancel").show();

	} else if (mode=="search_edit") {
		$(".modal-footer .ddm4_btn_search").show();
		$(".modal-footer .ddm4_btn_add").hide();
		$(".modal-footer .ddm4_btn_edit").hide();
		$(".modal-footer .ddm4_btn_delete").show();
		$(".modal-footer .ddm4_btn_reset").show();
		$(".modal-footer .ddm4_btn_close").hide();
		$(".modal-footer .ddm4_btn_cancel").show();

	} else if (mode=="log") {
		width=1920;
		$(".modal-footer .ddm4_btn_search").hide();
		$(".modal-footer .ddm4_btn_add").hide();
		$(".modal-footer .ddm4_btn_edit").hide();
		$(".modal-footer .ddm4_btn_delete").hide();
		$(".modal-footer .ddm4_btn_reset").hide();
		$(".modal-footer .ddm4_btn_close").show();
		$(".modal-footer .ddm4_btn_cancel").hide();

	}

	$(".modal-dialog").width(width);

	$(".modal-header h4").html(title);
	$(".modal .modal-body").html("<div class=\"ddm4_iframe_holder\" style=\"height:"+height+"px;\"><iframe class=\"ddm4_iframe_content\" style=\"height:"+height+"px;\"></iframe></div>");
	$(".ddm4_iframe_content").attr("src", $(elem).attr("pageName"));
	$(".modal .modal-content").load();
	$(".modal").modal("show");
}

function submitDDM4Modal(del) {
	$(".ddm4_iframe_content")[0].contentWindow.submitDDM4(del);
}

function resetDDM4Modal() {
	$(".ddm4_iframe_content")[0].contentWindow.resetDDM4();
}
');

}

?>