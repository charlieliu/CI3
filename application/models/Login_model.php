<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
require_once 'Base_Model.php' ;

class Login_model extends Base_model
{
	public function getUsers($input='')
	{
		if( !empty($input) )
		{
			//$sql = "SELECT * FROM user  WHERE `username`='".$input."'";
			//$query = $this->db->query($sql);
			$sql = 'SELECT * FROM user  WHERE `username`=? ;' ;
			$input = array($input);
			$query = $this->db->query($sql,$input);
			return array('data'=>$query->result_array(),'total'=>$query->num_rows());
		}
		else
		{
			return array('data'=>array(),'total'=>0);
		}
	}

	public function insUsers($input=array())
	{
		if( $input['username']=='' )
		{
			return 201;
		}
		else if( $input['password']=='' )
		{
			return 202;
		}
		else if( empty($input['email']) )
		{
			return 203;
		}
		else if( empty($input['addr']) )
		{
			return 204;
		}
		else
		{
			$dt = new DateTime();
			$dt = $dt->format('U');
			$data = array(
				'username'=>$input['username'],
				'salt'=>$input['salt'],
				'password'=>$input['password'],
				'email'=>$input['email'],
				'add_date'=>$dt,
				'login_date'=>'',
				'addr'=>$input['addr'],
			);
			$this->db->trans_start() ;
			$result = $this->db->insert('user', $data) ;
			$this->db->trans_complete() ;
			if( $result )
			{
				return 100;
			}
			else
			{
				return 300;
			}
		}
	}

	public function updateUsers($input='')
	{
		if( empty($input) )
		{
			return 200;
		}
		else
		{
			$dt = new DateTime();
			$dt = $dt->format('U');
			$this->db->set('login_date', $dt, false);// 強制CI不處理
			if( isset($_COOKIE['ci_session']) && preg_match('/^[A-Za-z0-9_]+$/', $_COOKIE['ci_session']) )
			{
				$this->db->set('login_id', $_COOKIE['ci_session']);// 強制CI不處理
			}
			$this->db->where('uid', $input);
			$this->db->trans_start();
			$result = $this->db->update('user');// CI 更新用法
			$this->db->trans_complete();
			if( $result )
			{
				return 100;
			}
			else
			{
				return 300;
			}
		}
	}
}
?>