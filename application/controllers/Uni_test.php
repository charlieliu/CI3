<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uni_test extends CI_Controller {

	public $current_title = '統一編號 測試';
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
		$content = array();
		$content[] = array(
			'content_title' => '統一編號 測試',
			'content_url' => 'uni_test/tw_uni',
		) ;

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
			'title' => '統一編號 測試',
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

	public function tw_uni()
	{
		// 標題 內容顯示
		$data = array(
			'title' => '運算公式',
			'current_title' => $this->current_title,
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			// 'content' => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('uni_test/uni_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}
}
?>
