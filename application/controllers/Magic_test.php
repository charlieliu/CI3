<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/

class Magic_test extends CI_Controller {

    private $current_title = 'Magic Method 測試';
    private $page_list = array();
    private $_csrf = null ;

    public $UserAgent = array() ;

    // 建構子
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
            $this->load->model('php_test_model','',TRUE) ;
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }
    }

    // 取得標題
    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    // 測試
    public function index($method='', $v1='', $v2='')
    {
        if( empty($method) )
        {
            // 標題 內容顯示
            $data = array(
                'title'             => $this->current_title,
                'current_title'     => $this->current_title,
                'current_page'      => strtolower(__CLASS__), // 當下類別
                'current_fun'       => strtolower(__FUNCTION__), // 當下function
            );
            $data = array_merge($data,$this->_csrf);
            $data['content_div']  = '<div class="container-fluid">';
            $data['content_div'] .= $data['current_page'].'/'.$data['current_fun']. "<br>===================<br>";
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/string/value/123').'">string</a><br>' ;
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/empty/false/null').'">empty</a><br>' ;
            $data['content_div'] .= '</div>';
            $view = $this->parser->parse('index_view', $data, true);
            $this->pub->remove_view_space($view);
        }
        else
        {
            $this->$method($v1, $v2);
        }
    }

    public function string($v1=null, $v2=null)
    {
        $content_div  = '<div class="container-fluid">';
        $content_div .= __CLASS__.'/'.__FUNCTION__ ;
        $content_div .= '<br>===================<br>';
        $content_div .= "function string($v1, $v2)<br>";
        $content_div .= '$v1 = '.var_export($v1 ,TRUE).'<br>';
        $content_div .= '$v2 = '.var_export($v2 ,TRUE).'<br>';
        $content_div .= '</div>';
        // 標題 內容顯示
        $data = array(
            'title'             => 'real function',
            'current_title' => $this->current_title,
            'current_page'  => strtolower(__CLASS__), // 當下類別
            'current_fun'   => strtolower(__FUNCTION__), // 當下function
            'content_div' => $content_div,
        );
        $view = $this->parser->parse('index_view', $data, true);
        $this->pub->remove_view_space($view);
    }

    public function __call($name, $arguments)
    {
        // 標題 內容顯示
        $data = array(
            'title'             => $this->current_title,
            'current_title' => $this->current_title,
            'current_page'  => strtolower(__CLASS__), // 當下類別
            'current_fun'   => strtolower(__FUNCTION__), // 當下function
        );
        $data = array_merge($data,$this->_csrf);
        $data['content_div']  = '<div class="container-fluid">';
        $data['content_div'] .= '<p>LINE: '.__LINE__.'</p>';
        $data['content_div'] .= '<p>'.$data['current_page'].'/'.$data['current_fun'].'</p>';
        $data['content_div'] .= '<hr>';
        // 注意: $name 的值区分大小写
        $data['content_div'] .= 'Calling object method: '.var_export($name, TRUE);
        $data['content_div'] .= '<hr>';
        $data['content_div'] .= 'Calling object arguments :'.var_export($arguments, TRUE);
        $data['content_div'] .= '</div>';
        $view = $this->parser->parse('index_view', $data, true);
        $this->pub->remove_view_space($view);
    }

    //  PHP 5.3.0之后版本
    public static function __callStatic($name, $arguments)
    {
        $str  = '<div class="container-fluid">';
        $str .= __CLASS__.'/'.__FUNCTION__ ;
        $str .= '<br>===================<br>';
        // 注意: $name 的值区分大小写
        $str .= "Calling static method '$name' ". implode(', ', $arguments). "<br>";
        $str .= '</div>';
        echo $str;

        // 標題 內容顯示
        // $data = array(
        //     'title'             => $this->current_title,
        //     'current_title' => $this->current_title,
        //     'current_page'  => strtolower(__CLASS__), // 當下類別
        //     'current_fun'   => strtolower(__FUNCTION__), // 當下function
        // );
        // $view = $this->parser->parse('index_view', $data, true);
        // $this->pub->remove_view_space($view);
    }
}
?>