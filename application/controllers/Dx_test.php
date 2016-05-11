<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/
class Dx_test extends CI_Controller {

	private $current_title = 'DevExpress 測試';
	private $page_list = '';
	private $_csrf = null ;

	public $UserAgent = array() ;

	// 建構子
	public function __construct()
	{
		parent::__construct();

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
	}

	// 取得標題
	public function getPageList()
	{
		echo json_encode($this->page_list);
	}

	// 測試分類畫面
	public function index()
	{
		$html_date['title'] = $this->current_title;

		$html_date['js'][]['src'] = 'js/jquery-1.11.js';
		$html_date['js'][]['src'] = 'js/dx/globalize.min.js';
		$html_date['js'][]['src'] = 'js/dx/dx.chartjs.js';
		$html_date['js'][]['src'] = 'js/dx/chartjs.js';

		$view = $this->parser->parse('dx_test/index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}
}
?>