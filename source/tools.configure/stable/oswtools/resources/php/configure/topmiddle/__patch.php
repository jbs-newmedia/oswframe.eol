<?php

$this->data['settings']=array();

$this->data['settings']['data']=array(
	'page_title'=>'Create/Update Tables',
);

if (($position=='run')&&(isset($_POST['next']))&&($_POST['next']=='next')) {
	if ((isset($this->data['values_json']['database_db']))&&(isset($this->data['values_json']['database_db']))&&(isset($this->data['values_json']['database_db']))&&(isset($this->data['values_json']['database_db']))) {
		osW_Tool_Database::addDatabase('default', array('type'=>'mysql', 'database'=>$this->data['values_json']['database_db'], 'server'=>$this->data['values_json']['database_server'], 'username'=>$this->data['values_json']['database_username'], 'password'=>$this->data['values_json']['database_password'], 'pconnect'=>false, 'prefix'=>$this->data['values_json']['database_prefix']));

		foreach (osW_Tool_Configure::getInstance()->getFilesDir($this->data['files'][$this->data['info']['page']]['dir'], '__patch_') as $file) {
			include(abs_path.'resources/php/configure/'.$file['dir'].'/'.$file['file']);
		}

		$this->data['settings']['data']['page_title']='Create/Update Tables';
	} else {
		$this->data['messages'][]='Tables creation/update was skipped (there is no database configured)';
	}
}

if (($position=='run')&&(isset($_POST['prev']))&&($_POST['prev']=='prev')) {
	$this->data['messages'][]='Tables creation/update was skipped (go to previous page)';
}

?>