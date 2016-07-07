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
        $this->load->helper(array('form', 'url'));

        $this->pub->check_login();

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
        $content[] = array(
            'content_title' => 'strlen 測試',
            'content_url' => 'php_test/strlen',
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

        bcscale(15);

        foreach( $test_i as $k=>$v )
        {
            $part_str = '<table border=1>';
            $part_str .= '<tr><th>type</th><th>a</th><th>b</th><th>bcadd(a,b)</th><th>a+b</th></tr>';
            $part_str .= '<tr><td>(string)</td><td>'.(string)$v['a'].'</td><td>'.(string)$v['b'].' </td><td>'.bcadd((string)$v['a'], (string)$v['b']).'</td><td>'.((string)$v['a']+(string)$v['b']).'</td></tr>';
            $part_str .= '<tr><td>(float)</td><td>'.(float)$v['a'].'</td><td>'.(float)$v['b'].' </td><td>'.bcadd((float)$v['a'], (float)$v['b']).'</td><td>'.((float)$v['a']+(float)$v['b']).'</td></tr>';
            $part_str .= '<tr><td>(int)</td><td>'.(int)$v['a'].'</td><td>'.(int)$v['b'].' </td><td>'.bcadd((int)$v['a'], (int)$v['b']).'</td><td>'.((int)$v['a']+(int)$v['b']).'</td></tr>';
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
        // ci_sessions
        $ci_sessions = $this->session->userdata() ;
        $ci_sessions['CI_VERSION'] = CI_VERSION ;

        // 顯示資料
        $content = array() ;

        $content[] = array(
            'content_title' => 'csrf token',
            'content_value' => $this->_str_replace(print_r($this->_csrf,true))
        ) ;

        $content[] = array(
            'content_title' => 'ci_sessions',
            'content_value' => $this->_str_replace(print_r($ci_sessions,true))
        ) ;

        $_cookies = array() ;
        foreach ($_COOKIE as $key => $value)
        {
            $_cookies[htmlspecialchars($key)] = htmlspecialchars($value) ;
        }
        $content[] = array(
            'content_title' => '$_COOKIE',
            'content_value' => $this->_str_replace(print_r($_cookies,true))
        ) ;

        $content[] = array(
            'content_title' => '$_SESSION',
            'content_value' => $this->_str_replace(print_r($_SESSION,true))
        ) ;

        $_servers = array() ;
        foreach ($_SERVER as $key => $value) {
            $_servers[htmlspecialchars($key)] = htmlspecialchars($value) ;
        }
        $content[] = array(
            'content_title' => '$_SERVER',
            'content_value' => $this->_str_replace(print_r($_servers,true))
        ) ;

        $ip_check = array() ;
        $ip_check['HTTP_CLIENT_IP'] = !empty($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : 'error : empty' ;
        $ip_check['HTTP_X_FORWARDED_FOR'] = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'error : empty' ;
        $ip_check['HTTP_X_CLIENT_IP'] = !empty($_SERVER['HTTP_X_CLIENT_IP']) ? $_SERVER['HTTP_X_CLIENT_IP'] : 'error : empty' ;
        $ip_check['HTTP_X_CLUSTER_CLIENT_IP'] = !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) ? $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] : 'error : empty' ;
        $ip_check['REMOTE_ADDR'] = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'error : empty' ;
        foreach ($ip_check as $key => $value) {
            $ip_check[$key] = htmlspecialchars($value) ;
        }
        $content[] = array(
            'content_title' => '$ip_check',
            'content_value' => $this->_str_replace(print_r($ip_check,true))
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
            'content_value' => htmlspecialchars(base64_encode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'urlencode()',
            'content_value' => htmlspecialchars(urlencode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'rawurlencode()',
            'content_value' => htmlspecialchars(rawurlencode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'utf8_encode()',
            'content_value' => htmlspecialchars(utf8_encode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'utf8_decode()',
            'content_value' => htmlspecialchars(utf8_decode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'ASCII',
            'content_value' => htmlspecialchars($this->pub->str_to_ascii($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'serialize()',
            'content_value' => htmlspecialchars(serialize($test_str)),
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

        //$this->load->helper('text');
        //$content[] = array(
        //  'content_title' => 'entities_to_ascii',
        //  'content_value' => entities_to_ascii($test_str),
        //) ;

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
            'hash_str'=> htmlspecialchars($test_str),
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
            'content_value' => htmlspecialchars(base64_decode($test_str)),
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
            'content_value' => htmlspecialchars(urldecode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'rawurldecode()',
            'content_value' => htmlspecialchars(rawurldecode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'utf8_decode()',
            'content_value' => htmlspecialchars(utf8_decode($test_str)),
        ) ;

        $content[] = array(
            'content_title' => 'utf8_encode()',
            'content_value' => htmlspecialchars(utf8_encode($test_str)),
        ) ;

        $chr_str = is_numeric($test_str) ? chr($test_str) : '' ;
        $chr_str = ($chr_str==' ') ? '&nbsp;' : $chr_str ;
        $content[] = array(
            'content_title' => 'chr()',
            'content_value' => htmlspecialchars($chr_str),
        ) ;

        $chr_arr = array();
        $chr_num = array() ;
        $ex = explode('\u', $test_str);
        foreach ($ex as $value)
        {
            $ex2 = explode('\x', $value);
            if( count($ex2)>1 )
            {
                foreach ($ex2 as $value2)
                {
                    if( $value2!='' )
                    {
                        $chr_arr[] = $value2 ;
                        $chr_num[] = base_convert($value2,16,10) ;
                    }
                }
            }
            else if( $value!='' )
            {
                $chr_arr[] = $value ;
                $chr_num[] = base_convert($value,16,10) ;
            }
        }
        $chr_str = $this->pub->utf8_encode_deep($chr_arr);
        $chr_str = implode(' ',$chr_str) ;
        $content[] = array(
            'content_title' => 'UTF-8',
            'content_value' => htmlspecialchars($chr_str),
        ) ;
        $chr_str = '' ;
        foreach ($chr_num as $value)
        {
            $chr_16 = chr($value) ;
            $chr_16 = ($chr_16==' ') ? '&nbsp;' : $chr_16 ;
            $chr_str .= htmlspecialchars($chr_16).'('.$value.')' ;
        }
        $content[] = array(
            'content_title' => 'chr(16)',
            'content_value' => $chr_str,
        ) ;

        $content[] = array(
            'content_title' => 'intval',
            'content_value' => intval($test_str),
        ) ;

        $floatval_str= floatval(str_replace(',', '', $test_str));
        $content[] = array(
            'content_title' => 'floatval',
            'content_value' => $floatval_str,
        ) ;

        $content[] = array(
            'content_title' => 'strtotime',
            'content_value' => strtotime($test_str),
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
            'hash_str'=>htmlspecialchars($test_str) ,
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
        $preg_array[] = array(
            'fun'    => '全部英數字大小寫符號',
            'remark' => '/^[\x{0021}-\x{007e}]+$/',
            'reg'    => preg_match('/^[\x{0021}-\x{007e}]+$/',$str),
            'remark2'=> '/^[\x{21}-\x{7e}]+$/',
            'reg2'   => preg_match('/^[\x{21}-\x{7e}]+$/',$str),
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
                $td_row['passwords'] = htmlspecialchars($row['hash_key']) ;
                //$td_row['passwords'] = $row['hash_key'] ;
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
        $this->load->model('top_500_pwd_model');
        $toppwds = $this->top_500_pwd_model->get_pwds();
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

    public function strlen()
    {
        //$this->check_session();
        $post = $this->input->post();
        $str = isset($post['str']) ? $post['str'] : '' ;

        // tbody
        // 顯示資料
        $content = [];
        $content[] = [
            'content_title'=>'strlen',
            'content_value'=>strlen($str),
        ];
        $content[] = [
            'content_title'=>'mb_strlen',
            'content_value'=>mb_strlen($str),
        ];
        $content[] = [
            'content_title'=>'substr',
            'content_value'=>substr($str, 0, strlen($str)-1),
        ];
        $content[] = [
            'content_title'=>'mb_substr',
            'content_value'=>mb_substr($str, 0, mb_strlen($str)-1),
        ];
        $grid_view = $this->parser->parse('php_test/strlen_grid_view', array('content'=>$content), true);

        // 標題 內容顯示
        $data = array(
            'title' => 'strlen 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'grid_view' => $grid_view,
            'str'=> $str,
            'csrf_name' => $this->_csrf['csrf_name'],
            'csrf_value' => $this->_csrf['csrf_value'],
        );
        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('php_test/strlen_outer_view', $data, true);

        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $this->parser->parse('index_view', $html_date ) ;
    }
}
?>
