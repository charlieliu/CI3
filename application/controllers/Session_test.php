<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_test extends CI_Controller {

    public $current_title = 'Session 測試';
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
        $this->load->helper(['form','url','test']);

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        // 顯示資料
        $content = [];
        $content[] = [
            'content_title' => 'Session 測試',
            'content_url' => strtolower(__CLASS__).'/show_info',
        ];

        $this->page_list = $content ;
    }

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function index()
    {
        //$this->check_session();

        $content = $this->page_list ;

        // 標題 內容顯示
        $data = array(
            'title' => 'Session 測試',
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

    public function show_info()
    {
        // ci_sessions
        $ci_sessions = $this->session->userdata() ;
        $ci_sessions['CI_VERSION'] = CI_VERSION ;

        // 顯示資料
        $content = array() ;

        $content[] = array(
            'content_title' => 'csrf token',
            'content_value' => my_str_replace(print_r($this->_csrf,true))
        ) ;

        $content[] = array(
            'content_title' => 'ci_sessions',
            'content_value' => my_str_replace(print_r($ci_sessions,true))
        ) ;

        $_cookies = array() ;
        foreach ($_COOKIE as $key => $value)
        {
            $_cookies[htmlspecialchars($key)] = htmlspecialchars($value) ;
        }
        $content[] = array(
            'content_title' => '$_COOKIE',
            'content_value' => my_str_replace(print_r($_cookies,true))
        ) ;

        $content[] = array(
            'content_title' => '$_SESSION',
            'content_value' => my_str_replace(print_r($_SESSION,true))
        ) ;

        $_servers = array() ;
        foreach ($_SERVER as $key => $value) {
            $_servers[htmlspecialchars($key)] = htmlspecialchars($value) ;
        }
        $content[] = array(
            'content_title' => '$_SERVER',
            'content_value' => my_str_replace(print_r($_servers,true))
        ) ;

        $ip_check = array() ;
        $ip_check['HTTP_CLIENT_IP'] = !empty($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : 'error : empty' ;
        $ip_check['HTTP_X_FORWARDED_FOR'] = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 'error : empty' ;
        $ip_check['HTTP_X_CLIENT_IP'] = !empty($_SERVER['HTTP_X_CLIENT_IP']) ? $_SERVER['HTTP_X_CLIENT_IP'] : 'error : empty' ;
        $ip_check['HTTP_X_CLUSTER_CLIENT_IP'] = !empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) ? $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] : 'error : empty' ;
        $ip_check['REMOTE_ADDR'] = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'error : empty' ;
        foreach ($ip_check as $key => $value) {
            $ip_check[$key] = htmlspecialchars($value) ;
        }
        $content[] = array(
            'content_title' => '$ip_check',
            'content_value' => my_str_replace(print_r($ip_check,true))
        ) ;

        // 標題 內容顯示
        $data = array(
            'title' => '顯示',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => $content,
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('php_test/test_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }
 /*
    public function check_session()
    {
        $post = $this->input->post();
        $post = $this->pub->trim_val($post);
        $session_id = !empty($post['session_id']) ? $post['session_id'] : $this->session->userdata('session_id') ;
        $ip_address = !empty($post['ip_address']) ? $post['ip_address'] : $_SERVER['REMOTE_ADDR'] ;
        $user_agent = !empty($post['user_agent']) ? $post['user_agent'] : $_SERVER['HTTP_USER_AGENT'] ;

        // check points
        if( empty($session_id) )
        {
            exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/HTTP_USER_AGENT');// session id
        }
        else if( empty($user_agent) )
        {
            exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/HTTP_USER_AGENT');// browser info
        }
        else if( empty($ip_address) )
        {
            exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/REMOTE_ADDR');// ip address
        }
        else
        {
            $this->load->model('session_test_model','',TRUE);

            // 2分鐘內 session 失效
            $del = $this->session_test_model->del_session_info();
            if( $del['status']!=100 )
            {
                exit('del_session_info :'.$del['status']);
            }
            else
            {
                //echo "LINE : ".__LINE__." del session error<br>";
            }

            // 取得 session 資訊
            $SESSION_LOGS = $this->get_session_info($session_id);
            $total = intval($SESSION_LOGS['total']);
            $data = !empty($SESSION_LOGS['data']) ? $SESSION_LOGS['data'] : '' ;

            if( $total>1 )
            {
                exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/get_session_info :'.$SESSION_LOGS['total']);
            }
            else if( $total<1 )
            {
                if( empty($session_id) )
                {
                    exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/$session_id = '.json_encode($session_id));
                }
                // 新增 session
                $data = $this->_add_session_info($session_id,$post);
            }
            else
            {
                if( empty($data) )
                {
                    exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/data empty');
                }
                else
                {
                    if( empty($data['IP_ADDRESS']) )
                    {
                        $this->session->sess_destroy();// 銷毀Session
                        exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/IP_ADDRESS empty');
                    }
                    else if( $data['IP_ADDRESS']!=$ip_address )
                    {
                        $this->session->sess_destroy();// 銷毀Session
                        exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/IP_ADDRESS');
                    }
                    else if( empty($data['USER_AGENT']) )
                    {
                        $this->session->sess_destroy();// 銷毀Session
                        exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/USER_AGENT empty');
                    }
                    else if( $data['USER_AGENT']!=$user_agent )
                    {
                        $this->session->sess_destroy();// 銷毀Session
                        exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'<br>/USER_AGENT : '.$data['USER_AGENT'].'<br>/POST user_agent : '.$user_agent);
                    }
                    // 更新 session
                    $data = $this->_mod_session_info($session_id);

                    if( $data['status']!=100 )
                    {
                        exit(__CLASS__.'/'.__FUNCTION__.'/LINE'.__LINE__.'/data = '.json_encode($data));
                    }
                }
            }

            if( !empty($post['session_id']) || !empty($post['ip_address']) || !empty($post['user_agent']) )
            {
                echo json_encode($data);
            }
            else if( $data['status']!=100 )
            {
                $data['data'] = __FUNCTION__.'/LINE'.__LINE__.' '.$data['data'] ;
                echo json_encode($data);
            }
            else
            {
                //echo json_encode($data);
            }
        }
    }

    private function _add_session_info($session_id='',$input=array())
    {
        if( empty($session_id) )
        {
            $status = 201;
            $data = __FUNCTION__.'/LINE '.__LINE__.' empty session_id';
        }
        else if( empty($input) || !is_array($input) )
        {
            $status = 202;
            $data = __FUNCTION__.'/LINE '.__LINE__.' empty input';
        }
        else
        {
            $add = $this->session_test_model->add_session_info($session_id,$input);
            if( intval($add['status'])!=100 )
            {
                $status = intval($add['status']);
                $data = $add['data'];
            }
            else
            {
                $SESSION_LOGS = $this->get_session_info($session_id);
                $status = ( intval($SESSION_LOGS['total'])==1 ) ? 100 : 101 ;
                $data = !empty($SESSION_LOGS['data']) ? $SESSION_LOGS['data'] : array() ;
            }
        }

        if( empty($data) )
        {
            $data = __FUNCTION__.'/LINE '.__LINE__.' empty data';
        }

        return array('status'=>$status,'data'=>$data);
    }

    private function _mod_session_info($session_id='')
    {
        if( empty($session_id) )
        {
            $status = 201;
            $data = __FUNCTION__.'/LINE '.__LINE__.' empty session_id';
        }
        else
        {
            $mod = $this->session_test_model->mod_session_info($session_id);
            if( intval($mod['status'])!=100 )
            {
                $status = intval($mod['status']);
                $data = $mod['data'];
            }
            else
            {
                $SESSION_LOGS = $this->get_session_info($session_id);
                $status = ( intval($SESSION_LOGS['total'])==1 ) ? 100 : 101 ;
                $data = !empty($SESSION_LOGS['data']) ? $SESSION_LOGS['data'] : array() ;
            }
        }
        if( empty($data) )
        {
            $data = __FUNCTION__.'/LINE '.__LINE__.' empty data';
        }
        return array('status'=>$status,'data'=>$data);
    }

    public function sess_destroy()
    {
        $this->session->sess_destroy();// 銷毀Session
    }

    public function get_session_info($session_id)
    {
        $this->load->model('session_test_model','',TRUE);
        $info = $this->session_test_model->get_session_info($session_id);
        if( $info['total']<1 )
        {
            $data = array();
        }
        else
        {
            //$data = $this->pub->o2a($info['data'][0]);
            $data = $info['data'][0];
        }
        return array('data'=>$data,'total'=>$info['total']);
    }
*/
}
?>
