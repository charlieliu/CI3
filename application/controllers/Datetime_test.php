<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

        ini_set("session.cookie_httponly", 1);
        header("x-frame-options:sammeorigin");
        header('Content-Type: text/html; charset=utf8');

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
            'content_title' => '時間格式 顯示',
            'content_url' => 'datetime_test/date_test',
        ];
        $content[] = [
            'content_title' => '時間格式 測試',
            'content_url' => 'datetime_test/deta_helper_rest',
        ];

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

    public function deta_helper_rest()
    {
        // load parser
        $this->load->helper(['datetime_tools']);

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
}
?>
