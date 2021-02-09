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

if (file_exists(vOut('settings_abspath').'frame/classes/osw_user/'.vOut('class_osw_user_name').'.php')) {
	include vOut('settings_abspath').'frame/classes/osw_user/'.vOut('class_osw_user_name').'.php';
} else {
	class osW_User extends osW_Object {

		/* VALUES */
		public $data=[];

		private $groupids=[];

		/* METHODS CORE */
		public function __construct() {
			parent::__construct(1, 0);
		}

		public function __destruct() {
			parent::__destruct();
		}

		/* METHODS */

		public function doLogin($user_id, $use_cookie) {
			$this->setData($user_id);

			if (($use_cookie==1)&&(osW_Object::setIsEnabled('osW_Cookie')===true)) {
				$this->setUserCookie();
			}

			if (osW_Session::getInstance()->setUserSession($user_id, $this->isAdmin())===true) {
				return true;
			}

			return false;
		}

		public function doLogout($user_id) {
			$this->setData(0);

			osW_Cookie::getInstance()->remove(vOut('user_cookiename'));

			if (osW_Session::getInstance()->unsetUserSession()===true) {
				return true;
			}

			return false;
		}

		public function getData($user_id=0) {
			$user_id=intval($user_id);
			if ($user_id==0) {
				$user_id=$this->getId();
			}

			if ($user_id==0) {
				return [];
			}

			if (!isset($this->data['user'][$user_id])) {
				$this->data['user'][$user_id]=[];
				$Quser=osW_Database::getInstance()->query('SELECT * FROM :table_user WHERE user_id=:user_id');
				$Quser->bindTable(':table_user', 'user');
				$Quser->bindInt(':user_id', $user_id);
				$Quser->execute();
				if ($Quser->query_handler===false) {
					$this->__initDB();
					$Quser->execute();
				}
				if ($Quser->numberOfRows()===1) {
					$Quser->next();
					$this->data['user'][$user_id]=$Quser->result;
				}
			}

			return $this->data['user'][$user_id];
		}

		public function getDataByEMail($user_email='') {
			if ($user_email=='') {
				$user_id=$this->getId();

				return $this->getData($user_id);
			}

			if (!isset($this->data['user_email2id'][$user_email])) {
				$this->data['user_email2id'][$user_email]=0;
				$Quser=osW_Database::getInstance()->query('SELECT user_id FROM :table_user WHERE user_email=:user_email');
				$Quser->bindTable(':table_user', 'user');
				$Quser->bindValue(':user_email', $user_email);
				$Quser->execute();
				if ($Quser->query_handler===false) {
					$this->__initDB();
					$Quser->execute();
				}
				if ($Quser->numberOfRows()===1) {
					$Quser->next();
					$this->data['user_email2id'][$user_email]=$Quser->result['user_id'];
				}
			}

			return $this->getData($this->data['user_email2id'][$user_email]);
		}

		public function setUserData($user_id) {
			return $this->setData($user_id);
		}

		public function setData($user_id) {
			$user_id=intval($user_id);

			if ($user_id>0) {
				$this->data['current_user']=[];
				$this->data['current_user']=$this->getData($user_id);

				if (strlen($this->data['current_user']['user_groupids'])>0) {
					$this->setGroupIds(vOut('user_defaultusergroupid').','.$this->data['current_user']['user_groupids']);
				} else {
					$this->setGroupIds(vOut('user_defaultusergroupid'));
				}

				if (!in_array($this->data['current_user']['user_cookielevel'], [1, 2, 3])) {
					$this->data['current_user']['user_cookielevel']=vOut('user_cookiedefaultlevel');
				}

				/*
				 * TODO: if (osW_Settings::getInstance()->validateLanguage($Quser->Value('user_language')) === true) { osW_Session::getInstance()->set('language', $Quser->Value('user_language')); }
				 */
				$this->setLoggedOn(true);
			} else {
				$this->setLoggedOn(false);
				$this->data['current_user']=[];
				$this->setGroupIds(vOut('user_defaultguestgroupid'));
			}

			return $this->getLoggedOn();
		}

		public function getID() {
			if (isset($this->data['current_user']['user_id'])) {
				return $this->data['current_user']['user_id'];
			}

			return 0;
		}

		public function getEMail() {
			if (isset($this->data['current_user']['user_email'])) {
				return $this->data['current_user']['user_email'];
			}

			return '';
		}

		public function getPassword() {
			if (isset($this->data['current_user']['user_password'])) {
				return $this->data['current_user']['user_password'];
			}

			return '';
		}

		public function getCookieLevel() {
			if (isset($this->data['current_user']['user_cookielevel'])) {
				return $this->data['current_user']['user_cookielevel'];
			}

			return vOut('user_cookiedefaultlevel');
		}

		function isGuest() {
			if ($this->getLoggedOn()!==true) {
				return true;
			}

			return false;
		}

		function isUser() {
			if ($this->getLoggedOn()===true) {
				return true;
			}

			return false;
		}

		function isAdmin() {
			if (($this->isUser()===true)&&(isset($this->data['current_user']['user_isadmin']))&&($this->data['current_user']['user_isadmin']===true)) {
				return true;
			}

			return false;
		}

		function setGroupIds($groupids) {
			$this->data['current_user']['groupids']=explode(',', $groupids);
		}

		function getGroupIds($user_id=0) {
			return $this->data['current_user']['groupids'];
		}

		function setLoggedOn($state) {
			if ($state==true) {
				$this->data['current_user']['user_isloggedon']=true;
			} else {
				$this->data['current_user']['user_isloggedon']=false;
			}
		}

		function getLoggedOn() {
			if ((isset($this->data['current_user']['user_isloggedon']))&&($this->data['current_user']['user_isloggedon']===true)) {
				return true;
			}

			return false;
		}

		public function checkUserCookie() {
			if ((strlen(osW_Settings::getInstance()->getAction())>2)&&(substr(osW_Settings::getInstance()->getAction(), 0, 2)=='do')) {
				return 0;
			}

			if ((isset($_COOKIE[vOut('user_cookiename')]))&&(strlen($_COOKIE[vOut('user_cookiename')])>vOut('user_cookiestrlen'))) {
				$QreadUserCookie=osW_Database::getInstance()->query('SELECT user_id FROM :table_user WHERE user_id=:user_id AND user_cookie=:user_cookie');
				$QreadUserCookie->bindTable(':table_user', 'user');
				$QreadUserCookie->bindInt(':user_id', intval(substr($_COOKIE[vOut('user_cookiename')], vOut('user_cookiestrlen'), strlen($_COOKIE[vOut('user_cookiename')]))));
				$QreadUserCookie->bindValue(':user_cookie', substr($_COOKIE[vOut('user_cookiename')], 0, vOut('user_cookiestrlen')));
				$QreadUserCookie->execute();
				if ($QreadUserCookie->query_handler===false) {
					$this->__initDB();
					$QreadUserCookie->execute();
				}
				if ($QreadUserCookie->numberOfRows()===1) {
					$QreadUserCookie->next();

					return $QreadUserCookie->Value('user_id');
				}
			}

			return 0;
		}

		public function createNewUser($user_email, $user_password) {
			$Quser=osW_Database::getInstance()->query('INSERT INTO :table_user (user_email, user_password, user_language) VALUE (:user_email, :user_password, :user_language)');
			$Quser->bindTable(':table_user', 'user');
			$Quser->bindValue(':user_email', $user_email);
			$Quser->bindCrypt(':user_password', $user_password);
			$Quser->bindValue(':user_language', vOut('frame_current_language'));
			$Quser->execute();
			if ($Quser->query_handler===false) {
				$this->__initDB();
				$Quser->execute();
			}

			return $Quser->nextId();
		}

		public function changeStatus($user_id, $user_status) {
			$Qsetstatus=osW_Database::getInstance()->query('UPDATE :table_user SET user_status=:user_status WHERE user_id=:user_id');
			$Qsetstatus->bindTable(':table_user', 'user');
			$Qsetstatus->bindInt(':user_status', $user_status);
			$Qsetstatus->bindInt(':user_id', $user_id);
			$Qsetstatus->execute();
			if ($Qsetstatus->query_handler===false) {
				$this->__initDB();
				$Qsetstatus->execute();
			}
			if ($Qsetstatus->query_handler==false) {
				return false;
			}

			return true;
		}

		public function changePassword($user_id, $user_password) {
			$Qsetpassword=osW_Database::getInstance()->query('UPDATE :table_user SET user_password=:user_password WHERE user_id=:user_id');
			$Qsetpassword->bindTable(':table_user', 'user');
			$Qsetpassword->bindCrypt(':user_password', $user_password);
			$Qsetpassword->bindInt(':user_id', $user_id);
			$Qsetpassword->execute();
			if ($Qsetpassword->query_handler===false) {
				$this->__initDB();
				$Qsetpassword->execute();
			}
			if ($Qsetpassword->query_handler==false) {
				return false;
			}

			return true;
		}

		public function changeEMail($user_id, $user_email) {
			$Qsetpassword=osW_Database::getInstance()->query('UPDATE :table_user SET user_email=:user_email WHERE user_id=:user_id');
			$Qsetpassword->bindTable(':table_user', 'user');
			$Qsetpassword->bindValue(':user_email', $user_email);
			$Qsetpassword->bindInt(':user_id', $user_id);
			$Qsetpassword->execute();
			if ($Qsetpassword->query_handler===false) {
				$this->__initDB();
				$Qsetpassword->execute();
			}
			if ($Qsetpassword->query_handler==false) {
				return false;
			}

			return true;
		}

		public function setUserCookie() {
			if ($this->getCookieLevel()==3) {
				$this->setNewUserCookie();
			} else {
				$QgetUserCookie=osW_Database::getInstance()->query('SELECT user_cookie FROM :table_user WHERE user_id=:user_id');
				$QgetUserCookie->bindTable(':table_user', 'user');
				$QgetUserCookie->bindInt(':user_id', $this->getID());
				$QgetUserCookie->execute();
				$QgetUserCookie->next();
				if ($QgetUserCookie->query_handler===false) {
					$this->__initDB();
					$QgetUserCookie->execute();
				}
				if (strlen($QgetUserCookie->Value('user_cookie'))!=vOut('user_cookiestrlen')) {
					$this->setNewUserCookie();
				} else {
					$n=$QgetUserCookie->Value('user_cookie');
					osW_Cookie::getInstance()->set(vOut('user_cookiename'), $n.$this->getID(), (time()+((60*60*24)*vOut('user_cookielifetime'))));
				}
			}
		}

		public function setNewUserCookie() {
			$n=md5($this->getID().microtime().uniqid(microtime()));

			$QupdateUserCookie=osW_Database::getInstance()->query('UPDATE :table_user SET user_cookie=:user_cookie WHERE user_id=:user_id');
			$QupdateUserCookie->bindTable(':table_user', 'user');
			$QupdateUserCookie->bindValue(':user_cookie', $n);
			$QupdateUserCookie->bindInt(':user_id', $this->getID());
			$QupdateUserCookie->execute();
			if ($QupdateUserCookie->query_handler===false) {
				$this->__initDB();
				$QupdateUserCookie->execute();
			}

			osW_Cookie::getInstance()->remove(vOut('user_cookiename'));
			osW_Cookie::getInstance()->set(vOut('user_cookiename'), $n.$this->getID(), (time()+((60*60*24)*vOut('user_cookielifetime'))));
		}

		/**
		 *
		 * @return osW_User
		 */
		public static function getInstance($alias='default') {
			return parent::getInstance($alias);
		}

	}
}

?>