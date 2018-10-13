<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

use Illuminate\Support\Collection;
use Services\Datetime_tools_services as Dt_tools;

class Datetime_test extends CI_Controller {

    public $current_title = 'PHP DateTime 測試';
    public $page_list = '';
    public $UserAgent = [];

    private $_csrf = null ;

    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    public function __construct()
    {
        parent::__construct();

        // load parser
        $this->load->helper(['datetime_tools']);

        // for CSRF
        $this->_csrf = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_value' => $this->security->get_csrf_hash(),
        );

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        // 顯示資料
        $content = [];
        $content[] = [
            'content_title' => '時間格式 顯示 (Composer)',
            'content_url' => 'datetime_test/date_test',
        ];
        $content[] = [
            'content_title' => '時間格式 測試 (Composer)',
            'content_url' => 'datetime_test/chk_deta',
        ];
        $content[] = [
            'content_title' => 'conv time zone',
            'content_url' => 'datetime_test/conv_date',
        ];
        $content[] = [
            'content_title' => 'conv time format',
            'content_url' => 'datetime_test/conv_format',
        ];
        $content[] = [
            'content_title' => '時間格式 顯示 (CI my helper)',
            'content_url' => 'datetime_test/ci_helper_date',
        ] ;

        $this->page_list = $content ;
    }

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function index()
    {
        $content = $this->page_list ;

        // 標題 內容顯示
        $data = array(
            'title'                     => 'PHP DateTime 測試',
            'current_title'      => $this->current_title,
            'current_page'    => strtolower(__CLASS__),         // 當下類別
            'current_fun'       => strtolower(__FUNCTION__),// 當下function
            'content'              => $content,
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('welcome_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function date_test()
    {
        $dt_tools = new Dt_tools;
        // 時間顯示測試
        $date_test = $dt_tools->get_show_date() ;

        // 顯示資料
        $content = [];

        $val_str = '<table border="1">';
        foreach($date_test as $key=>$val ) $val_str .= '<tr><td>'.$key.'</td><td>'.$val.'</td></tr>';
        $val_str .= '</table>';

        $content[] = [
            'content_title' => '時間格式',
            'content_value' => $val_str,
        ];

        // 標題 內容顯示
        $data = [
            'title'                   => '時間格式 顯示',
            'current_title'    => $this->current_title,
            'current_page'  => strtolower(__CLASS__),           // 當下類別
            'current_fun'     => strtolower(__FUNCTION__),  // 當下function
            'content'            => $content,
        ];

        // 中間挖掉的部分
        $content_div = $this->parser->parse('php_test/test_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function chk_deta()
    {
        $show_data = [
            NULL,
            [],
            '',
            0,
            1.01,
            '01082016',
            01082016,
            '18082016',
            18082016,
            '20160801',
            20160801,
            strtotime('2016/08/16'),
            'now()',
            time(),
            '01/08/2016',
            '01/08/2016 08:00:00',
            '18/08/2016',
            '18/08/2016 08:00:00',
            '01-08-2016',
            '01-08-2016 08:00:00',
            '18-08-2016',
            '18-08-2016 08:00:00',
        ];

        // 中間挖掉的部分
        $content_div = '<table border="1"><tr><th>value</th><th>type</th><th>chk_datetime_input(value)</th></tr>';

        foreach ($show_data as $value)
        {
            $content_div .= '<tr><td>'.var_export($value, TRUE).'</td><td>'.gettype($value).'</td><td>'.chk_datetime_input($value).'</td></tr>';
        }
        $content_div .= '</table>';

        $html_date = [
            'title'                   => '時間格式 測試',
            'current_title'    => $this->current_title,
            'current_page'  => strtolower(__CLASS__),           // 當下類別
            'current_fun'     => strtolower(__FUNCTION__),  // 當下function
            'content_div'     => $content_div,
        ];

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function conv_date()
    {

        $dt = date('Y/m/d H:i:s');

        $show_data = [];
        $show_data[] = [
            'in_dt' => $dt,
            'to_tz' => 'Europe/Rome',
        ];
        $show_data[] = [
            'in_dt' => $dt,
            'to_tz' => 'America/Los_Angeles',
        ];
        $show_data[] = [
            'in_dt' => $dt,
            'to_tz' => 'America/Denver',
        ];
        $show_data[] = [
            'in_dt' => $dt,
            'to_tz' => 'America/New_York',
        ];

        // 中間挖掉的部分
        $content_div = '<table border="1"><tr><th>input</th><th>in time zone</th><th>to time zone</th><th>output</th></tr>';

        foreach ($show_data as $row)
        {
            $content_div .= '<tr><td>'.$row['in_dt'].'</td><td>Asia/Taipei</td><td>'.$row['to_tz'].'</td><td>'.conv_datetime($row['in_dt'], $row['to_tz']).'</td></tr>';
        }
        $content_div .= '</table>';

        $html_date = [
            'title'                   => 'conv time zone',
            'current_title'    => $this->current_title,
            'current_page'  => strtolower(__CLASS__),           // 當下類別
            'current_fun'     => strtolower(__FUNCTION__),  // 當下function
            'content_div'     => $content_div,
        ];

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function conv_format()
    {

        $dt = date('Y/m/d H:i:s');

        $tz = [
            'Asia/Taipei',
            'Europe/Rome',
            'America/Los_Angeles',
        ];

        // 中間挖掉的部分
        $content_div = '<table border="1"><tr><th>date</th><th>time zone</th><th>output</th></tr>';

        foreach ($tz as $val)
        {
            $content_div .= '<tr><td>'.$dt.'</td><td>'.$val.'</td><td>'.time_zone_format($dt, $val).'</td></tr>';
        }
        $content_div .= '</table>';

        $html_date = [
            'title'                   => 'conv time format',
            'current_title'    => $this->current_title,
            'current_page'  => strtolower(__CLASS__),           // 當下類別
            'current_fun'     => strtolower(__FUNCTION__),  // 當下function
            'content_div'     => $content_div,
        ];

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function ci_helper_date()
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

        $date_ary['Note'] = 'Dates in the m/d/y or d-m-y formats are disambiguated by looking at the separator between the various components: if the separator is a slash (/), then the American m/d/y is assumed; whereas if the separator is a dash (-) or a dot (.), then the European d-m-y format is assumed. If, however, the year is given in a two digit format and the separator is a dash (-, the date string is parsed as y-m-d. To avoid potential ambiguity, it\'s best to use ISO 8601 (YYYY-MM-DD) dates or DateTime::createFromFormat() when possible.';

        $date_ary["strtotime('01/08/2016')"] = strtotime('01/08/2016');
        $date_ary["strtotime('01-08-2016')"] = strtotime('01-08-2016');
        $date_ary["strtotime('08/01/2016')"] = strtotime('08/01/2016');
        $date_ary["strtotime('08-01-2016')"] = strtotime('08-01-2016');
        $date_ary["strtotime('2016/08/01)"] = strtotime('2016/08/01');
        $date_ary["strtotime('2016-08-01')"] = strtotime('2016-08-01');

        $date_ary["strtotime('16/08/2016')"] = strtotime('16/08/2016');
        $date_ary["strtotime('16-08-2016')"] = strtotime('16-08-2016');
        $date_ary["strtotime('08/16/2016')"] = strtotime('08/16/2016');
        $date_ary["strtotime('08-16-2016')"] = strtotime('08-16-2016');
        $date_ary["strtotime('2016/08/16)"] = strtotime('2016/08/16');
        $date_ary["strtotime('2016-08-16')"] = strtotime('2016-08-16');

        return $date_ary ;
    }

    private function _str_replace($str){
        $order = array("\r\n", "\n", "\r", "￼", "<br />", "<br/>");
        $str = str_replace($order,"<br>",$str);// HTML5 寫法
        return $str;
    }
}
?>
