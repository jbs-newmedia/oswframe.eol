<?php

if (isset($_SESSION['tfu_config'])) {
	foreach ($_SESSION['tfu_config'] as $key => $value) {
		eval('$'.$key.'=\''.$value.'\';');
	}
}

?>