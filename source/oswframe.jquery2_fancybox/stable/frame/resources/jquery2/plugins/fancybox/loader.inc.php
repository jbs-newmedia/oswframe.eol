<?php

osW_JQuery2::getInstance()->loadPlugin('mousewheel');
osW_JQuery2::getInstance()->loadPlugin('easing');

osW_Template::getInstance()->addJSFileHead('frame/resources/jquery2/plugins/fancybox/jquery.fancybox-1.3.4.js');
osW_Template::getInstance()->addCSSFileHead('frame/resources/jquery2/plugins/fancybox/jquery.fancybox-1.3.4.css');

?>