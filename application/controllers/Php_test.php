<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Php_test extends CI_Controller {

	public $current_title = 'PHP 測試';
	public $page_list = '';
	public $UserAgent = array() ;

	private $_csrf = null ;

	public function getPageList()
	{
		echo json_encode($this->page_list);
	}

	public function __construct()
	{
		parent::__construct();
		ini_set("session.cookie_httponly", 1);
		header("x-frame-options:sammeorigin");
		header('Content-Type: text/html; charset=utf8');

		// for CSRF
		$this->_csrf = array(
			'csrf_name' => $this->security->get_csrf_token_name(),
			'csrf_value' => $this->security->get_csrf_hash(),
		);

		// load parser
		//$this->load->library(array('parser','session', 'pub'));
		$this->load->helper(array('form', 'url'));
		//$this->load->model('php_test_model','',TRUE) ;

		$this->UserAgent = $this->pub->get_UserAgent() ;
		if( isset($this->UserAgent['O']) )
		{
			$this->php_test_model->query_user_agent($this->UserAgent) ;
		}

		// 顯示資料
		$content = array();
		$content[] = array(
			'content_title' => 'PHP浮點 測試',
			'content_url' => 'php_test/float_test',
		) ;
		$content[] = array(
			'content_title' => 'PHP bcadd() 測試',
			'content_url' => 'php_test/bcadd_test',
		) ;
		$content[] = array(
			'content_title' => '時間格式顯示',
			'content_url' => 'php_test/date_test',
		) ;
		$content[] = array(
			'content_title' => 'CI session 測試',
			'content_url' => 'php_test/session_test',
		) ;
		$content[] = array(
			'content_title' => 'count() sizeof() 效能比較',
			'content_url' => 'php_test/count_sizeof'
		) ;
		$content[] = array(
			'content_title' => 'Hash encode 測試',
			'content_url' => 'php_test/hash_test',
		) ;
		$content[] = array(
			'content_title' => 'decode 測試',
			'content_url' => 'php_test/decode_test',
		) ;
		$content[] = array(
			'content_title' => '正規表示式 測試',
			'content_url' => 'php_test/preg_test',
		) ;
		$content[] = array(
			'content_title' => 'php chr() -- ASCII',
			'content_url' => 'php_test/php_chr',
		) ;
		$content[] = array(
			'content_title' => 'if else & switch 效能比較',
			'content_url' => 'php_test/switch_test',
		) ;
		$content[] = array(
			'content_title' => 'pwds Hash list',
			'content_url' => 'php_test/get_top_500_pwd',
		) ;

		$this->page_list = $content ;
	}

	/**
	 * @author Charlie Liu <liuchangli0107@gmail.com>
	 */
	public function index()
	{
		//$this->check_session();

		$content = $this->page_list ;

		// 標題 內容顯示
		$data = array(
			'title' => 'PHP 測試',
			'current_title' => $this->current_title,
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'content' => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('welcome_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function float_test()
	{
		//$this->check_session();

		// 顯示資料
		$content = array();

		// 測試Array
		$test_i = array();
		$test_i[] = array(
			'val' => '5650175242.508133742 + 308437806.831153821478770',
			'count' => 5650175242.508133742 + 308437806.831153821478770,
		);
		$test_i[] = array(
			'val' => '1000000069.321 - 1000000000',
			'count' => 1000000069.321 - 1000000000,
		);
		$test_i[] = array(
			'val' => '100000069.321 - 100000000',
			'count' => 100000069.321 - 100000000,
		);
		$test_i[] = array(
			'val' => '10000069.321 - 10000000',
			'count' => 10000069.321 - 10000000,
		);
		$test_i[] = array(
			'val' => '1000069.321 - 1000000',
			'count' => 1000069.321 - 1000000,
		);
		$test_i[] = array(
			'val' => '100069.321 - 100000',
			'count' => 100069.321 - 100000,
		);

		$part_str = '';
		foreach( $test_i as $k=>$v )
		{
			$part_str .= '<div><b>'.$v['val'].' = </b>'.$v['count'].'</div>' ;

		}
		$content[] = array(
			'content_title' => 'Part 1',
			'content_value' => $part_str,
		) ;

		// 測試Array
		$test_i2 = array();
		$test_i2[] = array(
			'val' => '1048576.321 - 1048576',
			'count' => 1048576.321 - 1048576,
		);
		$test_i2[] = array(
			'val' => '524288.321 - 524288',
			'count' => 524288.321 - 524288,
		);
		$test_i2[] = array(
			'val' => '262144.321 - 262144',
			'count' => 262144.321 - 262144,
		);
		$test_i2[] = array(
			'val' => '131072.321 - 131072',
			'count' => 131072.321 - 131072,
		);
		$test_i2[] = array(
			'val' => '65536.321 - 65536',
			'count' => 65536.321 - 65536,
		);
		$test_i2[] = array(
			'val' => '32768.321 - 32768',
			'count' => 32768.321 - 32768,
		);
		$test_i2[] = array(
			'val' => '16384.321 - 16384',
			'count' => 16384.321 - 16384,
		);
		$test_i2[] = array(
			'val' => '8192.321 - 8192',
			'count' => 8192.321 - 8192,
		);

		$part_str = '';
		foreach( $test_i2 as $k=>$v )
		{
			$part_str .= '<div><b>'.$v['val'].' = </b>'.$v['count'].'</div>' ;
		}
		$content[] = array(
			'content_title' => 'Part 2',
			'content_value' => $part_str,
		) ;

		// 標題 內容顯示
		$data = array(
			'title'      => 'Floating-point',
			'current_title' => $this->current_title,
			'current_page'  => strtolower(__CLASS__), // 當下類別
			'current_fun'=> strtolower(__FUNCTION__), // 當下function
			'content'    => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('php_test/test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function bcadd_test()
	{
		//$this->check_session();

		// 顯示資料
		$content = array();

		// 測試Array
		$test_i = array();
		$test_i[] = array(
			'a' => '5650175242.508133742',
			'b' => '308437806.831153821478770',
		);
		$test_i[] = array(
			'a' => '1000000069.321',
			'b' => '-1000000000.339287563478770',
		);
		$test_i[] = array(
			'a' => '100000069.321',
			'b' => '-100000000.339287563478770',
		);
		$test_i[] = array(
			'a' => '10000069.321',
			'b' => '-10000000.339287563478770',
		);
		$test_i[] = array(
			'a' => '1000069.321',
			'b' => '-1000000.339287563478770',
		);
		$test_i[] = array(
			'a' => '100069.321',
			'b' => '-100000.339287563478770',
		);
		$test_i[] = array(
			'a' => '1048576.321',
			'b' => '-1048576',
		);
		$test_i[] = array(
			'a' => '524288.321',
			'b' => '-524288',
		);
		$test_i[] = array(
			'a' => '262144.321',
			'b' => '-262144',
		);
		$test_i[] = array(
			'a' => '131072.321',
			'b' => '-131072',
		);
		$test_i[] = array(
			'a' => '65536.321',
			'b' => '-65536',
		);
		$test_i[] = array(
			'a' => '32768.321',
			'b' => '-32768',
		);
		$test_i[] = array(
			'a' => '16384.321',
			'b' => '-16384',
		);
		$test_i[] = array(
			'a' => '8192.321',
			'b' => '-8192',
		);
		$test_i[] = array(
			'a' => '1E5',
			'b' => '2E4',
		);
		$test_i[] = array(
			'a' => '" OR 1=1 #',
			'b' => 'alert(1)',
		);

		foreach( $test_i as $k=>$v )
		{
			$part_str = '<table border=1>';
			$part_str .= '<tr><th>type</th><th>a</th><th>b</th><th>bcadd(a,b)</th></tr>';
			$part_str .= '<tr><td>(string)</td><td>'.(string)$v['a'].'</td><td>'.(string)$v['b'].' </td><td>'.bcadd((string)$v['a'], (string)$v['b'], 15).'</td></tr>';
			$part_str .= '<tr><td>(float)</td><td>'.(float)$v['a'].'</td><td>'.(float)$v['b'].' </td><td>'.bcadd((float)$v['a'], (float)$v['b'], 15).'</td></tr>';
			$part_str .= '<tr><td>(int)</td><td>'.(int)$v['a'].'</td><td>'.(int)$v['b'].' </td><td>'.bcadd((int)$v['a'], (int)$v['b'], 15).'</td></tr>';
			$part_str .= '</table><br>';
			$content[] = array(
				'content_title' => 'Part '.($k+1),
				'content_value' => $part_str,
			) ;
		}

		// 標題 內容顯示
		$data = array(
			'title'      => 'bcadd()',
			'current_title' => $this->current_title,
			'current_page'  => strtolower(__CLASS__), // 當下類別
			'current_fun'=> strtolower(__FUNCTION__), // 當下function
			'content'    => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('php_test/test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function date_test()
	{
		//$this->check_session();
		// 時間顯示測試
		$date_test = $this->_date_test() ;

		// 顯示資料
		$content = array();
		/*
		$content[] = array(
			'content_title' => 'Date',
			'content_value' => $this->_str_replace(print_r($date_test,true))
		) ;

		$val_str = '';
		foreach($date_test as $key=>$val )
		{
			$val_str .= $key.' : '.$val.'<br>' ;
		}
		*/

		$val_str = '<table border="1">';
		foreach($date_test as $key=>$val )
		{
			$val_str .= '<tr><td>'.$key.'</td><td>'.$val.'</td></tr>' ;
		}
		$val_str .= '</table>';

		$content[] = array(
			'content_title' => '時間格式',
			'content_value' => $val_str,
		) ;

		// 標題 內容顯示
		$data = array(
			'title' => '時間格式顯示',
			'current_title' => $this->current_title,
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'content' => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('php_test/test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	private function _date_test()
	{
		$this->load->helper('date') ;
		$date_ary = array() ;

		$date_ary['PHP_date'] = date('Y-m-d H:i:s') ;

		$time = time() ;
		$date_ary['PHP_time'] = $time ;

		// eturns the current time as a Unix timestamp
		$date_ary['PHP_now'] = now() ;

		// If a timestamp is not included in the second parameter the current time will be used.
		$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a" ;
		$date_ary['PHP_mdate'] = mdate($datestring, $time);

		// Lets you generate a date string in one of several standardized formats
		//$date_ary['standard_date'] = array() ;
		$format = array() ;
		$format[] = 'DATE_ATOM';
		$format[] = 'DATE_COOKIE';
		$format[] = 'DATE_ISO8601';
		$format[] = 'DATE_RFC822';
		$format[] = 'DATE_RFC850';
		$format[] = 'DATE_RFC1036';
		$format[] = 'DATE_RFC1123';
		$format[] = 'DATE_RFC2822';
		$format[] = 'DATE_RSS';
		$format[] = 'DATE_W3C';
		foreach ($format as $value) {
			//$date_ary['standard_date']['CI_'.$value] = standard_date($value, $time) ;
			$date_ary['CI_'.$value] = standard_date($value, $time) ;
		}

		// Takes a Unix timestamp as input and returns it as GMT
		$date_ary['PHP_local_to_gmt'] = local_to_gmt($time) ;

		// Takes a timezone reference (for a list of valid timezones，see the "Timezone Reference" below) and returns the number of hours offset from UTC.
		$date_ary['PHP_timezones'] = timezones('UM8') ;


		$dt = new DateTime();

		$TPTTZ = new DateTimeZone('Asia/Taipei');
		$dt->setTimezone($TPTTZ);
		$date_ary['Asia/Taipei'] = $dt->format(DATE_RFC822);

		$MNTTZ = new DateTimeZone('America/Denver');
		$dt->setTimezone($MNTTZ);
		$date_ary['America/Denver'] = $dt->format(DATE_RFC822);

		$ESTTZ = new DateTimeZone('America/New_York');
		$dt->setTimezone($ESTTZ);
		$date_ary['America/New_York'] = $dt->format(DATE_RFC822);

		return $date_ary ;
	}

	private function _str_replace($str){
		$order = array("\r\n", "\n", "\r", "￼", "<br />", "<br/>");
		$str = str_replace($order,"<br>",$str);// HTML5 寫法
		return $str;
	}

	public function session_test()
	{
		//$this->check_session();
		/*
		// 增加自訂Session資料
		$newdata = array(
			'username'  => 'johndoe',
			'email'  => 'johndoe@some-site.com',
			'logged_in' => TRUE
		);
		$this->session->set_userdata($newdata);
		*/

		// 取得預設SESSION資料
		$session_id = $this->session->userdata('session_id') ; // CI session ID
		$ip_address = $this->session->userdata('ip_address') ; // 使用者IP位置
		$user_agent = $this->session->userdata('user_agent') ; // 使用者瀏覽器類型
		$last_activity = $this->session->userdata('last_activity') ; // 最後變動時間
		$user_data = $this->session->userdata('user_data') ;// 自訂資料
		$ip_address_1 = $this->session->userdata('HTTP_CLIENT_IP') ;// 自訂資料
		$ip_address_2_1 = $this->session->userdata('HTTP_X_FORWARDED_FOR') ;// 自訂資料
		$ip_address_2_2 = $this->session->userdata('HTTP_X_CLIENT_IP') ;// 自訂資料
		$ip_address_2_3 = $this->session->userdata('HTTP_X_CLUSTER_CLIENT_IP') ;// 自訂資料
		$ip_address_3 = $this->session->userdata('REMOTE_ADDR') ;// 自訂資料
		//$user_data = $this->_str_replace(print_r($user_data,true)) ;
		//$user_data = $this->session->all_userdata() ;
		if( !empty($this->UserAgent['M']) || !empty($this->UserAgent['S']) || !empty($this->UserAgent['A']) || !empty($this->UserAgent['AN']) )
		{
			$UserAgent_str = '('.$this->UserAgent['M'].'/'.$this->UserAgent['S'].')'.$this->UserAgent['A'].' : '.$this->UserAgent['AN'] ;
		}
		else
		{
			$UserAgent_str = '' ;
		}

		// ci_sessions
		$ci_sessions = array(
			'session_id' => $session_id,
			'ip_address' => $ip_address,
			'user_agent' => $user_agent,
			'last_activity' => $last_activity,
			'user_data' => $user_data,
			'UserAgent' => $UserAgent_str,
			'HTTP_CLIENT_IP'=>$ip_address_1,
			'HTTP_X_FORWARDED_FOR'=>$ip_address_2_1,
			'HTTP_X_CLIENT_IP'=>$ip_address_2_2,
			'HTTP_X_CLUSTER_CLIENT_IP'=>$ip_address_2_3,
			'REMOTE_ADDR'=>$ip_address_3,
			'CI_VERSION'=>CI_VERSION,
		);


		// DB測試
		// 刪除1分鐘內沒反應的 SESSION_LOGS
		// $this->session_test_model->delete_old_session() ;

		// 目前SESSION資料
		// 呼叫 session_test_model
		//$SESSION_LOGS = $this->get_session_info($this->session->userdata('session_id'));
		/*
		$SESSION_LOGS = array(
		   'SESSION_ID'  => $session_id ,
		   'IP_ADDRESS'  => $ip_address ,
		   'USER_AGENT'  => $user_agent,
		);

		// 更新DB
		//$count_num = $this->session_test_model->session_test_updata($SESSION_LOGS) ;

		// SESSION_LOGS
		if( $count_num!=false )
		{
			$SESSION_LOGS['count_num'] = $count_num ; // 最新資料筆數
		}
		else
		{
			$SESSION_LOGS['count_num'] = 'false' ;
		}
		*/

		// 顯示資料
		$content = array();
		$content[] = array(
			'content_title' => 'ci_sessions',
			'content_value' => $this->_str_replace(print_r($ci_sessions,true))
		) ;
		/*
		$content[] = array(
			'content_title' => 'SESSION_LOGS',
			'content_value' => $this->_str_replace(print_r($SESSION_LOGS,true))
		) ;
		*/
	   $server_copy = $_SERVER ;
	   $server_copy['ip_check']['HTTP_CLIENT_IP'] = !empty($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : 'error : empty' ;
	   $server_copy['ip_check']['HTTP_X_FORWARDED_FOR'] = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'error : empty' ;
	   $server_copy['ip_check']['HTTP_X_CLIENT_IP'] = !empty($_SERVER['HTTP_X_CLIENT_IP']) ? $_SERVER['HTTP_X_CLIENT_IP'] : 'error : empty' ;
	   $server_copy['ip_check']['HTTP_X_CLUSTER_CLIENT_IP'] = !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) ? $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] : 'error : empty' ;
	   $server_copy['ip_check']['REMOTE_ADDR'] = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'error : empty' ;
		$content[] = array(
			'content_title' => '_SERVER',
			'content_value' => $this->_str_replace(print_r($server_copy,true))
		) ;

		// 標題 內容顯示
		$data = array(
			'title' => 'CI session 測試',
			'current_title' => $this->current_title,
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'content' => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('php_test/test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function count_sizeof()
	{
		//$this->check_session();
		// 顯示資料
		$content = array();

		// Application 效能分析
		$this->output->enable_profiler(TRUE);//啟動效能分析器
		$sections = array(
			'config'  => TRUE,
			'queries' => TRUE
		);
		$this->output->set_profiler_sections($sections);

		// 測試用Array
		$array_size = 50000 ;
		$this->benchmark->mark('code_start');
		$test_array = array();
		for($test_i=0;$test_i<$array_size;$test_i++)
		{
			$test_array[] = $test_i ;
		}
		$this->benchmark->mark('code_end');
		$time_mark = $this->benchmark->elapsed_time('code_start','code_end');
		$content[] = array(
			'content_title' => 'Array('.$array_size.')',
			'content_value' => $time_mark,
		) ;

		// 測試次數
		$try_num = 1000000 ;

		// for 迴圈
		$this->benchmark->mark('code1_start');
		for($test_i=0;$test_i<$try_num;$test_i++)
		{

		}
		$this->benchmark->mark('code1_end');
		$time_mark = $this->benchmark->elapsed_time('code1_start','code1_end');
		$content[] = array(
			'content_title' => 'for() '.$try_num.' times',
			'content_value' => $time_mark,
		) ;

		// count()
		$this->benchmark->mark('code2_start');
		for($test_i=0;$test_i<$try_num;$test_i++)
		{
			$count_num = count($test_array) ;
		}
		$this->benchmark->mark('code2_end');
		$time_mark = $this->benchmark->elapsed_time('code2_start','code2_end');
		$content[] = array(
			'content_title' => 'count()='.$count_num.' '.$try_num.' times',
			'content_value' => $time_mark,
		) ;

		// sizeof()
		$this->benchmark->mark('code3_start');
		for($test_i=0;$test_i<$try_num;$test_i++)
		{
			$sizeof_num = sizeof($test_array) ;
		}
		$this->benchmark->mark('code3_end');
		$time_mark = $this->benchmark->elapsed_time('code3_start','code3_end');
		$content[] = array(
			'content_title' => 'sizeof()='.$sizeof_num.' '.$try_num.' times',
			'content_value' => $time_mark,
		) ;

		$this->output->enable_profiler(FALSE);//關閉效能分析器

		$content[] = array(
			'content_title' => 'Difference between sizeof() and count() in php',
			'content_value' => 'The sizeof() function is an alias for count().',
		) ;

		// 標題 內容顯示
		$data = array(
			'title'      => 'count() and sizeof()',
			'current_title' => $this->current_title,
			'current_page'  => strtolower(__CLASS__), // 當下類別
			'current_fun'=> strtolower(__FUNCTION__), // 當下function
			'content'    => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('php_test/test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function hash_test()
	{
		//$this->check_session();
		$post = $this->input->post();

		$hash_array = array(
			'0' => 'md2',
			'1' => 'md4',
			'2' => 'md5',
			'3' => 'sha1',
			//'4' => 'sha224',
			'5' => 'sha256',
			'6' => 'sha384',
			'7' => 'sha512',
			'8' => 'ripemd128',
			'9' => 'ripemd160',
			'10' => 'ripemd256',
			'11' => 'ripemd320',
			'12' => 'whirlpool',
			'13' => 'tiger128,3',
			'14' => 'tiger160,3',
			'15' => 'tiger192,3',
			'16' => 'tiger128,4',
			'17' => 'tiger160,4',
			'18' => 'tiger192,4',
			'19' => 'snefru',
			//'20' => 'snefru256',
			'21' => 'gost',
			'22' => 'adler32',
			'23' => 'crc32',
			'24' => 'crc32b',
			//'25' => 'salsa10',
			//'26' => 'salsa20',
			'27' => 'haval128,3',
			'28' => 'haval160,3',
			'29' => 'haval192,3',
			'30' => 'haval224,3',
			'31' => 'haval256,3',
			'32' => 'haval128,4',
			'33' => 'haval160,4',
			'34' => 'haval192,4',
			'35' => 'haval224,4',
			'36' => 'haval256,4',
			'37' => 'haval128,5',
			'38' => 'haval160,5',
			'39' => 'haval192,5',
			'40' => 'haval224,5',
			'41' => 'haval256,5',
		);

		$test_str = isset($post['hash_str']) ? $post['hash_str'] : '' ;

		// 顯示資料
		$content = array();

		$content[] = array(
			'content_title' => 'base64_encode()',
			'content_value' => base64_encode($test_str),
		) ;

		$content[] = array(
			'content_title' => 'urlencode()',
			'content_value' => urlencode($test_str),
		) ;

		$content[] = array(
			'content_title' => 'rawurlencode()',
			'content_value' => rawurlencode($test_str),
		) ;

		$content[] = array(
			'content_title' => 'utf8_encode()',
			'content_value' => utf8_encode($test_str),
		) ;

		$content[] = array(
			'content_title' => 'ASCII',
			'content_value' => $this->pub->str_to_ascii($test_str),
		) ;

		$content[] = array(
			'content_title' => 'serialize()',
			'content_value' => serialize($test_str),
		) ;

		foreach( $hash_array as $v )
		{
			$content[] = array(
				'content_title' => $v,
				'content_value' => hash($v,$test_str),
			) ;
			if($v=='md5')
			{
				$content[] = array(
					'content_title' => 'md5()',
					'content_value' => md5($test_str),
				) ;
			}
			else if($v=='sha1')
			{
				$content[] = array(
					'content_title' => 'sha1()',
					'content_value' => sha1($test_str),
				) ;
			}
		}

		if( $test_str!='' )
		{
			$this->php_test_model->query_hash_test($test_str);
		}

		// 標題 內容顯示
		$data = array(
			'title' => 'Hash encode 測試',
			'current_title' => $this->current_title,
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'content' => $content,
			'hash_str'=> $test_str,
		);

		// Template parser class
		// 中間挖掉的部分
		$data = array_merge($data,$this->_csrf);
		$content_div = $this->parser->parse('php_test/hash_test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function decode_test()
	{
		//$this->check_session();
		$post = $this->input->post();

		$test_str = isset($post['hash_str']) ? $post['hash_str'] : '' ;

		// 顯示資料
		$content = array();

		$content[] = array(
			'content_title' => 'base64_decode()',
			'content_value' => base64_decode($test_str),
		) ;

		// 6Ihq6UpmpuYH6MiGR6ZHLAYGBqjG58hniObopg
		/*
		echo '$test_str='.$test_str.'<br>';
		echo 'base64_decode($test_str)='.base64_decode($test_str).'<br>';
		echo 'base64_decode(str_replace(" ","+",$test_str))='.base64_decode(str_replace(" ","+",$test_str)).'<br>';
		echo 'base64_decode(serialize($test_str))='.base64_decode(serialize($test_str)).'<br>';
		*/

		$content[] = array(
			'content_title' => 'urldecode()',
			'content_value' => urldecode($test_str),
		) ;

		$content[] = array(
			'content_title' => 'rawurldecode()',
			'content_value' => rawurldecode($test_str),
		) ;

		$content[] = array(
			'content_title' => 'utf8_decode()',
			'content_value' => utf8_decode($test_str),
		) ;

		$chr_str = is_numeric($test_str) ? chr($test_str) : '' ;
		$chr_str = ($chr_str==' ') ? '&nbsp;' : $chr_str ;
		$content[] = array(
			'content_title' => 'chr()',
			'content_value' => $chr_str,
		) ;

		$chr = base_convert($test_str,16,10) ;
		$chr_str = chr($chr) ;
		$chr_str = ($chr_str==' ') ? '&nbsp;' : $chr_str ;
		$content[] = array(
			'content_title' => 'chr(16)',
			'content_value' => $chr_str.'('.$chr.')',
		) ;
/*
		var_dump(base_convert('\x{00e6}',16,10));
		echo '====================================';
		var_dump(chr(base_convert('\x{00e6}',16,10)));
*/
		// 標題 內容顯示
		$data = array(
			'title' => 'decode 測試',
			'current_title' => $this->current_title,
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'content' => $content,
			'hash_str'=> $test_str,
		);

		// Template parser class
		// 中間挖掉的部分
		$data = array_merge($data,$this->_csrf);
		$content_div = $this->parser->parse('php_test/hash_test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);

		//echo '<script type="text/javascript">alert("'.$test_str.'");</script>';
	}

	public function preg_test()
	{
		//$this->check_session();
		$post = $this->input->post();

		$str = isset($post['str']) ? $post['str'] : '' ;

		// 正規表達式
		$preg_array = array();
		$preg_array[] = array(
			'fun'    => 'URL',
			'remark' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i',
			'reg'    => preg_match('/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i',$str),
			'remark2'=> '/^(http?:\/\/+[\w\-]+\.[\w\-]+)/i',
			'reg2'   => preg_match('/^(http?:\/\/+[\w\-]+\.[\w\-]+)/i',$str),
		);
		$preg_array[] = array(
			'fun'    => '手機號碼',
			'remark' => '/^09[0-9]{8}$/',
			'reg'    => preg_match('/^09[0-9]{8}$/',$str),
			'remark2'=> '',
			'reg2'   => '',
		);
		$preg_array[] = array(
			'fun'    => '身分證字號',
			'remark' => '/^[A-Z]{1}[0-9]{9}$/',
			'reg'    => preg_match('/^[A-Z]{1}[0-9]{9}$/',$str),
			'remark2'=> '',
			'reg2'   => '',
		);
		$preg_array[] = array(
			'fun'    => '正整數 或 空值',
			'remark' => '/^\d*$/',
			'reg'    => preg_match('/^\d*$/',$str),
			'remark2'=> '',
			'reg2'   => '',
		);
		$preg_array[] = array(
			'fun'    => '全部是正整數',
			'remark' => '/^\d+$/',
			'reg'    => preg_match('/^\d+$/',$str),
			'remark2'=> '/^[0-9]+$/',
			'reg2'   => preg_match('/^[0-9]+$/',$str),
		);
		$preg_array[] = array(
			'fun'    => '含數字',
			'remark' => '/\d/',
			'reg'    => preg_match('/\d/',$str),
			'remark2'=> '/[0-9]/',
			'reg2'   => preg_match('/[0-9]/',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部非數字',
			'remark' => '/^\D+$/',
			'reg'    => preg_match('/^\D+$/',$str),
			'remark2'=> '/^[^0-9]+$/',
			'reg2'   => preg_match('/^[^0-9]+$/',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部是英文字母(小寫 | 大寫)',
			'remark' => '/^[a-z]+$/',
			'reg'    => preg_match('/^[a-z]+$/',$str),
			'remark2'=> '/^[A-Z]+$/',
			'reg2'   => preg_match('/^[A-Z]+$/',$str),
		);
		$preg_array[] = array(
			'fun'    => '含英文字母(小寫 | 大寫)',
			'remark' => '/[a-z]/',
			'reg'    => preg_match('/[a-z]/',$str),
			'remark2'=> '/[A-Z]/',
			'reg2'   => preg_match('/[A-Z]/',$str),
		);
		$preg_array[] = array(
			'fun'    => '含數字或英文字母或_',
			'remark' => '/^\w+$/',
			'reg'    => preg_match('/^\w+$/',$str),
			'remark2'=> '/^[A-Za-z0-9_]+$/',
			'reg2'   => preg_match('/^[A-Za-z0-9_]+$/',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部非數字或英文字母或_',
			'remark' => '/^\W+$/',
			'reg'    => preg_match('/^\W+$/',$str),
			'remark2'=> '/^[^A-Za-z0-9_]+$/',
			'reg2'   => preg_match('/^[^A-Za-z0-9_]+$/',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部是空白字元',
			'remark' => '/^\s+$/',
			'reg'    => preg_match('/^\s+$/',$str),
			'remark2'=> '/^[\x{0020}]+$/u',
			'reg2'   => preg_match('/^[\x{0020}]+$/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部非空白字元',
			'remark' => '/^\S+$/',
			'reg'    => preg_match('/^\S+$/',$str),
			'remark2'=> '/^[^\x{0020}]+$/u',
			'reg2'   => preg_match('/^[^\x{0020}]+$/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部中文 | 含中文',
			'remark' => '/^[\x{4e00}-\x{9fa5}]+$/u',
			'reg'    => preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$str),
			'remark2'=> '/^[\x{4e00}-\x{9fa5}]+$/u',
			'reg2'   => preg_match('/[\x{4e00}-\x{9fa5}]/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部文字 | 含文字',
			'remark' => '/^[\x{0080}-\x{FFFF}]+$/u',
			'reg'    => preg_match('/^[\x{0080}-\x{FFFF}]+$/u',$str),
			'remark2'=> '/^[\x{0080}-\x{FFFF}]+$/u',
			'reg2'   => preg_match('/[\x{4e00}-\x{9fa5}]/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部符號 | 含符號',
			'remark' => '/^[\x{0021}-\x{002f}]+$/u',
			'reg'    => preg_match('/^[\x{0021}-\x{002f}]+$/u',$str),
			'remark2'=> '/[\x{0021}-\x{002f}]/u',
			'reg2'   => preg_match('/[\x{0021}-\x{002f}]/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部數字 | 含數字',
			'remark' => '/^[\x{0030}-\x{0039}]+$/u',
			'reg'    => preg_match('/^[\x{0030}-\x{0039}]+$/u',$str),
			'remark2'=> '/[\x{0030}-\x{0039}]/u',
			'reg2'   => preg_match('/[\x{0030}-\x{0039}]/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部符號 | 含符號',
			'remark' => '/^[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]+$/u',
			'reg'    => preg_match('/^[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]+$/u',$str),
			'remark2'=> '/[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]/u',
			'reg2'   => preg_match('/[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部大寫英文 | 含大寫英文',
			'remark' => '/^[\x{0041}-\x{005a}]+$/u',
			'reg'    => preg_match('/^[\x{0041}-\x{005a}]+$/u',$str),
			'remark2'=> '/[\x{0041}-\x{005a}]/u',
			'reg2'   => preg_match('/[\x{0041}-\x{005a}]/u',$str),
		);
		$preg_array[] = array(
			'fun'    => '全部小寫英文 | 含小寫英文',
			'remark' => '/^[\x{0061}-\x{007a}]+$/u',
			'reg'    => preg_match('/^[\x{0061}-\x{007a}]+$/u',$str),
			'remark2'=> '/[\x{0061}-\x{007a}]/u',
			'reg2'   => preg_match('/[\x{0061}-\x{007a}]/u',$str),
		);


		// 顯示資料
		$content = array();

		foreach( $preg_array as $v )
		{
			$content[] = array(
				'content_name'  => $v['fun'],
				'content_title' => $v['remark'],
				'content_value' => $v['reg'],
				'content_title2'=> $v['remark2'],
				'content_value2'=> $v['reg2'],
			) ;
		}

		// tbody
		$grid_view = $this->parser->parse('php_test/preg_test_grid_view', array('content'=>$content), true);

		if( !isset($post['str']) )
		{

			// 標題 內容顯示
			$data = array(
				'title' => '正規表達式 測試',
				'current_title' => $this->current_title,
				'current_page' => strtolower(__CLASS__), // 當下類別
				'current_fun' => strtolower(__FUNCTION__), // 當下function
				'grid_view' => $grid_view,
				'str'=> $str,
			);
			// Template parser class
			// 中間挖掉的部分
			$content_div = $this->parser->parse('php_test/preg_test_outer_view', $data, true);

			// 中間部分塞入外框
			$html_date = $data ;
			$html_date['content_div'] = $content_div ;
			$html_date['js'][] = 'js/php_test/preg_test.js';
			$this->parser->parse('index_view', $html_date ) ;
		}
		else
		{
			echo json_encode(array('grid_view'=>$grid_view)) ;
		}
	}

	public function php_chr()
	{
		// 顯示資料
		$content = array();

		$ascii_arr[] = array('s'=>0,'e'=>32,'t'=>'空白');
		$ascii_arr[] = array('s'=>33,'e'=>47,'t'=>'符號');
		$ascii_arr[] = array('s'=>48,'e'=>57,'t'=>'數字');
		$ascii_arr[] = array('s'=>58,'e'=>64,'t'=>'符號');
		$ascii_arr[] = array('s'=>65,'e'=>90,'t'=>'大寫');
		$ascii_arr[] = array('s'=>91,'e'=>96,'t'=>'符號');
		$ascii_arr[] = array('s'=>97,'e'=>122,'t'=>'小寫');
		$ascii_arr[] = array('s'=>123,'e'=>127,'t'=>'符號');
		$ascii_arr[] = array('s'=>128,'e'=>255,'t'=>'字符');
		// 256 以上重複循環 33=>! 289=>!
		foreach ($ascii_arr as $row) {
			$content_value = '<table><tr><th>$ascii(10)</th><th>$ascii(8)</th><th>$ascii(16)</th><th>chr($ascii)</th></tr>';
			for($i=$row['s'];$i<=$row['e'];$i++)
			{
				/*
					chr() 参数可以是十进制、八进制或十六进制。
					通过前置 0 来规定八进制，
					通过前置 0x 来规定十六进制。
				*/
				$content_value .= '<tr><td>'.$i.'</td><td>'.base_convert($i,10,8).'</td><td>'.base_convert($i,10,16).'</td><td>'.chr($i).'</td></tr>';
			}
			$content_value .= '</table>';
			$content[] = array(
				'content_title'=>$row['t'],
				'content_value'=>$content_value,
			) ;
		}

		$content[] = array(
			'content_title'=>'ASCII 字碼表 1',
			'content_value'=>'https://msdn.microsoft.com/zh-tw/library/60ecse8t(v=vs.80).aspx',
		) ;
		$content[] = array(
			'content_title'=>'ASCII 字碼表 2',
			'content_value'=>'https://msdn.microsoft.com/zh-tw/library/9hxt0028(v=vs.80).aspx',
		) ;

		$content[] = array(
			'content_title'=>'256 以上重複循環 ex: chr(33) chr(289)',
			'content_value'=>'chr(33)='.chr(33).' chr(289)='.chr(289),
		) ;
		$content[] = array(
			'content_title'=>'10進位chr(52) 8進位chr(052) 16進位chr(0x52)',
			'content_value'=>chr(52).' '.chr(052).' '.chr(0x52),
		) ;

		$ord_arr[] = ' ' ;
		$ord_arr[] = '.' ;
		$ord_arr[] = '-' ;
		$ord_arr[] = '_' ;
		foreach ($ord_arr as $value) {
			$ord = ord($value);
			$content[] = array(
				'content_title'=>"ord('".$value."')",
				'content_value'=>$ord.'(10) '.base_convert($ord,10,8).'(8) '.base_convert($ord,10,16).'(16)',
			) ;
		}

		// 標題 內容顯示
		$data = array(
			'title'      => 'php chr()',
			'current_title' => $this->current_title,
			'current_page'  => strtolower(__CLASS__), // 當下類別
			'current_fun'=> strtolower(__FUNCTION__), // 當下function
			'content'    => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('php_test/test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function switch_test()
	{
		//$this->check_session();
		// 顯示資料
		$content = array();

		// Application 效能分析
		$this->output->enable_profiler(TRUE);//啟動效能分析器
		$sections = array(
			'config'  => TRUE,
			'queries' => TRUE
		);
		$this->output->set_profiler_sections($sections);

		// 測試用Array
		$test_array = array();
		$arr_size = 25000;
		for($test_i=0;$test_i<$arr_size;$test_i++)
		{
			$test_array[] = $test_i%10 ;
		}
		$time_if = 0 ;
		$time_sw = 0 ;
		$time_mark_if = 0 ;
		$time_mark_sw = 0 ;
		$test_size = 200;
		for($test_j=0;$test_j<$test_size;$test_j++)
		{
			$time_mark_if += $this->_if_loop_test($test_array) ;
			$time_mark_sw += $this->_switch_loop_test($test_array) ;
		}
		$str = $test_j.'('.$arr_size.') : '.$time_mark_if.' - '.$time_mark_sw.' = '.($time_mark_if-$time_mark_sw) ;
		$content[] = array(
			'content_title' => '第N個迴圈(判斷M個值) : if(時間) - switch(時間) = 時間差',
			'content_value' => $str,
		) ;

		$this->output->enable_profiler(FALSE);//關閉效能分析器

		// 標題 內容顯示
		$data = array(
			'title'      => 'if else and switch',
			'current_title' => $this->current_title,
			'current_page'  => strtolower(__CLASS__), // 當下類別
			'current_fun'=> strtolower(__FUNCTION__), // 當下function
			'content'    => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('php_test/test_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	private function _switch_loop_test($test_array)
	{
		// switch
		$this->benchmark->mark('code3_start');
		foreach($test_array as $v)
		{
			switch($v)
			{
				case 0:
					$this->_get_test_str() ;
					break;
				case 1:
					$this->_get_test_str() ;
					break;
				case 2:
					$this->_get_test_str() ;
					break;
				case 3:
					$this->_get_test_str() ;
					break;
				case 4:
					$this->_get_test_str() ;
					break;
				case 5:
					$this->_get_test_str() ;
					break;
				case 6:
					$this->_get_test_str() ;
					break;
				case 7:
					$this->_get_test_str() ;
					break;
				case 8:
					$this->_get_test_str() ;
					break;
				case 9:
					$this->_get_test_str() ;
					break;
			}
		}
		$this->benchmark->mark('code3_end');
		$time_mark = $this->benchmark->elapsed_time('code3_start','code3_end');
		return $time_mark ;
	}

	private function _if_loop_test($test_array)
	{
		// if else
		$this->benchmark->mark('code2_start');
		foreach($test_array as $v)
		{
			if($v==1)
			{
				$this->_get_test_str() ;
			}
			else if($v==2)
			{
				$this->_get_test_str() ;
			}
			else if($v==3)
			{
				$this->_get_test_str() ;
			}
			else if($v==4)
			{
				$this->_get_test_str() ;
			}
			else if($v==5)
			{
				$this->_get_test_str() ;
			}
			else if($v==6)
			{
				$this->_get_test_str() ;
			}
			else if($v==7)
			{
				$this->_get_test_str() ;
			}
			else if($v==8)
			{
				$this->_get_test_str() ;
			}
			else if($v==9)
			{
				$this->_get_test_str() ;
			}
			else if($v==0)
			{
				$this->_get_test_str() ;
			}
		}
		$this->benchmark->mark('code2_end');
		$time_mark = $this->benchmark->elapsed_time('code2_start','code2_end');
		return $time_mark ;
	}

	private function _get_test_str()
	{
		return FALSE ;
	}
/*
	public function check_session()
	{
		$post = $this->input->post();
		$post = $this->pub->trim_val($post);
		$session_id = !empty($post['session_id']) ? $post['session_id'] : $this->session->userdata('session_id') ;
		$ip_address = !empty($post['ip_address']) ? $post['ip_address'] : $_SERVER['REMOTE_ADDR'] ;
		$user_agent = !empty($post['user_agent']) ? $post['user_agent'] : $_SERVER['HTTP_USER_AGENT'] ;

		// check points
		if( empty($session_id) )
		{
			exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/HTTP_USER_AGENT');// session id
		}
		else if( empty($user_agent) )
		{
			exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/HTTP_USER_AGENT');// browser info
		}
		else if( empty($ip_address) )
		{
			exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/REMOTE_ADDR');// ip address
		}
		else
		{
			$this->load->model('session_test_model','',TRUE);

			// 2分鐘內 session 失效
			$del = $this->session_test_model->del_session_info();
			if( $del['status']!=100 )
			{
				exit('del_session_info :'.$del['status']);
			}
			else
			{
				//echo "LINE : ".__LINE__." del session error<br>";
			}

			// 取得 session 資訊
			$SESSION_LOGS = $this->get_session_info($session_id);
			$total = intval($SESSION_LOGS['total']);
			$data = !empty($SESSION_LOGS['data']) ? $SESSION_LOGS['data'] : '' ;

			if( $total>1 )
			{
				exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/get_session_info :'.$SESSION_LOGS['total']);
			}
			else if( $total<1 )
			{
				if( empty($session_id) )
				{
					exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/$session_id = '.json_encode($session_id));
				}
				// 新增 session
				$data = $this->_add_session_info($session_id,$post);
			}
			else
			{
				if( empty($data) )
				{
					exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/data empty');
				}
				else
				{
					if( empty($data['IP_ADDRESS']) )
					{
						$this->session->sess_destroy();// 銷毀Session
						exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/IP_ADDRESS empty');
					}
					else if( $data['IP_ADDRESS']!=$ip_address )
					{
						$this->session->sess_destroy();// 銷毀Session
						exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/IP_ADDRESS');
					}
					else if( empty($data['USER_AGENT']) )
					{
						$this->session->sess_destroy();// 銷毀Session
						exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/USER_AGENT empty');
					}
					else if( $data['USER_AGENT']!=$user_agent )
					{
						$this->session->sess_destroy();// 銷毀Session
						exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'<br>/USER_AGENT : '.$data['USER_AGENT'].'<br>/POST user_agent : '.$user_agent);
					}
					// 更新 session
					$data = $this->_mod_session_info($session_id);

					if( $data['status']!=100 )
					{
						exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/data = '.json_encode($data));
					}
				}
			}

			if( !empty($post['session_id']) || !empty($post['ip_address']) || !empty($post['user_agent']) )
			{
				echo json_encode($data);
			}
			else if( $data['status']!=100 )
			{
				$data['data'] = __FUNCTION__.'/LINE'.__LINE__.' '.$data['data'] ;
				echo json_encode($data);
			}
			else
			{
				//echo json_encode($data);
			}
		}
	}

	private function _add_session_info($session_id='',$input=array())
	{
		if( empty($session_id) )
		{
			$status = 201;
			$data = __FUNCTION__.'/LINE '.__LINE__.' empty session_id';
		}
		else if( empty($input) || !is_array($input) )
		{
			$status = 202;
			$data = __FUNCTION__.'/LINE '.__LINE__.' empty input';
		}
		else
		{
			$add = $this->session_test_model->add_session_info($session_id,$input);
			if( intval($add['status'])!=100 )
			{
				$status = intval($add['status']);
				$data = $add['data'];
			}
			else
			{
				$SESSION_LOGS = $this->get_session_info($session_id);
				$status = ( intval($SESSION_LOGS['total'])==1 ) ? 100 : 101 ;
				$data = !empty($SESSION_LOGS['data']) ? $SESSION_LOGS['data'] : array() ;
			}
		}

		if( empty($data) )
		{
			$data = __FUNCTION__.'/LINE '.__LINE__.' empty data';
		}

		return array('status'=>$status,'data'=>$data);
	}

	private function _mod_session_info($session_id='')
	{
		if( empty($session_id) )
		{
			$status = 201;
			$data = __FUNCTION__.'/LINE '.__LINE__.' empty session_id';
		}
		else
		{
			$mod = $this->session_test_model->mod_session_info($session_id);
			if( intval($mod['status'])!=100 )
			{
				$status = intval($mod['status']);
				$data = $mod['data'];
			}
			else
			{
				$SESSION_LOGS = $this->get_session_info($session_id);
				$status = ( intval($SESSION_LOGS['total'])==1 ) ? 100 : 101 ;
				$data = !empty($SESSION_LOGS['data']) ? $SESSION_LOGS['data'] : array() ;
			}
		}
		if( empty($data) )
		{
			$data = __FUNCTION__.'/LINE '.__LINE__.' empty data';
		}
		return array('status'=>$status,'data'=>$data);
	}

	public function sess_destroy()
	{
		$this->session->sess_destroy();// 銷毀Session
	}

	public function get_session_info($session_id)
	{
		$this->load->model('session_test_model','',TRUE);
		$info = $this->session_test_model->get_session_info($session_id);
		if( $info['total']<1 )
		{
			$data = array();
		}
		else
		{
			//$data = $this->pub->o2a($info['data'][0]);
			$data = $info['data'][0];
		}
		return array('data'=>$data,'total'=>$info['total']);
	}
*/
	public function get_top_500_pwd()
	{
		$hash_array = array('md5', 'sha1', 'sha256', 'sha512', );

		$post = $this->input->post() ;
		$post = $this->pub->trim_val($post) ;

		$page_max = 100 ;
		$page = isset($post['page'])?intval($post['page']):1 ;
		$total = $this->php_test_model->get_hash_test_num() ;// for WIN8's apache
		$total = isset($total[0]['total']) ? intval($total[0]['total']) : (isset($total['total']) ? intval($total['total']) : intval($total) ) ;

		/* top 500 pwds + top 500 ios pwds + default john = 4138 */
		if( $total<4138 )
		{
			/* add lib */
			$this->_add_top_500_pwds();
		}
		$pagecnt = ceil( $total/$page_max ) ;
		$page = ($page<1) ? 1 : ( ($page>$pagecnt ) ? $pagecnt : $page ) ;

		if( !isset($post['hash_str']) || $post['hash_str']=='' )
		{
			$reports = $this->php_test_model->query_hash_test('',$page,$page_max) ;
			$pwd_data = $reports['data'];
			$total = intval($reports['total']) ;
		}
		else
		{
			$reports = $this->php_test_model->query_hash_test($post['hash_str'],$page,$page_max,false);
			$pwd_data = $reports['data'];
			$total = intval($reports['total']) ;
			/* query hash value */
			if( $total==0 )
			{
				$reports = $this->php_test_model->query_hash_val($post['hash_str']) ;
				$pwd_data = $reports['data'];
				$total = intval($reports['total']) ;
			}
			/* add value */
			if( $total==0 )
			{
				$reports = $this->php_test_model->add_hash_test($post['hash_str']);
				$pwd_data = $reports['data'];
				$total = intval($reports['total']) ;
			}
			//var_dump($reports);
		}

		//echo 'LINE : '.__LINE__.'total='.$total.'<br>' ;
		$pagecnt = ceil( $total/$page_max ) ;

		$page_dropdown = '' ;
		if( $pagecnt>1 )
		{
			$options = array() ;
			if( $pagecnt>10 )
			{
				/*
				$options_25 =  ceil($pagecnt/4) ;
				$options_50 =  ceil($pagecnt/2) ;
				$options_75 =  ceil((3*$pagecnt)/4) ;
				$options[$options_25] = 'page '.$options_25.'(25%)' ;
				$options[$options_75] = 'page '.$options_75.'(50%)' ;
				$options[$options_50] = 'page '.$options_50.'(75%)' ;
				*/
				// first 5 pages
				for( $i=1; $i<=5; $i++ )
				{
					$options[$i] = 'page '.$i ;
				}
				// select page
				$options[$page] = 'page '.$page ;
				// last 5 pages
				for( $i=($pagecnt-4); $i<=$pagecnt; $i++ )
				{
					$options[$i] = 'page '.$i ;
				}
				// order by key
				ksort($options);
			}
			else
			{
				for( $i=1; $i<=$pagecnt; $i++ )
				{
					$options[$i] = 'page '.$i ;
				}
			}
			$page_dropdown = form_dropdown('page', $options, $page);
		}

		// title
		$th = array();
		//$th[] = 'index';
		$th[] = 'passwords';
		foreach ( $hash_array as $hash_type )
		{
			$th[] = $hash_type ;
		}

		// content
		//$pwd_row = ($page-1)*$page_max;
		$td = array();
		foreach ( $pwd_data as $row )
		{
			$td_row = array() ;
			if( $row['hash_key']!='' )
			{
				//$pwd_row++ ;
				//$td_row['index'] = $pwd_row ;
				//$td_row['index'] = $row['hash_id'] ;
				$td_row['passwords'] = $row['hash_key'] ;
				foreach ( $hash_array as $hash_type )
				{
					$td_row[$hash_type.'_var'] = $row[$hash_type.'_var'] ;
				}
				$td[] = $td_row ;
			}
			else
			{
				var_dump($row);
			}
		}

		$table_grid_view = $this->parser->parse('php_test/table_grid_view', array('td'=>$td,'th'=>$th,), true);

		if( !empty($post) )
		{
			$result = array(
				'status'=>'100',
				'pg'=>$page,
				'pageCnt'=>$pagecnt,
				'dropdown'=>$page_dropdown,
				'output'=>$table_grid_view,
				'post'=>$post,
			);
			echo json_encode($result);
		}
		else
		{
			// 標題 內容顯示
			$data = array(
				'title' => 'pwds Hash list',
				'current_title' => $this->current_title,
				'current_page' => strtolower(__CLASS__), // 當下類別
				'current_fun' => strtolower(__FUNCTION__), // 當下function
				'table_grid_view'=>$table_grid_view,
				'page'=>$page,
				'pagecnt'=>$pagecnt,
				'page_dropdown'=>$page_dropdown,
				'base_url'=>base_url(),
				'page_max'=>$page_max,
			);

			// 中間挖掉的部分
			$data = array_merge($data,$this->_csrf);
			$content_div = $this->parser->parse('php_test/table_view', $data, true);
			// 中間部分塞入外框
			$html_date = $data ;
			$html_date['content_div'] = $content_div ;
			$html_date['js'][] = 'js/page_nav.js';
			$html_date['js'][] = 'js/php_test/get_top_500_pwd.js';

			$view = $this->parser->parse('index_view', $html_date, true);
			$this->pub->remove_view_space($view);
		}
	}

	public function get_pwd_excel()
	{
		$post = $this->input->post() ;
		$post = $this->pub->trim_val($post) ;
		$page_max = intval($post['page_max']);
		$page = intval($post['page']) ;
		$hash_str = isset($post['hash_str']) ? $post['hash_str'] : '' ;
		$pwd_data = $this->php_test_model->query_hash_test($hash_str,$page,$page_max) ;
		$header[] = array('index','passwords','md5', 'sha1', 'sha256', 'sha512', );
		$data = array_merge($header,$pwd_data['data']) ;
		$this->load->library('excel');
		$this->excel->Array2xls($data,'get_pwd_excel') ;
	}

	public function toppwds()
	{
		$mun = $this->php_test_model->get_hash_test_num();
		if( !empty($mun) )
		{
			$mun = intval($mun) ;
		}
		else
		{
			print_r($mun);
			exit() ;
		}
		$list = $this->php_test_model->query_hash_test('',1,$mun,false);
		foreach ($list['data'] as $key => $row)
		{
			if(!empty($row['hash_key']))
			{
				echo $row['hash_key'].'<br>' ;
			}
		}
		exit;
	}

	private function _add_top_500_pwds()
	{
		$toppwds = array(
			'123456','pa#sword','12345678','1234','p#ssy','12345','dragon','qwerty','696969','mustang','password','passy',
			'letmein','baseball','master','michael','football','shadow','monkey','abc123','pa#s','f#ckme','pass',
			'6969','jordan','harley','ranger','iwantu','jennifer','hunter','f#ck','2000','test','fuck',
			'batman','trustno1','thomas','tigger','robert','access','love','buster','1234567','soccer',
			'hockey','killer','george','sexy','andrew','charlie','superman','a#shole','f#ckyou','dallas','fuckyou',
			'jessica','panties','pepper','1111','austin','william','daniel','golfer','summer','heather',
			'hammer','yankees','joshua','maggie','biteme','enter','ashley','thunder','cowboy','silver',
			'richard','f#cker','orange','merlin','michelle','corvette','bigdog','cheese','matthew','121212','fucker',
			'patrick','martin','freedom','ginger','bl#wjob','nicole','sparky','yellow','camaro','secret',
			'dick','falcon','taylor','111111','131313','123123','bitch','hello','scooter','please',
			'porsche','guitar','chelsea','black','diamond','nascar','jackson','cameron','654321','computer',
			'amanda','wizard','xxxxxxxx','money','phoenix','mickey','bailey','knight','iceman','tigers',
			'purple','andrea','horny','dakota','aaaaaa','player','sunshine','morgan','starwars','boomer',
			'cowboys','edward','charles','girls','booboo','coffee','xxxxxx','bulldog','ncc1701','rabbit',
			'peanut','john','johnny','gandalf','spanky','winter','brandy','compaq','carlos','tennis',
			'james','mike','brandon','fender','anthony','blowme','ferrari','cookie','chicken','maverick',
			'chicago','joseph','diablo','sexsex','hardcore','666666','willie','welcome','chris','panther',
			'yamaha','justin','banana','driver','marine','angels','fishing','david','maddog','hooters',
			'wilson','butthead','dennis','f#cking','captain','bigdick','chester','smokey','xavier','steven','fucking',
			'viking','snoopy','blue','eagles','winner','samantha','house','miller','flower','jack',
			'firebird','butter','united','turtle','steelers','tiffany','zxcvbn','tomcat','golf','bond007',
			'bear','tiger','doctor','gateway','gators','angel','junior','thx1138','porno','badboy',
			'debbie','spider','melissa','booger','1212','flyers','fish','porn','matrix','teens',
			'scooby','jason','walter','c#mshot','boston','braves','yankee','lover','barney','victor',
			'tucker','princess','mercedes','5150','doggie','zzzzzz','gunner','horney','bubba','2112',
			'fred','johnson','xxxxx','tits','member','boobs','donald','bigdaddy','bronco','penis',
			'voyager','rangers','birdie','trouble','white','topgun','bigtits','bitches','green','super',
			'qazwsx','magic','lakers','rachel','slayer','scott','2222','asdf','video','london',
			'7777','marlboro','srinivas','internet','action','carter','jasper','monster','teresa','jeremy',
			'11111111','bill','crystal','peter','p#ssies','c#ck','beer','rocket','theman','oliver','cock',
			'prince','beach','amateur','7777777','muffin','redsox','star','testing','shannon','murphy',
			'frank','hannah','dave','eagle1','11111','mother','nathan','raiders','steve',
			'forever','angela','viper','ou812','jake','lovers','suckit','gregory','buddy','whatever',
			'young','nicholas','lucky','helpme','jackie','monica','midnight','college','baby','c#nt','cunt',
			'brian','mark','startrek','sierra','leather','232323','4444','beavis','bigc#ck','happy','bigcock',
			'sophie','ladies','naughty','giants','booty','blonde','f#cked','golden','0000','fire','fucked',
			'sandra','pookie','packers','einstein','dolphins','0','chevy','winston','warrior','sammy',
			'slut','8675309','zxcvbnm','nipples','power','victoria','asdfgh','vagina','toyota','travis',
			'hotdog','paris','rock','xxxx','extreme','redskins','erotic','dirty','ford','freddy',
			'arsenal','access14','wolf','nipple','iloveyou','alex','florida','eric','legend','movie',
			'success','rosebud','jaguar','great','cool','cooper','1313','scorpio','mountain','madison',
			'987654','brazil','lauren','japan','naked','squirt','stars','apple','alexis','aaaa',
			'bonnie','peaches','jasmine','kevin','matt','qwertyui','danielle','beaver','4321','4128',
			'runner','swimming','dolphin','gordon','casper','stupid','shit','saturn','gemini','apples',
			'august','3333','canada','blazer','c#mming','hunting','kitty','rainbow','112233','arthur',
			'cream','calvin','shaved','surfer','samson','kelly','paul','mine','king','racing','5555',
			'eagle','hentai','newyork','little','redwings','smith','sticky','cocacola','animal','broncos',
			'private','skippy','marvin','blondes','enjoy','girl','apollo','parker','qwert','time',
			'sydney','women','voodoo','magnum','juice','abgrtyu','777777','dreams','maxwell','music',
			'rush2112','russia','scorpion','rebecca','tester','mistress','phantom','billy','6666','albert',
			'Password1','Destiny1','Pa$$w0rd','Vanessa1','August12','Fuckoff1','Password11',' Kennedy1','Jordan12','Princess15',
			'Princess1','Brianna1','Forever1','Steelers1','z,iyd86I','Freddie1','Password1!',' Jesusis#1','Jordan01','Princess08',
			'P@ssw0rd','Trustno1','iydgTvmujl6f','Slipknot1','l6fkiy9oN','Forever21','November15',' Jehovah1','Jesus143','PoohBear1',
			'Passw0rd','1qazZAQ!','Zachary1','Princess13',' Sweetie1','Death666','Music123','Isabelle1','Jessica7','Peanut11',
			'Michael1','Precious1','Yankees1','Princess12',' November1','Chopper1','Monkeys1','Hawaii50','Internet1','Peanut01',
			'Blink182','Freedom1','Stephen1','Midnight1','Love4ever','Arianna1','Matthew2','Grandma1','Goddess1','Password7',
			'!QAZ2wsx','Christian1',' Shannon1','Marines1','Ireland1','Allison1','Marie123','Godislove1',' Friends2','Password21',
			'Charlie1','Brooklyn1','John3:16','M1chelle','Iloveme2','Yankees2','Madonna1','Giggles1','Falcons7','Passw0rd1',
			'Anthony1','!QAZxsw2','Gerrard8','Lampard8','Christine1',' TrustNo1','Kristen1','Friday13','Derrick1','October22',
			'1qaz!QAZ','Password2','Fuckyou2','Jesus123','Buttons1','Tiger123','Kimberly1','Formula1','December21',' October13',
			'Brandon1','Football1','ZAQ!1qaz','Frankie1','Babyboy1','Summer05','Justin23','England1','Daisy123','November16',
			'Jordan23','ABCabc123','Pebbles1','Elizabeth2',' Angel101','September1',' Justin11','Cutiepie1','Colombia1','Montana1',
			'1qaz@WSX','Samantha1','Monster1','Douglas1','Vincent1','Sebastian1',' Jesus4me','Cricket1','Clayton1','Michael2',
			'Jessica1','Charmed1','Chicken1','Devil666','Spartan117',' Sabrina1','Jeremiah1','Catherine1',' Cheyenne1','Michael07',
			'Jasmine1','Trinity1','zaq1!QAZ','Christina1',' Soccer12','Princess07',' Jennifer2','Brownie1','Brittney1','Makayla1',
			'Michelle1','Chocolate1',' Spencer1','Bradley1','Princess2','Popcorn1','Jazmine1','Boricua1','Blink-182','Madison01',
			'Diamond1','America1','Savannah1','zaq1@WSX','Penguin1','Pokemon1','FuckYou2','Beckham7','August22','Lucky123',
			'Babygirl1','Password01',' Jesusis1','Tigger01','Password5','Omarion1','Colorado1','Awesome1','Asshole1','Longhorns1',
			'Iloveyou2','Natalie1','Jeffrey1','Summer08','Password3','Nursing1','Christmas1',' Annabelle1',' Ashley12','Kathryn1',
			'Matthew1','Superman1','Houston1','Princess21',' Panthers1','Miranda1','Bella123','Anderson1','Arsenal12','Katelyn1',
			'Rangers1','Scooter1','Florida1','Playboy1','Nirvana1','Melanie1','Bailey12','Alabama1','Addison1','Justin21',
			'Pa55word','Mustang1','Crystal1','October1','Nicole12','Maxwell1','August20','1941.Salembbb.41','Abcd1234','Jesus1st',
			'Iverson3','Brittany1','Tristan1','Katrina1','Nichole1','Lindsay1','3edc#EDC','123qweASD','@WSX2wsx','January29',
			'Sunshine1','Angel123','Thunder1','Iloveme1','Molly123','Joshua01','2wsx@WSX','abcABC123','!Qaz2wsx','ILoveYou2',
			'Madison1','Jonathan1','Thumper1','Chris123','Metallica1',' Hollywood1',' 12qw!@QW','Twilight1','zaq1ZAQ!','Hunter01',
			'William1','Friends1','Special1','Chicago1','Mercedes1','Hershey1','#EDC4rfv','Thirteen13',' ZAQ!xsw2','Honey123',
			'Elizabeth1',' Courtney1','Pr1ncess','Charlotte1',' Mackenzie1',' Hello123','Winter06','Taylor13','Whitney1','Holiday1',
			'Password123',' Aaliyah1','Password12',' Broncos1','Kenneth1','Gordon24','Welcome123',' Superstar1',' Welcome2','Harry123',
			'Liverpool1',' Rebecca1','Justice1','BabyGirl1','Jackson5','Gateway1','Unicorn1','Summer99','Vampire1','Falcons1',
			'Cameron1','Timothy1','Cowboys1','Abigail1','Genesis1','Garrett1','Tigger12','Soccer14','Valerie1','December1',
			'Butterfly1',' Scotland1','Charles1','Tinkerbell1',' Diamonds1','David123','Soccer13','Robert01','Titanic1','Dan1elle',
			'Beautiful1',' Raymond1','Blondie1','Rockstar1','Buttercup1',' Daniela1','Senior06','Prototype1',' Tigger123','Dallas22',
			'!QAZ1qaz','Inuyasha1','Softball1','RockYou1','Brandon7','Butterfly7',' Scrappy1','Princess5','Teddybear1',' College1',
			'Patrick1','Tiffany1','Orlando1','Michelle2','Whatever1','Buddy123','Scorpio1','Princess24',' Tbfkiy9oN','Classof08',
			'Welcome1','Pa55w0rd','Greenday1','Georgia1','TheSims2','Brandon2','Santana1','Pr1nc3ss','Sweetpea1','Chelsea123',
			'Iloveyou1','Nicholas1','Dominic1','Computer1','Summer06','Bethany1','Rocky123','Phantom1','Start123','Chargers1',
			'Bubbles1','Melissa1','!QAZzaq1','Breanna1','Starwars1','Austin316','Ricardo1','Patricia1','Soccer17','Cassandra1',
			'Chelsea1','Isabella1','abc123ABC','Babygurl1','Spiderman1',' Atlanta1','Princess123',' Password13',' Smokey01','Carolina1',
			'ZAQ!2wsx','Summer07','Snickers1','Trinity3','Soccer11','Angelina1','Password9','Passion1','Shopping1','Candy123',
			'Blessed1','Rainbow1','Patches1','Pumpkin1','Skittles1','Alexandra1',' Password4','P4ssword','Serenity1','Brayden1',
			'Richard1','Poohbear1','P@$$w0rd','Princess7','Princess01',' Airforce1','P@55w0rd','Nathan06','Senior07','Bigdaddy1',
			'Danielle1','Peaches1','Natasha1','Preston1','Phoenix1','Winston1','Monkey12','Monkey13','Sail2Boat3',' Bentley1',
			'Raiders1','Gabriel1','Myspace1','Newyork1','Pass1234','Veronica1','Michele1','Monkey01','Rusty123','Batista1',
			'Jackson1','Arsenal1','Monique1','Marissa1','Panther1','Vanilla1','Micheal1','Liverpool123','Russell1','Barcelona1',
			'Jesus777','Antonio1','Letmein1','Liberty1','November11',' Trouble1','Michael7','Liverp00l','Redskins1','Australia1',
			'Jennifer1','Victoria1','James123','Lebron23','Lindsey1','Summer01','Michael01','Laura123','Rebelde1','Austin02',
			'Alexander1',' Stephanie1',' Celtic1888',' Jamaica1','Katherine1',' Snowball1','Matthew3','Ladybug1','Princess4','August10',
			'Ronaldo7','Dolphins1','Benjamin1','Fuckyou1','JohnCena1','Rockyou1','Marshall1','Kristin1','Princess23',' August08',
			'Heather1','ABC123abc','Baseball1','Chester1','January1','Qwerty123','Loveyou2','Kendall1','Princess19',' Arsenal123',
			'Dolphin1','Spongebob1',' 1qazXSW@','Braxton1','Gangsta1','Pickles1','Lakers24','Justin01','Princess18',' Anthony11',
			'123456','12345','password','password1','123456789','12345678','1234567890','abc123','computer','tigger','1234',
			'qwerty','money','carmen','mickey','secret','summer','internet','a1b2c3','123','service','','canada','hello','ranger',
			'shadow','baseball','donald','harley','hockey','letmein','maggie','mike','mustang','snoopy','buster','dragon','jordan',
			'michael','michelle','mindy','patrick','123abc','andrew','bear','calvin','changeme','diamond','fuckme','fuckyou',
			'matthew','miller','tiger','trustno1','alex','apple','avalon','brandy','chelsea','coffee','falcon','freedom','gandalf',
			'green','helpme','linda','magic','merlin','newyork','soccer','thomas','wizard','asdfgh','bandit','batman','boris',
			'butthead','dorothy','eeyore','fishing','football','george','happy','iloveyou','jennifer','jonathan','love','marina',
			'master','missy','monday','monkey','natasha','ncc1701','pamela','pepper','piglet','poohbear','pookie','rabbit','rachel',
			'rocket','rose','smile','sparky','spring','steven','success','sunshine','victoria','whatever','zapata','8675309','amanda',
			'andy','angel','august','barney','biteme','boomer','brian','casey','cowboy','delta','doctor','fisher','island','john','joshua',
			'karen','marley','orange','please','rascal','richard','sarah','scooter','shalom','silver','skippy','stanley','taylor','welcome',
			'zephyr','111111','aaaaaa','access','albert','alexander','andrea','anna','anthony','asdfjkl;','ashley','basketball','beavis',
			'black','bob','booboo','bradley','brandon','buddy','caitlin','camaro','charlie','chicken','chris','cindy','cricket','dakota',
			'dallas','daniel','david','debbie','dolphin','elephant','emily','friend','fucker','ginger','goodluck','hammer','heather',
			'iceman','jason','jessica','jesus','joseph','jupiter','justin','kevin','knight','lacrosse','lakers','lizard','madison',
			'mary','mother','muffin','murphy','nirvana','paris','pentium','phoenix','picture','rainbow','sandy','saturn','scott',
			'shannon','shithead','skeeter','sophie','special','stephanie','stephen','steve','sweetie','teacher','tennis','test',
			'test123','tommy','topgun','tristan','wally','william','wilson','1q2w3e','654321','666666','a12345','a1b2c3d4','alpha',
			'amber','angela','angie','archie','asdf','blazer','bond007','booger','charles','christin','claire','control','danny',
			'david1','dennis','digital','disney','edward','elvis','felix','flipper','franklin','frodo','honda','horses','hunter',
			'indigo','james','jasper','jeremy','julian','kelsey','killer','lauren','marie','maryjane','matrix','maverick','mayday',
			'mercury','mitchell','morgan','mountain','niners','nothing','oliver','peace','peanut','pearljam','phantom','popcorn',
			'princess','psycho','pumpkin','purple','randy','rebecca','reddog','robert','rocky','roses','salmon','samson','sharon',
			'sierra','smokey','startrek','steelers','stimpy','sunflower','superman','support','sydney','techno','walter','willie',
			'willow','winner','ziggy','zxcvbnm','alaska','alexis','alice','animal','apples','barbara','benjamin','billy','blue',
			'bluebird','bobby','bonnie','bubba','camera','chocolate','clark','claudia','cocacola','compton','connect','cookie',
			'cruise','douglas','dreamer','dreams','duckie','eagles','eddie','einstein','enter','explorer','faith','family','ferrari',
			'flamingo','flower','foxtrot','francis','freddy','friday','froggy','giants','gizmo','global','goofy','happy1','hendrix',
			'henry','herman','homer','honey','house','houston','iguana','indiana','insane','inside','irish','ironman','jake','jasmin',
			'jeanne','jerry','joey','justice','katherine','kermit','kitty','koala','larry','leslie','logan','lucky','mark','martin',
			'matt','minnie','misty','mitch','mouse','nancy','nascar','nelson','pantera','parker','penguin','peter','piano','pizza',
			'prince','punkin','pyramid','raymond','robin','roger','rosebud','route66','royal','running','sadie','sasha','security',
			'sheena','sheila','skiing','snapple','snowball','sparrow','spencer','spike','star','stealth','student','sunny','sylvia',
			'tamara','taurus','teresa','theresa','thunderbird','tigers','tony','toyota','travel','tuesday','victory','viper1','wesley',
			'whisky','winnie','winter','wolves','xyz123','zorro','123123','1234567','696969','888888','Anthony','Joshua','Matthew','Tigger',
			'aaron','abby','abcdef','adidas','adrian','alfred','arthur','athena','austin','awesome','badger','bamboo','beagle','bears',
			'beatles','beautiful','beaver','benny','bigmac','bingo','bitch','blonde','boogie','boston','brenda','bright','bubba1',
			'bubbles','buffy','button','buttons','cactus','candy','captain','carlos','caroline','carrie','casper','catch22','chance',
			'charity','charlotte','cheese','cheryl','chloe','chris1','clancy','compaq','conrad','cooper','cooter','copper','cosmos',
			'cougar','cracker','crawford','crystal','curtis','cyclone','dance','diablo','dollars','dookie','dumbass','dundee',
			'elizabeth','eric','europe','farmer','firebird','fletcher','fluffy','france','freak1','friends','fuckoff','gabriel',
			'galaxy','gambit','garden','garfield','garnet','genesis','genius','godzilla','golfer','goober','grace','greenday',
			'groovy','grover','guitar','hacker','harry','hazel','hector','herbert','horizon','hornet','howard','icecream','imagine',
			'impala','jack','janice','jasmine','jason1','jeanette','jeffrey','jenifer','jenni','jesus1','jewels','joker','julie','julie1',
			'junior','justin1','kathleen','keith','kelly','kelly1','kennedy','kevin1','knicks','larry1','leonard','lestat','library',
			'lincoln','lionking','london','louise','lucky1','lucy','maddog','margaret','mariposa','marlboro','martin1','marty','master1',
			'mensuck','mercedes','metal','midori','mikey','millie','mirage','molly','monet','money1','monica','monopoly','mookie','moose',
			'moroni','music','naomi','nathan','nguyen','nicholas','nicole','nimrod','october','olive','olivia','online','oscar','oxford',
			'pacific','painter','peaches','penelope','pepsi','petunia','philip','phoenix1','photo','pickle','player','poiuyt','porsche',
			'porter','puppy','python','quality','raquel','raven','remember','robbie','robert1','roman','rugby','runner','russell','ryan',
			'sailing','sailor','samantha','savage','scarlett','school','sean','seven','shadow1','sheba','shelby','shit','shoes','simba',
			'simple','skipper','smiley','snake','snickers','sniper','snoopdog','snowman','sonic','spitfire','sprite','spunky','starwars',
			'station','stella','stingray','storm','stormy','stupid','sunny1','sunrise','surfer','susan','tammy','tango','tanya','teddy1',
			'theboss','theking','thumper','tina','tintin','tomcat','trebor','trevor','tweety','unicorn','valentine','valerie','vanilla',
			'veronica','victor','vincent','viper','warrior','warriors','weasel','wheels','wilbur','winston','wisdom','wombat','xavier',
			'yellow','zeppelin','1111','1212','Andrew','Family','Friends','Michael','Michelle','Snoopy','abcd1234','abcdefg','abigail',
			'account','adam','alex1','alice1','allison','alpine','andre1','andrea1','angel1','anita','annette','antares','apache','apollo',
			'aragorn','arizona','arnold','arsenal','asdfasdf','asdfg','asdfghjk','avenger','baby','babydoll','bailey','banana','barry',
			'basket','batman1','beaner','beast','beatrice','bella','bertha','bigben','bigdog','biggles','bigman','binky','biology',
			'bishop','blondie','bluefish','bobcat','bosco','braves','brazil','bruce','bruno','brutus','buffalo','bulldog','bullet',
			'bullshit','bunny','business','butch','butler','butter','california','carebear','carol','carol1','carole','cassie','castle',
			'catalina','catherine','cccccc','celine','center','champion','chanel','chaos','chelsea1','chester1','chicago','chico',
			'christian','christy','church','cinder','colleen','colorado','columbia','commander','connie','cookies','cooking',
			'corona','cowboys','coyote','craig','creative','cuddles','cuervo','cutie','daddy','daisy','daniel1','danielle','davids',
			'death','denis','derek','design','destiny','diana','diane','dickhead','digger','dodger','donna','dougie','dragonfly',
			'dylan','eagle','eclipse','electric','emerald','etoile','excalibur','express','fender','fiona','fireman','flash','florida',
			'flowers','foster','francesco','francine','francois','frank','french','fuckface','gemini','general','gerald','germany',
			'gilbert','goaway','golden','goldfish','goose','gordon','graham','grant','gregory','gretchen','gunner','hannah','harold',
			'harrison','harvey','hawkeye','heaven','heidi','helen','helena','hithere','hobbit','ibanez','idontknow','integra',
			'ireland','irene','isaac','isabel','jackass','jackie','jackson','jaguar','jamaica','japan','jenny1','jessie','johan',
			'johnny','joker1','jordan23','judith','julia','jumanji','kangaroo','karen1','kathy','keepout','keith1','kenneth','kimberly',
			'kingdom','kitkat','kramer','kristen','laura','laurie','lawrence','lawyer','legend','liberty','light','lindsay','lindsey',
			'lisa','liverpool','lola','lonely','louis','lovely','loveme','lucas','madonna','malcolm','malibu','marathon','marcel',
			'maria1','mariah','mariah1','marilyn','mario','marvin','maurice','maxine','maxwell','me','meggie','melanie','melissa',
			'melody','mexico','michael1','michele','midnight','mike1','miracle','misha','mishka','molly1','monique','montreal',
			'moocow','moore','morris','mouse1','mulder','nautica','nellie','newton','nick','nirvana1','nissan','norman','notebook',
			'ocean','olivier','ollie','oranges','oregon','orion','panda','pandora','panther','passion','patricia','pearl','peewee',
			'pencil','penny','people','percy','person','peter1','petey','picasso','pierre','pinkfloyd','polaris','police','pookie1',
			'poppy','power','predator','preston','q1w2e3','queen','queenie','quentin','ralph','random','rangers','raptor','reality',
			'redrum','remote','reynolds','rhonda','ricardo','ricardo1','ricky','river','roadrunner','robinhood','rocknroll','rocky1',
			'ronald','roxy','ruthie','sabrina','sakura','sally','sampson','samuel','sandra','santa','sapphire','scarlet','scorpio',
			'scott1','scottie','scruffy','seattle','serena','shanti','shark','shogun','simon','singer','skull','skywalker','slacker',
			'smashing','smiles','snowflake','snuffy','soccer1','soleil','sonny','spanky','speedy','spider','spooky','stacey','star69',
			'start','steven1','stinky','strawberry','stuart','sugar','sundance','superfly','suzanne','suzuki','swimmer','swimming',
			'system','taffy','tarzan','teddy','teddybear','terry','theatre','thunder','thursday','tinker','tootsie','tornado','tracy',
			'tricia','trident','trojan','truman','trumpet','tucker','turtle','tyler','utopia','voyager','warcraft','warlock','warren',
			'water','wayne','wendy','williams','willy','winona','woody','woofwoof','wrangler','wright','xfiles','xxxxxx','yankees',
			'yvonne','zebra','zenith','zigzag','zombie','zxc123','zxcvb','000000','007007','11111','11111111','123321','171717',
			'181818','1a2b3c','1chris','4runner','54321','55555','6969','7777777','789456','88888888','Alexis','Bailey','Charlie',
			'Chris','Daniel','Dragon','Elizabeth','HARLEY','Heather','Jennifer','Jessica','Jordan','KILLER','Nicholas','Password',
			'Princess','Purple','Rebecca','Robert','Shadow','Steven','Summer','Sunshine','Superman','Taylor','Thomas','Victoria',
			'abcd123','abcde','accord','active','africa','airborne','alfaro','alicia','aliens','alina','aline','alison','allen','aloha',
			'alpha1','althea','altima','amanda1','amazing','america','amour','anderson','andre','andrew1','andromeda','angels','angie1',
			'annie','anything','apple1','apple2','applepie','april','aquarius','ariane','ariel','arlene','artemis','asdf1234','asdfjkl',
			'ashley1','ashraf','ashton','asterix','attila','autumn','avatar','babes','bambi','barbie','barney1','barrett','bball',
			'beaches','beanie','beans','beauty','becca','belize','belle','belmont','benji','benson','bernardo','berry','betsy','betty',
			'bigboss','bigred','billy1','birdie','birthday','biscuit','bitter','blackjack','blah','blanche','blood','blowjob','blowme',
			'blueeyes','blues','bogart','bombay','boobie','boots','bootsie','boxers','brandi','brent','brewster','bridge','bronco',
			'bronte','brooke','brother','bryan','bubble','buddha','budgie','burton','butterfly','byron','calendar','calvin1','camel',
			'camille','campbell','camping','cancer','canela','cannon','carbon','carnage','carolyn','carrot','cascade','catfish',
			'cathy','catwoman','cecile','celica','change','chantal','charger','cherry','chiara','chiefs','china','chris123',
			'christ1','christmas','christopher','chuck','cindy1','cinema','civic','claude','clueless','cobain','cobra','cody',
			'colette','college','colors','colt45','confused','cool','corvette','cosmo','country','crusader','cunningham','cupcake',
			'cynthia','dagger','dammit','dancer','daphne','darkstar','darren','darryl','darwin','deborah','december','deedee',
			'deeznuts','delano','delete','demon','denise','denny','desert','deskjet','detroit','devil','devine','devon','dexter',
			'dianne','diesel','director','dixie','dodgers','doggy','dollar','dolly','dominique','domino','dontknow','doogie','doudou',
			'downtown','dragon1','driver','dude','dudley','dutchess','dwight','eagle1','easter','eastern','edith','edmund','eight','element',
			'elissa','ellen','elliot','empire','enigma','enterprise','erin','escort','estelle','eugene','evelyn','explore','family1',
			'fatboy','felipe','ferguson','ferret','ferris','fireball','fishes','fishie','flight','florida1','flowerpot','forward',
			'freddie','freebird','freeman','frisco','fritz','froggie','froggies','frogs','fucku','future','gabby','games','garcia',
			'gaston','gateway','george1','georgia','german','germany1','getout','ghost','gibson','giselle','gmoney','goblin',
			'goblue','gollum','grandma','gremlin','grizzly','grumpy','guess','guitar1','gustavo','haggis','haha','hailey',
			'halloween','hamilton','hamlet','hanna','hanson','happy123','happyday','hardcore','harley1','harriet','harris',
			'harvard','health','heart','heather1','heather2','hedgehog','helene','hello1','hello123','hellohello','hermes',
			'heythere','highland','hilda','hillary','history','hitler','hobbes','holiday','holly','honda1','hongkong','hootie',
			'horse','hotrod','hudson','hummer','huskies','idiot','iforget','iloveu','impact','indonesia','irina','isabelle','israel',
			'italia','italy','jackie1','jacob','jakey','james1','jamesbond','jamie','jamjam','jeffrey1','jennie','jenny','jensen','jesse',
			'jesse1','jester','jethro','jimbob','jimmy','joanna','joelle','john316','jordie','jorge','josh','journey','joyce','jubilee',
			'jules','julien','juliet','junebug','juniper','justdoit','karin','karine','karma','katerina','katie','katie1','kayla','keeper',
			'keller','kendall','kenny','ketchup','kings','kissme','kitten','kittycat','kkkkkk','kristi','kristine','labtec','laddie',
			'ladybug','lance','laurel','lawson','leader','leland','lemon','lester','letter','letters','lexus1','libra','lights',
			'lionel','little','lizzy','lolita','lonestar','longhorn','looney','loren','lorna','loser','lovers','loveyou',
			'lucia','lucifer','lucky14','maddie','madmax','magic1','magnum','maiden','maine','management','manson','manuel',
			'marcus','maria','marielle','marine','marino','marshall','martha','maxmax','meatloaf','medical','megan','melina',
			'memphis','mermaid','miami','michel','michigan','mickey1','microsoft','mikael','milano','miles','millenium',
			'million','miranda','miriam','mission','mmmmmm','mobile','monkey1','monroe','montana','monty','moomoo',
			'moonbeam','morpheus','motorola','movies','mozart','munchkin','murray','mustang1','nadia','nadine','napoleon',
			'nation','national','nestle','newlife','newyork1','nichole','nikita','nikki','nintendo','nokia','nomore','normal',
			'norton','noway','nugget','number9','numbers','nurse','nutmeg','ohshit','oicu812','omega','openup','orchid','oreo',
			'orlando','packard','packers','paloma','pancake','panic','parola','parrot','partner','pascal','patches','patriots',
			'paula','pauline','payton','peach','peanuts','pedro1','peggy','perfect','perry','peterpan','philips','phillips',
			'phone','pierce','pigeon','pink','pioneer','piper1','pirate','pisces','playboy','pluto','poetry','pontiac','pookey',
			'popeye','prayer','precious','prelude','premier','puddin','pulsar','pussy','pussy1','qwert','qwerty12','qwertyui',
			'rabbit1','rachelle','racoon','rambo','randy1','ravens','redman','redskins','reggae','reggie','renee','renegade',
			'rescue','revolution','richard1','richards','richmond','riley','ripper','robby','roberts','rock','rocket1','rockie',
			'rockon','roger1','rogers','roland','rommel','rookie','rootbeer','rosie','rufus','rusty','ruthless','sabbath','sabina',
			'safety','saint','samiam','sammie','sammy','samsam','sandi','sanjose','saphire','sarah1','saskia','sassy','saturday',
			'science','scooby','scoobydoo','scooter1','scorpion','scotty','scouts','search','september','server','seven7','sexy',
			'shaggy','shanny','shaolin','shasta','shayne','shelly','sherry','shirley','shorty','shotgun','sidney','simba1','sinatra',
			'sirius','skate','skipper1','skyler','slayer','sleepy','slider','smile1','smitty','smoke','snakes','snapper','snoop',
			'solomon','sophia','space','sparks','spartan','spike1','sponge','spurs','squash','stargate','starlight','stars','steph1',
			'steve1','stevens','stewart','stone','stranger','stretch','strong','studio','stumpy','sucker','suckme','sultan','summit',
			'sunfire','sunset','super','superstar','surfing','susan1','sutton','sweden','sweetpea','sweety','swordfish','tabatha',
			'tacobell','taiwan','tamtam','tanner','target','tasha','tattoo','tequila','terry1','texas','thankyou','theend',
			'thompson','thrasher','tiger2','timber','timothy','tinkerbell','topcat','topher','toshiba','tototo','travis',
			'treasure','trees','tricky','trish','triton','trombone','trouble','trucker','turbo','twins','tyler1','ultimate',
			'unique','united','ursula','vacation','valley','vampire','vanessa','venice','venus','vermont','vicki','vicky','victor1',
			'vincent1','violet','violin','virgil','virginia','vision','volley','voodoo','vortex','waiting','wanker','warner','water1',
			'wayne1','webster','weezer','wendy1','western','white','whitney','whocares','wildcat','william1','wilma','window',
			'winniethepooh','wolfgang','wolverine','wonder','xxxxxxxx','yamaha','yankee','yogibear','yolanda','yomama',
			'yvette','zachary','zebras','zxcvbn','00000000','121212','1234qwer','131313','13579','90210','99999999','ABC123',
			'action','amelie','anaconda','apollo13','artist','asshole','benoit','bernard','bernie','bigbird','blizzard',
			'bluesky','bonjour','caesar','cardinal','carolina','cesar','chandler','chapman','charlie1','chevy','chiquita',
			'chocolat','coco','cougars','courtney','dolphins','dominic','donkey','dusty','eminem','energy','fearless','forest',
			'forever','glenn','guinness','hotdog','indian','jared','jimbo','johnson','jojo','josie','kristin','lloyd','lorraine',
			'lynn','maxime','memory','mimi','mirror','nebraska','nemesis','network','nigel','oatmeal','patton','pedro','planet',
			'players','portland','praise','psalms','qwaszx','raiders','rambo1','rancid','shawn','shelley','softball','speedo',
			'sports','ssssss','steele','steph','stephani','sunday','tiffany','tigre','toronto','trixie','undead','valentin',
			'velvet','viking','walker','watson','young','babygirl','pretty','hottie','teamo','987654321','naruto','spongebob',
			'daniela','princesa','christ','blessed','single','qazwsx','pokemon','iloveyou1','iloveyou2','fuckyou1','hahaha',
			'poop','blessing','blahblah','blink182','123qwe','trinity','passw0rd','google','looking','spirit','iloveyou!',
			'qwerty1','onelove','mylove','222222','ilovegod','football1','loving','emmanuel','1q2w3e4r','red123','blabla',
			'112233','hallo','spiderman','simpsons','monster','november','brooklyn','poopoo','darkness','159753','pineapple',
			'chester','1qaz2wsx','drowssap','monkey12','wordpass','q1w2e3r4','coolness','11235813','something','alexandra',
			'estrella','miguel','iloveme','sayang','princess1','555555','999999','alejandro','brittany','alejandra',
			'tequiero','antonio','987654','00000','fernando','corazon','cristina','kisses','myspace','rebelde','babygurl',
			'alyssa','mahalkita','gabriela','pictures','hellokitty','babygirl1','angelica','mahalko','mariana','eduardo',
			'andres','ronaldo','inuyasha','adriana','celtic','samsung','angelo','456789','sebastian','karina','hotmail',
			'0123456789','barcelona','cameron','slipknot','cutiepie','50cent','bonita','maganda','babyboy','natalie',
			'cuteako','javier','789456123','123654','bowwow','portugal','777777','volleyball','january','cristian','bianca',
			'chrisbrown','101010','sweet','panget','benfica','love123','lollipop','camila','qwertyuiop','harrypotter',
			'ihateyou','christine','lorena','andreea','charmed','rafael','brianna','aaliyah','johncena','lovelove','gangsta',
			'333333','hiphop','mybaby','sergio','metallica','myspace1','babyblue','badboy','fernanda','westlife','sasuke',
			'steaua','roberto','slideshow','asdfghjkl','santiago','jayson','5201314','jerome','gandako','gatita','babyko',
			'246810','sweetheart','chivas','alberto','valeria','nicole1','12345678910','leonardo','jayjay','liliana',
			'sexygirl','232323','amores','anthony1','bitch1','fatima','miamor','lover','lalala','252525','skittles','colombia',
			'159357','manutd','123456a','britney','katrina','christina','pasaway','mahal','tatiana','cantik','0123456',
			'teiubesc','147258369','natalia','francisco','amorcito','paola','angelito','manchester','mommy1','147258',
			'amigos','marlon','linkinpark','147852','diego','444444','iverson','andrei','justine','frankie','pimpin','fashion',
			'bestfriend','england','hermosa','456123','102030','sporting','hearts','potter','iloveu2','number1','212121',
			'truelove','jayden','savannah','hottie1','ganda','scotland','ilovehim','shakira','estrellita','brandon1',
			'sweets','familia','love12','omarion','monkeys','loverboy','elijah','ronnie','mamita','999999999','broken',
			'rodrigo','westside','mauricio','amigas','preciosa','shopping','flores','isabella','martinez','elaine',
			'friendster','cheche','gracie','connor','valentina','darling','santos','joanne','fuckyou2','pebbles','sunshine1',
			'gangster','gloria','darkangel','bettyboop','jessica1','cheyenne','dustin','iubire','a123456','purple1',
			'bestfriends','inlove','batista','karla','chacha','marian','sexyme','pogiako','jordan1','010203','daddy1',
			'daddysgirl','billabong','pinky','erika','skater','nenita','tigger1','gatito','lokita','maldita','buttercup',
			'bambam','glitter','123789','sister','zacefron','tokiohotel','loveya','lovebug','bubblegum','marissa','cecilia',
			'lollypop','nicolas','puppies','ariana','chubby','sexybitch','roxana','mememe','susana','baller','hotstuff','carter',
			'babylove','angelina','playgirl','sweet16','012345','bhebhe','marcos','loveme1','milagros','lilmama','beyonce',
			'lovely1','catdog','armando','margarita','151515','loves','202020','gerard','undertaker','amistad','capricorn',
			'delfin','cheerleader','password2','PASSWORD','lizzie','matthew1','enrique','badgirl','141414','dancing','cuteme',
			'amelia','skyline','angeles','janine','carlitos','justme','legolas','michelle1','cinderella','jesuschrist',
			'ilovejesus','tazmania','tekiero','thebest','princesita','lucky7','jesucristo','buddy1','regina','myself',
			'lipgloss','jazmin','rosita','chichi','pangit','mierda','741852963','hernandez','arturo','silvia','melvin',
			'celeste','pussycat','gorgeous','honeyko','mylife','babyboo','loveu','lupita','panthers','hollywood','alfredo',
			'musica','hawaii','sparkle','kristina','sexymama','crazy','scarface','098765','hayden','micheal','242424',
			'0987654321','marisol','jeremiah','mhine','isaiah','lolipop','butterfly1','xbox360','madalina','anamaria',
			'yourmom','jasmine1','bubbles1','beatriz','diamonds','friendship','sweetness','desiree','741852','hannah1',
			'bananas','julius','leanne','marie1','lover1','twinkle','february','bebita','87654321','twilight','imissyou',
			'pollito','ashlee','cookie1','147852369','beckham','simone','nursing','torres','damian','123123123','joshua1',
			'babyface','dinamo','mommy','juliana','cassandra','redsox','gundam','0000','ou812','dave','golf','molson','Monday',
			'newpass','thx1138','1','Internet','coke','foobar','abc','fish','fred','help','ncc1701d','newuser','none','pat','dog',
			'duck','duke','floyd','guest','joe','kingfish','micro','sam','telecom','test1','7777','absolut','babylon5','backup',
			'bill','bird33','deliver','fire','flip','galileo','gopher','hansolo','jane','jim','mom','passwd','phil','phish',
			'porsche911','rain','red','sergei','training','truck','video','volvo','007','1969','5683','Bond007','Friday',
			'Hendrix','October','Taurus','aaa','alexandr','catalog','challenge','clipper','coltrane','cyrano','dan','dawn',
			'dean','deutsch','dilbert','e-mail','export','ford','fountain','fox','frog','gabriell','garlic','goforit','grateful',
			'hoops','lady','ledzep','lee','mailman','mantra','market','mazda1','metallic','ncc1701e','nesbitt','open','pete',
			'quest','republic','research','supra','tara','testing','xanadu','xxxx','zaphod','zeus','0007','1022','10sne1',
			'1973','1978','2000','2222','3bears','Broadway','Fisher','Jeanne','Killer','Knight','Master','Pepper','Sierra',
			'Tennis','abacab','abcd','ace','acropolis','amy','anders','avenir','basil','bass','beer','ben','bliss','blowfish',
			'boss','bridges','buck','bugsy','bull','cannondale','canon','catnip','chip','civil','content','cook','cordelia',
			'crack1','cyber','daisie','dark1','database','deadhead','denali','depeche','dickens','emmitt','entropy','farout',
			'farside','feedback','fidel','firenze','fish1','fletch','fool','fozzie','fun','gargoyle','gasman','gold','graphic',
			'hell','image','intern','intrepid','jeff','jkl123','joel','johanna1','kidder','kim','king','kirk','kris','lambda',
			'leon','logical','lorrie','major','mariner','mark1','max','media','merlot','midway','mine','mmouse','moon','mopar',
			'mortimer','nermal','nina','olsen','opera','overkill','pacers','packer','picard','polar','polo','primus',
			'prometheus','public','radio','rastafarian','reptile','rob','robotech','rodeo','rolex','rouge','roy','ruby',
			'salasana','scarecrow','scout','scuba1','sergey','skibum','skunk','sound','starter','sting1','sunbird','tbird',
			'teflon','temporal','terminal','the','thejudge','time','toby','today','tokyo','tree','trout','vader','val','valhalla',
			'windsurf','wolf','wolf1','xcountry','yoda','yukon','1213','1214','1225','1313','1818','1975','1977','1991','1kitty',
			'2001','2020','2112','2kids','333','4444','5050','57chevy','7dwarfs','Animals','Ariel','Bismillah','Booboo','Boston',
			'Carol','Computer','Creative','Curtis','Denise','Eagles','Esther','Fishing','Freddy','Gandalf','Golden','Goober',
			'Hacker','Harley','Henry','Hershey','Jackson','Jersey','Joanna','Johnson','Katie','Kitten','Liberty','Lindsay',
			'Lizard','Madeline','Margaret','Maxwell','Money','Monster','Pamela','Peaches','Peter','Phoenix','Piglet','Pookie',
			'Rabbit','Raiders','Random','Russell','Sammy','Saturn','Skeeter','Smokey','Sparky','Speedy','Sterling','Theresa',
			'Thunder','Vincent','Willow','Winnie','Wolverine','aaaa','aardvark','abbott','acura','admin','admin1','adrock',
			'aerobics','agent','airwolf','ali','alien','allegro','allstate','altamira','altima1','andrew!','ann','anne','anneli',
			'aptiva','arrow','asdf;lkj','assmunch','baraka','barnyard','bart','bartman','beasty','beavis1','bebe','belgium',
			'beowulf','beryl','best','bharat','bichon','bigal','biker','bilbo','bills','bimmer','biochem','birdy','blinds',
			'blitz','bluejean','bogey','bogus','boulder','bourbon','boxer','brain','branch','britain','broker','bucks',
			'buffett','bugs','bulls','burns','buzz','c00per','calgary','camay','carl','cat','cement','cessna','chad','chainsaw',
			'chameleon','chang','chess','chinook','chouette','chronos','cicero','circuit','cirque','cirrus','clapton',
			'clarkson','class','claudel','cleo','cliff','clock','color','comet','concept','concorde','coolbean','corky',
			'cornflake','corwin','cows','crescent','cross','crowley','cthulhu','cunt','current','cutlass','daedalus','dagger1',
			'daily','dale','dana','daytek','dead','decker','dharma','dillweed','dipper','disco','dixon','doitnow','doors',
			'dork','doug','dutch','effie','ella','elsie','engage','eric1','ernie1','escort1','excel','faculty','fairview',
			'faust','fenris','finance','first','fishhead','flanders','fleurs','flute','flyboy','flyer','franka','frederic',
			'free','front242','frontier','fugazi','funtime','gaby','gaelic','gambler','gammaphi','garfunkel','garth','gary',
			'gateway2','gator1','gibbons','gigi','gilgamesh','goat','godiva','goethe','gofish','good','gramps','gravis','gray',
			'greed','greg','greg1','greta','gretzky','guido','gumby','h2opolo','hamid','hank','hawkeye1','health1','hello8',
			'help123','helper','homerj','hoosier','hope','huang','hugo','hydrogen','ib6ub9','insight','instructor','integral',
			'iomega','iris','izzy','jazz','jean','jeepster','jetta1','joanie','josee','joy','julia2','jumbo','jump','justice4',
			'kalamazoo','kali','kat','kate','kerala','kids','kiwi','kleenex','kombat','lamer','laser','laserjet','lassie1',
			'leblanc','legal','leo','life','lions','liz','logger','logos','loislane','loki','longer','lori','lost','lotus',
			'lou','macha','macross','madoka','makeitso','mallard','marc','math','mattingly','mechanic','meister','mercer',
			'merde','merrill','michal','michou','mickel','minou','mobydick','modem','mojo','montana3','montrose','motor',
			'mowgli','mulder1','muscle','neil','neutrino','newaccount','nicklaus','nightshade','nightwing','nike','none1',
			'nopass','nouveau','novell','oaxaca','obiwan','obsession','orville','otter','ozzy','packrat','paint','papa',
			'paradigm','pass','pavel','peterk','phialpha','phishy','piano1','pianoman','pianos','pipeline','plato','play',
			'poetic','print','printing','provider','qqq111','quebec','qwer','racer','racerx','radar','rafiki','raleigh',
			'rasta1','redcloud','redfish','redwing','redwood','reed','rene','reznor','rhino','ripple','rita','robocop',
			'robotics','roche','roni','rossignol','rugger','safety1','saigon','satori','saturn5','schnapps','scotch',
			'scuba','secret3','seeker','services','sex','shanghai','shazam','shelter','sigmachi','signal','signature',
			'simsim','skydive','slick','smegma','smiths','smurfy','snow','sober1','sonics','sony','spazz','sphynx','spock',
			'spoon','spot','sprocket','starbuck','steel','stephi','sting','stocks','storage','strat','strato','stud','student2',
			'susanna','swanson','swim','switzer','system5','t-bone','talon','tarheel','tata','tazdevil','tester','testtest',
			'thisisit','thorne','tightend','tim','tom','tool','total','toucan','transfer','transit','transport','trapper',
			'trash','trophy','tucson','turbo2','unity','upsilon','vedder','vette','vikram','virago','visual','volcano','walden',
			'waldo','walleye','webmaster','wedge','whale1','whit','whoville','wibble','will','wombat1','word','world','x-files',
			'xxx123','zack','zepplin','zoltan','zoomer','123go','21122112','5555','911','FuckYou','Fuckyou','Gizmo','Hello',
			'Michel','Qwerty','Windows','angus','aspen','ass','bird','booster','byteme','cats','changeit','christia',
			'christoph','classroom','cloclo','corrado','dasha','fiction','french1','fubar','gator','gilles','gocougs',
			'hilbert','hola','home','judy','koko','lulu','mac','macintosh','mailer','mars','meow','ne1469','niki','paul',
			'politics','pomme','property','ruth','sales','salut','scrooge','skidoo','spain','surf','sylvie','symbol',
			'forum','rotimi','god','saved','2580','1998','xxx','1928','777','info','a','netware','sun','tech','doom','mmm',
			'one','ppp','1911','1948','1996','5252','Champs','Tuesday','bach','crow','don','draft','hal9000','herzog','huey',
			'jethrotull','jussi','mail','miki','nicarao','snowski','1316','1412','1430','1952','1953','1955','1956','1960',
			'1964','1qw23e','22','2200','2252','3010','3112','4788','6262','Alpha','Bastard','Beavis','Cardinal','Celtics',
			'Cougar','Darkman','Figaro','Fortune','Geronimo','Hammer','Homer','Janet','Mellon','Merlot','Metallic','Montreal',
			'Newton','Paladin','Peanuts','Service','Vernon','Waterloo','Webster','aki123','aqua','aylmer','beta','bozo',
			'car','chat','chinacat','cora','courier','dogbert','eieio','elina1','fly','funguy','fuzz','ggeorge','glider1',
			'gone','hawk','heikki','histoire','hugh','if6was9','ingvar','jan','jedi','jimi','juhani','khan','lima','midvale',
			'neko','nesbit','nexus6','nisse','notta1','pam','park','pole','pope','pyro','ram','reliant','rex','rush','seoul',
			'skip','stan','sue','suzy','tab','testi','thelorax','tika','tnt','toto1','tre','wind','x-men','xyz','zxc','369','Abcdef',
			'Asdfgh','Changeme','NCC1701','Zxcvbnm','demo','doom2','e','good-luck','homebrew','m1911a1','nat','ne1410s','ne14a69',
			'zhongguo','sample123','0852','basf','OU812','!@#$%','informix','majordomo','news','temp','trek','!@#$%^','!@#$%^&*',
			'Pentium','Raistlin','adi','bmw','law','m','new','opus','plus','visa','www','y','zzz','1332','1950','3141','3533','4055','4854',
			'6301','Bonzo','ChangeMe','Front242','Gretel','Michel1','Noriko','Sidekick','Sverige','Swoosh','Woodrow','aa','ayelet',
			'barn','betacam','biz','boat','cuda','doc','hal','hallowell','haro','hosehead','i','ilmari','irmeli','j1l2t3','jer','kcin',
			'kerrya','kissa2','leaf','lissabon','mart','matti1','mech','morecats','paagal','performa','prof','ratio','ship','slip',
			'stivers','tapani','targas','test2','test3','tula','unix','user1','xanth','!@#$%^&','1701d','@#$%^&','Qwert','allo',
			'dirk','go','newcourt','nite','notused','sss',
			'1qaz','1qaz2wsx','asdfg','zxcvb',
		);
		foreach ( $toppwds as $key=>$val )
		{
			$this->php_test_model->query_hash_test($val,$key);
		};
	}

	public function get_url($tag='')
	{
		header('content-type: application/javascript') ;
		switch ($tag) {
			case 'get_top_500_pwd':
				echo 'var URLs = "'.base_url().'php_test/get_top_500_pwd";' ;
				break;
		}
	}
}
?>
