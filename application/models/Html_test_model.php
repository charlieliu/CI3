<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SESSION MODEL
 *
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
class Html_test_model extends CI_Model {

	function __construct()
	{
		// 呼叫模型(Model)的建構函數
		parent::__construct();
		$this->load->database();
	}

	public function query_browsers($str='',$version='')
	{
		if( empty($str) )
		{
			$sql = "SELECT * FROM `user_agent` WHERE 1=1 ORDER BY `agent_name`,`agent_version`,`agent_system` ;";
			$query = $this->db->query($sql) ;
		}
		else
		{
			//$str = addslashes($str) ;
			$sql = "SELECT * FROM `user_agent` WHERE `agent_name`=? OR `agent_version`=? OR `agent_system`=? OR `agent_type`=?  ORDER BY `agent_name`,`agent_version`,`agent_system` ;";
			$query = $this->db->query($sql,array($str,$str,$str,$str)) ;
		}
		$data = $query->result_array() ;
		$total = $query->num_rows() ;
		if( $version!='' )
		{
			$output = array() ;
			foreach ($data as $row)
			{
				if( strchr($row['agent_version'],$version) )
				{
					$output[] = $row ;
				}
			}
			$data = $output ;
			$total = count($data) ;
		}
		return array('data'=>$data,'total'=>$total,) ;
	}

	public function query_user_agent_num()
	{
		$sql = "SELECT COUNT(UA_id) AS total FROM `user_agent` ;";
		$query = $this->db->query($sql) ;
		$data = $query->result_array() ;
		return $data[0]['total'] ;
	}
}
?>