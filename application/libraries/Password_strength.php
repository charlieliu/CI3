<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password_strength {

	public $min_length = 6 ;

	public function __construct()
	{
	}

	public function get_salt()
	{
		$num = rand(14776336,9999999) ;
		$output = '' ;
		if( $num>0 )
		{
			$apha = array(
				'1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
				'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p',
				'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
				'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l',
				'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',
				'z', 'x', 'c', 'v', 'b', 'n', 'm',
				'Z', 'X', 'C', 'V', 'B', 'N', 'M',
			);
			$count_apha = count($apha) ;
			do{
				$num2str = $num%$count_apha ;
				$str = $apha[$num2str] ;
				$output = $str.$output ;
				$num = floor($num/$count_apha) ;
			}while( $num>0 );
		}
		return str_shuffle($output.rand(101,999)) ;
	}

	public function set_min_length($num=6)
	{
		$this->min_length = intval($num) ;
	}

	public function check_strength($pw,$chk_ary=array())
	{
		$len = $this->min_length-1 ;

		if( strlen($pw)<$this->min_length ) return 0 ;
		if( !empty($chk_ary) && is_array($chk_ary) )
		{
			foreach ($chk_ary as $val)
			{
				if( $val==$pw )
				{
					return 0 ;
				}
			}
		}

		$modes = 0 ;
		for ($i=0; $i<strlen($pw); $i++)
		{
			$modes |= $this->_CharMode( ord(substr($pw,$i,1)) ) ;
		}
		return $this->_bitTotal($modes) ;
	}

	private function _CharMode($in)
	{
		if( $in>=48 && $in<=57 )
		{
			// numbers
			return 1 ;
		}
		else if( $in>=65 && $in<=90 )
		{
			// 大寫
			return 2 ;
		}
		else if( $in>=97 && $in<=122 )
		{
			// 小寫
			return 4 ;
		}
		else
		{
			// others
			return 8 ;
		}
	}

	private function _bitTotal($num)
	{
		$modes = 0 ;
		for ($i=0; $i<4 ; $i++)
		{
			if( $num & 1 ) $modes++ ;
			$num >>= 1 ;
		}
		return $modes ;
	}
}
?>