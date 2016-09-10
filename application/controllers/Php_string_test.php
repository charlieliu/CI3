<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Php_string_test extends CI_Controller {

    public $current_title = 'PHP 字串 測試';
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

        ini_set("session.cookie_httponly", 1);
        header("x-frame-options:sammeorigin");
        header('Content-Type: text/html; charset=utf8');

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
            'content_title' => '正規表示式 測試',
            'content_url' => strtolower(__CLASS__).'/preg_test',
            ] ;
        $content[] = array(
            'content_title' => 'php chr() -- ASCII',
            'content_url' => strtolower(__CLASS__).'/php_chr',
        ) ;
        $content[] = array(
            'content_title' => 'strlen 測試',
            'content_url' => strtolower(__CLASS__).'/strlen',
        ) ;

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
            'title' => 'PHP 字串 測試',
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

    public function preg_test()
    {
        $post = $this->input->post();

        $str = isset($post['str']) ? $post['str'] : '' ;

        // 正規表達式
        $preg_array = array();
        $preg_array[] = array(
            'fun'    => 'URL',
            'remark' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i',
            'reg'    => preg_match('/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i',$str),
            'remark2'=> '/^(http?:\/\/+[\w\-]+\.[\w\-]+)/i',
            'reg2'   => preg_match('/^(http?:\/\/+[\w\-]+\.[\w\-]+)/i',$str),
        );
        $preg_array[] = array(
            'fun'    => '手機號碼',
            'remark' => '/^09[0-9]{8}$/',
            'reg'    => preg_match('/^09[0-9]{8}$/',$str),
            'remark2'=> '',
            'reg2'   => '',
        );
        $preg_array[] = array(
            'fun'    => '身分證字號',
            'remark' => '/^[A-Z]{1}[0-9]{9}$/',
            'reg'    => preg_match('/^[A-Z]{1}[0-9]{9}$/',$str),
            'remark2'=> '',
            'reg2'   => '',
        );
        $preg_array[] = array(
            'fun'    => '正整數 或 空值',
            'remark' => '/^\d*$/',
            'reg'    => preg_match('/^\d*$/',$str),
            'remark2'=> '',
            'reg2'   => '',
        );
        $preg_array[] = array(
            'fun'    => '全部是正整數',
            'remark' => '/^\d+$/',
            'reg'    => preg_match('/^\d+$/',$str),
            'remark2'=> '/^[0-9]+$/',
            'reg2'   => preg_match('/^[0-9]+$/',$str),
        );
        $preg_array[] = array(
            'fun'    => '含數字',
            'remark' => '/\d/',
            'reg'    => preg_match('/\d/',$str),
            'remark2'=> '/[0-9]/',
            'reg2'   => preg_match('/[0-9]/',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部非數字',
            'remark' => '/^\D+$/',
            'reg'    => preg_match('/^\D+$/',$str),
            'remark2'=> '/^[^0-9]+$/',
            'reg2'   => preg_match('/^[^0-9]+$/',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部是英文字母(小寫 | 大寫)',
            'remark' => '/^[a-z]+$/',
            'reg'    => preg_match('/^[a-z]+$/',$str),
            'remark2'=> '/^[A-Z]+$/',
            'reg2'   => preg_match('/^[A-Z]+$/',$str),
        );
        $preg_array[] = array(
            'fun'    => '含英文字母(小寫 | 大寫)',
            'remark' => '/[a-z]/',
            'reg'    => preg_match('/[a-z]/',$str),
            'remark2'=> '/[A-Z]/',
            'reg2'   => preg_match('/[A-Z]/',$str),
        );
        $preg_array[] = array(
            'fun'    => '含數字或英文字母或_',
            'remark' => '/^\w+$/',
            'reg'    => preg_match('/^\w+$/',$str),
            'remark2'=> '/^[A-Za-z0-9_]+$/',
            'reg2'   => preg_match('/^[A-Za-z0-9_]+$/',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部非數字或英文字母或_',
            'remark' => '/^\W+$/',
            'reg'    => preg_match('/^\W+$/',$str),
            'remark2'=> '/^[^A-Za-z0-9_]+$/',
            'reg2'   => preg_match('/^[^A-Za-z0-9_]+$/',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部是空白字元',
            'remark' => '/^\s+$/',
            'reg'    => preg_match('/^\s+$/',$str),
            'remark2'=> '/^[\x{0020}]+$/u',
            'reg2'   => preg_match('/^[\x{0020}]+$/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部非空白字元',
            'remark' => '/^\S+$/',
            'reg'    => preg_match('/^\S+$/',$str),
            'remark2'=> '/^[^\x{0020}]+$/u',
            'reg2'   => preg_match('/^[^\x{0020}]+$/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部中文 | 含中文',
            'remark' => '/^[\x{4e00}-\x{9fa5}]+$/u',
            'reg'    => preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$str),
            'remark2'=> '/^[\x{4e00}-\x{9fa5}]+$/u',
            'reg2'   => preg_match('/[\x{4e00}-\x{9fa5}]/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部文字 | 含文字',
            'remark' => '/^[\x{0080}-\x{FFFF}]+$/u',
            'reg'    => preg_match('/^[\x{0080}-\x{FFFF}]+$/u',$str),
            'remark2'=> '/^[\x{0080}-\x{FFFF}]+$/u',
            'reg2'   => preg_match('/[\x{4e00}-\x{9fa5}]/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部符號 | 含符號',
            'remark' => '/^[\x{0021}-\x{002f}]+$/u',
            'reg'    => preg_match('/^[\x{0021}-\x{002f}]+$/u',$str),
            'remark2'=> '/[\x{0021}-\x{002f}]/u',
            'reg2'   => preg_match('/[\x{0021}-\x{002f}]/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部數字 | 含數字',
            'remark' => '/^[\x{0030}-\x{0039}]+$/u',
            'reg'    => preg_match('/^[\x{0030}-\x{0039}]+$/u',$str),
            'remark2'=> '/[\x{0030}-\x{0039}]/u',
            'reg2'   => preg_match('/[\x{0030}-\x{0039}]/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部符號 | 含符號',
            'remark' => '/^[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]+$/u',
            'reg'    => preg_match('/^[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]+$/u',$str),
            'remark2'=> '/[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]/u',
            'reg2'   => preg_match('/[\x{003a}-\x{0040}\x{005b}-\x{0060}\x{007b}-\x{007f}]/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部大寫英文 | 含大寫英文',
            'remark' => '/^[\x{0041}-\x{005a}]+$/u',
            'reg'    => preg_match('/^[\x{0041}-\x{005a}]+$/u',$str),
            'remark2'=> '/[\x{0041}-\x{005a}]/u',
            'reg2'   => preg_match('/[\x{0041}-\x{005a}]/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部小寫英文 | 含小寫英文',
            'remark' => '/^[\x{0061}-\x{007a}]+$/u',
            'reg'    => preg_match('/^[\x{0061}-\x{007a}]+$/u',$str),
            'remark2'=> '/[\x{0061}-\x{007a}]/u',
            'reg2'   => preg_match('/[\x{0061}-\x{007a}]/u',$str),
        );
        $preg_array[] = array(
            'fun'    => '全部英數字大小寫符號',
            'remark' => '/^[\x{0021}-\x{007e}]+$/',
            'reg'    => preg_match('/^[\x{0021}-\x{007e}]+$/',$str),
            'remark2'=> '/^[\x{21}-\x{7e}]+$/',
            'reg2'   => preg_match('/^[\x{21}-\x{7e}]+$/',$str),
        );

        // 顯示資料
        $content = array();

        foreach( $preg_array as $v )
        {
            $content[] = array(
                'content_name'  => $v['fun'],
                'content_title' => $v['remark'],
                'content_value' => $v['reg'],
                'content_title2'=> $v['remark2'],
                'content_value2'=> $v['reg2'],
            ) ;
        }

        // tbody
        $grid_view = $this->parser->parse('php_test/preg_test_grid_view', array('content'=>$content), true);

        if( !isset($post['str']) )
        {
            // 標題 內容顯示
            $data = [
                'title' => '正規表達式 測試',
                'current_title' => $this->current_title,
                'current_page' => strtolower(__CLASS__), // 當下類別
                'current_fun' => strtolower(__FUNCTION__), // 當下function
                'grid_view' => $grid_view,
                'str'=> $str,
                'csrf_name' => $this->_csrf['csrf_name'],
                'csrf_value' => $this->_csrf['csrf_value'],
            ] ;

            // 中間挖掉的部分
            $content_div = $this->parser->parse('php_test/preg_test_outer_view', $data, true);

            // 中間部分塞入外框
            $html_date = $data ;
            $html_date['content_div'] = $content_div ;
            $html_date['js'][] = 'js/php_test/preg_test.js';
            $this->parser->parse('index_view', $html_date ) ;
        }
        else
        {
            echo json_encode(array('grid_view'=>$grid_view)) ;
        }
    }

    public function php_chr()
    {
        // 顯示資料
        $content = array();

        $ascii_arr[] = array('s'=>0,'e'=>32,'t'=>'空白');
        $ascii_arr[] = array('s'=>33,'e'=>47,'t'=>'符號');
        $ascii_arr[] = array('s'=>48,'e'=>57,'t'=>'數字');
        $ascii_arr[] = array('s'=>58,'e'=>64,'t'=>'符號');
        $ascii_arr[] = array('s'=>65,'e'=>90,'t'=>'大寫');
        $ascii_arr[] = array('s'=>91,'e'=>96,'t'=>'符號');
        $ascii_arr[] = array('s'=>97,'e'=>122,'t'=>'小寫');
        $ascii_arr[] = array('s'=>123,'e'=>127,'t'=>'符號');
        $ascii_arr[] = array('s'=>128,'e'=>255,'t'=>'字符');
        // 256 以上重複循環 33=>! 289=>!
        foreach ($ascii_arr as $row) {
            $content_value = '<table><tr><th>$ascii(10)</th><th>$ascii(8)</th><th>$ascii(16)</th><th>chr($ascii)</th></tr>';
            for($i=$row['s'];$i<=$row['e'];$i++)
            {
                /*
                    chr() 参数可以是十进制、八进制或十六进制。
                    通过前置 0 来规定八进制，
                    通过前置 0x 来规定十六进制。
                */
                $content_value .= '<tr><td>'.$i.'</td><td>'.base_convert($i,10,8).'</td><td>'.base_convert($i,10,16).'</td><td>'.chr($i).'</td></tr>';
            }
            $content_value .= '</table>';
            $content[] = array(
                'content_title'=>$row['t'],
                'content_value'=>$content_value,
            ) ;
        }

        $content[] = array(
            'content_title'=>'ASCII 字碼表 1',
            'content_value'=>'https://msdn.microsoft.com/zh-tw/library/60ecse8t(v=vs.80).aspx',
        ) ;
        $content[] = array(
            'content_title'=>'ASCII 字碼表 2',
            'content_value'=>'https://msdn.microsoft.com/zh-tw/library/9hxt0028(v=vs.80).aspx',
        ) ;

        $content[] = array(
            'content_title'=>'256 以上重複循環 ex: chr(33) chr(289)',
            'content_value'=>'chr(33)='.chr(33).' chr(289)='.chr(289),
        ) ;
        $content[] = array(
            'content_title'=>'10進位chr(52) 8進位chr(052) 16進位chr(0x52)',
            'content_value'=>chr(52).' '.chr(052).' '.chr(0x52),
        ) ;

        $ord_arr[] = ' ' ;
        $ord_arr[] = '.' ;
        $ord_arr[] = '-' ;
        $ord_arr[] = '_' ;
        foreach ($ord_arr as $value) {
            $ord = ord($value);
            $content[] = array(
                'content_title'=>"ord('".$value."')",
                'content_value'=>$ord.'(10) '.base_convert($ord,10,8).'(8) '.base_convert($ord,10,16).'(16)',
            ) ;
        }

        // 標題 內容顯示
        $data = array(
            'title'      => 'php chr()',
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

    public function strlen()
    {
        //$this->check_session();
        $post = $this->input->post();
        $str = isset($post['str']) ? $post['str'] : '' ;

        // tbody
        // 顯示資料
        $content = [];
        $content[] = [
            'content_title'=>'strlen',
            'content_value'=>strlen($str),
        ];
        $content[] = [
            'content_title'=>'mb_strlen',
            'content_value'=>mb_strlen($str),
        ];
        $content[] = [
            'content_title'=>'substr',
            'content_value'=>substr($str, 0, strlen($str)-1),
        ];
        $content[] = [
            'content_title'=>'mb_substr',
            'content_value'=>mb_substr($str, 0, mb_strlen($str)-1),
        ];
        $grid_view = $this->parser->parse('php_test/strlen_grid_view', array('content'=>$content), true);

        // 標題 內容顯示
        $data = array(
            'title' => 'strlen 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'grid_view' => $grid_view,
            'str'=> $str,
            'csrf_name' => $this->_csrf['csrf_name'],
            'csrf_value' => $this->_csrf['csrf_value'],
        );
        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('php_test/strlen_outer_view', $data, true);

        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $this->parser->parse('index_view', $html_date ) ;
    }
}
?>
