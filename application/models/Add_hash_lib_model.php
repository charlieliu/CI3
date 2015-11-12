<?php
set_time_limit ( 604800 );
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SESSION MODEL
 *
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
class Add_hash_lib_model extends Base_model {
	public function query_hash_test($hash_key='',$page=1,$limit=20,$is_add=true)
	{
		$limit = intval($limit);
		$offset = (intval($page)-1)*$limit ;
		$offset = ($offset <0) ? 0 : $offset ;
		$total = 0 ;
		if( $hash_key!='' )
		{
			$sql = "SELECT * FROM `rainbowtable`  WHERE `pwd`=?";
			$query = $this->db->query($sql,array($hash_key));
			$total = $query->num_rows() ;
		}
		else if( $offset!=0 || $limit!=20 )
		{
			$sql = "SELECT * FROM `rainbowtable` LIMIT ".$offset.",".$limit." ;";
			$query = $this->db->query($sql);
			$total = $this->get_hash_test_num() ;
		}
		else
		{
			$sql = "SELECT * FROM `rainbowtable` LIMIT 20 ;";
			$query = $this->db->query($sql);
			$total = $this->get_hash_test_num() ;
		}
		$total = is_array($total) ? $total[0]['total'] : $total ;
		if( $hash_key!='' && $total==0 )
		{
			if( $is_add )
			{
				return $this->add_hash_test($hash_key);
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
					$sql = "SELECT * FROM `rainbowtable`  WHERE `md5_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				case 'sha1':
					$sql = "SELECT * FROM `rainbowtable`  WHERE `sha1_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				case 'sha256':
					$sql = "SELECT * FROM `rainbowtable`  WHERE `sha256_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				case 'sha512':
					$sql = "SELECT * FROM `rainbowtable`  WHERE `sha512_var`=?";
					$query = $this->db->query($sql,array($hash_val));
					break;
				default:
					$sql = "SELECT * FROM `rainbowtable`  WHERE `md5_var`=? OR `sha1_var`=? OR `sha256_var`=? OR `sha512_var`=? ";
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
		$sql = "SELECT count(`pwd`) AS total  FROM `rainbowtable` ;";
		$query = $this->db->query($sql);
		$data = $query->result_array() ;
		return $data[0]['total'] ;
	}
	public function add_hash_test($hash_key='')
	{
		$data = array();
		$total = 0;
		if( $hash_key!='' )
		{
			$input = array(
				'pwd'=>$hash_key,
				'md5_var'=>md5($hash_key),
				'sha1_var'=>sha1($hash_key),
				'sha256_var'=>hash('sha256',$hash_key),
				'sha512_var'=>hash('sha512',$hash_key),
			);
			$result = $this->db->insert('rainbowtable', $input);
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

	public function add_hash_redis($hash_key='')
	{
		if( $hash_key!='' )
		{
			$this->load->library('redis') ;
			$status = '100' ;
			$result['pwd'] = $this->redis->sadd('pwd', $hash_key) ;
			$result['md5'] = $this->redis->set(('md5:'.$hash_key.':pwd'), md5($hash_key)) ;
			$result['sha1'] = $this->redis->set(('sha1:'.$hash_key.':pwd'), sha1($hash_key)) ;
			$result['sha256'] = $this->redis->set(('sha256:'.$hash_key.':pwd'), hash('sha256',$hash_key)) ;
			$result['sha512'] = $this->redis->set(('sha512:'.$hash_key.':pwd'), hash('sha512',$hash_key)) ;
		}
		else
		{
			$status = '200' ;
			$result = '' ;
		}
		return array('status'=>$status,'result'=>$result,'act'=>'add_hash_redis',);
	}
}
?>