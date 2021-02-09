<?php

/**
 *
 * @author Juergen Schwind
 * @copyright Copyright (c), Juergen Schwind
 * @package osWFrame
 * @link http://oswframe.com
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 *
 */
class osW_SeoAuth extends osW_Object {

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	public function output($se, $auth) {
		$authed=false;
		$output='';

		switch ($se) {
			case 'google' :
				if (vOut('seoauth_google_enabled')===true) {
					$valid_users=explode(',', vOut('seoauth_google_users'));
					if (in_array($auth, $valid_users)) {
						$output.='google-site-verification: google'.$auth.'.html';
						$authed=true;
					}
				}
				break;
			case 'bing' :
				if (vOut('seoauth_bing_enabled')===true) {
					$valid_users=explode(',', vOut('seoauth_bing_users'));
					$output.='<?xml version="1.0"?>
<users>
';
					foreach ($valid_users as $valid_user) {
						$output.='<user>'.$valid_user.'</user>
';
					}
					$output.='</users>';
					header("content-type: text/xml");
					$authed=true;
				}
			default :
				break;
		}

		if ($authed===true) {
			echo $output;
			h()->_die();
		} else {
			$_GET['error_status']=404;
			osW_Settings::getInstance()->frame_default_module=vOut('settings_errorlogger');
			osW_Settings::getInstance()->frame_engine=true;
		}
	}

	/**
	 *
	 * @return osW_SeoAuth
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>