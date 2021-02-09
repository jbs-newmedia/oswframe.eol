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
class osW_Session extends osW_Object {

	/* PROPERTIES */
	private $disabled_modules=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
		if (!is_dir(vOut('settings_abspath').vOut('session_path'))) {
			h()->_mkDir(vOut('settings_abspath').vOut('session_path'));
		}
		h()->_protectDir(vOut('settings_abspath').vOut('session_path'));
		session_save_path(vOut('settings_abspath').vOut('session_path'));

		$cookie_domain='';
		if (strlen(vOut('project_subdomain'))>0) {
			$cookie_domain.=vOut('project_subdomain').'.';
		}
		$cookie_domain.=vOut('project_domain');
		if (vOut('session_use_only_cookies')===true) {
			ini_set('session.use_only_cookies', 1);
		} else {
			ini_set('session.use_only_cookies', 0);
		}
		session_set_cookie_params(vOut('session_cookie_lifetime'), '/', $cookie_domain, vOut('session_secure'), vOut('session_httponly'));
		$this->setSessionName(vOut('session_name'));
		$this->setSessionIp(h()->_getIpAddress());
		$this->setSessionUA(h()->_getUserAgent());
		$this->setSpider();
		$this->setMobile();
		$this->setDisabledModules();
	}

	public function __destruct() {
		osW_Session::getInstance()->addHistory();
		parent::__destruct();
	}

	/* METHODS */
	public function getId() {
		return session_id();
	}

	private function setSessionName($name) {
		session_name($name);
	}

	public function getSessionName() {
		return session_name();
	}

	private function setSessionUA($useragent) {
		$this->useragent=strtolower($useragent);
	}

	public function getSessionUA() {
		return $this->useragent;
	}

	private function setSessionIp($ip) {
		$this->sessionip=$ip;
	}

	public function getSessionIp() {
		return $this->sessionip;
	}

	public function deleteSessions() {
		if ($handle=opendir(vOut('settings_abspath').vOut('session_path'))) {
			while (false!==($file=readdir($handle))) {
				if (($file!='.')&&($file!='..')) {
					$this->deleteSession(vOut('session_path').$file);
				}
			}
			closedir($handle);
		}
	}

	private function deleteSession($session) {
		if (file_exists(vOut('settings_abspath').$session)) {
			if (filemtime(vOut('settings_abspath').$session)<(time()-vOut('session_lifetime'))) {
				h()->_unlink(vOut('settings_abspath').$session);
			}
		}
	}

	public function checkSession() {
		if (vOut('session_gc_probability')===true) {
			$nr=h()->_rand(1, vOut('session_gc_divisor'));
			$h=round(vOut('session_gc_divisor')/2);
			if ($nr==$h) {
				$this->deleteSessions();
			}
		}

		if ($this->startSession()) {
			if ($this->verifySession()===true) {
				return true;
			} else {
				$this->startNewSession();
				if ($this->verifySession()===true) {
					return true;
				} else {
					return false;
				}
			}
		}
	}

	private function setSessionStarted($value) {
		if ($value===true) {
			$this->issessionstarted=true;
		} else {
			$this->issessionstarted=false;
		}
	}

	public function getSessionStarted() {
		if ($this->issessionstarted===true) {
			return true;
		}

		return false;
	}

	private function startSession() {
		if (session_start()) {
			if (!isset($_SESSION['sessionstart'])) {
				session_regenerate_id(true);
			}
			$this->setSessionStarted(true);

			return true;
		}

		return false;
	}

	private function startNewSession() {
		$time=time();
		session_regenerate_id(true);
		$this->setNullSession();
		$this->setNewSession(true);
		$this->set('useragent', $this->getSessionUA());
		$this->set('sessionstart', $time);
		$this->set('sessionip', $this->getSessionIp());
		$this->set('sessionlastcheck', $time);
	}

	private function setNewSession($value) {
		if ($value===true) {
			$this->isnewsession=true;
		} else {
			$this->isnewsession=false;
		}
	}

	public function isNewSession() {
		if ($this->isnewsession===true) {
			return true;
		}

		return false;
	}

	public function getSessionLifetime() {
		return ($this->value('sessionlastcheck')+vOut('session_lifetime'));
	}

	private function verifySession() {
		if ($this->value('sessionlastcheck')<(time()-vOut('session_lifetime'))) {
			return false;
		}
		if ((vOut('session_verifyua')===true)&&($this->value('useragent')!==$this->getSessionUA())) {
			return false;
		}
		if (strlen(vOut('session_verifyip'))>0) {
			if (h()->_verifyIP($this->getSessionIp(), $this->value('sessionip'), vOut('session_verifyip'))!==true) {
				return false;
			}
		}
		$this->set('sessionlastcheck', time());

		return true;
	}

	public function isSpider() {
		if ($this->isspider===true) {
			return true;
		}

		return false;
	}

	private function setSpider() {
		if (strlen($this->getSessionUA())>0) {
			if (file_exists(vOut('settings_abspath').'frame/resources/spiders.txt')) {
				$spiders=file(vOut('settings_abspath').'frame/resources/spiders.txt');
				foreach ($spiders as $spider) {
					if (!is_null($spider)) {
						if (strpos($this->getSessionUA(), trim($spider))!==false) {
							$this->isspider=true;

							return true;
						}
					}
				}
			}
		}

		return true;
	}

	public function isMobile() {
		if ($this->ismobile===true) {
			return true;
		}

		return false;
	}

	private function setMobile() {
		$useragent='';
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$useragent=$_SERVER['HTTP_USER_AGENT'];
		}
		if (preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
			$this->ismobile=true;
		} else {
			$this->ismobile=false;
		}
	}

	public function setNullSession() {
		session_regenerate_id();
		$_SESSION=[];

		return true;
	}

	private function addHistory() {
		if (vOut('frame_canonical_url')!=null) {
			if ($this->exists('history')) {
				$history=$this->value('history');
				foreach ($history as $key=>$value) {
					if ($key>vOut('session_historycount')) {
						if (isset($history[$key+1])) {
							unset($history[$key+1]);
						}
					} else {
						$history[$key+1]=$value;
					}
				}
			} else {
				$history=[];
			}
			$history[0]=['time'=>time(), 'url'=>vOut('frame_canonical_url')];
			$this->set('history', $history);
		}
	}

	public function getHistory($page=0) {
		$history=$this->value('history');
		if (isset($history[$page])) {
			return $history[$page];
		} else {
			return false;
		}
	}

	public function set($variable, $value) {
		if ($this->getSessionStarted()===true) {
			$_SESSION[$variable]=$value;

			return true;
		}

		return false;
	}

	public function value($variable) {
		if ($this->exists($variable)===true) {
			return $_SESSION[$variable];
		}

		return false;
	}

	public function remove($variable) {
		if ($this->exists($variable)===true) {
			unset($_SESSION[$variable]);

			return true;
		}

		return false;
	}

	public function exists($variable) {
		if (($this->getSessionStarted()===true)&&(isset($_SESSION[$variable]))) {
			return true;
		}

		return false;
	}

	public function setUserSession($user_id=0, $user_isadminauthed=0) {
		if ($user_id==0) {
			$user_id=osW_User::getInstance()->getId();
		}

		if ($user_isadminauthed==0) {
			$user_isadminauthed=osW_User::getInstance()->isAdmin();
		}

		$this->set('user_isadminauthed', $user_isadminauthed);
		$this->set('user_id', $user_id);

		return true;
	}

	public function unsetUserSession() {
		$this->set('user_isadminauthed', 0);
		$this->set('user_id', 0);

		return true;
	}

	public function setDisabledModules() {
		if (strlen(vOut('session_disabled_modules'))>0) {
			$list=explode(',', vOut('session_disabled_modules'));
			if (count($list)>0) {
				foreach ($list as $module) {
					$this->setDisabledModule($module);
				}
			}
		}
		if (strlen(vOut('session_disabled_modules_custom'))>0) {
			$list=explode(',', vOut('session_disabled_modules_custom'));
			if (count($list)>0) {
				foreach ($list as $module) {
					$this->setDisabledModule($module);
				}
			}
		}
	}

	public function setDisabledModule($module) {
		if (!isset($this->disabled_modules[$module])) {
			$this->disabled_modules[$module]=true;
		}
	}

	public function isDisabledModule($module) {
		if (isset($this->disabled_modules[$module])) {
			return true;
		}

		return false;
	}

	/**
	 *
	 * @return osW_Session
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>