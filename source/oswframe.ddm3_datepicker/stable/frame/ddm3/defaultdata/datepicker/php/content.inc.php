<?php

osW_JQuery2::getInstance()->load();
osW_JQuery2::getInstance()->loadUI('ddm3');

$default_options['enabled']=true;
$default_options['options']['required']=false;
$default_options['options']['order']=false;
$default_options['options']['default_value']='';
$default_options['options']['year_min']='1900';
$default_options['options']['year_max']=date('Y');
$default_options['options']['date_format']='%d.%m.%Y';
$default_options['options']['month_asname']=false;
$default_options['options']['day_first']='1';
$default_options['options']['year_change']=true;
$default_options['options']['text_button']='Kalender';
$default_options['options']['read_only']=false;
$default_options['validation']['module']='datepicker';

?>