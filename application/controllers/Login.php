<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public $current_title = 'Login 測試';
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
		$this->load->library(array('parser','session', 'pub','password_strength'));
		$this->load->helper(array('form', 'url'));
		//$this->pub->check_session($this->session->userdata('session_id'));
		$this->load->model('php_test_model','',TRUE) ;

		$this->UserAgent = $this->pub->get_UserAgent() ;
		if( isset($this->UserAgent['O']) )
		{
			$this->php_test_model->query_user_agent($this->UserAgent) ;
		}
	}

	/**
	 * @author Charlie Liu <liuchangli0107@gmail.com>
	 */
	public function index()
	{
		$this->login();
	}

	public function login()
	{
		// 標題 內容顯示
		$data = array(
			'title'         	=> $this->current_title,
			'current_title' 	=> $this->current_title,
			'current_page'  	=> strtolower(__CLASS__), // 當下類別
			'current_fun'   	=> strtolower(__FUNCTION__), // 當下function
			'btn_value'     	=> 'login',
			'btn_url'       	=> 'check_login',
			'base_url'      	=> base_url(),
		);

		// Template parser class
		// 中間挖掉的部分
		$data = array_merge($data,$this->_csrf);
		$content_div = $this->parser->parse('login/login_view', $data, true);
		//exit($content_div);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;
		//$html_date['css'][] = 'css/bootstrap-3.2.0-dist/css/bootstrap.min.css';
		$html_date['js'][] = 'css/bootstrap-3.2.0-dist/js/bootstrap.min.js';
		//$html_date['js'][] = base_url().'login/get_url/login';
		$html_date['js'][] = 'js/login.js';

		$view = $this->parser->parse('index_view', $html_date, true);
		exit($view);
		$this->pub->remove_view_space($view);
	}

	public function check_login()
	{
		$post = $this->input->post();
		$post = $this->pub->trim_val($post);
		$status = '' ;

		if( empty($post['username']) )
		{
			$status = 201 ;
		}
		else if( !preg_match("/^[\x{4e00}-\x{9fa5}\w\.\-]+$/u", $post['username']) )
		{
			$status = 202 ;
		}
		else if( empty($post['pwd']) )
		{
			$status = 203 ;
		}
		else
		{
			$this->load->model('login_model','',TRUE);
			$users = $this->login_model->getUsers($post['username']);
			if( intval($users['total'])<1 )
			{
				$status = 101 ;
			}
			else if( intval($users['total'])==1 )
			{
				// check pwds
				$pwds_hash = md5($users['data'][0]['salt'].$post['pwd']) ;
				if( $pwds_hash!=$users['data'][0]['password'] )
				{
					$status = 102;
				}
				else if( empty($users['data'][0]['auth_type']) )
				{
					$status = 103;
				}
				else
				{
					$updateUsers = $this->login_model->updateUsers($users['data'][0]['uid']);

					$userdata = array(
						'uid'=>$users['data'][0]['uid'],
						'username'=>$users['data'][0]['username'],
						'updateUsers'=>$updateUsers,
					);
					$this->session->set_userdata($userdata);

					if( isset($_COOKIE['ci_session']) )
					{
						$status = 200;
					}
					else
					{
						$status = 100;
					}
				}
			}
			else
			{
				$status = 104;
			}
		}

		if( !empty($post) )
		{
			$output_ary = array_merge(array('status'=>$status,),$post) ;
		}
		else
		{
			$output_ary = array('status'=>$status) ;
		}
		echo json_encode($output_ary);
	}

	public function register()
	{
		// 標題 內容顯示
		$data = array(
			'title' => '註冊 測試',
			'current_title' => $this->current_title,
			'current_page'  => strtolower(__CLASS__), // 當下類別
			'current_fun'   => strtolower(__FUNCTION__), // 當下function
			'btn_value'     => 'create',
			'btn_url'       => 'do_register',
			'base_url'      => base_url(),
		);

		// Template parser class
		// 中間挖掉的部分
		$data = array_merge($data,$this->_csrf);
		$content_div = $this->parser->parse('login/register_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;
		$html_date['js'][] = 'js/jquery.form.js';
		$html_date['js'][] = 'js/register.js';

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function do_register()
	{
		$post = $this->input->post();
		$post = $this->pub->trim_val($post);
		if( empty($post['username']) )
		{
			$status = 'name is empty';
		}
		else if( !preg_match("/^[\x{4e00}-\x{9fa5}\w\.\-]+$/u", $post['username']) )
		{
			$status = 'name 限用中英文數字_.-';
		}
		else if( !isset($post['pwd']) )
		{
			$status = 'pwd is empty';
		}
		else if( empty($post['repwd']) )
		{
			$status = 'repwd is empty';
		}
		else if( $post['pwd']!=$post['repwd'] )
		{
			$status = 'pwd and repwd is different';
		}
		else if( empty($post['email']) )
		{
			$status = 'email is empty';
		}
		else if( !preg_match("/^(\w|\.|\+|\-)+@(\w|\-)+\.(\w|\.|\-)+$/", $post['email']) )
		{
			$status = 'email address error';
		}
		else if( empty($post['addr']) )
		{
			$status = 'address is empty';
		}
		else
		{
			$pwd_level = $this->password_strength->check_strength($post['pwd']) ;
			if( $pwd_level<=2 )
			{
				$status = '密碼強度不足';
			}
			else
			{
				$this->load->model('login_model','',TRUE);
				$content = $this->login_model->getUsers($post['username']);
				if( $content['total']>0 )
				{
					$status = 'username has be used';
				}
				else
				{
					//$salt = rand(101,999);
					$salt = $this->password_strength->get_salt() ;
					$data = array(
						'username'=>$post['username'],
						'salt'=>$salt,
						'password'=>md5($salt.$post['pwd']),
						'email'=>$post['email'],
						'addr'=>$post['addr'],
					);
					$status = $this->login_model->insUsers($data);
				}
			}
		}

		if( !empty($post) )
		{
			$output_ary = array_merge(array('status'=>$status,),$post) ;
		}
		else
		{
			$output_ary = array('status'=>$status) ;
		}
		echo json_encode($output_ary);
	}

	public function get_url($tag='')
	{
		header('content-type: application/javascript') ;
		echo 'var IndexURLs = "'.base_url().'";' ;
		switch ($tag) {
			case 'login':
				echo 'var URLs = "'.base_url().'login/check_login";' ;
				break;
			case 'register':
				echo 'var URLs = "'.base_url().'login/do_register";' ;
				break;
			default:
				echo 'var URLs = "'.base_url().'";' ;
				break;
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		header('Location: '.base_url()) ;
	}
}
?>
