<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SESSION MODEL
 *
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
class Xhprof_model extends Base_model {
	public function query_log($run_id='', $set_name='',$remark_str='',$page=1,$limit=20,$is_add=TRUE)
	{
		$limit = intval($limit);
		$offset = (intval($page)-1)*$limit ;
		$offset = ($offset <0) ? 0 : $offset ;
		$total = 0 ;

		$sql = "SELECT * FROM `xhprof_log` WHERE 1 = 1 " ;
		$sql_ary = array() ;
		if( $run_id!='' )
		{
			$sql .= " AND `run_id`=?" ;
			$sql_ary[] = $run_id ;
		}
		if( $set_name!='' )
		{
			$sql .= " AND `set_name`=?" ;
			$sql_ary[] = $set_name ;
		}
		if( $remark_str!='' )
		{
			$sql .= " AND `remark_str`=?" ;
			$sql_ary[] = $remark_str ;
		}
		if( $run_id!='' ||  $set_name!='' || $remark_str!=''  )
		{
			$sql .= " ORDER BY `datetime` DESC LIMIT ".$offset.",".$limit.";";
			$query = $this->db->query($sql,$sql_ary);
		}
		else
		{
			$sql = "SELECT * FROM `xhprof_log` ORDER BY `datetime` DESC LIMIT ".$offset.",".$limit.";";
			$query = $this->db->query($sql);
		}
		/*
		if( $run_id!='' )
		{
			$sql = "SELECT * FROM `xhprof_log` WHERE `run_id`=? ORDER BY `datetime` DESC LIMIT ".$offset.",".$limit.";" ;
			$query = $this->db->query($sql,array($run_id));
			$sql_ary = array($run_id) ;
			$total = $query->num_rows() ;
		}
		else if( $run_id=='' &&  $set_name!='' && $remark_str!=''  )
		{
			$sql = "SELECT * FROM `xhprof_log` WHERE `set_name`=? AND `remark_str`=? ORDER BY `datetime` DESC LIMIT ".$offset.",".$limit.";" ;
			$query = $this->db->query($sql,array($set_name,$remark_str));
			$sql_ary = array($set_name,$remark_str) ;
			$total = $query->num_rows() ;
			//var_dump($total);exit;
		}
		*/
		$total = $query->num_rows() ;
		$total = is_array($total) ? $total[0]['total'] : $total ;

		if( count($sql_ary)>0 && $total==0 )
		{
			if( $is_add )
			{
				return $this->add_xhprof_log($run_id, $set_name, $remark_str) ;
			}
			else
			{
				return array('status'=>'101','data'=>array(),'total'=>0,'act'=>__FUNCTION__,'sql'=>$sql,'sql_ary'=>$sql_ary);
			}
		}
		else
		{
			return array('status'=>'100','data'=>$query->result_array(),'total'=>$total,'act'=>__FUNCTION__,'sql'=>$sql,'sql_ary'=>$sql_ary);
		}
	}

	public function add_xhprof_log($run_id='', $set_name='',$remark_str='')
	{
		$total = 0;
		$input = array(
			'run_id'=>$run_id,
			'set_name'=>$set_name,
			'remark_str'=>$remark_str,
		);
		$file_name = '/var/log/xhprof/'.$run_id.'.'.$set_name.'.xhprof' ;
		if( file_exists($file_name) )
		{
			$result = $this->db->insert('xhprof_log', $input);
			if($result)
			{
				$status = 100 ;
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
		return array('status'=>$status,'input'=>$input,'total'=>$total,'act'=>__FUNCTION__,);
	}
}
?>