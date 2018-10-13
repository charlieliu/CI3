<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

class Dx_test extends CI_Controller {

    private $current_title = 'DevExpress 測試';
    private $page_list = '';
    private $_csrf = null ;

    public $UserAgent = array() ;

    // 建構子
    public function __construct()
    {
        parent::__construct();

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

        $content['dxChart'] = array(
            'content_title' => 'dxChart',
            'content_url' => base_url().'dx_test/dxChart',
        ) ;
        $content['dxAccordion'] = array(
            'content_title' => 'dxAccordion',
            'content_url' => base_url().'dx_test/index/dxAccordion',
            'disabled'=>TRUE,
        ) ;
        $content['dxDeferRendering'] = array(
            'content_title' => 'dxDeferRendering',
            'content_url' => base_url().'dx_test/index/dxDeferRendering',
            'disabled'=>TRUE,
        ) ;
        $content['dx_input'] = array(
            'content_title' => 'dxTextBox dxButton dxNumberBox dxTextArea dxFileUploader  dxValidator dxValidationSummary',
            'content_url' => base_url().'dx_test/index/dx_input',
        ) ;

        $dx[] = 'dxActionSheet';
        $dx[] = 'dxAutocomplete';
        $dx[] = 'dxBox';
        $dx[] = 'dxCalendar';
        $dx[] = 'dxCheckBox';
        $dx[] = 'dxColorBox';
        $dx[] = 'dxDataGrid';
        $dx[] = 'dxDateBox';
        // $dx[] = 'dxForm';
        $dx[] = 'dxRadioGroup';
        $dx[] = 'dxSelectBox';
        $dx[] = 'dxTagBox';

        foreach ($dx as $val)
        {
            $content[$val] = array(
                'content_title' => $val,
                'content_url' => base_url().'dx_test/index/'.$val,
            ) ;
        }

        $this->page_list = $content ;
    }

    // 取得標題
    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    // 測試分類畫面
    public function index($method='', $css='l')
    {
        if ( in_array($method, array_keys($this->page_list)))
            $this->_dx_view($method, $css);
        else
            $this->_list_view();
    }

    // 測試畫面 Chart
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

    private function _list_view()
    {
        $content = $this->page_list ;
        // 標題 內容顯示
        $data = array(
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' =>'index', // 當下function
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

    private function _dx_view($function, $css, $data = [])
    {
        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('dx_test/'.$function.'_view', $data, true);
        $title = ('dx_input' == $function) ? 'dxTextBox dxButton dxNumberBox dxTextArea dxFileUploader  dxValidator dxValidationSummary' : $function ;
        // 中間部分塞入外框
        $html_date = [
            'title' => $title,
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower($function), // 當下function
            'content_div'   => $content_div,
        ] ;

        $html_date['css'][] = 'css/dx/dx.common.css';
        if ('l' == $css)
            $html_date['css'][] = 'css/dx/dx.light.css';
        else
            $html_date['css'][] = 'css/dx/dx.dark.css';
        if (file_exists('css/dx/'.$function.'.css'))
            $html_date['css'][] = 'css/dx/'.$function.'.css';

        $html_date['js'][] = 'js/dx/globalize.min.js';
        $html_date['js'][] = 'js/dx/dx.webappjs.js';
        $html_date['js'][] = 'js/dx/dx.all.js';
        $html_date['js'][] = 'js/dx/'.$function.'.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }
}
?>