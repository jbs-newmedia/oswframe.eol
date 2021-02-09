<?php
/**
 * $Id: SessionAuthenticator.php 642 2009-01-19 13:49:06Z spocke $
 *
 * @package SessionAuthenticator
 * @author Moxiecode
 * @copyright Copyright � 2007, Moxiecode Systems AB, All rights reserved.
 */

// TODO osWFrameMod
define('OSW_TOKEN_NAME', 'tinymce_token');
$root_dir=realpath(__DIR__.'/../../../../../../../../../');
include($root_dir.'/frame/includes/sid_trans.php');

/**
 * This class handles MCImageManager BaseAuthenticator stuff.
 *
 * @package BaseAuthenticator
 */
class Moxiecode_osWSessionAuthenticator extends Moxiecode_ManagerPlugin {
	/**#@+
	 * @access public
	 */

	/**
	 * ..
	 */
	function Moxiecode_osWSessionAuthenticator() {
	}

	/**
	 * ..
	 */
	function onAuthenticate(&$man) {
		return true;
	}
}

// Add plugin to MCManager
$man->registerPlugin("osWSessionAuthenticator", new Moxiecode_osWSessionAuthenticator());

?>