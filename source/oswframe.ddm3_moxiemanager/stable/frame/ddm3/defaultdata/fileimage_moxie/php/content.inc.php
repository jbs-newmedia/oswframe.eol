<?php

$default_options['enabled']=true;
$default_options['options']['required']=false;
$default_options['options']['order']=false;
$default_options['options']['default_value']='';
$default_options['options']['file_dir']='data';
$default_options['options']['file_dir_tmp']='.tmp';
$default_options['options']['file_name']='original';
$default_options['options']['temp_suffix']='___osw_tmp';
$default_options['options']['delete_suffix']='___osw_delete';
$default_options['options']['text_file_view']=$this->getGroupMessage($ddm_group, 'text_image_view');
$default_options['options']['text_file_delete']=$this->getGroupMessage($ddm_group, 'text_image_delete');
$default_options['options']['store_name']=false;
$default_options['options']['store_type']=false;
$default_options['options']['store_size']=false;
$default_options['options']['store_md5']=false;
$default_options['validation']['module']='fileimage_moxie';
$default_options['_search']['enabled']=false;

?>