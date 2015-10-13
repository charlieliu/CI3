<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/
class Html5_test extends CI_Controller {

	private $current_title = 'HTML5 測試';
	private $page_list = '';
	private $_csrf = null ;

	public $UserAgent = array() ;

	// 建構子
	public function __construct()
	{
		parent::__construct();

		header('Content-Type: text/html; charset=utf8');

		// for CSRF
		$this->_csrf = array(
			'csrf_name' => $this->security->get_csrf_token_name(),
			'csrf_value' => $this->security->get_csrf_hash(),
		);

		// load parser
		//$this->load->library(array('parser','session', 'pub'));
		$this->load->helper(array('form', 'url'));
		$this->load->model('php_test_model','',TRUE) ;

		$this->pub->check_login();

		$this->UserAgent = $this->pub->get_UserAgent() ;
		if( isset($this->UserAgent['O']) )
		{
			$this->php_test_model->query_user_agent($this->UserAgent) ;
		}

		$content[] = array(
			'content_title' => '控制 HTML5 視訊播放程式',
			'content_url' => base_url().'html5_test/test/1',
		) ;
		$content[] = array(
			'content_title' => 'Form',
			'content_url' => base_url().'html5_test/test/2',
		) ;
		$content[] = array(
			'content_title' => 'datalist',
			'content_url' => base_url().'html5_test/test/3',
		) ;
		$content[] = array(
			'content_title' => 'output',
			'content_url' => base_url().'html5_test/test/4',
		) ;
		$content[] = array(
			'content_title' => 'data-* Attributes',
			'content_url' => base_url().'html5_test/test/5',
		) ;
		$content[] = array(
			'content_title' => 'drap / drop',
			'content_url' => base_url().'html5_test/test/6',
		) ;

		$this->page_list = $content ;
	}

	// 取得標題
	public function getPageList()
	{
		echo json_encode($this->page_list);
	}

	// 測試分類畫面
	public function index()
	{
		$content = $this->page_list ;
		// 標題 內容顯示
		$data = array(
			'title' => $this->current_title,
			'current_title' => $this->current_title,
			'current_page' => strtolower(__CLASS__), // 當下類別
			'current_fun' => strtolower(__FUNCTION__), // 當下function
			'content' => $content,
		);

		// Template parser class
		// 中間挖掉的部分
		$content_div = $this->parser->parse('welcome_view', $data, true);
		// 中間部分塞入外框
		$html_date = $data ;
		$html_date['content_div'] = $content_div ;

		$view = $this->parser->parse('index_view', $html_date, true);
		$this->pub->remove_view_space($view);
	}

	// VIEW
	public function test($in='1')
	{
		$this->load->model('html_test_model','',TRUE) ;

		$post = $this->input->post();
		$post = $this->pub->trim_val($post);
		if( !empty($post) )
		{
			if( $in=='3' && !empty($post['browser']) )
			{
				$query_ary = explode(' ', $post['browser']) ;
				if( strpos($post['browser'],'Internet Explorer')!== false )
				{
					if( isset($query_ary[2]) )
					{
						$browsers = $this->html_test_model->query_browsers('Internet Explorer',$query_ary[2]);
					}
					else
					{
						$browsers = $this->html_test_model->query_browsers('Internet Explorer');
					}
				}
				else if( isset($query_ary[1]) )
				{
					$browsers = $this->html_test_model->query_browsers($query_ary[0],$query_ary[1]);
				}
				else if( !empty($query_ary[0]) )
				{
					$browsers = $this->html_test_model->query_browsers($query_ary[0]);
				}
				//$browsers = array_merge($post,$browsers) ;
				//$browsers = array_merge($query_ary,$browsers) ;
				exit( json_encode($browsers) ) ;
			}
			if( isset($_FILES) )
			{
				foreach ($_FILES as $key => $value)
				{
					$key = $this->pub->htmlspecialchars($key) ;
					$value = $this->pub->htmlspecialchars($value) ;
					$post['FILES'][$key] = $value;
				}
			}
			echo json_encode($post);
		}
		else
		{
			// 標題 內容顯示
			$data = array(
				'title' => $this->current_title,
				'current_title' => $this->current_title,
				'current_page' => strtolower(__CLASS__), // 當下類別
				'current_fun' => strtolower(__FUNCTION__), // 當下function
				'content' => '',
				'base_url'=>base_url(),
				'space_4'=>$this->pub->n2nbsp(4),
			);

			switch ($in) {
				case '1':
					$data['title'] .= ' -- HTML Media' ;
					break;
				case '2':
					$data['title'] .= ' -- Form / Input' ;
					$type_arr = array();
					$type_arr[] = array(
						'type'=>'text',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>1,
							'IE11'=>1,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>0,
						),
					);
					$type_arr[] = array(
						'type'=>'email',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>1,
							'IE11'=>1,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>0,
						),
					);
					$type_arr[] = array(
						'type'=>'color',
						'browser_support'=>array(
							'Arora'=>1,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>1,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>1,
							'Safari'=>0,
						),
					);
					$type_arr[] = array(
						'type'=>'number',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>1,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>1,
						),
					);
					$type_arr[] = array(
						'type'=>'tel',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>0,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>0,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>0,
							'QupZilla'=>0,
							'Safari'=>0,
						),
					);
					$type_arr[] = array(
						'type'=>'date',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>0,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>1,
						),
					);
					$type_arr[] = array(
						'type'=>'month',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>0,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>1,
						),
					);
					$type_arr[] = array(
						'type'=>'week',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>0,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>1,
						),
					);
					$type_arr[] = array(
						'type'=>'time',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>0,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>1,
						),
					);
					$type_arr[] = array(
						'type'=>'datetime-local',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>1,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>0,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>1,
							'QupZilla'=>0,
							'Safari'=>1,
						),
					);
					$type_arr[] = array(
						'type'=>'datetime',
						'browser_support'=>array(
							'Arora'=>0,
							'Chrome'=>0,
							'Dillo'=>0,
							'Elinks'=>0,
							'Epiphany'=>0,
							'Firefox'=>0,
							'IE11'=>0,
							'Midori'=>0,
							'Opera'=>0,
							'QupZilla'=>0,
							'Safari'=>1,
						),
					);
					$data['test_date'] = '18Mar2015' ;
					//print_r($this->_csrf);
					$grid_view_arr = array('type_arr'=>$type_arr) ;
					$grid_view_arr = array_merge($grid_view_arr,$this->_csrf);
					$data['grid_view'] = $this->parser->parse('html5_test/test_'.$in.'_grid_view', $grid_view_arr, true);
					break;
				case '3':
					// count 瀏覽器 版本
					$user_agent_num = intval($this->html_test_model->query_user_agent_num());
					if( $user_agent_num<37 )
					{
						$this->_add_user_agent_list() ;
					}
					$data['title'] .= ' -- &lt;datalist&gt;' ;
					$browsers = $this->html_test_model->query_browsers();
					$data['browsers'] = array() ;
					foreach ($browsers['data'] as $row)
					{
						if( !empty($row['agent_name']) )
						{
							$version = explode('.', $row['agent_version']) ;
							$data['browsers'][] = $row['agent_name'].' '.$version[0] ;
						}
					}
					$data['browsers'] = array_unique($data['browsers'])  ;
					break;
				case '4':
					$data['title'] .= ' -- &lt;output&gt;' ;
					break;
				case '5':
					$data['title'] .= ' -- data-* Attributes' ;
					break;
				case '6':
					$data['title'] .= ' -- drap / drop' ;
					break;
				default:
					$in = '' ;
					break;
			}
			if( !empty($in) )
			{
				$data['js'][] = 'js/html5_test/test_'.$in.'.js';
			}

			// 中間挖掉的部分
			$data = array_merge($data,$this->_csrf);
			$content_div = empty($in) ? '' : $this->parser->parse('html5_test/test_'.$in.'_view', $data, true);

			// 中間部分塞入外框
			$html_date = $data ;
			$html_date['content_div'] = $content_div ;

			$view = $this->parser->parse('index_view', $html_date, true);
			$this->pub->remove_view_space($view);
		}
	}

	public function get_url($in='')
	{
		header('content-type: application/javascript') ;
		if( $in=='3' )
		{
			echo 'var URLs = "'.base_url().'html5_test/test/3";' ;
		}
	}

	private function _add_user_agent_list()
	{
		// User Agent Overrider 偏好設定
		$user_Agent_list = array() ;

		# Linux
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64; rv:29.0) Gecko/20100101 Firefox/29.0' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:37.0) Gecko/20100101 Firefox/37.0' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:39.0) Gecko/20100101 Firefox/39.0' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.21 (KHTML, like Gecko) Arora/0.11.0 Safari/537.21' ;
		$user_Agent_list[] = 'Dillo/3.0.3' ;
		$user_Agent_list[] = 'ELinks/0.12~pre6-4ubuntu1 (textmode; Ubuntu; Linux 3.13.0-37-generic x86_64; 80x24-2)' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/538.15 (KHTML, like Gecko) Version/8.0 Safari/538.15 Ubuntu/14.04 (3.10.3-0ubuntu2) Epiphany/3.10.3' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; zh-tw) AppleWebKit/537+ (KHTML, like Gecko) Version/5.0 Safari/537.6+ Midori/0.4' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36 OPR/28.0.1750.48' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.130 Safari/537.36 OPR/30.0.1835.125' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.21 (KHTML, like Gecko) QupZilla/1.6.0 Safari/537.21' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) KHTML/4.14.2 (like Gecko) Konqueror/4.14' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64; rv:25.3) Gecko/20150425 Firefox/31.9 PaleMoon/25.3.2' ;
		$user_Agent_list[] = 'Dooble/0.07 (zh_TW) WebKit' ;
		$user_Agent_list[] = 'NetSurf/2.9 (Linux; x86_64)' ;
		$user_Agent_list[] = 'Mozilla/5.0 (X11; Linux x86_64) KHTML/4.14.2 (like Gecko) Konqueror/4.14' ;
		$user_Agent_list[] = 'Links (2.8; Linux 3.16.0-38-generic x86_64; GNU C 4.8.2; x)' ;

		# Mac
		$user_Agent_list[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:29.0) Gecko/20100101 Firefox/29.0' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14' ;

		# Windows
		$user_Agent_list[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:29.0) Gecko/20100101 Firefox/29.0' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)' ;
		$user_Agent_list[] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)' ;
		$user_Agent_list[] = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0)' ;
		$user_Agent_list[] = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)' ;
		$user_Agent_list[] = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36 OPR/29.0.1795.47' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0' ;

		# Android
		$user_Agent_list[] = 'Mozilla/5.0 (Android; Mobile; rv:29.0) Gecko/29.0 Firefox/29.0' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Linux; Android 4.4.2; Nexus 4 Build/KOT49H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.114 Mobile Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Linux; Android 4.1.2; LT26w Build/6.2.B.1.96) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.93 Mobile Safari/537.36' ;

		# iOS
		$user_Agent_list[] = 'Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) CriOS/34.0.1847.18 Mobile/11B554a Safari/9537.53' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36' ;
		$user_Agent_list[] = 'Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B554a Safari/9537.53' ;
		$user_Agent_list[] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/600.5.17 (KHTML, like Gecko) Version/8.0.5 Safari/600.5.17' ;

		foreach ($user_Agent_list as $value)
		{
			$row = $this->pub->check_UserAgent($value) ;
			$this->php_test_model->query_user_agent($row) ;
		}
	}
}
?>