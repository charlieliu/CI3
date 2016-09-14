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
                'title' => $this->current_title,
                'current_title' => $this->current_title,
                'current_page' => strtolower(__CLASS__), // 當下類別
                'current_fun' => strtolower(__FUNCTION__), // 當下function
            );
            $data = array_merge($data,$this->_csrf);
            $data['content_div']  = '<div class="container-fluid">';
            $data['content_div'] .= $data['current_page'].'/'.$data['current_fun']. "<br>===================<br>";
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/string/value/123').'">string</a><br>' ;
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/String').'">String</a><br>' ;
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/empty/false/null').'">empty</a><br>' ;
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/foobar').'">foobar</a><br>' ;
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/Foobar2').'">Foobar2</a><br>' ;
            $data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/__callStatic').'">__callStatic</a><br>' ;
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
        $content_div .= 'function string($v1, $v2)<br>';
        $content_div .= '$v1 = '.var_export($v1 ,TRUE).'<br>';
        $content_div .= '$v2 = '.var_export($v2 ,TRUE).'<br>';
        $content_div .= '</div>';

        // 標題 內容顯示
        $data = array(
            'title' => 'function string($v1, $v2)',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content_div' => $content_div,
        );
        $view = $this->parser->parse('index_view', $data, true);
        $this->pub->remove_view_space($view);
    }

    // php 5.5.9 ~ php 7.0 can use
    public function __call($name, $arguments=[])
    {
        // 標題 內容顯示
        $data = array(
            'title' => $this->current_title,
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
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

    //  PHP < 5.3.0 ???
    public static function __callStatic($name, $arguments)
    {
        $CI = & get_instance();
        $str  = '<div class="container-fluid">';
        $str .= __CLASS__.'/'.__FUNCTION__ ;
        $str .= '<br>===================<br>';
        // 注意: $name 的值区分大小写
        $str .= "Calling static method : ". var_export($name, TRUE) ;
        $str .= '<hr>';
        $str .= "Calling static arguments : ". var_export($arguments, TRUE) ;
        $str .= '</div>';

        // 標題 內容顯示
        $data = [
            'title' => 'Magic Method 測試',
            'current_title' => 'Magic Method 測試',
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content_div' => $str,
        ];
        $view = $CI->parser->parse('index_view', $data, true);
        $CI->pub->remove_view_space($view);
    }

    public function foobar($arg, $arg2)
    {
        // Call the $foo->bar() method with 2 arguments
        $foo = new foo;
        call_user_func_array(array($foo, "bar"), array("three", "four"));
    }

    public function Foobar2($arg, $arg2)
    {
        // Call the bar() function with 2 arguments
        call_user_func_array([$this, "bar"], array("one", "two"));
    }

    public function bar($arg, $arg2)
    {
        $str  = '<div class="container-fluid">';
        $str .= __CLASS__.'/'.__FUNCTION__ ;
        $str .= '<br>===================<br>';
        $str .= "Calling static arg : ". var_export($arg, TRUE) ;
        $str .= '<hr>';
        $str .= "Calling static arg2 : ". var_export($arg2, TRUE) ;
        $str .= '</div>';

        // 標題 內容顯示
        $data = [
            'title' => 'bar',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content_div' => $str,
        ];
        $view = $this->parser->parse('index_view', $data, true);
        $this->pub->remove_view_space($view);
    }
}

class foo {
    function bar($arg, $arg2)
    {
        $CI = & get_instance();
        $str  = '<div class="container-fluid">';
        $str .= __CLASS__.'/'.__FUNCTION__ ;
        $str .= '<br>===================<br>';
        $str .= "Calling static arg : ". var_export($arg, TRUE) ;
        $str .= '<hr>';
        $str .= "Calling static arg2 : ". var_export($arg2, TRUE) ;
        $str .= '</div>';

        // 標題 內容顯示
        $data = [
            'title' => 'foobar',
            'current_title' => 'Magic Method 測試',
            'current_page' => 'magic_test', // Magic Method 測試
            'current_fun' => 'foobar',
            'content_div' => $str,
        ];
        $view = $CI->parser->parse('index_view', $data, true);
        $CI->pub->remove_view_space($view);
    }
}
?>