<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

class Redis_test extends CI_Controller {

	private $current_title = 'Redis 測試';
	private $page_list = array();
	private $_csrf = null ;
	private $_dblink = 0 ;
	private $_redis_log = '' ;

	public $UserAgent = array() ;

	// 建構子
	public function __construct()
	{
		parent::__construct();

		// for CSRF
		$this->_csrf = array(
			'csrf_name' => $this->security->get_csrf_token_name(),
			'csrf_value' => $this->security->get_csrf_hash(),
		);

		// load parser
		//$this->load->library(array('parser','session', 'pub'));
		$this->load->helper(array('form', 'url'));

		$this->pub->check_login();

		$this->UserAgent = $this->pub->get_UserAgent() ;
		if( isset($this->UserAgent['O']) )
		{
			$this->load->model('php_test_model','',TRUE) ;
			$this->php_test_model->query_user_agent($this->UserAgent) ;
		}
		$this->session->keep_flashdata('redis_db');
		$this->_dblink = intval($this->session->flashdata('redis_db')) ;

		$this->_redis_log = $this->session->userdata('redis_log') ;
	}

	// 取得標題
	public function getPageList()
	{
		echo json_encode($this->page_list);
	}

	// 測試分類畫面
	public function index()
	{
		if( base_url()=='http://localhost/' )
		{
			$grid_data['redis_act'][]= array(
				'title'=>'適合全體類型的命令',
				'act'=>array(
					// 適合全體類型的命令
					'SELECT'=>'SELECT index 選擇數據庫',
					'KEYS'=>'KEYS pattern 返回匹配的key列表 (KEYS foo*:查找foo開頭的keys)',
					'DBSIZE'=>'DBSIZE返回當前數據庫鍵的總數',
					'EXISTS'=>'EXISTS key 判斷一個鍵是否存在;存在返回 1;否則返回0;',
					'TYPE'=>'TYPE key 返回某個key元素的數據類型 ( none:不存在,string:字符,hash:雜湊,list:列表,set,zset)',
					'RANDOMKEY'=>'RANDOMKEY 隨機獲得一個已經存在的鍵，如果當前數據庫爲空，則返回空字符串',
					'RENAME'=>'RENAME oldname newname更改key的名字，新鍵如果存在將被覆蓋',
					'RENAMENX'=>'RENAMENX oldname newname 更改key的名字，如果名字存在則更改失敗',
					'DEL'=>'DEL key 刪除某個key,或是一系列key;DEL key1 key2 key3 key4',
					'EXPIRE'=>'EXPIRE key count 設置某個key的過期時間（秒）,(EXPIRE bruce 1000：設置bruce這個key1000秒後系統自動刪除)注意：如果在還沒有過期的時候，對值進行了改變，那麼那個值會被清除。',
					'PERSIST'=>'PERSIST key 清除某個key的過期時間',
					'TTL'=>'TTL查找某個key還有多長時間過期,返回時間秒',
					'MOVE'=>'MOVE key dbindex 將指定鍵從當前數據庫移到目標數據庫 dbindex。成功返回 1;否則返回0（源數據庫不存在key或目標數據庫已存在同名key）;',
					'FLUSHDB'=>'FLUSHDB 清空當前數據庫中的所有鍵',
					'FLUSHALL'=>'FLUSHALL 清空所有數據庫中的所有鍵',
				)
			);
		}
		else
		{
			$grid_data['redis_act'][]= array(
				'title'=>'適合全體類型的命令',
				'act'=>array(
					// 適合全體類型的命令
					'SELECT'=>'SELECT index 選擇數據庫',
					'KEYS'=>'KEYS pattern 返回匹配的key列表 (KEYS foo*:查找foo開頭的keys)',
					'DBSIZE'=>'DBSIZE返回當前數據庫鍵的總數',
					'EXISTS'=>'EXISTS key 判斷一個鍵是否存在;存在返回 1;否則返回0;',
					'TYPE'=>'TYPE key 返回某個key元素的數據類型 ( none:不存在,string:字符,hash:雜湊,list:列表,set,zset)',
					'RANDOMKEY'=>'RANDOMKEY 隨機獲得一個已經存在的鍵，如果當前數據庫爲空，則返回空字符串',
					'RENAME'=>'RENAME oldname newname更改key的名字，新鍵如果存在將被覆蓋',
					'RENAMENX'=>'RENAMENX oldname newname 更改key的名字，如果名字存在則更改失敗',
					'DEL'=>'DEL key 刪除某個key,或是一系列key;DEL key1 key2 key3 key4',
					'EXPIRE'=>'EXPIRE key count 設置某個key的過期時間（秒）,(EXPIRE bruce 1000：設置bruce這個key1000秒後系統自動刪除)注意：如果在還沒有過期的時候，對值進行了改變，那麼那個值會被清除。',
					'PERSIST'=>'PERSIST key 清除某個key的過期時間',
					'TTL'=>'TTL查找某個key還有多長時間過期,返回時間秒',
					'MOVE'=>'MOVE key dbindex 將指定鍵從當前數據庫移到目標數據庫 dbindex。成功返回 1;否則返回0（源數據庫不存在key或目標數據庫已存在同名key）;',
				)
			);
		}
		$grid_data['redis_act'][]= array(
			'title'=>'處理字符串的命令',
			'act'=>array(
				// 處理字符串的命令
				'SET'=>'SET key value 給一個鍵設置字符串值。SET keyname datalength data (SET bruce 10 paitoubing:保存key爲burce,字符串長度爲10的一個字符串paitoubing到數據庫)，data最大不可超過1G。',
				'MSET'=>'MSET key1 value1 key2 value2 key3 value3… keyN valueN 在一次原子操作下一次性設置多個鍵和值',
				'SETNX'=>'SETNX key value SETNX與SET的區別是SET可以創建與更新key的value，而SETNX是如果key不存在，則創建key與value數據',
				'MSETNX'=>'MSETNX key1 value1 key2 value2 key3 value3… keyN valueN 在一次原子操作下一次性設置多個鍵和值（目標鍵不存在情況下，如果有一個以上的key已存在，則失敗返回0）',
				'GETSET'=>'GETSET key value可以理解成獲得的key的值然後SET這個值，更加方便的操作 (SET bruce 10 paitoubing,這個時候需要修改bruce變成1234567890並獲取這個以前的數據paitoubing,GETSET bruce 10 1234567890)',
				'APPEND'=>'APPEND key value 尾端追加value',
				'GET'=>'GET key獲取某個key 的值。如key不存在，則返回字符串“nil”；如key的值不爲字符串類型，則返回一個錯誤。',
				'MGET'=>'MGET key1 key2 key3… keyN 一次性返回多個鍵的值',
				'STRLEN'=>'STRLEN key 返回符串長度',
				'INCR'=>'INCR key 自增鍵值',
				'INCRBY'=>'INCRBY key integer 令鍵值自增指定數值',
				'INCRBYFLOAT'=>'INCRBY key float 令鍵值自增指定數值(浮點運算)',
				'DECR'=>'DECR key 自減鍵值',
				'DECRBY'=>'DECRBY key integer 令鍵值自減指定數值',
				'SETBIT'=>'SETBIT key offset value 二進位位元',
				'GETBIT'=>'GETBIT key value 二進位位元',
				'BITCOUNT'=>'BITCOUNT key 二進位位元',
				'BITOP'=>'BITOP option key key2 key3 二進位位元。option: AND, OR, XOR 和 NOT，key=key2運算key3。',
			)
		);
		$grid_data['redis_act'][]= array(
			'title'=>'雜湊型態',
			'act'=>array(
				// 雜湊型態
				'HSET'=>'HSET key field value 給某個欄位設置雜湊值。',
				'HSETNX'=>'HSETNX key field value 如果某個欄位不存在，則創建key, field與value數據。',
				'HINCRBY'=>'HINCRBY key field integer 令某個欄位增加指定數值',
				'HKEYS'=>'HKEYS pattern 返回key的欄位列表',
				'HLEN'=>'HLEN key 返回key的欄位個數',
				'HGET'=>'HGET key field 返回某個欄位的雜湊值',
				'HGETALL'=>'HGETALL key 返回某個key的欄位&雜湊值',
				'HEXISTS'=>'HEXISTS key field 判斷一個鍵是否存在;存在返回 1;否則返回0;',
				'HDEL'=>'HDEL key field 刪除某個欄位',
			)
		) ;
		$grid_data['redis_act'][]= array(
			'title'=>'列表型態',
			'act'=>array(
				// 列表型態
				'LPUSH'=>'LPUSH key value 從 List 頭部添加一個元素（如序列不存在，則先創建，如已存在同名Key而非序列，則返回錯誤）',
				'RPUSH'=>'RPUSH key value 從 List 尾部添加一個元素',
				'LPOP'=>'LPOP key 彈出 List 的第一個元素',
				'RPOP'=>'RPOP key 彈出 List 的最後一個元素',
				'RPOPLPUSH'=>'RPOPLPUSH srckey dstkey 彈出 _srckey_ 中最後一個元素並將其壓入 _dstkey_頭部，key不存在或序列爲空則返回“nil”',
				'LLEN'=>'LLEN key 返回一個 List 的長度',
				'LRANGE'=>'LRANGE key start end從自定的範圍內返回序列的元素 (LRANGE testlist 0 2;返回序列testlist前0 1 2元素)',
				'LTRIM'=>'LTRIM key start end修剪某個範圍之外的數據 (LTRIM testlist 0 2;保留0 1 2元素，其餘的刪除)',
				'LINDEX'=>'LINDEX key index返回某個位置的序列值(LINDEX testlist 0;返回序列testlist位置爲0的元素)',
				'LSET'=>'LSET key index value更新某個位置元素的值',
				'LREM'=>'LREM key count value 從 List 的頭部（count正數）或尾部（count負數）刪除一定數量（count）匹配value的元素，返回刪除的元素數量。',
				'LINSERT'=>'LINSERT key BEFORE|AFTER pivot value 在列表中從左向右找到pivot的元素，然後根據第二個參數BEFORE|AFTER來決定插入到元素前面或後面。',
			)
		) ;
		$grid_data['redis_act'][]= array(
			'title'=>'集合型態',
			'act'=>array(
				// 處理集合(sets)的命令（有索引無序序列）
				'SADD'=>'SADD key member增加元素到SETS序列,如果元素（membe）不存在則添加成功 1，否則失敗 0;(SADD testlist 3 n one)',
				'SREM'=>'SREM key member 刪除SETS序列的某個元素，如果元素不存在則失敗0，否則成功 1(SREM testlist 3 N one)',
				'SMEMBERS'=>'SMEMBERS key 返回某個序列的所有元素',
				'SCARD'=>'SCARD key 統計某個SETS的序列的元素數量',
				'SISMEMBER'=>'SISMEMBER key member 獲知指定成員是否存在於集閤中',
				'SDIFF'=>'SDIFF key1 key2,key3 … keyN 依據 key2, …, keyN 求 key1 的差集。官方例子：<br>key1 = x,a,b,c<br>key2 = c<br>key3 = a,d',
				'SDIFFSTORE'=>'SDIFFSTORE dstkey key1 key2 … keyN 依據 key2, …, keyN 求 key1 的差集並存入 dstkey',
				'SINTER'=>'SINTER key1 key2 … keyN 返回 key1, key2, …, keyN 中的交集',
				'SINTERSTORE'=>'SINTERSTORE dstkey key1 key2 … keyN 將 key1, key2, …, keyN 中的交集存入 dstkey',
				'SUNION'=>'SUNION key1 key2 … keyN 返回 key1, key2, …, keyN 的聯集',
				'SUNIONSTORE'=>'SUNIONSTORE dstkey key1 key2 … keyN 將 key1, key2, …, keyN 的聯集存入 dstkey',
				'SPOP'=>'SPOP key 從集合中隨機彈出一個成員',
				'SRANDMEMBER'=>'SRANDMEMBER key count 隨機返回某個序列的元素 count:正(不重複N次) 負(重複N次)',
				'SMOVE'=>'SMOVE srckey dstkey member 把一個SETS序列的某個元素 移動到 另外一個SETS序列 (SMOVE testlist test 3n two;從序列testlist移動元素two到 test中，testlist中將不存在two元素)',
			)
		) ;
		$grid_data['redis_act'][]= array(
			'title'=>'處理有序集合(sorted sets)的命令 (zsets)',
			'act'=>array(
				// 處理有序集合(sorted sets)的命令 (zsets)
				'ZADD'=>'ZADD key score member 添加指定成員到有序集閤中，如果目標存在則更新分數（score排序用）',
				'ZINCRBY'=>'ZINCRBY key increment member 如果成員存在則將其增加_increment_，否則將設置一個score爲_increment_的成員',
				'ZREM'=>'ZREM key member 從有序集合刪除指定成員',
				'ZREMRANGEBYRANK'=>'ZREMRANGEBYRANK key start end 刪除指定範圍的成員 start/end:排序(0,1,2,....)',
				'ZSCORE'=>'ZSCORE key member 返回分數',
				'ZRANK'=>'ZRANK key member 返回排序(升序)',
				'ZREVRANK'=>'ZREVRANK key member 返回排序(降序)',
				'ZRANGE'=>'ZRANGE key start end 返回升序排序後的指定範圍的成員 start/end:排序(0,1,2,....)',
				'ZREVRANGE'=>'ZREVRANGE key start end 返回降序排序後的指定範圍的成員 start/end:排序(0,1,2,....)',
				'ZRANGEBYSCORE'=>'ZRANGEBYSCORE key min max 返回所有符合 分數 >= min 和 分數<=max 的成員 ( "(分數">"min", +inf:正無限大 )',
				'ZCARD'=>'ZCARD key 返回有序集合的元素數量',
				'ZINTERSTORE'=>'ZINTERSTORE dstkey numkey key key2 key3 ... 新增dstkey 為numkey個key key2 key3 ...交集',
				'ZUNIONSTORE'=>'ZUNIONSTORE dstkey numkey key key2 key3 ... 新增dstkey 為numkey個key key2 key3 ...聯集',
			)
		) ;

		$grid_data['redis_act'][]= array(
			'title'=>'command',
			'act'=>array(
				'command'=>'command value',
			)
		) ;
/*
		$grid_data['redis_act'][]= array(
			'title'=>'排序（List, Set, Sorted Set）',
			'act'=>array(
				// 排序（List, Set, Sorted Set）
				'SORT'=>'SORT key BY pattern LIMIT start end GET pattern ASC|DESC ALPHA 按照指定模式排序集合或List<br><br>
				SORT mylist<br>默認升序 ASC<br><br>
				SORT mylist DESC<br><br>
				SORT mylist LIMIT 0 10<br>從序號0開始，取10條<br><br>
				SORT mylist LIMIT 0 10 ALPHA DESC<br>按首字符排序<br><br>
				SORT mylist BY weight_*<br><br>
				SORT mylist BY weight_* GET object_*<br><br>
				SORT mylist BY weight_* GET object_* GET #<br><br>
				SORT mylist BY weight_* STORE resultkey<br>將返回的結果存放於resultkey序列（List）',
			)
		) ;
*/
		$grid_data['redis_db'] = $this->_dblink ;
		$grid_data = array_merge($grid_data,$this->_csrf);
		$grid_view = $this->parser->parse('redis_test/redis_test_grid_view', $grid_data, true) ;

		// 標題 內容顯示
		$data = array(
			'title' 		=> $this->current_title,
			'current_title' 	=> $this->current_title,
			'current_page' 	=> strtolower(__CLASS__), // 當下類別
			'current_fun' 	=> strtolower(__FUNCTION__), // 當下function
			'base_url'	=> base_url(),
			'grid_view'	=> $grid_view,
			'class'		=> strtolower(__CLASS__),
		);

		// 中間挖掉的部分
		$data = array_merge($data,$this->_csrf);
		$content_div = $this->parser->parse('redis_test/redis_test_view', $data, true) ;

		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;
		$html_date['js'][] = 'js/redis_test.js';
		$html_date['redis_log'] = $this->_redis_log ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	public function do_redis()
	{
		// $this->load->library(array('redis','xhprof')) ;
		// $this->xhprof->XHProf_Start() ;
		$this->load->library('redis');

		// redis start
		$this->benchmark->mark('total_time_start');
		$command = $this->redis->select($this->_dblink) ;
		if( $command!='OK' )
		{
			exit('LINE:'.__LINE__.' command("select '.$this->_dblink.'")='.$command);
		}

		$post = $this->input->post();

		$input['redis_act']	= isset($post['redis_act'])	? strtolower($post['redis_act']) : '' ;
		$input['key_str']	= isset($post['key_str'])		? $post['key_str'] : '' ;
		$input['key_str2']	= isset($post['key_str2'])	? $post['key_str2'] : '' ;
		$input['key_str3']	= isset($post['key_str3'])	? $post['key_str3'] : '' ;
		$input['val_str']		= isset($post['val_str'])		? $post['val_str'] : '' ;
		$input['val_str2']	= isset($post['val_str2'])		? $post['val_str2'] : '' ;
		$input['val_str3']	= isset($post['val_str3'])		? $post['val_str3'] : '' ;
		$input['off_str']		= isset($post['off_str'])		? $post['off_str'] : '' ;
		$input['opt_str']	= isset($post['opt_str'])		? $post['opt_str'] : '' ;
		$input['ind_str']	= isset($post['ind_str'])		? $post['ind_str'] : '' ;
		$input['field_str']	= isset($post['field_str'])	? $post['field_str'] : '' ;
		$input['dstkey']		= isset($post['dstkey'])		? $post['dstkey'] : '' ;
		$input['score']		= isset($post['score'])		? $post['score'] : '' ;
		$input['numkey']	= isset($post['numkey'])		? intval($post['numkey']) : 0 ;
		$result = 'INPUT VALUE ERROR' ;
		$time = array() ;
		switch($input['redis_act'])
		{
			// 適合全體類型的命令
			case 'exists':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->exists($input['key_str']) ;
				}
				break;
			case 'del':
				if( !empty($post['key_str']) && !empty($post['key_str2']) &&!empty($post['key_str3']) )
				{
					$result = $this->redis->del($input['key_str'], $input['key_str2'], $input['key_str3']) ;
				}
				else if( !empty($post['key_str']) && !empty($post['key_str2']) )
				{
					$result = $this->redis->del($input['key_str'], $input['key_str2']) ;
				}
				else if( !empty($post['key_str']) )
				{
					$result = $this->redis->del($input['key_str']) ;
				}
				break;
			case 'type':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->type($input['key_str']) ;
				}
				break;
			case 'keys':
				$input['key_str'] = $input['key_str'].'*' ;
				$result = $this->redis->keys($input['key_str']) ;
				break;
			case 'randomkey':
				$result = $this->redis->randomkey() ;
				break;
			case 'rename':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->rename($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'renamenx':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->renamenx($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'dbsize':
				$result = $this->redis->dbsize() ;
				break;
			case 'expire':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->expire($input['key_str'], $input['ind_str']) ;
				}
				break;
			case 'persist':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->persist($input['key_str']) ;
				}
				break;
			case 'ttl':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->ttl($input['key_str']) ;
				}
				break;
			case 'select':
				$input['ind_str'] = intval($input['ind_str']) ;
				if( $input['ind_str']>=0 && $input['ind_str']<16 )
				{
					$result = $this->redis->select($input['ind_str']) ;
					if( $result=='OK' )
					{
						$this->_dblink = $input['ind_str'] ;
						$this->session->set_flashdata('redis_db', $input['ind_str']);
					}
				}
				break;
			case 'move':
				$input['ind_str'] = intval($input['ind_str']) ;
				if( trim($input['key_str'])!='' && $input['ind_str']>=0 && $input['ind_str']<16 )
				{
					$result = $this->redis->move($input['key_str'], $input['ind_str']) ;
				}
				break;
			case 'flushdb':
				$result = $this->redis->flushdb() ;
				break;
			case 'flushall':
				$result = $this->redis->flushall() ;
				break;

			// 處理字符串的命令
			case 'set':
			case 'mset':
				if( trim($input['key_str'])!='' && isset($input['key_str2']) && isset($input['key_str3']) )
				{
					$result = $this->redis->mset($input['key_str'], $input['val_str'], $input['key_str2'], $input['val_str2'], $input['key_str3'], $input['val_str3']) ;
				}
				else if( trim($input['key_str'])!='' && isset($input['key_str2']) )
				{
					$result = $this->redis->mset($input['key_str'], $input['val_str'], $input['key_str2'], $input['val_str2']) ;
				}
				else if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->set($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'setnx':
			case 'msetnx':
				if( trim($input['key_str'])!='' && isset($input['key_str2']) && isset($input['key_str3']) )
				{
					$result = $this->redis->msetnx($input['key_str'], $input['val_str'], $input['key_str2'], $input['val_str2'], $input['key_str3'], $input['val_str3']) ;
				}
				else if( trim($input['key_str'])!='' && isset($input['key_str2']) )
				{
					$result = $this->redis->msetnx($input['key_str'], $input['val_str'], $input['key_str2'], $input['val_str2']) ;
				}
				else if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->setnx($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'setbit':
				if( trim($input['key_str'])!='' )
				{
					$input['off_str'] = intval($input['off_str']) ;
					$result = $this->redis->setbit($input['key_str'], $input['off_str'], $input['val_str']) ;
				}
				break;
			case 'getbit':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->getbit($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'bitcount':
				if( trim($input['key_str'])!='' )
				{

				}
				$result = $this->redis->bitcount($input['key_str']) ;
				break;
			case 'bitop':
				if( trim($input['opt_str'])!='' && trim($input['key_str'])!='' && trim($input['key_str2'])!='' && trim($input['key_str3'])!='' )
				{
					$result = $this->redis->bitop($input['opt_str'], $input['key_str'], $input['key_str2'], $input['key_str3']) ;
				}
				break;
			case 'append':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->append($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'get':
			case 'mget':
				if( trim($input['key_str'])!='' && trim($input['key_str2'])!='' && trim($input['key_str3'])!='' )
				{
					$result = $this->redis->mget($input['key_str'], $input['key_str2'], $input['key_str3']) ;
				}
				else if( trim($input['key_str'])!='' && trim($input['key_str2'])!='' )
				{
					$result = $this->redis->mget($input['key_str'], $input['key_str2']) ;
				}
				else if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->get($input['key_str']) ;
				}
				break;
			case 'getset':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->getset($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'strlen':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->strlen($input['key_str']) ;
				}
				break;
			case 'incr':
			case 'incrby':
				if( trim($input['key_str'])!='' && isset($post['val_str']) )
				{
					$input['val_str'] = intval($input['val_str']) ;
					$result = $this->redis->incrby($input['key_str'], $input['val_str']) ;
				}
				else if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->incr($input['key_str']) ;
				}
				break;
			case 'incrbyfloat':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->incrbyfloat($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'decr':
			case 'decrby':
				if( trim($input['key_str'])!='' && isset($post['val_str']) )
				{
					$input['val_str'] = intval($input['val_str']) ;
					$result = $this->redis->decrby($input['key_str'], $input['val_str']) ;
				}
				else if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->decr($input['key_str']) ;
				}
				break;

			// 雜湊型態
			case 'hset':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hset($input['key_str'], $input['field_str'], $input['val_str']) ;
				}
				break;
			case 'hsetnx':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hsetnx($input['key_str'], $input['field_str'], $input['val_str']) ;
				}
				break;
			case 'hincrby':
				if( trim($input['key_str'])!='' )
				{
					$input['val_str'] = intval($input['val_str']) ;
					$result = $this->redis->hincrby($input['key_str'], $input['field_str'], $input['val_str']) ;
				}
				break;
			case 'hkeys':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hkeys($input['key_str']) ;
				}
				break;
			case 'hlen':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hlen($input['key_str']) ;
				}
				break;
			case 'hget':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hget($input['key_str'], $input['field_str']) ;
				}
				break;
			case 'hgetall':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hgetall($input['key_str']) ;
				}
				break;
			case 'hexists':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hexists($input['key_str'], $input['field_str']) ;
				}
				break;
			case 'hdel':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->hdel($input['key_str'], $input['field_str']) ;
				}
				break;

			// 列表型態
			case 'rpush':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->rpush($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'lpush':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->lpush($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'lpop':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->lpop($input['key_str']) ;
				}
				break;
			case 'rpop':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->rpop($input['key_str']) ;
				}
				break;
			case 'rpoplpush':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->rpoplpush($input['key_str'], $input['dstkey']) ;
				}
				break;
			case 'llen':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->llen($input['key_str']) ;
				}
				break;
			case 'lrange':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->lrange($input['key_str'], $input['val_str'], $input['val_str2']) ;
				}
				break;
			case 'ltrim':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->ltrim($input['key_str'], $input['val_str'], $input['val_str2']) ;
				}
				break;
			case 'lindex':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->lindex($input['key_str'], $input['ind_str']) ;
				}
				break;
			case 'lset':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->lset($input['key_str'], $input['ind_str'], $input['val_str']) ;
				}
				break;
			case 'lrem':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->lrem($input['key_str'], $input['ind_str'], $input['val_str']) ;
				}
				break;
			case 'linsert':
				$input['off_str'] = strtoupper($input['off_str']) ;
				if(
					trim($input['key_str'])!='' &&
					( $input['off_str']=='BEFORE' || $input['off_str']=='AFTER' ) &&
					$input['field_str']!=''
				)
				{
					$result = $this->redis->linsert($input['key_str'], $input['off_str'], $input['field_str'], $input['val_str']) ;
				}
				break;

			// 集合型態
			case 'sadd':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->sadd($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'srem':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->srem($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'sismember':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->sismember($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'smembers':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->smembers($input['key_str']) ;
				}
				break;
			case 'scard':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->scard($input['key_str']) ;
				}
				break;
			case 'sdiff':
				if( trim($input['key_str'])!='' && isset($post['key_str2']) && $input['key_str3']!='' )
				{
					$result = $this->redis->sdiff($input['key_str'], $input['key_str2'], $input['key_str3']) ;
				}
				else if( trim($input['key_str'])!='' && isset($post['key_str2']) )
				{
					$result = $this->redis->sdiff($input['key_str'], $input['key_str2']) ;
				}
				break;
			case 'sdiffstore':
				if( trim($input['key_str'])!='' && isset($post['key_str2']) && isset($post['dstkey']) )
				{
					$result = $this->redis->sdiffstore($input['dstkey'], $input['key_str'], $input['key_str2']) ;
				}
				break;
			case 'sinter':
				if( trim($input['key_str'])!='' && isset($post['key_str2']) && $input['key_str3']!='' )
				{
					$result = $this->redis->sinter($input['key_str'], $input['key_str2'], $input['key_str3']) ;
				}
				else if( trim($input['key_str'])!='' && isset($post['key_str2']) )
				{
					$result = $this->redis->sinter($input['key_str'], $input['key_str2']) ;
				}
				break;
			case 'sinterstore':
				if( trim($input['key_str'])!='' && isset($post['key_str2']) && isset($post['dstkey']) )
				{
					$result = $this->redis->sinterstore($input['dstkey'], $input['key_str'], $input['key_str2']) ;
				}
				break;
			case 'sunion':
				if( trim($input['key_str'])!='' && isset($post['key_str2']) && $input['key_str3']!='' )
				{
					$result = $this->redis->sunion($input['key_str'], $input['key_str2'], $input['key_str3']) ;
				}
				else if( trim($input['key_str'])!='' && isset($post['key_str2']) )
				{
					$result = $this->redis->sunion($input['key_str'], $input['key_str2']) ;
				}
				break;
			case 'sunionstore':
				if( trim($input['key_str'])!='' && isset($post['key_str2']) && isset($post['dstkey']) )
				{
					$result = $this->redis->sunionstore($input['dstkey'], $input['key_str'], $input['key_str2']) ;
				}
				break;
			case 'spop':
				$result = $this->redis->spop($input['key_str']) ;
				break;
			case 'srandmember':
				if( trim($input['key_str'])!='' && !empty($post['ind_str']) )
				{
					$input['ind_str'] = intval($input['ind_str']) ;
					$result = $this->redis->srandmember($input['key_str'], $input['ind_str']) ;
				}
				else if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->srandmember($input['key_str']) ;
				}
				break;
			case 'smove':
				if( trim($input['key_str'])!='' && isset($post['dstkey']) && isset($post['val_str']) )
				{
					$result = $this->redis->smove($input['key_str'], $input['dstkey'], $input['val_str']) ;
				}
				break;

			// 有序集合型態
			case 'zadd':
				if( trim($input['key_str'])!='' && isset($post['score']) && isset($post['val_str']) )
				{
					$result = $this->redis->zadd($input['key_str'], $input['score'], $input['val_str']) ;
				}
				break;
			case 'zincrby':
				if( trim($input['key_str'])!='' && isset($post['score']) && isset($post['val_str']) )
				{
					$result = $this->redis->zincrby($input['key_str'], $input['score'], $input['val_str']) ;
				}
				break;
			case 'zrem':
				if( trim($input['key_str'])!='' && isset($post['val_str']) )
				{
					$result = $this->redis->zrem($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'zremrangebyrank':
				if( trim($input['key_str'])!='' && isset($post['val_str']) && isset($post['val_str2']) )
				{
					$result = $this->redis->zremrangebyrank($input['key_str'], $input['val_str'], $input['val_str2']) ;
				}
				break;
			case 'zrevrange':
				if( trim($input['key_str'])!='' && isset($post['val_str']) && isset($post['val_str2']) )
				{
					$result = $this->redis->zrevrange($input['key_str'], $input['val_str'], $input['val_str2']) ;
				}
				break;
			case 'zrange':
				if( trim($input['key_str'])!='' && isset($post['val_str']) && isset($post['val_str2']) )
				{
					$result = $this->redis->zrange($input['key_str'], $input['val_str'], $input['val_str2']) ;
				}
				break;
			case 'zrank':
				if( trim($input['key_str'])!='' && isset($post['val_str']) )
				{
					$result = $this->redis->zrank($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'zrevrank':
				if( trim($input['key_str'])!='' && isset($post['val_str']) )
				{
					$result = $this->redis->zrevrank($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'zscore':
				if( trim($input['key_str'])!='' && isset($post['val_str']) )
				{
					$result = $this->redis->zscore($input['key_str'], $input['val_str']) ;
				}
				break;
			case 'zrangebyscore':
				if( trim($input['key_str'])!='' && isset($post['val_str']) && isset($post['val_str2']) )
				{
					$result = $this->redis->zrangebyscore($input['key_str'], $input['val_str'], $input['val_str2']) ;
				}
				break;
			case 'zcard':
				if( trim($input['key_str'])!='' )
				{
					$result = $this->redis->zcard($input['key_str']) ;
				}
				break;
			case 'zinterstore':
				if( isset($post['dstkey']) && !empty($input['numkey']) )
				{
					if( $input['numkey']==1 && trim($input['key_str'])!='' )
					{
						$result = $this->redis->zinterstore($input['dstkey'], 1, $input['key_str'] ) ;
					}
					else if( $input['numkey']==2 && trim($input['key_str'])!='' && isset($post['key_str2']) )
					{
						$result = $this->redis->zinterstore($input['dstkey'], 2, $input['key_str'], $input['key_str2']) ;
					}
					else if( $input['numkey']==3 && trim($input['key_str'])!='' && isset($post['key_str2']) && isset($post['key_str3']))
					{
						$result = $this->redis->zinterstore($input['dstkey'], 3, $input['key_str'], $input['key_str2'], $input['key_str3'] ) ;
					}
				}
				break;
			case 'zunionstore':
				if( isset($post['dstkey']) && !empty($input['numkey']) )
				{
					if( $input['numkey']==1 && trim($input['key_str'])!='' )
					{
						$result = $this->redis->zunionstore($input['dstkey'], 1, $input['key_str'] ) ;
					}
					else if( $input['numkey']==2 && trim($input['key_str'])!='' && isset($post['key_str2']) )
					{
						$result = $this->redis->zunionstore($input['dstkey'], 2, $input['key_str'], $input['key_str2']) ;
					}
					else if( $input['numkey']==3 && trim($input['key_str'])!='' && isset($post['key_str2']) && isset($post['key_str3']))
					{
						$result = $this->redis->zunionstore($input['dstkey'], 2, $input['key_str'], $input['key_str2'], $input['key_str3'] ) ;
					}
				}
				break;
/*
			case 'command':
				if( trim($input['val_str'])!='' )
				{
					$result = array() ;
					$this->benchmark->mark('command_start');
					$result[] = $this->redis->command($input['val_str']) ;
					$this->benchmark->mark('command_end');
					$time[] = $this->benchmark->elapsed_time('command_start','command_end');
				}
				break;
*/
			case 'multi':
				$result = array() ;

				$this->benchmark->mark('MULTI_start');
				$result[] = $this->redis->MULTI() ;
				$this->benchmark->mark('MULTI_end');
				$time['MULTI'] = $this->benchmark->elapsed_time('MULTI_start','MULTI_end');

				$this->benchmark->mark('act1_start');
				$result[] = $this->redis->SET('key', 'value') ;
				$this->benchmark->mark('act1_end');
				$time['act1'] = $this->benchmark->elapsed_time('act1_start','act1_end');

				$this->benchmark->mark('act2_start');
				$result[] = $this->redis->SET('key', 'redis_test') ;
				$this->benchmark->mark('act2_end');
				$time['act2'] = $this->benchmark->elapsed_time('act2_start','act2_end');

				$this->benchmark->mark('EXEC_start');
				//$result[] = $this->redis->command('EXEC') ;
				$result[] = $this->redis->EXEC() ;
				$this->benchmark->mark('EXEC_end');
				$time['EXEC'] = $this->benchmark->elapsed_time('EXEC_start','EXEC_end');
				break;

			default:
				$result = strtoupper($input['redis_act']).' do not exists' ;
				break;
		}
		if( is_array($result) )
		{
			foreach($result as $key=>$row)
			{
				if( is_array($row) )
				{
					foreach($row as $key_2=>$val)
					{
						$result[$key][$key_2] = $this->decode_result($val) ;
					}
				}
				else
				{
					$result[$key] = $this->decode_result($row) ;
				}
			}
		}
		else
		{
			$result = $this->decode_result($result) ;
		}
		$this->_redis_log = $this->session->userdata('redis_log') ;
		$this->benchmark->mark('total_time_end');
		$time['total_time'] = $this->benchmark->elapsed_time('total_time_start','total_time_end');
		$this->_redis_log .= print_r($time, TRUE) ;
		// $run_id = $this->xhprof->XHProf_End('redis',('redis_'.$input['redis_act']) ) ;

		$output = array(
			'result'=>$result,
			'dblink'=>$this->_dblink,
			'post'=>$post,
			'input'=>$input,
			'redis_log'=>$this->_redis_log,
			// 'run_id'=>$run_id,
			'xhprof_dif'=>$this->query_xhprof_log($input['redis_act']),
		);
		echo json_encode($output) ;
	}

	// query xhprof log
	public function query_xhprof_log($remark_str)
	{
		$this->load->model('xhprof_model','',TRUE);

		$redis_query = (array)$this->xhprof_model->query_log('', 'redis', 'redis_'.$remark_str, 1, 20, FALSE) ;
		$predis_query = (array)$this->xhprof_model->query_log('', 'redis', 'Predis_'.$remark_str, 1, 20, FALSE) ;
		$xhprof_dif = array() ;
		if( $redis_query['total']>0 && $predis_query['total']>0 )
		{
			foreach ($redis_query['data'] as  $redis_row)
			{
				foreach ($predis_query['data'] as $predis_row)
				{
					$xhprof_dif[] = base_url().'xhprof/xhprof_html/index.php?XDEBUG_SESSION_START=sublime.xdebug&run1='.$redis_row['run_id'].'&run2='.$predis_row['run_id'].'&source=redis&run_val=redis_predis<br>' ;
				}
			}
		}
		else if( $predis_query['total']>0 )
		{
			foreach ($predis_query['data'] as  $predis_row)
			{
				$xhprof_dif[] = base_url().'xhprof/xhprof_html/index.php?XDEBUG_SESSION_START=sublime.xdebug&run='.$predis_row['run_id'].'&source=redis&run_val=predis<br>' ;
			}
		}
		else if( $redis_query['total']>0 )
		{
			foreach ($redis_query['data'] as  $redis_row)
			{
				$xhprof_dif[] = base_url().'xhprof/xhprof_html/index.php?XDEBUG_SESSION_START=sublime.xdebug&run='.$redis_row['run_id'].'&source=redis&run_val=redis<br>' ;
			}
		}
		return $xhprof_dif ;
	}

	public function decode_result($input)
	{
		$output = $input ;
		if( is_null($input) )
		{
			$output = 'nil' ;
		}
		else if( is_bool($input) )
		{
			$output = $input===TRUE ? 'true' : 'false' ;
		}
		else if( is_object($input) )
		{
			// Predis\Response\Status Object ( [payload:Predis\Response\Status:private] => OK )
			// change object private value to array
			$result = (array)$input ;
			// create a new array
			$output = array() ;
			foreach ($result as $key => $value)
			{
				// add value to new value
				$output[] = $value ;
			}
		}
		return $output ;
	}

	public function get_url()
	{
		header('content-type: application/javascript') ;
		echo 'var URLs = "'.base_url().'redis_test/do_redis?XDEBUG_SESSION_START=sublime.xdebug";' ;
	}
}
?>