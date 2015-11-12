<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SESSION MODEL
 *
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
class Php_test_model extends CI_Model {
	public function query_hash_test($hash_key='',$page=1,$limit=20,$is_add=true)
	{
		$limit = intval($limit);
		$offset = (intval($page)-1)*$limit ;
		$offset = ($offset <0) ? 0 : $offset ;
		$total = 0 ;
		if( $hash_key!='' )
		{
			$sql = "SELECT * FROM `hash_test`  WHERE `hash_key`=?";
			$query = $this->db->query($sql,array($hash_key));
			$total = $query->num_rows() ;
		}
		else if( $offset!=0 || $limit!=20 )
		{
			$sql = "SELECT * FROM `hash_test` LIMIT ".$offset.",".$limit." ;";
			$query = $this->db->query($sql);
			$total = $this->get_hash_test_num() ;
		}
		else
		{
			$sql = "SELECT * FROM `hash_test` LIMIT 20 ;";
			$query = $this->db->query($sql);
			$total = $this->get_hash_test_num() ;
		}
		$total = is_array($total) ? $total[0]['total'] : $total ;
		if( $hash_key!='' && $total==0 )
		{
			if( $is_add )
			{
				$this->add_hash_test($hash_key);
			}
			else
			{
				return array('status'=>'101','data'=>array(),'total'=>0,'act'=>'query_hash_test',);
			}
		}
		else
		{
			return array('status'=>'100','data'=>$query->result_array(),'total'=>$total,'act'=>'query_hash_test',);
		}
	}
	public function query_hash_val($hash_val='',$hash_type='')
	{
		if( $hash_val!='' )
		{
			switch ($hash_type) {
				case 'md5r':
					$sql = "SELECT * FROM `hash_test`  WHERE `md5_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				case 'sha1':
					$sql = "SELECT * FROM `hash_test`  WHERE `sha1_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				case 'sha256':
					$sql = "SELECT * FROM `hash_test`  WHERE `sha256_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				case 'sha512':
					$sql = "SELECT * FROM `hash_test`  WHERE `sha512_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				default:
					$sql = "SELECT * FROM `hash_test`  WHERE `md5_var`=? OR `sha1_var`=? OR `sha256_var`=? OR `sha512_var`=? ";
					$query = $this->db->query($sql,array($hash_val,$hash_val,$hash_val,$hash_val));
					break;
			}
			return array('status'=>'100','data'=>$query->result_array(),'total'=>$query->num_rows(),'act'=>'query_hash_val',);
		}
		else
		{
			return array('status'=>'200','data'=>array(),'total'=>0,'act'=>'query_hash_val',);
		}
	}
	public function get_hash_test_num()
	{
		$sql = "SELECT count(`hash_key`) AS total  FROM `hash_test` ;";
		$query = $this->db->query($sql);
		return $query->result_array()[0]['total'] ;
	}
	public function add_hash_test($hash_key='')
	{
		$data = array();
		$total = 0;
		if( $hash_key!='' )
		{
			$input = array(
				'hash_key'=>$hash_key,
				'md5_var'=>md5($hash_key),
				'sha1_var'=>sha1($hash_key),
				'sha256_var'=>hash('sha256',$hash_key),
				'sha512_var'=>hash('sha512',$hash_key),
			);
			$result = $this->db->insert('hash_test', $input);
			if($result)
			{
				$status = 100 ;
				$data = $input;
				$total = 1;
			}
			else
			{
				$status = 300 ;
			}
		}
		else
		{
			$status = 200;
		}
		return array('status'=>$status,'data'=>$data,'total'=>$total,'act'=>'add_hash_test',);
	}
	public function query_user_agent($agent='',$is_add=true)
	{
		$data = array() ;
		$total = 0 ;
		$agent['O'] = isset($agent['O']) ? $agent['O'] : '' ;
		if( $agent['O']!='' )
		{
			$sql = "SELECT * FROM `user_agent`  WHERE `UA_id`=?";
			$query = $this->db->query($sql,array($agent['O'])) ;
			$data = $query->result_array() ;
			$data = count($data)==1 ? $data[0] : $data ;
			$total = $query->num_rows() ;
			$total = is_array($total) ? $total[0]['total'] : $total ;
			if( empty($total) )
			{
				$status = '101' ;
				if( $is_add )
				{
					$this->add_user_agent($agent) ;
				}
			}
			else
			{
				$status = '100' ;
				$mod_arr = array() ;
				$check_points = array(
					'agent_name' => 'A',
					'agent_version' => 'AN',
					'agent_type' => 'M',
					'agent_system' => 'S',
				);
				foreach ($check_points as $key=>$val )
				{
					if( !empty($data[$key]) && !empty($agent[$val]) && $data[$key]!=$agent[$val] )
					{
						$mod_arr[$key] = $agent[$val] ;
					}
					else if( empty($data[$key]) && !empty($agent[$val]) )
					{
						$mod_arr[$key] = $agent[$val] ;
					}
				}
				if( !empty($mod_arr) )
				{
					$mod_arr['UA_id'] = $data['UA_id'] ;
					$this->mod_user_agent($mod_arr) ;
				}
			}
		}
		else
		{
			$status = '200' ;
		}
		return array('status'=>$status,'data'=>$data,'total'=>$total,'act'=>'query_user_agent',);
	}
	/*
	$agent = array(
			"O" => UA_id,// 原始 HTTP_USER_AGENT
			"A" => agent_name,  // 瀏覽器 種類 IE/Firefox/Chrome/Safari/Opera
			"AN" => agent_version, // 瀏覽器 版本
			"M" => agent_type,  // 作業系統 Mobile/Desktop
			"S" => agent_system,  // 作業系統
		);
	 */
	public function add_user_agent($agent=array())
	{
		$data = array();
		$total = 0;
		if( isset($agent['O']) )
		{
			$input = array(
				'UA_id'=>$agent['O'],
				'agent_name'=>( isset($agent['A']) ? $agent['A'] : '' ),
				'agent_version'=>( isset($agent['AN']) ? $agent['AN'] : '' ),
				'agent_type'=>( isset($agent['M']) ? $agent['M'] : '' ),
				'agent_system'=>( isset($agent['S']) ? $agent['S'] : '' ),
			);
			$result = $this->db->insert('user_agent', $input);
			if($result)
			{
				$status = 100 ;
				$data = $input;
				$total = 1;
			}
			else
			{
				$status = 300 ;
			}
		}
		else
		{
			$status = 200 ;
		}
		return array('status'=>$status,'data'=>$data,'total'=>$total,'act'=>'add_user_agent',);
	}
	public function mod_user_agent($mod_arr)
	{
		$this->db->where('UA_id', $mod_arr['UA_id']);
		// CI 更新用法
		$result = $this->db->update('user_agent',$mod_arr);
	}
}
?>