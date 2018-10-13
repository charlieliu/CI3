<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

class Php_hash_test extends CI_Controller {

    public $current_title = 'PHP encode decode 測試';
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
        $this->_csrf = [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_value' => $this->security->get_csrf_hash(),
        ];

        // load parser
        $this->load->helper(array('form', 'url'));

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) ) $this->php_test_model->query_user_agent($this->UserAgent) ;

        // 顯示資料
        $content = [];
        $content[] = [
            'content_title' => 'Hash encode 測試',
            'content_url' => 'php_hash_test/hash_test',
        ];
        $content[] = [
            'content_title' => 'decode 測試',
            'content_url' => 'php_hash_test/decode_test',
            ];

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
            'title' => 'PHP encode decode 測試',
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
}
?>
