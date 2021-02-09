<?php

$default_options['enabled']=true;
$default_options['options']['required']=false;
$default_options['options']['order']=false;
$default_options['options']['default_value']='';
$default_options['options']['read_only']=false;
$default_options['options']['displayorder']='yn';
$default_options['options']['text_all']=$this->getGroupMessage($ddm_group, 'text_all');
$default_options['options']['text_yes']=$this->getGroupMessage($ddm_group, 'text_yes');
$default_options['options']['text_no']=$this->getGroupMessage($ddm_group, 'text_no');
$default_options['_search']['options']['default_value']='%';
$default_options['validation']['module']='yesno';

?>