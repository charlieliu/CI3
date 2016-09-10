<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/
class Hash_test extends CI_Controller {

    private $current_title = '動態 Hash 測試';
    private $page_list = '';
    private $_csrf = null ;
    private $_md5_key2val = array() ;
    private $_md5_key2hash = array() ;
    private $_md5_val2hash = array() ;
    private $_md5_hash2key = array() ;
    private $_md5_hash2val = array() ;

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

        $this->_add_md5_list('hash_str','is_active') ;
        $this->_add_md5_list('hidden_text','is_owner') ;
    }

    // 取得標題
    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    // 測試分類畫面
    public function index()
    {
        // 標題 內容顯示
        $data = array(
            'title' => $this->current_title,
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
        );

        // Template parser class
        // 中間挖掉的部分
        $data['content_div'] = $this->_get_view($data);

        // 中間部分塞入外框
        //$html_date['js'][] = 'js/hash_test/hash_test.js';
        $view = $this->parser->parse('index_view', $data, true);
        $this->pub->remove_view_space($view);
    }

    public function report_post()
    {
        $post = $this->input->post() ;
        if( !empty($post) )
        {
            $output = array() ;
            $output['status'] = '100' ;
            foreach ($post as $key => $value)
            {
                if( isset($this->_md5_hash2key[$key]) && isset($this->_md5_hash2val[$value]) )
                {
                    $key = $this->_md5_hash2key[$key] ;
                    $value = $this->_md5_hash2val[$value] ;
                }
                else
                {
                    $output['status'] = '101' ;
                }
                $output[$key] = $value ;
            }
        }
        else
        {
            $output = array('status'=>'102') ;
        }
        echo json_encode($output) ;
    }

    public function get_url()
    {
        header('content-type: application/javascript') ;
        echo 'var URLs = "'.base_url().'hash_test/report_post"; ' ;
    }

    public function get_js()
    {
        header('content-type: application/javascript') ;
        echo '$(document).ready(function(){$("#btn_submit").click(function(){$("#btn_show").hide();$("#btn_disp").show();$.post(URLs,{' ;
        if( !empty($this->_md5_key2hash) )
        {
            foreach ($this->_md5_key2hash as $key => $hash)
            {
                echo '"'.$hash.'" : $("#'.$hash.'").val(),' ;
            }
        }
        echo '"'.$this->security->get_csrf_token_name().'" : $("#'.$this->security->get_csrf_token_name().'").val()' ;
        echo '},function(response){' ;
        echo 'alert(response.status);if(response.status="100"){$("#btn_show").show();$("#btn_disp").hide();}else{location.reload();};' ;
        echo '},"json");});});';
    }

    private function _add_md5_list($key='', $value='')
    {
        $hash_key = 'K'.substr(md5( $key.$this->security->get_csrf_hash() ), 0 , 11) ;
        $hash_val = 'V'.substr(md5( $value.$this->security->get_csrf_hash() ), 0 , 11) ;
        $this->_md5_key2val[$key] = $hash_val ;
        $this->_md5_key2hash[$key] = $hash_key ;
        $this->_md5_val2hash[$value] = $hash_val ;
        $this->_md5_hash2key[$hash_key] = $key ;
        $this->_md5_hash2val[$hash_val] = $value ;
    }

    private function _get_view($data)
    {
        $view = '<div id="body">' ;
        $view .= '<p>'.$data['current_page'].'/'.$data['current_fun'].'</p><form method="POST">' ;
        $view .= '<input type="text" id="'.$this->_md5_key2hash['hash_str'].'" value="'.$this->_md5_key2val['hash_str'].'">' ;
        $view .= '<input type="text" id="'.$this->_md5_key2hash['hidden_text'].'" value="'.$this->_md5_key2val['hidden_text'].'">' ;
        $view .= '<input type="hidden" id="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">' ;
        $view .= '<span id="btn_show"><input type="button" id="btn_submit" value="查詢"></span>' ;
        $view .= '<span id="btn_disp" style="display:none;">查詢.....</span>' ;
        $view .= '</form>' ;
        $view .= '<script type="text/javascript" src="'.base_url().'hash_test/get_url?v='.uniqid().'"></script>' ;
        $view .= '<script type="text/javascript" src="'.base_url().'hash_test/get_js?v='.uniqid().'"></script>' ;
        $view .= '</div>' ;
        return $view ;
    }

    public function random_pwds($length=16, $seed_type='default')
    {
        $content = array() ;
        for ($i=0; $i <100 ; $i++)
        {
            $content[] = $this->_generateRandomString($length,$seed_type) ;
        }

        // 標題 內容顯示
        $data = array(
            'title' => 'make pwds 測試('.htmlspecialchars($length).'/'.htmlspecialchars($seed_type).')',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
        );

        // Template parser class
        // 中間挖掉的部分
        $content_div = '<div id="body"><p>'.strtolower(__CLASS__).'/'.strtolower(__FUNCTION__).'</p><table>';
        foreach ($content as $key => $value)
        {
            $content_div .= '<tr class="content_block"><td>'.$key.'</td><td>'.htmlspecialchars($value).'</td></tr>';
        }
        $content_div .= '</table></div>';

        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    private function _generateRandomString($length=16, $seed_type='')
    {
        // lib
        switch ($seed_type)
        {
            case 'alpha':
                $characters = 'qwertyuiopasdfghjklzxcvbnm' ;
                break;
            case 'ALPHA':
                $characters = 'QWERTYUIOPASDFGHJKLZXCVBNM' ;
                break;
            case 'numbers':
                $characters = '1234567890' ;
                break;
            case 'keyboard':
                $characters = '~!@#$%^&*()_+`1234567890-=QWERTYUIOP{}|qwertyuiop[]\ASDFGHJKL:"asdfghjkl;'."'".'ZXCVBNM<>?zxcvbnm,./';
                break;
            default:
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#&_';
                break;
        };
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>