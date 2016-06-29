<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/
class Dx_test extends CI_Controller {

    private $current_title = 'DevExpress 測試';
    private $page_list = '';
    private $_csrf = null ;

    public $UserAgent = array() ;

    // 建構子
    public function __construct()
    {
        parent::__construct();

        header('Content-Type: text/html; charset=utf8');

        // for CSRF
        $this->_csrf = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_value' => $this->security->get_csrf_hash(),
        );

        // load parser
        //$this->load->library(array('parser','session', 'pub'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('php_test_model','',TRUE) ;

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        $content[] = array(
            'content_title' => 'dxChart',
            'content_url' => base_url().'dx_test/dxChart',
        ) ;
        $content[] = array(
            'content_title' => 'dxData',
            'content_url' => base_url().'dx_test/dxData',
        ) ;
        $content[] = array(
            'content_title' => 'dx_input',
            'content_url' => base_url().'dx_test/dx_input',
        ) ;
        $content[] = array(
            'content_title' => 'dxTagBox',
            'content_url' => base_url().'dx_test/dxTagBox',
        ) ;
        $this->page_list = $content ;
    }

    // 取得標題
    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    // 測試分類畫面
    public function index()
    {
        $content = $this->page_list ;
        // 標題 內容顯示
        $data = array(
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => $content,
        );

        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('welcome_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['title'] = $this->current_title;
        $html_date['current_title'] = $this->current_title;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // 測試畫面
    public function dxChart()
    {
        $data = [];
        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('dx_test/dxChart_view', $data, true);
        // 標題 內容顯示
        $html_date = array(
            'title' =>  'dxChart',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content_div'   => $content_div,
        );

        $html_date['js'][] = 'js/dx/globalize.min.js';
        $html_date['js'][] = 'js/dx/dx.chartjs.js';
        $html_date['js'][] = 'js/dx/chartjs.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // 測試畫面
    public function dxData($css='l')
    {
        $data = [];
        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('dx_test/dxData_view', $data, true);
        // 標題 內容顯示
        $html_date = array(
            'title' =>  'dxData',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content_div'   => $content_div,
        );

        $html_date['css'][] = 'css/dx/dx.common.css';
        if ('l' == $css)
            $html_date['css'][] = 'css/dx/dx.light.css';
        else
            $html_date['css'][] = 'css/dx/dx.dark.css';

        $html_date['js'][] = 'js/dx/globalize.min.js';
        $html_date['js'][] = 'js/dx/dx.webappjs.js';
        $html_date['js'][] = 'js/dx/datajs.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // 測試畫面
    public function dx_input($css='l')
    {
        $data = [];
        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('dx_test/dx_input_view', $data, true);

        // 標題 內容顯示
        $html_date = array(
            'title'                 => 'dx input',
            'current_title'   => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun'   => strtolower(__FUNCTION__), // 當下function
            'content_div'   => $content_div,
        );

        $html_date['css'][] = 'css/dx/dx.common.css';
        if ('l' == $css)
            $html_date['css'][] = 'css/dx/dx.light.css';
        else
            $html_date['css'][] = 'css/dx/dx.dark.css';

        $html_date['js'][] = 'js/dx/globalize.min.js';
        $html_date['js'][] = 'js/dx/dx.webappjs.js';
        $html_date['js'][] = 'js/dx/dx_input.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function dxTagBox($css='l'){
        $data = [];
        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('dx_test/dxTagBox_view', $data, true);
        // 中間部分塞入外框
        $html_date = [
            'title' => 'dxTagBox',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content_div'   => $content_div,
        ] ;

        $html_date['css'][] = 'css/dx/dx.common.css';
        if ('l' == $css)
            $html_date['css'][] = 'css/dx/dx.light.css';
        else
            $html_date['css'][] = 'css/dx/dx.dark.css';
        $html_date['css'][] = 'css/dx/dxTagBox.css';

        $html_date['js'][] = 'js/dx/globalize.min.js';
        $html_date['js'][] = 'js/dx/dx.webappjs.js';
        $html_date['js'][] = 'js/dx/dxTagBox.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }
}
?>