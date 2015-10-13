<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pub{
	public function CurlPost($postURL='', $postdata='')
	{
		if( empty($postURL) )
		{
			$result = 'empty postURL';
		}
		else if( empty($postdata) )
		{
			$result = 'empty postdata';
		}
		else
		{
			$ch = curl_init();// create a new cURL resource
			curl_setopt($ch, CURLOPT_URL, $postURL);// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			if( !empty($_SERVER["HTTP_USER_AGENT"]) )
			{
				curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);

			$result = curl_exec($ch);// grab URL and pass it to the browser
			curl_close($ch);// close cURL resource, and free up system resources
		}
		return $result;
	}

	public function check_session($session_id='')
	{
		if( empty($_SERVER["HTTP_USER_AGENT"]) )
		{
			exit(201);
		}
		else if( empty($_SERVER["REMOTE_ADDR"]) )
		{
			exit(202);
		}
		else if( empty($session_id) )
		{
			exit(203);
		}
		else if( preg_match("/^[\'\"\<]+$/u", $_SERVER["HTTP_USER_AGENT"]) )
		{
			exit(204);
		}
		else if( !preg_match("/^[\w\.]+$/u", $_SERVER["REMOTE_ADDR"]) )
		{
			exit(205);
		}
		else if( !preg_match("/^[\w]+$/u", $session_id) )
		{
			exit(206);
		}
		else
		{
			/*
			$url = base_url().'index.php?/php_test/check_session';
			//$url = base_url().'php_test/check_session';
			$data = array(
				'session_id'=>$session_id,
				'ip_address'=>$_SERVER["REMOTE_ADDR"],
				'user_agent'=>$_SERVER["HTTP_USER_AGENT"],
			);
			$data = json_decode($this->CurlPost($url,json_encode($data)));
			$data = $this->o2a($data);

			if( $data['status']!=100 )
			{
				var_dump($data);
				//exit();
				//echo '<script>alert("'.$data['status'].'");</script>';
			}
			*/
		}
	}

	public function trim_val($in_data)
	{
		$output = '' ;
		if( !empty($in_data) )
		{
			if( is_array($in_data) )
			{
				foreach ($in_data as $key=>$value)
				{
					$in_data[$key] = trim($value);
				}
				$output = $in_data;
			}
			else
			{
				$output = trim($in_data);
			}
		}
		else
		{
			$output = $in_data;
		}
		return $output ;
	}

	public function urldecode_val($in_data)
	{
		if( !empty($in_data) )
		{
			if( is_array($in_data) )
			{
				foreach ($in_data as $key=>$value) {
					$in_data[$key] = urldecode($value);
				}
				return $in_data;
			}
			else
			{
				return urldecode($in_data);
			}
		}
		else
		{
			return $in_data;
		}
	}

	public function utf8_decode_val($in_data)
	{
		if( !empty($in_data) )
		{
			if( is_array($in_data) )
			{
				foreach ($in_data as $key=>$value) {
					$in_data[$key] = utf8_decode($value);
				}
				return $in_data;
			}
			else
			{
				return utf8_decode($in_data);
			}
		}
		else
		{
			return $in_data;
		}
	}

	public function o2a($input)
	{
		if( is_array($input) )
		{
			foreach ($input as $key=>$value) {
				if( is_object($value) )
				{
					$input[$key] = get_object_vars($value);
				}
				else if( is_array($value) )
				{
					$input[$key] = $this->o2a($value);
				}
			}
			return $input;
		}
		else if( is_object($input) )
		{
			return get_object_vars($input);
		}
		else
		{
			return $input;
		}
	}

	public function n2nbsp($intv){
		$str = '';
		$num = intval($intv)>0 ? intval($intv) : 1 ;
		for( $i=0; $i < $num; $i++ ){
			$str .= '&nbsp;';
		}
		return $str;
	}

	public function remove_view_space($view){
		// 先將多個空白縮成一個
		while( stripos($view,'  ') )
		{
			$view = str_replace('  ', ' ', $view);
		}
		// 處理換行
		$order = array("\r\n", "\n", "\r", "￼",'
');
		$view = str_replace($order, '', $view);
		// 其他符號
		$view = str_replace('> <', '><', $view);
		$view = str_replace('" />', '"/>', $view);
		$view = str_replace('> ', '>', $view);
		$view = str_replace(' <', '<', $view);
		$view = str_replace(') {', '){', $view);
		echo $view;
	}

	public function str_replace($str){
		$order = array("\r\n", "\n", "\r", "￼", "<br />", "<br/>");
		$str = str_replace($order,"<br>",$str);// HTML5 寫法
		return $str;
	}

	public function str_to_ascii($str)
	{
		$encoded = '';
		$str = (string)$str ;
		if( mb_strlen($str,'utf-8')==1 )
		{
			// char change to ASCII code
			$ord = ord($str) ;
			$encoded .= '{'.$str.':'.$ord.'/'.str_pad(base_convert($ord,10,16),4,'0',STR_PAD_LEFT).'}';
		}
		else if( mb_strlen($str,'utf-8')>1 )
		{
			// string to array
			$str = $this->utf8Split($str);
			foreach ($str as $key => $value)
			{
				$ord = ord($value) ;
				$encoded .= ', {'.$value.':'.$ord.'/'.str_pad(base_convert($ord,10,16),4,'0',STR_PAD_LEFT).'}';
			}
			$encoded = substr($encoded,2);
		}

		return $encoded;
	}

	public function utf8Split($str, $len=1)
	{
		$arr = array();
		$strLen = mb_strlen($str, 'UTF-8');
		for( $i=0; $i<$strLen; $i++ )
		{
			$arr[] = mb_substr($str, $i, $len, 'UTF-8');
		}
		return $arr;
	}

	public function get_UserAgent()
	{
		// IE請參考
		// http://msdn.microsoft.com/en-us/library/ie/hh869301(v=vs.85).aspx

		$str = !empty($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '' ;
		return $this->check_UserAgent($str) ;
	}

	public function check_UserAgent($str)
	{
		$output = array(
			"O" => $str,// 原始 HTTP_USER_AGENT
			"A" => '',  // 瀏覽器 種類 IE/Firefox/Chrome/Safari/Opera
			"AN" => '', // 瀏覽器 版本
			"M" => '',  // 作業系統 Mobile/Desktop
			"S" => '',  // 作業系統
		);
		// 作業系統
		// iPad
			// Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25
		// Windows
			// chrome // Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36
			// Safari // Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2
			// Opera // Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36 OPR/29.0.1795.47
			// Firefox // Mozilla/5.0 (Windows NT 6.3; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0
		if( strpos($str,'Android') ){
			$output['M'] = 'Mobile';
			$output['S'] = 'Android';
		}
		else if( strpos($str,'BlackBerry')!==false )
		{
			$output['M'] = 'Mobile';
			$output['S'] = 'BlackBerry';
		}
		else if( strpos($str,'iPhone')!==false )
		{
			$output['M'] = 'Mobile';
			$output['S'] = 'iPhone';
		}
		else if( strpos($str,'ipod')!==false || strpos($str,'iPod')!==false )
		{
			$output['M'] = 'Mobile';
			$output['S'] = 'iPod';
		}
		else if( strpos($str,'ipad')!==false || strpos($str,'iPad')!==false )
		{
			$output['M'] = 'Mobile';
			$output['S'] = 'iPad';
		}
		else if( strpos($str,'Palm')!==false )
		{
			$output['M'] = 'Mobile';
			$output['S'] = 'Palm';
		}
		else if( strpos($str,'Linux')!==false )
		{
			$output['M'] = 'Desktop';
			$output['S'] = 'Linux';
		}
		else if( strpos($str,'Macintosh')!==false )
		{
			$output['M'] = 'Desktop';
			$output['S'] = 'Macintosh';
		}
		else if( strpos($str,'Windows')!==false )
		{
			$output['M'] = 'Desktop';
			$output['S'] = 'Windows';
		}

		// 瀏覽器
		if( strpos($str,"MSIE")!== false )
		{
			$output['A'] = "Internet Explorer";
		}
		else if( strpos($str,"PaleMoon")!== false )
		{
			$output['A'] = "PaleMoon";
		}
		else if( strpos($str,"Firefox")!== false )
		{
			$output['A'] = "Firefox";
		}
		else if( strpos($str,"Opera")!== false || strpos($str,"OPR")!== false )
		{
			$output['A'] = "Opera";
		}
		else if( strpos($str,"Chrome")!== false )
		{
			$output['A'] = "Chrome";
		}
		else if( strpos($str,"Arora")!== false )
		{
			$output['A'] = "Arora";
		}
		else if( strpos($str,"Midori")!== false )
		{
			$output['A'] = "Midori";
		}
		else if( strpos($str,"QupZilla")!== false )
		{
			$output['A'] = "QupZilla";
		}
		else if( strpos($str,"Epiphany")!== false )
		{
			$output['A'] = "Epiphany";
		}
		else if( strpos($str,"Sony")!== false )
		{
			$output['A'] = "Sony";
		}
		else if( strpos($str,"Safari")!== false )
		{
			$output['A'] = "Safari";
		}
		else if( strpos($str,"Konqueror")!== false )
		{
			$output['A'] = "Konqueror";
		}
		else if( strpos($str,"rv:")!== false &&  strpos($str,"Trident/")!== false )
		{
			$output['A'] = "Internet Explorer";
			$sit_0 = stripos($str,'rv:') + 3;
			$str = substr($str,$sit_0) ;
			$sit_1 = stripos($str,')') ;
			$output['AN'] = substr($str,0,$sit_1) ;
		}
		else if( strpos($str,"ELinks")!== false )
		{
			$output['A'] = "ELinks";
			$sit_0 = stripos($str,'ELinks/') + 7;
			$str = substr($str,$sit_0) ;
			$sit_1 = stripos($str,' (') ;
			$output['AN'] = substr($str,0,$sit_1) ;
		}
		else if( strpos($str,"Links")!== false )
		{
			$output['A'] = "Links";
			$sit_0 = stripos($str,'Links (') + 7;
			$str = substr($str,$sit_0) ;
			$sit_1 = stripos($str,'; Linux') ;
			$output['AN'] = substr($str,0,$sit_1) ;
		}
		else if( strpos($str,"Dillo")!== false )
		{
			$output['A'] = 'Dillo';
			$output['S'] = 'Linux';
			$output['M'] = 'Desktop';
		}
		else if( strpos($str,"Dooble")!== false )
		{
			$output['A'] = 'Dooble';
			$sit_0 = stripos($str,'Dooble/') + 7;
			$str = substr($str,$sit_0) ;
		}
		else if( strpos($str,"NetSurf")!== false )
		{
			$output['A'] = 'NetSurf';
			$sit_0 = stripos($str,'NetSurf/') + 8;
			$str = substr($str,$sit_0) ;
		}
		else if( strpos($str,"curl")!== false || strpos($str,"nmap")!== false )
		{
			$output['A'] = "Attack";
		}
		else
		{
			$output['A'] = '';
		}

		//Mozilla/5.0 (Linux; U; Android 4.1.2; zh-tw; SonyLT26w Build/6.2.B.1.96) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30
		//Mozilla/5.0 (Linux; Android 4.1.2; LT26w Build/6.2.B.1.96) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36
		//Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36
		//WIN8 safari : Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2

		// 版本判斷
		if( $output['AN']=='' )
		{
			switch($output['A']){
				case 'Opera':
					$sit_0 = ( $output['S']=='Windows' ) ? ( stripos($str,'Opera/') + 6 ) : ( stripos($str,'OPR/') + 4 );
					break;
				case 'Internet Explorer':
					$sit_0 = stripos($str,'MSIE ') + 5;
					break;
				case 'Arora':
					$sit_0 = stripos($str,'Arora/') + 6;
					break;
				case 'Dillo':
					$sit_0 = stripos($str,'Dillo/') + 6;
					break;
				case 'Chrome':
					$sit_0 = stripos($str,'Chrome/') + 7;
					break;
				case 'Midori':
					$sit_0 = stripos($str,'Midori/') + 7;
					break;
				case 'Firefox':
					$sit_0 = stripos($str,'Firefox/') + 8;
					break;
				case 'Safari':
					$sit_0 = stripos($str,'Version/') + 8;
					break;
				case 'Sony':
					$sit_0 = stripos($str,'Version/') + 8;
					break;
				case 'Epiphany':
					$sit_0 = stripos($str,'Epiphany/') + 9;
					break;
				case 'PaleMoon':
					$sit_0 = stripos($str,'PaleMoon/') + 9;
					break;
				case 'QupZilla':
					$sit_0 = stripos($str,'QupZilla/') + 9;
					break;
				case 'Konqueror':
					$sit_0 = stripos($str,'Konqueror/') + 10;
					break;
				default:
					$sit_0 = 0;
					break;
			}
			$str = substr($str,$sit_0) ;
			if( $output['A']=='Internet Explorer' )
			{
				$sit_1 = stripos($str,';') ;
			}
			else
			{
				$sit_1 = stripos($str,' ') ;
			}
			if( $output['A']!='' )
			{
				if($sit_1!==false )
				{
					$output['AN'] = substr($str,0,$sit_1) ;
				}
				else
				{
					$output['AN'] = $str ;
				}
			}
			else
			{
				$output['AN'] = '' ;
			}
		}
		return $output;
	}

	public function get_lang()
	{
		return $_SERVER['HTTP_ACCEPT_LANGUAGE'] ;
	}

	public function htmlspecialchars($ary=NULL)
	{
		if( !empty($ary) )
		{
			$ary_type = gettype($ary) ;
			if( $ary_type=='array' )
			{
				foreach ($ary as $key => $value)
				{
					$ary[$key] = htmlspecialchars($value) ;
				}
			}
			else if( $ary_type=='string' )
			{
				$ary = htmlspecialchars($ary) ;
			}
		}
		return $ary ;
	}

	public function utf8_encode_deep(&$input)
	{
		$output = '' ;
		if (is_string($input)) {
			$output = utf8_encode($input);
		}
		else if (is_array($input))
		{
			$output = array();
			foreach ($input as &$value)
			{
				$output[] = utf8_encode($value);
			}
			unset($value);
		}
		else if (is_object($input))
		{
			$output = array();
			$vars = array_keys(get_object_vars($input));
			foreach ($vars as $var)
			{
				$output[] = utf8_encode($input->$var);
			}
		}
		return $output ;
	}

	public function check_login()
	{
		if( !isset($_SESSION['uid']) || empty($_SESSION['username']) )
		{
			//exit(base_url().'login');
			header('Location: '.base_url().'login') ;
			exit(base_url().'login');
		}
		else
		{
			//print_r($_SESSION) ;
		}
	}
}
?>