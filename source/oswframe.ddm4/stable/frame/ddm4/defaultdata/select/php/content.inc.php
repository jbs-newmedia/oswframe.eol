<?php

$default_options['enabled']=true;
$default_options['options']['required']=false;
$default_options['options']['check_required']=true;
$default_options['options']['order']=false;
$default_options['options']['search']=false;
$default_options['options']['default_value']='';
$default_options['options']['blank_value']=true;
$default_options['options']['data']=array();
$default_options['options']['text_all']=$this->getGroupMessage($ddm_group, 'text_all');
$default_options['options']['read_only']=false;
$default_options['_search']['options']['blank_value']=false;
$default_options['_search']['options']['default_value']='%';
$default_options['validation']['module']='string';

?>