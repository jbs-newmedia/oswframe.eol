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
class osW_PageRestrictor extends osW_Object {

	/* PROPERTIES */
	private $forbidden_post_words=[];

	private $validate_user_agents=[];

	private $forbidden_ips=[];

	private $forbidden_user_agents=[];

	private $forbidden_referer=[];

	private $forbidden_ip_ranges=[];

	private $logonly_ip_ranges=[];

	/* METHODS CORE */
	public function __construct() {
		parent::__construct(2, 0);
		// TODO: config
		$this->forbidden_post_words=['viagra', 'cialis', 'phentermine', 'tramadol', 'xanax', 'tramadol'];
	}

	public function __destruct() {
		parent::__destruct();
	}

	/* METHODS */
	private function PRES_outLogMessage($trap_name='unknown', $aditional_info='') {
		$thisHost=gethostbyaddr($current_ip_address);
		error_log('"'.date("d.m.Y H:i:s").'";"'.$current_ip_address.'";"'.$thisHost.'";"'.(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'').'";"'.(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'').'";"'.getenv('REQUEST_URI').'";"'.$_SERVER['HTTP_HOST'].'";"'.$post_data.'";"'.$trap_name.'";"'.$aditional_info.'"'."\n", 3, PRES_LOG_TARGET.'logonly/'.$trap_name.'-'.$_SERVER['HTTP_HOST'].'-log-only-.log');
	}

	private function outputRestrictMessage($checksum='') {
		header("Status: 500 Internal Server Error");
		echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>500 Internal Server Error</title></head><body><h1>Internal Server Error</h1><p>The server encountered an internal error or misconfiguration and was unable to complete your request.</p><p>Please contact the server administrator and inform them of the time the error occurred, and anything you might have done that may have caused the error.</p><p>More information about this error may be available in the server error log at <strong>'.$checksum.'</strong>.</p></body></html>';
		h()->_die();
	}

	public function handle() {
		$this->current_ip_address=isset($_SERVER['HTTP_X_FORWARDED_HOST'])?$_SERVER['HTTP_X_FORWARDED_FOR']:$_SERVER['REMOTE_ADDR'];
		$this->current_ip_long=ip2long($this->current_ip_address);
		$this->host_name=gethostbyaddr($this->current_ip_address);
		$this->user_agent=strtolower(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'');
		$this->http_referer=strtolower(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'');
		$this->http_host=$_SERVER['HTTP_HOST'];
		$this->request_uri=strtolower(getenv('REQUEST_URI'));
		$this->post_data=isset($_POST)?strtolower(serialize($_POST)):'';

		$this->checkForbiddenPostData();
		$this->validateUserAgent();
		$this->checkForbiddenIP();
		$this->checkForbiddenUserAgent();
		$this->checkForbiddenReferer();
		$this->checkForbiddenIPRanges();
		$this->checkLogOnlyIPRanges();
		// TODO: config
		if (strpos($this->request_uri, '=http:')!==false||strpos($this->request_uri, '=https:')!==false||strpos($this->request_uri, '=ftp:')!==false||strpos($this->request_uri, '../')!==false) {
			$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$i);
			$this->logMessage(__CLASS__, 'forbiddencharuri', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum]);
			$this->outputRestrictMessage($checksum);
		}
		// TODO: config
		if (strpos($this->post_data, '"http:')!==false||strpos($this->post_data, '"https:')!==false||strpos($this->post_data, '"ftp:')!==false) {
			$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$i);
			$this->logMessage(__CLASS__, 'criticalpost', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum, 'post_data'=>$this->$post_data]);
			$this->outputRestrictMessage($checksum);
		}
		// TODO: config
		if (strpos($this->request_uri, 'select')!==false||strpos($this->request_uri, 'where')!==false||strpos($this->request_uri, 'insert')!==false) {
			$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$i);
			$this->logMessage(__CLASS__, 'criticaluri', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum]);
			$this->outputRestrictMessage($checksum);
		}
		// TODO: config
		if (strpos($this->http_host, ':80')!==false||strpos($this->http_host, ':443')!==false) {
			$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$i);
			$this->logMessage(__CLASS__, 'proxyaccess', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum]);
			$this->outputRestrictMessage($checksum);
		}
	}

	private function checkForbiddenPostData() {
		for ($i=0; $i<count($this->forbidden_post_words); $i++) {
			if (stristr($this->post_data, $this->forbidden_post_words[$i])===true) {
				$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$i);
				$this->logMessage(__CLASS__, 'forbiddenpostdata', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum, 'forbidden_word'=>$this->forbidden_post_words[$i], 'post_data'=>$this->$post_data]);
				$this->outputRestrictMessage($checksum);
			}
		}
	}

	private function validateUserAgent() {
		// TODO: config
		if (stristr($this->user_agent, 'googlebot')||stristr($this->user_agent, 'mediapartners-google')||stristr($this->user_agent, 'slurp')||stristr($this->user_agent, 'msnbot')||stristr($this->user_agent, '/teoma')||stristr($this->user_agent, 'scooter')||stristr($this->user_agent, 'ia_archiver')||stristr($this->user_agent, 'gonzo')||stristr($this->user_agent, 'speedy spider')||stristr($this->user_agent, 'exabot')||stristr($this->user_agent, 'seekbot')||stristr($this->user_agent, 'yahoofeedseeker')||stristr($this->user_agent, 'becomebot')||stristr($this->user_agent, 'neomo')||stristr($this->user_agent, 'gigabot')) {
			if (osW_Cache::getInstance()->exists(__CLASS__.'/good-ips', $this->current_ip_address)) {
				return true;
			} elseif (osW_Cache::getInstance()->exists(__CLASS__.'/bad-ips', $this->current_ip_address)) {
				$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$this->current_ip_address);
				$this->logMessage(__CLASS__, 'knownfakecrawler', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum]);
				$this->outputRestrictMessage($checksum);
			} else {
				if (!preg_match("/\.googlebot\.com$/", $this->host_name)&&!preg_match("/\.yahoo\.net$/", $this->host_name)&&!preg_match("/\.yahoo\.com$/", $this->host_name)&&!preg_match("/\.inktomisearch\.com$/", $this->host_name)&&!preg_match("/\.live\.com$/", $this->host_name)&&!preg_match("/\.ask\.com$/", $this->host_name)&&!preg_match("/\.alexa\.com$/", $this->host_name)&&!preg_match("/\.archive\.org$/", $this->host_name)&&!preg_match("/\.suchen\.de$/", $this->host_name)&&!preg_match("/\.odn\.de$/", $this->host_name)&&                // Telekom Gonzo ?
					!preg_match("/\.entireweb\.com$/", $this->host_name)&&!preg_match("/\.phx\.gbll$/", $this->host_name)&&!preg_match("/\.phx\.gbl$/", $this->host_name)&&!preg_match("/\.exabot\.com$/", $this->host_name)&&!preg_match("/\.seekbot\.net$/", $this->host_name)&&!preg_match("/\.become\.com$/", $this->host_name)&&!preg_match("/\.gigablast\.com$/", $this->host_name)&&!preg_match("/\.neomo-crawler\.net$/", $this->host_name)&&!preg_match("/\.msn.com\.net$/", $this->host_name)&&!preg_match("/\.facebook\.com$/", $this->host_name)&&!preg_match("/\.cuil\.com$/", $this->host_name)) {
					osW_Cache::getInstance()->write(__CLASS__.'/bad-ips', $this->current_ip_address, '');
					$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$this->current_ip_address);
					$this->logMessage(__CLASS__, 'newfakecrawler', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum]);
					$this->outputRestrictMessage($checksum);
				} else {
					if (gethostbyname($this->host_name)!=$this->current_ip_address) {
						$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$this->current_ip_address);
						$this->logMessage(__CLASS__, 'gethostbyname', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum, 'ipbyhostname'=>gethostbyname($this->host_name)]);
						$this->outputRestrictMessage($checksum);
					}
					osW_Cache::getInstance()->write(__CLASS__.'/good-ips', $this->current_ip_address, '');

					return true;
				}
			}
		}
	}

	private function checkForbiddenIP() {
		// TODO: config
		$this->forbidden_ips=[ip2long('74.86.209.74')=>ip2long('74.86.209.74'), ip2long('208.101.44.3')=>ip2long('208.101.44.3'), -2134570210=>-2134570210, -2122641136=>-2122641136, -2103359371=>-2103359371, -2086536348=>-2086536348, -2083743730=>-2083743730, -2080911305=>-2080911305, -2040502047=>-2040502047, -1973902559=>-1973902559, -1826617824=>-1826617824, -1826583233=>-1826583233, -1826583231=>-1826583231, -1812253957=>-1812253957, -1738773956=>-1738773956, -1505308926=>-1505308926, -1421706139=>-1421706139, -1421706059=>-1421706059, -1065286848=>-1065286848, -1055698233=>-1055698233, -1052999101=>-1052999101, -1045812914=>-1045812914, -1029155581=>-1029155581, -1025456336=>-1025456336, -1014505410=>-1014505410, -1004000434=>-1004000434, -956846517=>-956846517, -940667206=>-940667206, -935231581=>-935231581, -914768683=>-914768683, -908539794=>-908539794, -903401429=>-903401429, -892039677=>-892039677, -882821902=>-882821902, -871502604=>-871502604, -839393632=>-839393632, -835225860=>-835225860, -810417980=>-810417980, -800681167=>-800681167, -792470967=>-792470967, -786413722=>-786413722, -784172456=>-784172456, -780206562=>-780206562, -761956224=>-761956224, -761880526=>-761880526, -761880498=>-761880498, -761880299=>-761880299, -761880281=>-761880281, -758772514=>-758772514, -756083574=>-756083574, -737381586=>-737381586, -733434043=>-733434043, -732331943=>-732331943, -724885726=>-724885726, -723635434=>-723635434, -651721420=>-651721420, -641263740=>-641263740, -639958271=>-639958271, -623144458=>-623144458, -622359811=>-622359811, -618383230=>-618383230, -608959731=>-608959731, -592112809=>-592112809, -591253691=>-591253691, -578049789=>-578049789, -567406289=>-567406289, -562417889=>-562417889, -562215437=>-562215437, 134689216=>134689216, 206347412=>206347412, 307102044=>307102044, 408829559=>408829559, 411177158=>411177158, 412714754=>412714754, 414311987=>414311987, 415694970=>415694970, 644077998=>644077998, 644098406=>644098406, 974553867=>974553867, 974555273=>974555273, 996133797=>996133797, 1032292489=>1032292489, 1032707525=>1032707525, 1035664375=>1035664375, 1043351059=>1043351059, 1063559971=>1063559971, 1067603907=>1067603907, 1071943693=>1071943693, 1075518618=>1075518618, 1076007364=>1076007364, 1078616307=>1078616307, 1079073374=>1079073374, 1079353403=>1079353403, 1084034842=>1084034842, 1087021977=>1087021977, 1114870576=>1114870576, 1115065916=>1115065916, 1115980863=>1115980863, 1117415134=>1117415134, 1121690022=>1121690022, 1123481253=>1123481253, 1124651455=>1124651455, 1125353162=>1125353162, 1129206085=>1129206085, 1130679042=>1130679042, 1134619878=>1134619878, 1135908348=>1135908348, 1143255351=>1143255351, 1159613698=>1159613698, 1163729354=>1163729354, 1175672253=>1175672253, 1179988580=>1179988580, 1179988582=>1179988582, 1179997924=>1179997924, 1180044386=>1180044386, 1180061826=>1180061826, 1180118610=>1180118610, 1183891180=>1183891180, 1192063861=>1192063861, 1210377890=>1210377890, 1223699477=>1223699477, 1250084878=>1250084878, 1255149119=>1255149119, 1280404204=>1280404204, 1347244135=>1347244135, 1351797775=>1351797775, 1353396233=>1353396233, 1358719126=>1358719126, 1378458438=>1378458438, 1382205868=>1382205868, 1384985816=>1384985816, 1385782744=>1385782744, 1388771856=>1388771856, 1395029541=>1395029541, 1395152199=>1395152199, 1424292652=>1424292652, 1424346870=>1424346870, 1424399957=>1424399957, 1427713361=>1427713361, 1427739528=>1427739528, 1435419197=>1435419197, 1466580119=>1466580119, 1466600523=>1466600523, 1468754492=>1468754492, 1474695828=>1474695828, 1475690308=>1475690308, 1475951530=>1475951530, 1488916910=>1488916910, 1488925654=>1488925654, 1500600062=>1500600062, 1502269095=>1502269095, 1534658133=>1534658133, 2112909762=>2112909762];
		if (isset($this->forbidden_ips[$this->current_ip_long])) {
			$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$this->current_ip_address);
			$this->logMessage(__CLASS__, 'forbiddenip', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum]);
			$this->outputRestrictMessage($checksum);
		}
	}

	private function checkForbiddenUserAgent() {
		// TODO: config
		$this->forbidden_user_agents=['18x24.com', '<script', 'nimblecrawler', 'bot@bot.bot', 'twiceler', 'sensis web crawler', 'mozilla/4.0 (compatible; msie 5.0; windows nt 4.0)', 'datacha0s', 'www.jobs.de', 'rpt-httpclient', 'yacy', 'gt::www', 'carpet', 'planty', '++++', 'webcorp', 'gsitecrawler', 'gick', 'sphider', 'contype', 'capture', 'unido-bot', 'adressen', 'fake', 'sbider', 'research-spider', 'javascript', 'shopwiki', 'buildcms', 'interarchy', 'dragonfly', 'heritrix', 'ozelot', 'nicebot', 'webcollage', 'indy library', 'core-project', 'mydoom', 'links sql', 'cfg_spider', 'aipbot', 'anonym', 'backlink-check', 'badass', 'biz360', 'bladder', 'bulk', 'c-spider', 'compatible; ics', 'convera', 'crawler mozilla', 'disco pump', 'ditto', 'dns-digger', 'drip', 'eCatch', 'ecatch', 'eirgrabber', 'emeraldshield', 'extra', 'extract', 'extractorpro', 'eyenetie', 'findlinks', 'flashget', 'fuchsbot', 'gecko/20060508 googlebot 2.1', 'getright', 'gets', 'go!zilla', 'go-ahead-got-it', 'grafula', 'harvest', 'hpprint', 'http/1.0', 'httrack', 'incompatible', 'ineturl', 'interget', 'internet ninja', 'irlbot', 'jayde', 'jetcar', 'jeteye', 'jobo', 'jobspider', 'justview', 'larbin', 'lftp', 'linkwalker', 'lwp-', 'lwp::simple', 'mavicanet', 'midown tool', 'mister pix', 'mj12', 'mozilla/3.0 (compatible)', 'mozilla 2.0', 'msiecrawler', 'mvaclient', 'naver', 'nearsite', 'netforex', 'netresearchserver', 'netspider', 'ng-search', 'nusearch', 'nutch', 'offline explorer', 'omniexplorer_bot', 'onsearch.de', 'pagegrabber', 'papa foto', 'picgrabber', 'picture finder', 'pockey', 'powermarks', 'psbot', 'psycheclone', 'pump', 'pussycat', 'python', 'reget', 'ruby', 'sagool', 'scann', 'scspider', 'scumbot', 'semanticdiscovery', 'sitesucker', 'sleuth', 'sna-', 'snoopy', 'sogou spider', 'spacebison', 'ssm agent', 'superhttp', 'surveybot', 'synoobot', 'syntryx', 'takeout', 'teleport', 'turnitinbot', 'updated', 'voyager', 'webauto', 'webcopier', 'webfetch', 'webimage', 'webreaper', 'websauger', 'webster', 'webstripper', 'websucker', 'webwhacker', 'webzip', 'west wind', 'wget', 'winhttp', 'wwwster'];
		for ($i=0; $i<count($this->forbidden_user_agents); $i++) {
			if (strpos($this->user_agent, $this->forbidden_user_agents[$i])!==false) {
				$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$this->current_ip_address);
				$this->logMessage(__CLASS__, 'forbiddenuseragent', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum, 'forbidden_user_agent'=>$this->forbidden_user_agents[$i]]);
				$this->outputRestrictMessage($checksum);
			}
		}
	}

	private function checkForbiddenReferer() {
		// TODO: config
		$this->forbidden_referer=['<script', '192.168.52.7', 'answerbus.', 'jobs.biz', '.dddddd.com', '.dealx.info', '.findmenow.info', '.gambling', '.globalmedicalguide.com', '.hhhhhh.com', '.metabolism', '.novacspacetravel.com', '.penfind', '.phentamine', '.phentermine', '.pills', '.rape-me.net', '.rapedvirgins.net', '.zoosex.in', 'buy-ambien.de.tf', 'credit-', 'loans', 'mortgage', 'onsearch.de', 'ottosuch.de', 'pharmacy', 'phentermine', 'pickyourshoes.com', 'tamiflu-online.int.tf', 'vicodinonline.is.dreaming.org'];
		for ($i=0; $i<count($this->forbidden_referer); $i++) {
			if (strpos($this->http_referer, $this->forbidden_referer[$i])!==false) {
				$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$this->current_ip_address);
				$this->logMessage(__CLASS__, 'forbiddenReferer', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum, 'forbidden_referer'=>$this->forbidden_referer[$i]]);
				$this->outputRestrictMessage($checksum);
			}
		}
	}

	private function checkForbiddenIPRanges() {
		// TODO: config
		$this->forbidden_ip_ranges=[-2040502272=>-2040502017, -1924387550=>-1924387549, -1845666160=>-1845666153, -1794572261=>-1794572229, -1750269952=>-1750204417, -1511718912=>-1511653377, -1069300224=>-1069299969, -1055338496=>-1055337473, -1055084032=>-1055083777, -1054288896=>-1054287873, -1054153728=>-1054152705, -1046214656=>-1046214401, -1043778560=>-1043777537, -1040271360=>-1040269313, -1038625024=>-1038624769, -1035150592=>-1035150337, -1030998048=>-1030998017, -1030626816=>-1030626561, -1028161536=>-1028161281, -1025571712=>-1025571585, -1022947328=>-1022946305, -1022879232=>-1022878977, -1021577472=>-1021577217, -1021531136=>-1021530625, -1020914688=>-1020914433, -1020852992=>-1020852737, -1019341824=>-1019341313, -1014524464=>-1014524457, -1014476736=>-1014476705, -1014450176=>-1014449921, -1014374400=>-1014373889, -1009913024=>-1009912993, -1008619264=>-1008619009, -1008614400=>-1008613377, -1008604160=>-1008603137, -1008551152=>-1008551137, -1008498720=>-1008498689, -959531776=>-959529985, -917958400=>-917958337, -907935744=>-907935489, -907086896=>-907086881, -901539584=>-901539329, -900003840=>-900001793, -899665024=>-899664897, -896989696=>-896989441, -896867840=>-896867329, -882737152=>-882720769, -881781760=>-881781505, -880623616=>-880607233, -877553664=>-877553153, -876150784=>-876085249, -871669760=>-871667713, -871522304=>-871521281, -862124288=>-862124033, -856260608=>-856254465, -846544896=>-846542849, 841908224=>-841891841, -840267776=>-840266753, -840265728=>-840265217, -840251904=>-840251649, -840251392=>-840251137, -840242688=>-840242177, -827756992=>-827756961, -826540032=>-826539969, -818249728=>-818249473, -817662720=>-817662465, -810470656=>-810470401, -808304640=>-808288257, -807295480=>-807295473, -806715392=>-806682625, -800931840=>-800930817, -798162944=>-798130177, -793247744=>-793116673, -792337920=>-792337409, -790638592=>-790638081, -784172544=>-784172289, -782123008=>-782114817, -780110080=>-780109953, -778526720=>-778518529, -778043392=>-778022913, -777571824=>-777571809, -777248768=>-777240577, -772939200=>-772939169, -768362752=>-768362625, -766347776=>-766347649, -765988864=>-765984769, -763874304=>-763873793, -761880522=>-761880520, -761880458=>-761880457, -760185560=>-760185553, -759181056=>-759180801, -757202944=>-757137409, -756702720=>-756702209, -755196288=>-755196273, -753664000=>-753598465, -753598464=>-753532929, -752385280=>-752385025, -747096576=>-747096321, -746566656=>-746566401, -745545728=>-745537537, -740503296=>-740503041, -739273216=>-739272705, -737381888=>-737381601, -736943360=>-736943297, -736940492=>-736940490, -733431040=>-733430785, -731907072=>-731906561, -730799360=>-730799105, -730798336=>-730798081, -726996992=>-726996737, -724130560=>-724130305, -723320832=>-723317249, -723315712=>-723312129, -723311616=>-723305217, -723304960=>-723303937, -723303424=>-723292929, -723292928=>-723292903, -723292928=>-723292673, -723290624=>-723290369, -723263488=>-723259393, -717285376=>-717284865, -715966592=>-715966561, -712679424=>-712675329, -710157824=>-710157313, -709220352=>-709218305, -708052864=>-708052801, -708051648=>-708051585, -706397184=>-706396929, -705847040=>-705846785, -705708032=>-705705985, -705693392=>-705693377, -704675840=>-704667649, -670584064=>-670583809, -669907712=>-669907457, -669634560=>-669634305, -668975104=>-668966913, -668410367=>-668410113, -667616064=>-667616001, -663642112=>-663633921, -663339008=>-663322625, -663166976=>-663158785, -661585920=>-661577729, -660054016=>-660053761, -659065472=>-659065457, -653052928=>-653052865, -652971776=>-652970753, -652970752=>-652970497, -649592832=>-649591297, -649569792=>-649569281, -647011328=>-647011073, -646739456=>-646737921, -643792896=>-643788801, -643784704=>-643780609, -643780608=>-643776513, -643772416=>-643768321, -642995200=>-642994945, -642991104=>-642990849, -642912512=>-642912385, -642856192=>-642855937, -642777840=>-642777825, -641523712=>-641519617, -641522432=>-641522177, -641384448=>-641380353, -641263744=>-641263713, -640360448=>-640360321, -640360320=>-640360193, -633438208=>-633339905, -632989696=>-632989441, -622299136=>-622299009, -621299328=>-621299201, -615306864=>-615306849, -611437312=>-611437057, -598212608=>-597950465, -596377600=>-596115457, -595591168=>-595574785, -593494016=>-593297409, -592117760=>-592052225, -591421088=>-591421057, -579665920=>-579600385, -564026624=>-564026369, -562294000=>-562293985, 72263296=>72263359, 211076224=>211076351, 211079616=>211079679, 211497984=>211498015, 212795424=>212795439, 415995648=>415995903, 417914112=>417914367, 644074240=>644074495, 644098304=>644098559, 645398528=>654311423, 991336704=>991336767, 1019131904=>1019133951, 1019146304=>1019146335, 1022885888=>1022951423, 1023741952=>1023742975, 1023758336=>1023759359, 1029612800=>1029613055, 1030501888=>1030501951, 1032257536=>1032323071, 1039597568=>1039613951, 1041958912=>1041959167, 1042770432=>1042770687, 1045135360=>1045168127, 1046331392=>1046347775, 1047832576=>1047832831, 1047984128=>1047984383, 1049440256=>1049442303, 1049442304=>1049444351, 1052193280=>1052193535, 1055388417=>1055388670, 1062584832=>1062585087, 1062786048=>1062786559, 1066689504=>1066689535, 1072774400=>1072774527, 1073862400=>1073862655, 1074132224=>1074132287, 1075512320=>1075512575, 1076011008=>1076019199, 1076232192=>1076248575, 1076445184=>1076461567, 1077842976=>1077843007, 1079762944=>1079771135, 1079822080=>1079822335, 1079987232=>1079987263, 1081065472=>1081073663, 1081871872=>1081871999, 1081899744=>1081899775, 1082096640=>1082096895, 1083417936=>1083417951, 1083858336=>1083858351, 1085669376=>1085734911, 1089404928=>1089437695, 1090199040=>1090199551, 1091796992=>1091813375, 1092940032=>1092940287, 1093033984=>1093038079, 1094565888=>1094582271, 1096941568=>1096974335, 1097207008=>1097207015, 1098262784=>1098262815, 1098502144=>1098502655, 1102472192=>1102472447, 1105113184=>1105113215, 1106608128=>1106609151, 1107173376=>1107181567, 1108414336=>1108414399, 1109196800=>1109229567, 1109639168=>1109655551, 1110118400=>1110122495, 1110255152=>1110255167, 1110302720=>1110310911, 1110540288=>1110573055, 1110933504=>1110941695, 1111403504=>1111403519, 1113210880=>1113227263, 1114619904=>1114636287, 1114734592=>1114767359, 1116192768=>1116200959, 1117179744=>1117179759, 1118980608=>1118980863, 1119054704=>1119054719, 1120011776=>1120012031, 1120395264=>1120403455, 1120893152=>1120893167, 1122493696=>1122493951, 1122525184=>1122533375, 1123844096=>1123848191, 1125056512=>1125122047, 1132285368=>1132285375, 1152548864=>1152581631, 1157955584=>1157963775, 1158525185=>1158525320, 1158933568=>1158933583, 1160318464=>1160318591, 1160355840=>1160364031, 1160396800=>1160404991, 1160945664=>1160953855, 1160953856=>1160962047, 1161396224=>1161404415, 1161401856=>1161402111, 1162379264=>1162412031, 1163185952=>1163185983, 1177205376=>1177205503, 1179910144=>1180172287, 1185529344=>1185529855, 1200819872=>1200819879, 1208090624=>1208107007, 1208316672=>1208316799, 1208331520=>1208331775, 1208606720=>1208614911, 1209417728=>1209425919, 1209876480=>1209884671, 1209919904=>1209919935, 1210351616=>1210351871, 1223163904=>1223229439, 1242047840=>1242047847, 1345353984=>1345354239, 1346572544=>1346573055, 1346756608=>1346756863, 1347662952=>1347662959, 1354676480=>1354676735, 1354690560=>1354690815, 1354692096=>1354692351, 1354693888=>1354694143, 1355045600=>1355045607, 1355048192=>1355048447, 1357743104=>1357743231, 1357746176=>1357747199, 1357758080=>1357758207, 1358778368=>1358778879, 1359162112=>1359162367, 1359170048=>1359170175, 1360800000=>1360800255, 1365090304=>1365090431, 1365092416=>1365092431, 1370062884=>1370066943, 1370070272=>1370078463, 1370558464=>1370558975, 1372687488=>1372687551, 1372693504=>1372694527, 1381038080=>1381040127, 1382043904=>1382044159, 1382227457=>1382227583, 1383457280=>1383457791, 1386553344=>1386557439, 1386561536=>1386577919, 1386586112=>1386590207, 1386590208=>1386594303, 1390440960=>1390441471, 1393639896=>1393639903, 1393640320=>1393640327, 1401237504=>1401241599, 1401245696=>1401246719, 1401249792=>1401257983, 1401829376=>1401831423, 1402224640=>1402224895, 1402328064=>1402329087, 1403813888=>1403817983, 1406963712=>1406963967, 1408454656=>1408456703, 1408659456=>1408663551, 1425470752=>1425470783, 1426767872=>1426771967, 1427036160=>1427038207, 1427188224=>1427188479, 1427702016=>1427705855, 1427734784=>1427738879, 1432160000=>1432160255, 1432163072=>1432163327, 1433901056=>1433901311, 1434712992=>1434713007, 1436463360=>1436463615, 1438994176=>1438994431, 1440092160=>1440123903, 1441580544=>1441580799, 1442803712=>1442807807, 1446710512=>1446710519, 1466091200=>1466091215, 1466564608=>1466568703, 1466568704=>1466572799, 1467367424=>1467383807, 1472348160=>1472350207, 1474890752=>1474890815, 1502986240=>1503002623, 1503052284=>1503052287, 2111123456=>2111133183, 2111284049=>2111284063];
		foreach ($this->forbidden_ip_ranges as $forbidden_start=>$forbidden_end) {
			if (($this->current_ip_long>=$forbidden_start)&&($this->current_ip_long<=$forbidden_end)) {
				$checksum=md5(microtime().$this->current_ip_long.$this->user_agent.$this->current_ip_address);
				$this->logMessage(__CLASS__, 'forbiddeniprange', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'checksum'=>$checksum, 'ip-range'=>$forbidden_start.'-'.$forbidden_end]);
				$this->outputRestrictMessage($checksum);
			}
		}
	}

	private function checkLogOnlyIPRanges() {
		// TODO: config
		$this->logonly_ip_ranges=[-2145365540=>-2145365540, -2137784320=>-2137718785, -2134769664=>-2134704129, -2133852160=>-2133786625, -2109014016=>-2108948481, -2086600704=>-2086535169, -2080964608=>-2080899073, -2068250624=>-2068185089, -1963587799=>-1963587799, -1961754112=>-1961753857, -1867055104=>-1866989569, -1738801152=>-1738735617, -1470169088=>-1470103553, -1055030784=>-1055029249, -1049720064=>-1049719809, -1049062224=>-1049062209, -1045812992=>-1045812737, -1040777216=>-1040769025, -1030668288=>-1030660097, -1021887879=>-1021887879, -1013008128=>-1013007873, -1008496240=>-1008496225, -1007431696=>-1007431681, -1004011520=>-1003986945, -953253888=>-953221121, -914328301=>-914328301, -897232896=>-897228801, -876569088=>-876568577, -846856192=>-846848001, -744620032=>-744554497, -735924416=>-735924385, -733434368=>-733430785, -729137152=>-729135361, -727577600=>-727576577, -721200206=>-721200206, -717483008=>-717481985, -716859392=>-716858881, -711823360=>-711819265, -708422464=>-708422433, -705703936=>-705699841, -704892672=>-704892657, -646897664=>-646896897, -645660672=>-645627905, -643801088=>-643796993, -639958272=>-639958017, -627048448=>-625999873, -562241536=>-562237441, 210913776=>210913783, 407363468=>407363468, 412712960=>412745727, 637534208=>644874239, 644874240=>645398527, 701243392=>701247487, 974520320=>974651391, 997195776=>997982207, 1023901696=>1023934463, 1024524288=>1024589823, 1035632640=>1035665407, 1037828096=>1038614527, 1045304836=>1045304836, 1048577792=>1048578047, 1049027751=>1049027751, 1049755648=>1049821183, 1054981096=>1054981103, 1056879232=>1056879329, 1062073024=>1062252943, 1082654720=>1082671103, 1087021056=>1087029247, 1089904640=>1089912831, 1097059328=>1097059583, 1097859072=>1098526463, 1113751552=>1113784319, 1113759837=>1113759837, 1113980928=>1113985023, 1122664448=>1122697215, 1123418112=>1123483647, 1125253120=>1125384191, 1134608384=>1134624767, 1163722752=>1163788287, 1191444480=>1191575551, 1192230912=>1192296447, 1208926208=>1208942591, 1211301888=>1211318271, 1347543040=>1347547135, 1347895296=>1347903487, 1351797760=>1351798271, 1353842688=>1353845759, 1354629120=>1354694655, 1356530432=>1356530687, 1357217792=>1357234175, 1358718976=>1358719231, 1359044608=>1359052799, 1365025536=>1365025791, 1370066944=>1370070271, 1372605104=>1372605119, 1379761361=>1379761361, 1382203392=>1382219775, 1384984576=>1384988671, 1386610688=>1386612480, 1388771840=>1388772095, 1401587800=>1401587807, 1410576384=>1410580479, 1420581085=>1420581085, 1424588864=>1424588927, 1426169890=>1426169890, 1426219008=>1426219263, 1427246592=>1427246639, 1432623104=>1432625151, 1441719120=>1441719135, 1473904640=>1474035710, 1475006736=>1475006739, 1489371136=>1489436671, 1502216192=>1502347263];
		foreach ($this->logonly_ip_ranges as $logonly_start=>$logonly_end) {
			if (($this->current_ip_long>=$logonly_start)&&($this->current_ip_long<=$logonly_end)) {
				$this->logMessage(__CLASS__, 'logonlyiprange', ['time'=>time(), 'ip_adress'=>$this->current_ip_address, 'host_name'=>$this->host_name, 'user_agent'=>$this->user_agent, 'http_referer'=>$this->http_referer, 'http_host'=>$this->http_host, 'request_uri'=>$this->request_uri, 'ip-range'=>$logonly_start.'-'.$logonly_end]);
			}
		}
	}

	/**
	 *
	 * @return osW_PageRestrictor
	 */
	public static function getInstance($alias='default') {
		return parent::getInstance($alias);
	}

}

?>