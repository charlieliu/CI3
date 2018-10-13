<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

class Lazada_test extends CI_Controller {

	public $current_title = 'PHP 測試';
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
		$now = new DateTime();
		$output_ary = array();
		$parameters = array(
			'Action'=>'GetDocument',
			'Format'=>'JSON',
			'Timestamp'=>$now->format(DateTime::ISO8601),
			'UserID'=>'rita.chen@uitox.com',
			'Version'=>'1.0',
			'Signature'=>'41eb8bdb041c0de7a6dbedc5f4bdcf5fcefd638e',
			'DocumentType'=>'invoice',//One of 'invoice', 'shippingLabel' or 'shippingParcel'
			'OrderItemIds'=>array(4554372,4554373),
		);
		ksort($parameters);
		foreach ($parameters as $key => $value)
		{
			$encode_val[] = rawurlencode($key).'='.rawurlencode($value);
			echo rawurlencode($key).'='.rawurlencode($value).'<br>';
		}
		$href_str = 'https://sellercenter-api.lazada.com.my/?'.implode('&', $encode_val);
		echo $href_str.'<br>';
		echo '<a href="'.$href_str.'" target="blank" >LAZADA INVOICE</a>';
	}
}
?>
