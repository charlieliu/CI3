<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Php_test extends CI_Controller {

    public $current_title = 'PHP 測試';
    public $page_list = '';
    public $UserAgent = array() ;

    private $_csrf = null ;

    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    public function __construct()
    {
        parent::__construct();

        ini_set("session.cookie_httponly", 1);
        header("x-frame-options:sammeorigin");
        header('Content-Type: text/html; charset=utf8');

        // for CSRF
        $this->_csrf = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_value' => $this->security->get_csrf_hash(),
        );

        // load parser
        $this->load->helper(['form','url','test']);

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        // 顯示資料
        $content = array();
        $content[] = array(
            'content_title' => 'count() sizeof() 效能比較',
            'content_url' => 'php_test/count_sizeof'
        ) ;
        $content[] = array(
            'content_title' => 'if else & switch 效能比較',
            'content_url' => 'php_test/switch_test',
        ) ;
        $content[] = array(
            'content_title' => 'pwds Hash list',
            'content_url' => 'php_test/get_top_500_pwd',
        ) ;

        $this->page_list = $content ;
    }

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function index()
    {
        $content = $this->page_list ;

        // 標題 內容顯示
        $data = array(
            'title' => 'PHP 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => $content,
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('welcome_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function count_sizeof()
    {
        // 顯示資料
        $content = array();

        // Application 效能分析
        $this->output->enable_profiler(TRUE);//啟動效能分析器
        $sections = array(
            'config'  => TRUE,
            'queries' => TRUE
        );
        $this->output->set_profiler_sections($sections);

        // 測試用Array
        $array_size = 50000 ;
        $this->benchmark->mark('code_start');
        $test_array = array();
        for($test_i=0;$test_i<$array_size;$test_i++)
        {
            $test_array[] = $test_i ;
        }
        $this->benchmark->mark('code_end');
        $time_mark = $this->benchmark->elapsed_time('code_start','code_end');
        $content[] = array(
            'content_title' => 'Array('.$array_size.')',
            'content_value' => $time_mark,
        ) ;

        // 測試次數
        $try_num = 1000000 ;

        // for 迴圈
        $this->benchmark->mark('code1_start');
        for($test_i=0;$test_i<$try_num;$test_i++)
        {

        }
        $this->benchmark->mark('code1_end');
        $time_mark = $this->benchmark->elapsed_time('code1_start','code1_end');
        $content[] = array(
            'content_title' => 'for() '.$try_num.' times',
            'content_value' => $time_mark,
        ) ;

        // count()
        $this->benchmark->mark('code2_start');
        for($test_i=0;$test_i<$try_num;$test_i++)
        {
            $count_num = count($test_array) ;
        }
        $this->benchmark->mark('code2_end');
        $time_mark = $this->benchmark->elapsed_time('code2_start','code2_end');
        $content[] = array(
            'content_title' => 'count()='.$count_num.' '.$try_num.' times',
            'content_value' => $time_mark,
        ) ;

        // sizeof()
        $this->benchmark->mark('code3_start');
        for($test_i=0;$test_i<$try_num;$test_i++)
        {
            $sizeof_num = sizeof($test_array) ;
        }
        $this->benchmark->mark('code3_end');
        $time_mark = $this->benchmark->elapsed_time('code3_start','code3_end');
        $content[] = array(
            'content_title' => 'sizeof()='.$sizeof_num.' '.$try_num.' times',
            'content_value' => $time_mark,
        ) ;

        $this->output->enable_profiler(FALSE);//關閉效能分析器

        $content[] = array(
            'content_title' => 'Difference between sizeof() and count() in php',
            'content_value' => 'The sizeof() function is an alias for count().',
        ) ;

        // 標題 內容顯示
        $data = array(
            'title'      => 'count() and sizeof()',
            'current_title' => $this->current_title,
            'current_page'  => strtolower(__CLASS__), // 當下類別
            'current_fun'=> strtolower(__FUNCTION__), // 當下function
            'content'    => $content,
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('php_test/test_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function switch_test()
    {
        // 顯示資料
        $content = array();

        // Application 效能分析
        $this->output->enable_profiler(TRUE);//啟動效能分析器
        $sections = array(
            'config'  => TRUE,
            'queries' => TRUE
        );
        $this->output->set_profiler_sections($sections);

        // 測試用Array
        $test_array = array();
        $arr_size = 25000;
        for($test_i=0;$test_i<$arr_size;$test_i++)
        {
            $test_array[] = $test_i%10 ;
        }
        $time_if = 0 ;
        $time_sw = 0 ;
        $time_mark_if = 0 ;
        $time_mark_sw = 0 ;
        $test_size = 200;
        for($test_j=0;$test_j<$test_size;$test_j++)
        {
            $time_mark_if += $this->_if_loop_test($test_array) ;
            $time_mark_sw += $this->_switch_loop_test($test_array) ;
        }
        $str = $test_j.'('.$arr_size.') : '.$time_mark_if.' - '.$time_mark_sw.' = '.($time_mark_if-$time_mark_sw) ;
        $content[] = array(
            'content_title' => '第N個迴圈(判斷M個值) : if(時間) - switch(時間) = 時間差',
            'content_value' => $str,
        ) ;

        $this->output->enable_profiler(FALSE);//關閉效能分析器

        // 標題 內容顯示
        $data = array(
            'title'      => 'if else and switch',
            'current_title' => $this->current_title,
            'current_page'  => strtolower(__CLASS__), // 當下類別
            'current_fun'=> strtolower(__FUNCTION__), // 當下function
            'content'    => $content,
        );

        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('php_test/test_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    private function _switch_loop_test($test_array)
    {
        // switch
        $this->benchmark->mark('code3_start');
        foreach($test_array as $v)
        {
            switch($v)
            {
                case 0:
                    $this->_get_test_str() ;
                    break;
                case 1:
                    $this->_get_test_str() ;
                    break;
                case 2:
                    $this->_get_test_str() ;
                    break;
                case 3:
                    $this->_get_test_str() ;
                    break;
                case 4:
                    $this->_get_test_str() ;
                    break;
                case 5:
                    $this->_get_test_str() ;
                    break;
                case 6:
                    $this->_get_test_str() ;
                    break;
                case 7:
                    $this->_get_test_str() ;
                    break;
                case 8:
                    $this->_get_test_str() ;
                    break;
                case 9:
                    $this->_get_test_str() ;
                    break;
            }
        }
        $this->benchmark->mark('code3_end');
        $time_mark = $this->benchmark->elapsed_time('code3_start','code3_end');
        return $time_mark ;
    }

    private function _if_loop_test($test_array)
    {
        // if else
        $this->benchmark->mark('code2_start');
        foreach($test_array as $v)
        {
            if($v==1)
            {
                $this->_get_test_str() ;
            }
            else if($v==2)
            {
                $this->_get_test_str() ;
            }
            else if($v==3)
            {
                $this->_get_test_str() ;
            }
            else if($v==4)
            {
                $this->_get_test_str() ;
            }
            else if($v==5)
            {
                $this->_get_test_str() ;
            }
            else if($v==6)
            {
                $this->_get_test_str() ;
            }
            else if($v==7)
            {
                $this->_get_test_str() ;
            }
            else if($v==8)
            {
                $this->_get_test_str() ;
            }
            else if($v==9)
            {
                $this->_get_test_str() ;
            }
            else if($v==0)
            {
                $this->_get_test_str() ;
            }
        }
        $this->benchmark->mark('code2_end');
        $time_mark = $this->benchmark->elapsed_time('code2_start','code2_end');
        return $time_mark ;
    }

    private function _get_test_str()
    {
        return FALSE ;
    }

    public function get_top_500_pwd()
    {
        $hash_array = array('md5', 'sha1', 'sha256', 'sha512', );

        $post = $this->input->post() ;
        $post = $this->pub->trim_val($post) ;

        $page_max = 100 ;
        $page = isset($post['page'])?intval($post['page']):1 ;
        $total = $this->php_test_model->get_hash_test_num() ;// for WIN8's apache
        $total = isset($total[0]['total']) ? intval($total[0]['total']) : (isset($total['total']) ? intval($total['total']) : intval($total) ) ;

        /* top 500 pwds + top 500 ios pwds + default john = 4138 */
        if( $total<4138 )
        {
            /* add lib */
            $this->_add_top_500_pwds();
        }
        $pagecnt = ceil( $total/$page_max ) ;
        $page = ($page<1) ? 1 : ( ($page>$pagecnt ) ? $pagecnt : $page ) ;

        if( !isset($post['hash_str']) || $post['hash_str']=='' )
        {
            $reports = $this->php_test_model->query_hash_test('',$page,$page_max) ;
            $pwd_data = $reports['data'];
            $total = intval($reports['total']) ;
        }
        else
        {
            $reports = $this->php_test_model->query_hash_test($post['hash_str'],$page,$page_max,false);
            $pwd_data = $reports['data'];
            $total = intval($reports['total']) ;
            /* query hash value */
            if( $total==0 )
            {
                $reports = $this->php_test_model->query_hash_val($post['hash_str']) ;
                $pwd_data = $reports['data'];
                $total = intval($reports['total']) ;
            }
            /* add value */
            if( $total==0 )
            {
                $reports = $this->php_test_model->add_hash_test($post['hash_str']);
                $pwd_data = $reports['data'];
                $total = intval($reports['total']) ;
            }
            //var_dump($reports);
        }

        //echo 'LINE : '.__LINE__.'total='.$total.'<br>' ;
        $pagecnt = ceil( $total/$page_max ) ;

        $page_dropdown = '' ;
        if( $pagecnt>1 )
        {
            $options = array() ;
            if( $pagecnt>10 )
            {
                /*
                $options_25 =  ceil($pagecnt/4) ;
                $options_50 =  ceil($pagecnt/2) ;
                $options_75 =  ceil((3*$pagecnt)/4) ;
                $options[$options_25] = 'page '.$options_25.'(25%)' ;
                $options[$options_75] = 'page '.$options_75.'(50%)' ;
                $options[$options_50] = 'page '.$options_50.'(75%)' ;
                */
                // first 5 pages
                for( $i=1; $i<=5; $i++ )
                {
                    $options[$i] = 'page '.$i ;
                }
                // select page
                $options[$page] = 'page '.$page ;
                // last 5 pages
                for( $i=($pagecnt-4); $i<=$pagecnt; $i++ )
                {
                    $options[$i] = 'page '.$i ;
                }
                // order by key
                ksort($options);
            }
            else
            {
                for( $i=1; $i<=$pagecnt; $i++ )
                {
                    $options[$i] = 'page '.$i ;
                }
            }
            $page_dropdown = form_dropdown('page', $options, $page);
        }

        // title
        $th = array();
        //$th[] = 'index';
        $th[] = 'passwords';
        foreach ( $hash_array as $hash_type )
        {
            $th[] = $hash_type ;
        }

        // content
        //$pwd_row = ($page-1)*$page_max;
        $td = array();
        foreach ( $pwd_data as $row )
        {
            $td_row = array() ;
            if( $row['hash_key']!='' )
            {
                //$pwd_row++ ;
                //$td_row['index'] = $pwd_row ;
                //$td_row['index'] = $row['hash_id'] ;
                $td_row['passwords'] = htmlspecialchars($row['hash_key']) ;
                //$td_row['passwords'] = $row['hash_key'] ;
                foreach ( $hash_array as $hash_type )
                {
                    $td_row[$hash_type.'_var'] = $row[$hash_type.'_var'] ;
                }
                $td[] = $td_row ;
            }
            else
            {
                var_dump($row);
            }
        }

        $table_grid_view = $this->parser->parse('php_test/table_grid_view', array('td'=>$td,'th'=>$th,), true);

        if( !empty($post) )
        {
            $result = array(
                'status'=>'100',
                'pg'=>$page,
                'pageCnt'=>$pagecnt,
                'dropdown'=>$page_dropdown,
                'output'=>$table_grid_view,
                'post'=>$post,
            );
            echo json_encode($result);
        }
        else
        {
            // 標題 內容顯示
            $data = array(
                'title' => 'pwds Hash list',
                'current_title' => $this->current_title,
                'current_page' => strtolower(__CLASS__), // 當下類別
                'current_fun' => strtolower(__FUNCTION__), // 當下function
                'table_grid_view'=>$table_grid_view,
                'page'=>$page,
                'pagecnt'=>$pagecnt,
                'page_dropdown'=>$page_dropdown,
                'base_url'=>base_url(),
                'page_max'=>$page_max,
            );

            // 中間挖掉的部分
            $data = array_merge($data,$this->_csrf);
            $content_div = $this->parser->parse('php_test/table_view', $data, true);
            // 中間部分塞入外框
            $html_date = $data ;
            $html_date['content_div'] = $content_div ;
            $html_date['js'][] = 'js/page_nav.js';
            $html_date['js'][] = 'js/php_test/get_top_500_pwd.js';

            $view = $this->parser->parse('index_view', $html_date, true);
            $this->pub->remove_view_space($view);
        }
    }

    public function get_pwd_excel()
    {
        $post = $this->input->post() ;
        $post = $this->pub->trim_val($post) ;
        $page_max = intval($post['page_max']);
        $page = intval($post['page']) ;
        $hash_str = isset($post['hash_str']) ? $post['hash_str'] : '' ;
        $pwd_data = $this->php_test_model->query_hash_test($hash_str,$page,$page_max) ;
        $header[] = array('index','passwords','md5', 'sha1', 'sha256', 'sha512', );
        $data = array_merge($header,$pwd_data['data']) ;
        $this->load->library('excel');
        $this->excel->Array2xls($data,'get_pwd_excel') ;
    }

    public function toppwds()
    {
        $mun = $this->php_test_model->get_hash_test_num();
        if( !empty($mun) )
        {
            $mun = intval($mun) ;
        }
        else
        {
            print_r($mun);
            exit() ;
        }
        $list = $this->php_test_model->query_hash_test('',1,$mun,false);
        foreach ($list['data'] as $key => $row)
        {
            if(!empty($row['hash_key']))
            {
                echo $row['hash_key'].'<br>' ;
            }
        }
        exit;
    }

    private function _add_top_500_pwds()
    {
        $this->load->model('top_500_pwd_model');
        $toppwds = $this->top_500_pwd_model->get_pwds();
        foreach ( $toppwds as $key=>$val )
        {
            $this->php_test_model->query_hash_test($val,$key);
        };
    }

    public function get_url($tag='')
    {
        header('content-type: application/javascript') ;
        switch ($tag) {
            case 'get_top_500_pwd':
                echo 'var URLs = "'.base_url().'php_test/get_top_500_pwd";' ;
                break;
        }
    }
}
?>
