<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

const ORZ = 'ORZ';

class Constant_test extends CI_Controller {

    private $current_title = 'Constant 測試';
    private $page_list = array();
    private $_csrf = null ;

    public $UserAgent = array() ;

    // 建構子
    public function __construct()
    {
        parent::__construct();

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->load->model('php_test_model','',TRUE) ;
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        // 顯示資料
        $content = [];
        $content[] = [
            'content_title' => 'define',
            'content_url' => strtolower(__CLASS__).'/define',
        ] ;

        $this->page_list = $content ;
    }

    // 取得標題
    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    // 測試
    public function index($method='', $v1='', $v2='')
    {
        $content = $this->page_list ;

        // 標題 內容顯示
        $data = array(
            'title' => 'Constant 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => $content,
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('welcome_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function define()
    {

        $content_div  = '<div class="container-fluid">';
        $content_div .= __CLASS__.'/'.__FUNCTION__ ;
        $content_div .= '<br>===================<br>';

        $content_div .= 'before class on LINE 5 : const ORZ = "ORZ";<br>';
        $content_div .= 'ORZ = '.var_export(ORZ, TRUE).'<br><br>';

        define("QoQ", "QoQ");
        $content_div .= 'define("QoQ", "QoQ");<br>';
        defined("QoQ") || define("QoQ", "orz");
        $content_div .= 'defined("QoQ") || define("QoQ", "orz");<br>';
        $content_div .= 'QoQ = '.var_export(QoQ, TRUE).'<br><br>';

        defined("omo") || define("omo", "^_^");
        $content_div .= 'defined("omo") || define("omo", "^_^");<br>';
        $content_div .= 'omo = '.var_export(omo, TRUE).'<br><br>';

        if (!defined('OoO')) define('OoO', 'XD');
        $content_div .= 'if (!defined("OoO")) define("OoO", "XD");<br>';
        $content_div .= 'OoO = '.var_export(OoO, TRUE).'<br><br>';

        if (!defined('ORZ')) define('ORZ', 'XD');
        $content_div .= 'if (!defined("ORZ")) define("ORZ", "XD");<br>';
        $content_div .= 'ORZ = '.var_export(ORZ, TRUE).'<br><br>';

        // syntax error, unexpected 'const' (T_CONST)
        // if (!defined('BAR')) const BAR = 'BAR';
        // $content_div .= 'if (!defined("BAR")) const BAR = 'BAR';<br>';
        // $content_div .= 'BAR = '.var_export(BAR, TRUE).'<br><br>';

        $content_div .= '</div>';

        // 標題 內容顯示
        $data = array(
            'title' => 'define',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content_div' => $content_div,
        );
        $view = $this->parser->parse('index_view', $data, true);
        $this->pub->remove_view_space($view);
    }
}
?>