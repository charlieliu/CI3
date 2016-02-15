<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preg_replace_test extends CI_Controller {

	public $current_title = 'PHP Preg_replace 測試';
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
		/*
		$$string = 'April 15, 2003';
		$pattern = '/(\w+) (\d+), (\d+)/i';
		$replacement = '${1}1,$3';
		echo preg_replace($pattern, $replacement, $string);
		*/
		/*
		$patterns = array (
			'/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/',
			'/^\s*{(\w+)}\s*=/');
		$replace = array ('\3/\4/\1\2', '$\1 =');
		echo preg_replace($patterns, $replace, '{startDate} = 1999-5-27');
		*/
		$ary['test'] = '123';
		$ary['DT1'] = '1999/05/27T12:34:56Z';
		$ary['q'] = 'AND ';
		$ary['DT2'] = '2015/12/16T08:00:00Z';
		$ary['asdf'] = '456';
		var_dump($ary);

		echo "<br><br><br><br><br><br>";
		$string = json_encode($ary);
		$preg_string = preg_replace('/(\d{4})\x{005c}\x{002f}(\d{1,2})\x{005c}\x{002f}(\d{1,2})T(\d{1,2}):(\d{1,2}):(\d{1,2})Z/', '${1}\/${2}\/${3} ${4}:${5}:${6}', $string);
		echo $preg_string;
		echo "<br><br><br><br><br><br>";
		var_dump(json_decode($preg_string));

		echo "<br><br><br><br><br><br>";
		$preg_string = preg_replace('/(\d{4})\x{005c}\x{002f}(\d{1,2})\x{005c}\x{002f}(\d{1,2})\x{0020}(\d{1,2}):(\d{1,2}):(\d{1,2})/', '${1}\/${2}\/${3}T${4}:${5}:${6}Z', $string);
		echo $preg_string;
		echo "<br><br><br><br><br><br>";
		var_dump(json_decode($preg_string));
	}
}
?>
