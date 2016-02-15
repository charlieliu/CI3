<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Continue_test extends CI_Controller {

	public $current_title = 'PHP Continue 測試';
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
	}

	/**
	 * @author Charlie Liu <liuchangli0107@gmail.com>
	 */
	public function index()
	{
		echo 'while & continue start<br>';
		$i = 1;
		while (true) { // 這裡看上去這個循環會一直執行
			if ($i==2) {// 2跳過不顯示
				$i++;
				continue;
			} else if ($i==5) {// 但到這裡$i=5就跳出循循環了
				break;
			} else {
				echo $i . '<br>';
			}
			$i++;
		}
		exit;
		echo 'while & continue end<br>';
	}
}
?>
