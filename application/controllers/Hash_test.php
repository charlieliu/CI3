<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/
class Hash_test extends CI_Controller {

	private $current_title = '動態 Hash 測試';
	private $page_list = '';
	private $_csrf = null ;
	private $_md5_key = array() ;
	private $_md5_val = array() ;

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
		$this->load->library(array('parser','session', 'pub'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('php_test_model','',TRUE) ;

		$this->UserAgent = $this->pub->get_UserAgent() ;
		if( isset($this->UserAgent['O']) )
		{
			$this->php_test_model->query_user_agent($this->UserAgent) ;
		}

		$this->_add_md5_list('hash_str','is_active') ;
		$this->_add_md5_list('hidden_text','is_owner','H') ;
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
			'base_url' => base_url(),
			'version' => date('YmdHis'),
		);
		$data = array_merge($data, $this->_csrf) ;
		$data = array_merge($data, $this->_md5_key) ;

		// Template parser class
		// 中間挖掉的部分
		$data['content_div'] = $this->parser->parse('hash_test/hash_test_view', $data, true);

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
			$output = array('status'=>'101') ;
			foreach ($post as $key => $value)
			{
				if( isset($this->_md5_val[$key]) )
				{
					$key = $this->_md5_val[$key] ;
					$output['status'] = '100' ;
					$output[$key] = $value ;
				}
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
		if( !empty($this->_md5_key) )
		{
			foreach ($this->_md5_key as $key => $value)
			{
				echo '"'.$value.'" : $("#'.$value.'").val(),' ;
			}
		}
		echo '"csrf_test_name" : $("#csrf_test_name").val()' ;
		echo '},function(response){' ;
		echo 'alert(response.status);if(response.status="100"){$("#btn_show").show();$("#btn_disp").hide();}else{location.reload();};' ;
		echo '},"json");});});';
	}

	private function _add_md5_list($key='', $value='',$head='T')
	{
		$hash_val = $head.substr(md5( $value.$this->session->userdata('session_id') ), 0 , 11) ;
		$this->_md5_key[$key] = $hash_val ;
		$this->_md5_val[$hash_val] = $value ;
	}
}
?>