<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
class Base_Model extends CI_Model
{
	// 建構子
	function __construct()
	{
		// 呼叫模型(Model)的建構函數
		parent::__construct();
		$this->load->database();
	}
	// 解構子
	function __destruct()
	{
		$this->db->close();
	}
}
?>