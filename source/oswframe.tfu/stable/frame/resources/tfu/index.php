<?php

// OSW
define('OSW_TOKEN_NAME', 'tfu_token');
$root_dir=realpath(__DIR__.'/../../../');
include($root_dir.'/frame/includes/sid_trans.php');

$tfu_config=array();

if ((isset($_GET['width']))&&(intval($_GET['width'])>0)) {
	$tfu_config['width']=intval($_GET['width']);
} else {
	$tfu_config['width']=650;
}

if ((isset($_GET['height']))&&(intval($_GET['height'])>0)) {
	$tfu_config['height']=intval($_GET['height']);
} else {
	$tfu_config['height']=340;
}

if (isset($_SESSION['tfu_flashvars'])) {
	$tfu_flashvars=$_SESSION['tfu_flashvars'];
	unset($tfu_flashvars['id']);
	unset($tfu_flashvars['class']);
	unset($tfu_flashvars['width']);
	unset($tfu_flashvars['height']);
} else {
	$tfu_flashvars=array();
}

if (isset($_SESSION['tfu_params'])) {
	$tfu_params=$_SESSION['tfu_params'];
} else {
	$tfu_params=array();
}


if ((isset($tfu_params['scale']))&&((($tfu_params['scale']!='noScale')&&($tfu_params['scale']!='Scale')))) {
	$tfu_params['scale']='noScale';
}

if ((isset($tfu_params['allowfullscreen']))&&((($tfu_params['allowfullscreen']!='true')&&($tfu_params['allowfullscreen']!='false')))) {
	$tfu_params['allowfullscreen']='true';
}

if ((isset($tfu_flashvars['c_theme']))&&((($tfu_flashvars['c_theme']!='haloOrange')&&($tfu_flashvars['c_theme']!='haloGreen')&&($tfu_flashvars['c_theme']!='haloBlue')))) {
	$tfu_flashvars['c_theme']='haloOrange';
}


/*
 * 
 * 		// Please read the description in the html page for details.
		// flashvars.tfu_description_mode="true";
		// flashvars.hide_remote_view="true";
		// flashvars.big_server_view="true";
		// flashvars.show_server_date_instead_size="true";
		// flashvars.enable_absolut_path="true";
		// flashvars.switch_sides="true";
		// flashvars.hide_upload="true";  // This is when you set $allowed_file_extensions = ''
		// flashvars.show_size="false"; // This is the parameter show_size from the config. You have to use "true" and "false". Not like in tfu_config '' for false. 

 c_header_bg", "7777FF");
c_header_bg_2", "0000FF");
c_text_header", "FFFFFF");
c_text", "000099");
c_border", "0000ff");
c_bg", "efefef");
c_list_bg", "f9f9f9");
c_progress_text", "ffffff");
c_progress_label", "7777FF");
c_progress_bar", "0000ff");
c_progress_bar_seperator", "0000ff");
c_progress_bar_bg","000066");
c_popup_bg", "ffffff");
c_popup_header_bg", "FF7777");
c_popup_header_bg_2", "FF0000");
c_popup_border", "ff0000");
c_bg_numbers", "EAEAEA");
*/



?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de">
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>TWG Flash Uploader 2.16</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
function uploadFinished(loc) {
   // here you can do something after the upload - loc is the parameter you provide in the config!
   // you can call e.g. a php page where you have stored infos during upload!
   // e.g. if you want to jump to another page after upload the code could be:
   // window.location.href=loc;
   document.getElementById("status").innerHTML = "Status: uploadFinished(..) called. Parameter: loc=" + loc;
}
function previewSelect(loc,id,fullname) {
    // here you can do something after selecting a file - loc is the parameter you provide in the config!
    // id the number you have selected in the list!
   // you can call e.g. a php page where you have stored infos when selecting a file!
   // fullname is the fullpath to the file. e.g. http://<yourhost>/<path>/<selected file>
   document.getElementById("status").innerHTML = "Status: previewSelect(..) called. Parameter: loc=" + loc + ", id=" + id + ", fullname= " + fullname;
}

function deleteFile(loc) {
    // here you can do something after deleting a file - loc is the parameter you provide in the config!
     document.getElementById("status").innerHTML = "Status: deleteFile(..) called. Parameter: loc=" + loc;
}

function changeFolder(loc) {
    // here you can do something after changing a folder - loc is the parameter you provide in the config!
     document.getElementById("status").innerHTML = "Status: changeFolder(..) called. Parameter: loc=" + loc;
}

function createFolder(status,loc) {
    // here you can do something after creating a folder - loc is the parameter you provide in the config!
     if (status == "exists")     statusstr="folder exists";
     else if (status == "true")  statusstr="folder created";
     else if (status == "false") statusstr="folder not created";
     else statusstr = "unknown status";
     document.getElementById("status").innerHTML = "Status: changeFolder(..) called. Parameter: loc=" + loc + ", status=" + statusstr;
}

function renameFolder(status,loc) {
    // here you can do something after renaming a folder - loc is the parameter you provide in the config!
     if (status == "exists")     statusstr="destination folder exists";
     else if (status == "true")  statusstr="folder renamed";
     else if (status == "false") statusstr="folder not renamed";
     else statusstr = "unknown status";
     document.getElementById("status").innerHTML = "Status: renameFolder(..) called. Parameter: loc=" + loc + ", status=" + statusstr;
}

function deleteFolder(status,loc) {
    // here you can do something after deleting a folder - loc is the parameter you provide in the config!
     if (status == "true")     statusstr="folder deleted";
     else if (status == "false") statusstr="folder not deleted";
     else statusstr = "unknown status";
     document.getElementById("status").innerHTML = "Status: deleteFolder(..) called. Parameter: loc=" + loc + ", status=" + statusstr;
}

function copymove(doCopyFolder,type,total,ok,error,exits,param) {
  // here you can do something after copying/moving a file or folder - loc is the parameter you provide in the config!
   // doCopyFolder = if "true" a folder action was done, "false" a file action
   // type = "m" = move, otherwise copy
   // total = Total number of files moved/copied
   // ok = Files copied/moved without errors
   // error = Files copied/moved with errors
   // exits = Number of files that already existed and are not overwritten
   // param = is the parameter you provide in the config!
   targetstr = (doCopyFolder == "true") ?  "folder" : "file";
   typestr = (type == "m") ? "move" : "copy";
   document.getElementById("status").innerHTML = "Status: copymove(..) called. Parameter: loc=" + loc + ", target=" + targetstr + ", type=" + typestr + ", total=" + total + ", ok=" + ok + ", error=" + error + ", exists="+exists;
}

function getTFUFormData(fields) {
  var validateOk = true;
  var spacer = String.fromCharCode(4);
  // You have to return doNotUpload if you e.g. have mandatory fields and they are not filed.
  // add the check to this function and return 'doNotUpload'. Then the upload is not started.
  // noone should enter this
  var doNotUpload = String.fromCharCode(5) + String.fromCharCode(4) + String.fromCharCode(5);
  
  var result="";
  var sarray = fields.split(",");
  for (var i = 0; i < sarray.length; ++i) {
     if (document.getElementById(sarray[i])) {
       result += document.getElementById(sarray[i]).value;
     }
     result += spacer;
  }
  // if you validate and the validation fails return doNotUpload to prevent the upload
  if (validateOk) {
    return result;
  } else {
    return doNotUpload;
  }
}

/* All connection errors are wrapped in TFU.
   For enhanced debugging it is helpful to see the real error messages.  
   Only use the part below for debuging!
*/
function debugError(errorString) {
  alert(errorString);
}

// Used for the JFUploader plugin!
function setImage(index, name, x , y) {
}

/*
 You can refresh the file list by Javascript. This is e.g. used in WFU where the thumbnails are generated
 in an extra step and to keep the listing of the flash and the file in synch.  
*/
function refreshFileList() {
   var obj = document.getElementById("flash_tfu");     
   if (obj && typeof obj.refreshFileList != "undefined") {
      obj.refreshFileList();
   }
} 

/**
 * This is the function you have modify the return value if you use IDN-Domains
 * Please read the howto about IDN in the TFU FAQ 20.
 * The standalone version need the alias url + the full path to the tfu folder.
 * The Joomla, Wordpress and TWG version has config parameters which are 
 * explained in the howto as well.    
 */ 
function getIDN() {
  return "";
}

/**
This function is only here to demonstrate the different languages of TWG
Normaly you add this parameter directly like shown below in the code.
*/
function changeLanguage(lang) { 
var flashvars = {};
var params = {};
params.allowfullscreen = "true";
params.scale = "noScale";
var attributes = { id: "flash_tfu", name: "flash_tfu" };

flashvars.lang=lang;

document.getElementById("flashcontainer").innerHTML = "<div id=\"flashcontent\">Loading</div>";
swfobject.embedSWF("tfu_216.swf", "flashcontent", "<?php echo $tfu_config['width'];?>", "<?php echo $tfu_config['height'];?>", "8.0.0", "", flashvars, params, attributes);
}

$(document).ready(function() {

});
</script>

<style type="text/css">
	body { margin:0px; padding:0px; }
}
</style>
</head>
<body>
	<!-- include with javascript - best solution because otherwise you get the "klick to activate border in IE" -->
	<script type="text/javascript" src="swfobject.js"></script>
	<script type="text/javascript">
		document.write('<div id="flashcontainer"><div id="flashcontent"><div class="noflash">TWG Flash Uploader requires at least Flash 8.<br>Please update your browser.</div></div></div>');
		var flashvars = {};
		flashvars.session_name = "<?php echo session_name()?>";
		flashvars.session_id ="<?php echo session_id()?>";
		<?php foreach ($tfu_flashvars as $key => $value):?>
		flashvars.<?php echo $key?> = "<?php echo $value?>";
		<?php endforeach?>
		
		var params = {};
		<?php foreach ($tfu_params as $key => $value):?>
		params.<?php echo $key?> = "<?php echo $value?>";
		<?php endforeach?>

		var attributes = { id: "flash_tfu", name: "flash_tfu" };
		
		swfobject.embedSWF("tfu_216.swf", "flashcontent", "<?php echo $tfu_config['width'];?>", "<?php echo $tfu_config['height'];?>", "8.0.0", "", flashvars, params, attributes);
		swfobject.embedSWF("tfu_preloader.swf", "flashcontent", "<?php echo $tfu_config['width'];?>", "<?php echo $tfu_config['height'];?>", "8.0.0", "", flashvars, params, attributes);
	</script>
	<!-- end include with Javascript -->
	<!-- static html include -->
	<noscript>
		<div id="flashcontainer"><div id="flashcontent"><div class="noflash">TWG Flash Uploader requires JavaScript.<br>Please config your browser.</div></div></div>
	</noscript>
	<!-- end static html include -->
</body>
</html>