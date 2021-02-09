<?php

osW_JQuery2::getInstance()->load();
osW_JQuery2::getInstance()->loadUI('ddm3');

$default_options['enabled']=true;
$default_options['options']['required']=false;
$default_options['options']['order']=false;
$default_options['options']['default_value']='';
$default_options['options']['text_char']=$this->getGroupMessage($ddm_group, 'text_char');
$default_options['options']['text_chars']=$this->getGroupMessage($ddm_group, 'text_chars');
$default_options['options']['read_only']=false;
$default_options['options']['show_output']=false;
$default_options['validation']['module']='string';

?>