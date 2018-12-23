<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

class Math_test extends CI_Controller {

    public $current_title = '數學加減乘除 測試';
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
        $content = [];
        for ($i=1; $i < 5; $i++)
        {
            $content[] = [
                'content_title' => '加法 - '.$i.' 位數',
                'content_url' => strtolower(__CLASS__).'/addition/'.$i,
            ] ;
            $content[] = [
                'content_title' => '減法 - '.$i.' 位數',
                'content_url' => strtolower(__CLASS__).'/subtraction/'.$i,
            ] ;
            $content[] = [
                'content_title' => '乘法 - '.$i.' 位數',
                'content_url' => strtolower(__CLASS__).'/multiplication/'.$i,
            ] ;
            $content[] = [
                'content_title' => '除法 - '.$i.' 位數',
                'content_url' => strtolower(__CLASS__).'/division/'.$i,
            ] ;
        }

        $this->page_list = $content ;
    }

    private function _html($title = '', $grid_view = '')
    {

        // 標題 內容顯示
        $data = [
            'title' => $title,
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'grid_view' => $grid_view,
            'csrf_name' => $this->_csrf['csrf_name'],
            'csrf_value' => $this->_csrf['csrf_value'],
        ] ;

        // 中間挖掉的部分
        $content_div = $this->parser->parse('math_test/outer_view', $data, true);

        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $this->parser->parse('index_view', $html_date ) ;
    }

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function index()
    {
        $content = $this->page_list ;

        // 標題 內容顯示
        $data = array(
            'title' => '數學加減乘除 測試',
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

    private function _math($num, $mark)
    {
        $start = '1';
        $end = '9';
        for($i = $num; $i > 1; $i--)
        {
            $start .= '0';
            $end .= '9';
        }
        $value_1 = $rand_1 = rand($start,$end);
        $value_2 = $rand_2 = rand($start,$end);
        switch($mark)
        {
            case '-':
                if ($rand_1 < $rand_2)
                {
                    $value_1 = $rand_2;
                    $value_2 = $rand_1;
                }
                $answer = $value_1 - $value_2;
                break;
            case 'X':
                $answer = $value_1 * $value_2;
                break;
            case '/':
                $value_1 = $rand_1 * $rand_2;
                $value_2 = $rand_1;
                $answer = $rand_2;
                break;
            default:
                $answer = $value_1 + $value_2;
                break;
        }

        return [
            'value_1'   => $value_1,
            'value_2'   => $value_2,
            'answer'    => $answer,
            'mark'      => $mark,
        ];
    }

    public function addition($num = 1)
    {
        // 顯示資料
        $content = array();
        for($i = 5; $i > 0; $i--)
        {
            $tmp = $this->_math($num, '+');
            $tmp['key'] = $i;
            $content[] = $tmp;
        }

        // tbody
        $grid_view = $this->parser->parse('math_test/grid_view', array('content'=>$content), true);

        $this->_html('加法 - '.$num.' 位數 測試', $grid_view);
    }

    public function subtraction($num = 1)
    {
        // 顯示資料
        $content = [];
        for($i = 5; $i > 0; $i--)
        {
            $tmp = $this->_math($num, '-');
            $tmp['key'] = $i;
            $content[] = $tmp;
        }

        // tbody
        $grid_view = $this->parser->parse('math_test/grid_view', array('content'=>$content), true);

        $this->_html('減法 - '.$num.' 位數 測試', $grid_view);
    }

    public function multiplication($num)
    {
        // 顯示資料
        $content = [];
        for($i = 5; $i > 0; $i--)
        {
            $tmp = $this->_math($num, 'X');
            $tmp['key'] = $i;
            $content[] = $tmp;
        }

        // tbody
        $grid_view = $this->parser->parse('math_test/grid_view', array('content'=>$content), true);

        $this->_html('乘法 - '.$num.' 位數 測試', $grid_view);
    }

    public function division($num)
    {
        // 顯示資料
        $content = [];
        for($i = 5; $i > 0; $i--)
        {
            $tmp = $this->_math($num, '/');
            $tmp['key'] = $i;
            $content[] = $tmp;
        }

        // tbody
        $grid_view = $this->parser->parse('math_test/grid_view', array('content'=>$content), true);

        $this->_html('除法 - '.$num.' 位數 測試', $grid_view);
    }
}

