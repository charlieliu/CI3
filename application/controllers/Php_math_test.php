<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

class Php_math_test extends CI_Controller {

    public $current_title = 'PHP 運算 測試';
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
        $content[] = [
            'content_title' => 'PHP 浮點運算 測試',
            'content_url' => strtolower(__CLASS__).'/float_test',
        ] ;
        $content[] = [
            'content_title' => 'PHP bcadd() 測試',
            'content_url' => strtolower(__CLASS__).'/bcadd_test',
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
            'title' => 'PHP 運算 測試',
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

        // 中間挖掉的部分
        $content_div = $this->parser->parse('php_test/test_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }
}
?>
