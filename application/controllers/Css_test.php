<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Css_test extends CI_Controller {

	public $current_title = 'CSS 測試';

	public $page_list = '';

	public $UserAgent = array() ;

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
		// load parser
		//$this->load->library(array('parser','session', 'pub'));
		$this->load->helper(array('form', 'url'));
		//$this->pub->check_session($this->session->userdata('session_id'));
		$this->load->model('php_test_model','',TRUE) ;

		$this->pub->check_login();

		$this->UserAgent = $this->pub->get_UserAgent() ;
		if( isset($this->UserAgent['O']) )
		{
			$this->php_test_model->query_user_agent($this->UserAgent) ;
		}

		// 顯示資料
		$content = array();
		$content[] = array(
			'content_title' => '轉圈圈',
			'content_url' => 'css_test/css_test_1'
		);
		$content[] = array(
			'content_title' => '用CSS反轉',
			'content_url' => 'css_test/css_test_2'
		);
		$content[] = array(
			'content_title' => '用 CSS3 做表單',
			'content_url' => 'css_test/css_test_3'
		);
		$content[] = array(
			'content_title' => '用 CSS3 做畫廊',
			'content_url' => 'css_test/css_test_4'
		);
		$content[] = array(
			'content_title' => 'CSS3 2D Transforms',
			'content_url' => 'css_test/css_test_5'
		);
		$content[] = array(
			'content_title' => 'CSS+JQuery 翻轉',
			'content_url' => 'css_test/css_test_6'
		);

		$this->page_list = $content ;
	}

	/**
	 * Floating-point test Page for this controller.
	 *
	 * @author Charlie Liu <liuchangli0107@gmail.com>
	 */
	public function index()
	{
		$content = $this->page_list ;

		// 標題 內容顯示
		$data = array(
			'title' => 'CSS 測試',
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

	public function css_test_1()
	{
		// 標題 內容顯示
		$data = array(
			'title' => '轉圈圈',
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'current_title' => $this->current_title,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('css_test/css_test_1_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function css_test_2()
	{
		// load parser
		$this->load->library('parser');

		$content = array() ;

		for($i=0;$i<10;$i++)
		{
			$content[]['ol_li'] = $i+1 ;
		}

		// 標題 內容顯示
		$data = array(
			'title' => '用CSS反轉',
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'current_title' => $this->current_title,
			'content' => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('css_test/css_test_2_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function css_test_3()
	{
		// 標題 內容顯示
		$data = array(
			'title' => '用 CSS3 做表單',
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'current_title' => $this->current_title,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('css_test/css_test_3_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;
		$html_date['css'][] = 'css/css_test_3.css' ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function css_test_4()
	{
		// 標題 內容顯示
		$data = array(
			'title' => '用 CSS3 做畫廊',
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'current_title' => $this->current_title,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('css_test/css_test_4_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function css_test_5()
	{
		// 標題 內容顯示
		$data = array(
			'title' => 'CSS3 2D Transforms',
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'current_title' => $this->current_title,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('css_test/css_test_5_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;
		$html_date['css'][] = 'css/css_test_5.css' ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function css_test_6()
	{
		// 標題 內容顯示
		$data = array(
			'title' => 'CSS+JQuery 翻轉',
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'current_title' => $this->current_title,
			'base_url'=>base_url(),
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('css_test/css_test_6_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;
		$html_date['css'][] = 'css/css_test_6.css' ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}
}
?>