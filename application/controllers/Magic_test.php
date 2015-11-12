<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/

class Magic_test extends CI_Controller {

	private $current_title = 'Magic Method 測試';
	private $page_list = array();
	private $_csrf = null ;

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

		$this->pub->check_login();

		$this->UserAgent = $this->pub->get_UserAgent() ;
		if( isset($this->UserAgent['O']) )
		{
			$this->load->model('php_test_model','',TRUE) ;
			$this->php_test_model->query_user_agent($this->UserAgent) ;
		}
	}

	// 取得標題
	public function getPageList()
	{
		echo json_encode($this->page_list);
	}

	// 測試
	public function index($method='')
	{
		if( empty($method) )
		{
			// 標題 內容顯示
			$data = array(
				'title'         	=> $this->current_title,
				'current_title' 	=> $this->current_title,
				'current_page'  	=> strtolower(__CLASS__), // 當下類別
				'current_fun'   	=> strtolower(__FUNCTION__), // 當下function
			);
			$data = array_merge($data,$this->_csrf);
			$data['content_div'] = $data['current_page'].'/'.$data['current_fun']. "<br>===================<br>";
			$data['content_div'] .= '<a href="'.base_url($data['current_page'].'/'.$data['current_fun'].'/test').'">test</a>' ;
			$view = $this->parser->parse('index_view', $data, true);
			$this->pub->remove_view_space($view);
		}
		else
		{
			$this->$method();
		}
	}

	public function __call($name, $arguments)
	{
		// 標題 內容顯示
		$data = array(
			'title'         	=> $this->current_title,
			'current_title' 	=> $this->current_title,
			'current_page'  	=> strtolower(__CLASS__), // 當下類別
			'current_fun'   	=> strtolower(__FUNCTION__), // 當下function
		);
		$data = array_merge($data,$this->_csrf);
		$data['content_div'] = $data['current_page'].'/'.$data['current_fun']. "<br>===================<br>";
		// 注意: $name 的值区分大小写
		$data['content_div'] .= "Calling object method '$name' ". implode(', ', $arguments). "<br>";
		$view = $this->parser->parse('index_view', $data, true);
		$this->pub->remove_view_space($view);
	}

	//  PHP 5.3.0之后版本
	public static function __callStatic($name, $arguments)
	{
		echo __CLASS__.'/'.__FUNCTION__ ;
		echo '<br>===================<br>';
		// 注意: $name 的值区分大小写
		echo "Calling static method '$name' ". implode(', ', $arguments). "<br>";
	}
}
?>