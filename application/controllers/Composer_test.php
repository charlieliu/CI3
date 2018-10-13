<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("session.cookie_httponly", 1);
header("x-frame-options:sammeorigin");
header('Content-Type: text/html; charset=utf8');

use Services\Atm_services;
use Services\Tools_services;

class Composer_test extends CI_Controller {

    public $current_title = 'laravel Composer 測試';
    public $UserAgent = array() ;

    public $page_list = '';
    public function getPageList()
    {
        echo json_encode($this->page_list);
    }

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));

        $this->load->model('php_test_model','',TRUE) ;

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        // 顯示資料
        $content[] = array(
            'content_title' => 'Composer 測試',
            'content_url' => base_url().'composer_test/composer',
        ) ;
        $content[] = array(
            'content_title' => '應用',
            'content_url' => base_url().'composer_test/order_test',
        ) ;

        $this->page_list = $content ;
    }

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function index()
    {
        // 標題 內容顯示
        $data = array(
            'title' => $this->current_title,
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => $this->page_list,
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

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function composer()
    {
        $atm_services = new Atm_services;

        $output = [];

        $collection = collect(['1' => [], '2' => [], '3' => [], '4' => [], ]);

        /* ========== Closure start ========= */
        $output['push'] = $collection->push(['5'])->push('6')->push([]);
        $output['forget'] = $collection->forget(['1','2']);
        /* ========== Closure end ========= */

        /* ========== Callback start ========= */
        $output['map'] = $collection->map(function ($item){ if(gettype($item) == 'array') $item[] = 'array'; return $item; });
        $each = [];
        $collection->each(function ($item, $key) use(&$each){ $each[] = ['key'=>$key,'item'=>$item, ]; });
        $output['each'] = $each;
        $output['keys'] = $collection->keys();
        $output['values'] = $collection->values();
        $output['except'] = $collection->except([6,7]);
        $output['only'] = $collection->only(['1', '4']);
        $output['count'] = $collection->count();
        $output['all'] = $collection->all();
        /* ========== Callback end ========= */

        // $collection = collect([1, 2, 3, 4]);
        // $output['filtered'] = $collection->filter(function ($item) {
        //     return FALSE;
        // })->all();

        $data['content'] = [];

        // 中間挖掉的部分
        foreach ($output as $key => $value)
        {
            $str = ('push'==$key || 'forget'==$key) ? '<code>Closure</code>' : '<code>Callback</code>';
            $str .= '<p>'.var_export($key, TRUE).'</p>';
            $str .= '<div>'.var_export($value, TRUE).'</div>';
            $data['content'][] = [
                'class'=>(('push'==$key || 'forget'==$key) ? 'bg_gray_2' : 'bg_gray_1'),
                'string'=>$str,
            ];
        }
         $content_div = $this->parser->parse('php_test/array_filter_grid_view', $data, true);

        // 中間部分塞入外框
        $html_date = [
            'title' => 'Composer 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => [],
            'content_div'=>$content_div,
        ] ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function tools_test()
    {
        $Tools_services = new Tools_services;

        $path = $Tools_services->echo_path();
        var_dump($path);
        return;
    }

    public function order_test()
    {
        $usersData = [
            ['userId' => '11111111', 'isVip' => false, 'isOnline' => false, 'followerCount' => 100,],
            ['userId' => '22222222', 'isVip' => false, 'isOnline' => true,   'followerCount' => 50,],
            ['userId' => '33333333', 'isVip' => false, 'isOnline' => false, 'followerCount' => 500,],
            ['userId' => '44444444', 'isVip' => true,   'isOnline' => true,    'followerCount' => 1500,],
            ['userId' => '55555555', 'isVip' => false, 'isOnline' => false, 'followerCount' => 300,],
            ['userId' => '66666666', 'isVip' => true,   'isOnline' => true,    'followerCount' => 200,],
            ['userId' => '77777777', 'isVip' => false, 'isOnline' => false,  'followerCount' => 20,],
            ['userId' => '88888888', 'isVip' => false, 'isOnline' => false,  'followerCount' => 10,],
            ['userId' => '99999999', 'isVip' => false, 'isOnline' => false,  'followerCount' => 150,],
        ];

        $nbsp_str = $this->pub->n2nbsp(4);

        $content_div = '<div class="content_block">
        <a href="https://gist.github.com/jaceju/dcae0e91c366221569b9e943c2960a79">考題： Laravel Collection 應用</a>
        <ol>
        <li>先以 isVip 分組， true 排前面， false 排後面。</li>
        <li>對已經分組的結果，再以 isOnline 分組， true 排前面， false 排後面。</li>
        <li>對所有分組以 followerCount 由高至低排序。</li>
        <li>把所有分組結果重新組合成只有一層的 array 。</li>
        <li><div>$usersData = [<br>
        '.$nbsp_str.'["userId" => "11111111", "isVip" => false, "isOnline" => false, "followerCount" => 100,],<br>
        '.$nbsp_str.'["userId" => "22222222", "isVip" => false, "isOnline" => true,   "followerCount" => 50,],<br>
        '.$nbsp_str.'["userId" => "33333333", "isVip" => false, "isOnline" => false, "followerCount" => 500,],<br>
        '.$nbsp_str.'["userId" => "44444444", "isVip" => true,   "isOnline" => true,    "followerCount" => 1500,],<br>
        '.$nbsp_str.'["userId" => "55555555", "isVip" => false, "isOnline" => false, "followerCount" => 300,],<br>
        '.$nbsp_str.'["userId" => "66666666", "isVip" => true,   "isOnline" => true,    "followerCount" => 200,],<br>
        '.$nbsp_str.'["userId" => "77777777", "isVip" => false, "isOnline" => false,  "followerCount" => 20,],<br>
        '.$nbsp_str.'["userId" => "88888888", "isVip" => false, "isOnline" => false,  "followerCount" => 10,],<br>
        '.$nbsp_str.'["userId" => "99999999", "isVip" => false, "isOnline" => false,  "followerCount" => 150,],<br>
        ];</div></li>
        <li>預期重新排序過的 $usersData 應如下：<div>[<br>
        '.$nbsp_str.'["userId" => "44444444", "isVip" => true,  "isOnline" => true,  "followerCount" => 1500,],<br>
        '.$nbsp_str.'["userId" => "66666666", "isVip" => true,  "isOnline" => true,  "followerCount" => 200, ],<br>
        '.$nbsp_str.'["userId" => "22222222", "isVip" => false, "isOnline" => true,  "followerCount" => 50,  ],<br>
        '.$nbsp_str.'["userId" => "33333333", "isVip" => false, "isOnline" => false, "followerCount" => 500, ],<br>
        '.$nbsp_str.'["userId" => "55555555", "isVip" => false, "isOnline" => false, "followerCount" => 300, ],<br>
        '.$nbsp_str.'["userId" => "99999999", "isVip" => false, "isOnline" => false, "followerCount" => 150, ],<br>
        '.$nbsp_str.'["userId" => "11111111", "isVip" => false, "isOnline" => false, "followerCount" => 100, ],<br>
        '.$nbsp_str.'["userId" => "77777777", "isVip" => false, "isOnline" => false, "followerCount" => 20,  ],<br>
        '.$nbsp_str.'["userId" => "88888888", "isVip" => false, "isOnline" => false, "followerCount" => 10,  ],<br>
        ]</div></li>
        </ol>
        </div>';

         $users = collect($usersData)
         ->sortByDesc(function($item){
            $score = $item['followerCount'];
            if($item['isVip'] == true)
                $score += 1000000;
            if($item['isOnline'] == true)
                $score += 100000;
            return $score;
         })
         ->values()
         ->all();

         $content_div .= '<div class="content_block"><code>$users = collect($usersData)<br>
         ->sortByDesc(function($item){<br>
        '.$nbsp_str.'$score = $item["followerCount"];<br>
        '.$nbsp_str.'if($item["isVip"] == true) $score += 1000000;<br>
        '.$nbsp_str.'if($item["isOnline"] == true) $score += 100000;<br>
        '.$nbsp_str.'return $score;<br>
        })<br>
         ->values()<br>
         ->all();</code><div>'.json_encode($users, TRUE).'</div></div>';

         $users2 = collect($usersData)
         ->sortByDesc(function($item){
            return $item['followerCount'];
         })
         ->sortByDesc(function($item){
            $score = $item['isOnline'] === true ? 1 : 0;
            return $score;
         })
         ->sortByDesc(function($item){
            $score = $item['isVip'] === true ? 1 : 0;
            return $score;
         })
         ->values()
         ->all();

         $content_div .= '<div class="content_block"><code>$users2 = collect($usersData)<br>
         ->sortByDesc(function($item){ return $item["followerCount"]; })<br>
         ->sortByDesc(function($item){ $score = $item["isOnline"] === true ? 1 : 0; return $score; })<br>
         ->sortByDesc(function($item){ $score = $item["isVip"] === true ? 1 : 0; return $score; })<br>
         ->values()<br>
         ->all();</code><div>'.json_encode($users2, TRUE).'</div></div>';

         // 中間部分塞入外框
        $html_date = [
            'title' => '應用',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => [],
            'content_div'=>$content_div,
        ] ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }
}
?>