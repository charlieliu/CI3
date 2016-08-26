<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author Charlie Liu <liuchangli0107@gmail.com>
*/
class Js_test extends CI_Controller {

    private $current_title = 'JS 測試';
    private $page_list = '';
    private $_csrf = null ;

    public $UserAgent = array() ;

    // 建構子
    public function __construct()
    {
        parent::__construct();

        $this->pub->check_login();

        ini_set("session.cookie_httponly", 1);
        header("x-frame-options:sammeorigin");
        header('Content-Type: text/html; charset=utf8');

        // for CSRF
        $this->_csrf = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_value' => $this->security->get_csrf_hash(),
        );

        // load parser
        //$this->load->library(array('parser','session', 'pub'));
        $this->load->helper(array('form', 'url'));
        //$this->pub->check_session($this->session->userdata('session_id'));
        $this->load->model('php_test_model','',TRUE) ;

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        $content[] = array(
            'content_title' => '利用 jQuery 來製作網頁頁籤(Tab)',
            'content_url' => base_url().'js_test/abgne_tab',
        ) ;
        $content[] = array(
            'content_title' => 'JS object 測試 -- 繼承(prototype)',
            'content_url' => base_url().'js_test/js_object_test',
        ) ;
        $content[] = array(
            'content_title' => 'JS object 測試2',
            'content_url' => base_url().'js_test/js_object_test2',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery file_upload 套件 測試',
            'content_url' => base_url().'js_test/file_upload',
        ) ;
        $content[] = array(
            'content_title' => '檔案大小',
            'content_url' => base_url().'js_test/get_filesize',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery mobile 測試',
            'content_url' => base_url().'js_test/jqm',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery UI 套件',
            'content_url' => base_url().'js_test/ui',
        ) ;
        $content[] = array(
            'content_title' => '密碼強度判斷',
            'content_url' => base_url().'js_test/pwStrength',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- 滑動效果',
            'content_url' => base_url().'js_test/jquery_test',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- attr()/prop()',
            'content_url' => base_url().'js_test/jquery_test/2',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- on() bind()',
            'content_url' => base_url().'js_test/jquery_test/3',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- append() preppend() ...',
            'content_url' => base_url().'js_test/jquery_test/4',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- call apply',
            'content_url' => base_url().'js_test/jquery_test/5',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- parent() parents() closest()',
            'content_url' => base_url().'js_test/jquery_test/6',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- next() prev()',
            'content_url' => base_url().'js_test/jquery_test/7',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- typeof',
            'content_url' => base_url().'js_test/jquery_test/8',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- push',
            'content_url' => base_url().'js_test/jquery_test/9',
        ) ;
        $content[] = array(
            'content_title' => 'jQuery 測試 -- document ready/window.onload',
            'content_url' => base_url().'js_test/jquery_test/10',
        ) ;
        $content[] = array(
            'content_title' => 'XSS 測試 -- images',
            'content_url' => base_url().'js_test/xss_test',
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
            'title' => 'JS 測試',
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
    public function abgne_tab()
    {
        // 顯示資料
        $content = array();
        $nav[] = array(
            'content_id' => 'tab_1',
            'content_title' => '青花瓷',
        ) ;
        $content[] = array(
            'content_id' => 'tab_1',
            'content_title' => '青花瓷',
            'content_value' => '作詞：方文山<br>作曲：周杰倫<br>編曲：鍾興民<br><br>素胚勾勒出青花筆鋒濃轉淡<br>瓶身描繪的牡丹一如妳初妝<br>冉冉檀香透過窗心事我了然<br>宣紙上走筆至此擱一半<br><br>釉色渲染仕女圖韻味被私藏<br>而妳嫣然的一笑如含苞待放<br>妳的美一縷飄散 去到我去不了的地方<br><br>天青色等煙雨 而我在等妳<br>炊煙裊裊昇起 隔江千萬里<br>在瓶底書漢隸仿前朝的飄逸<br>就當我為遇見妳伏筆<br><br>天青色等煙雨 而我在等妳<br>月色被打撈起 暈開了結局<br>如傳世的青花瓷自顧自美麗 妳眼帶笑意<br><br>色白花青的錦鯉躍然於碗底<br>臨摹宋體落款時卻惦記著妳<br>妳隱藏在窯燒裡千年的秘密<br>極細膩猶如繡花針落地<br><br>簾外芭蕉惹驟雨門環惹銅綠<br>而我路過那江南小鎮惹了妳<br>在潑墨山水畫裡 妳從墨色深處被隱去<br><br>天青色等煙雨 而我在等妳<br>炊煙裊裊昇起 隔江千萬里<br>在瓶底書漢隸仿前朝的飄逸<br>就當我為遇見妳伏筆<br><br>天青色等煙雨 而我在等妳<br>月色被打撈起 暈開了結局<br>如傳世的青花瓷自顧自美麗 妳眼帶笑意<br><br>天青色等煙雨 而我在等妳<br>炊煙裊裊昇起 隔江千萬里<br>在瓶底書漢隸仿前朝的飄逸<br>就當我為遇見妳伏筆<br><br>天青色等煙雨 而我在等妳<br>月色被打撈起 暈開了結局<br>如傳世的青花瓷自顧自美麗 妳眼帶笑意<br><br>更多更詳盡歌詞 在 <b>※ Mojim.com　魔鏡歌詞網</b><br>',
        ) ;

        $nav[] = array(
            'content_id' => 'tab_2',
            'content_title' => '髮如雪',
        ) ;
        $content[] = array(
            'content_id' => 'tab_2',
            'content_title' => '髮如雪',
            'content_value' => '作詞：方文山<br>作曲：周杰倫<br><br>狼牙月 伊人憔悴<br>我舉杯 飲盡了風雪<br>是誰打翻前世櫃 惹塵埃是非<br>緣字訣 幾番輪迴<br>妳鎖眉 哭紅顏喚不回<br>縱然青史已經成灰 我愛不滅<br>繁華如三千東流水 我只取一瓢愛了解<br>只戀妳化身的蝶<br><br>妳髮如雪 淒美了離別<br>我焚香感動了誰<br>邀明月 讓回憶皎潔<br>愛在月光下完美<br>妳髮如雪 紛飛了眼淚<br>我等待蒼老了誰<br>紅塵醉 微醺的歲月<br>我用無悔 刻永世愛妳的碑<br><br>Rap:<br>你髮如雪 淒美了離別<br>我焚香感動了誰<br>邀明月 讓回憶皎潔<br>愛在月光下完美<br>你髮如雪 紛飛了眼淚<br>我等待蒼老了誰<br>紅塵醉 微醺的歲月<br><br>啦兒啦 啦兒啦 啦兒啦兒啦<br>啦兒啦 啦兒啦 啦兒啦兒啦<br>銅鏡映無邪 紮馬尾<br>妳若撒野 今生我把酒奉陪<br><br>更多更詳盡歌詞 在 <b>※ Mojim.com　魔鏡歌詞網</b><br>',
        ) ;

        $nav[] = array(
            'content_id' => 'tab_3',
            'content_title' => '菊花台',
        ) ;
        $content[] = array(
            'content_id' => 'tab_3',
            'content_title' => '菊花台',
            'content_value' => '作詞：方文山<br>作曲：周杰倫<br>編曲：鍾興民<br><br>你的淚光　柔弱中帶傷　慘白的月彎彎勾住過往<br>夜太漫長　凝結成了霜　是誰在閣樓上冰冷的絕望<br>雨輕輕彈　朱紅色的窗　我一生在紙上被風吹亂<br>夢在遠方　化成一縷香　隨風飄散你的模樣<br><br>菊花殘滿地傷　你的笑容已泛黃　花落人斷腸　我心事靜靜躺<br>北風亂夜未央　你的影子剪不斷　徒留我孤單　在湖面成雙<br><br>花已向晚　飄落了燦爛　凋謝的世道上命運不堪<br><br>愁莫渡江　秋心拆兩半　怕你上不了岸一輩子搖晃<br>誰的江山　馬蹄聲狂亂　我一身的戎裝呼嘯滄桑<br>天微微亮　你輕聲的嘆　一夜惆悵如此委婉<br><br>菊花殘滿地傷　你的笑容已泛黃　花落人斷腸　我心事靜靜躺<br>北風亂夜未央　你的影子剪不斷　徒留我孤單　在湖面成雙<br><br>菊花殘滿地傷　你的笑容已泛黃　花落人斷腸　我心事靜靜躺<br>北風亂夜未央　你的影子剪不斷　徒留我孤單　在湖面成雙<br><br>更多更詳盡歌詞 在 <b>※ Mojim.com　魔鏡歌詞網</b><br>',
        ) ;

        // 標題 內容顯示
        $data = array(
            'title'         => '利用 jQuery 來製作網頁頁籤(Tab)',
            'current_title' => $this->current_title,
            'current_page'  => strtolower(__CLASS__), // 當下類別
            'current_fun'   => strtolower(__FUNCTION__), // 當下function
            'nav'           => $nav,
            'content'       => $content,
        );

        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('jquery_test/abgne_tab_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $html_date['css'][] = 'css/abgne_tab.css';
        $html_date['js'][] = 'js/js_test/abgne_tab.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // VIEW js_object_test
    public function js_object_test()
    {

        // 標題 內容顯示
        $data = array(
            'title' => 'JS Object 測試 -- 繼承(prototype)',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
        );

        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('jquery_test/js_object_test_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $html_date['js'][] = 'js/js_test/js_object_test.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // VIEW js_object_test2
    public function js_object_test2()
    {

        // 標題 內容顯示
        $data = array(
            'title' => 'JS Object 測試2',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
        );

        // Template parser class
        // 中間挖掉的部分
        $content_div = $this->parser->parse('jquery_test/js_object_test2_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $html_date['js'][] = 'js/js_test/js_object_test2.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // VIEW file_upload
    public function file_upload()
    {
        // 標題 內容顯示
        $data = array(
            'title' => 'JS file upload 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
            '_FILES'=>$_FILES,
            'base_url'=>base_url(),
        );

        // 中間挖掉的部分
        $data = array_merge($data,$this->_csrf);
        $content_div = $this->parser->parse('jquery_test/file_upload_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $html_date['css'] = array() ;
        //$html_date['css'][] = 'js/jQuery-File-Upload-9.7.2/css/style.css';
        $html_date['css'][] = 'js/jQuery-File-Upload-9.7.2/css/jquery.fileupload.css';
        $html_date['css'][] = 'js/jQuery-File-Upload-9.7.2/css/jquery.fileupload-ui.css';
        /* from https://github.com/blueimp */
        //$html_date['css'][] = 'http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css';
        $html_date['css'][] = 'css/js_test/blueimp-gallery.min.css';

        $html_date['css_ie'] = array() ;
        $html_date['css_ie'][] = 'js/jQuery-File-Upload-9.7.2/css/demo-ie8.css';

        $html_date['js'] = array() ;
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/vendor/jquery.ui.widget.js';
        /* from https://github.com/blueimp */
        //$html_date['js'][] = 'http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js';
        //$html_date['js'][] = 'http://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js';
        //$html_date['js'][] = 'http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js';
        //$html_date['js'][] = 'http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js';
        $html_date['js'][] = 'js/js_test/tmpl.min.js';
        $html_date['js'][] = 'js/js_test/load-image.all.min.js';
        $html_date['js'][] = 'js/js_test/canvas-to-blob.min.js';
        $html_date['js'][] = 'js/js_test/jquery.blueimp-gallery.min.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/jquery.fileupload.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/jquery.fileupload-process.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/jquery.fileupload-image.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/jquery.fileupload-audio.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/jquery.fileupload-video.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/jquery.fileupload-validate.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/jquery.fileupload-ui.js';
        $html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/main_charlie.js';
        //$html_date['js'][] = 'js/jQuery-File-Upload-9.7.2/js/main.js';

        $html_date['js_ie'] = array() ;
        $html_date['js_ie'][] = 'js/jQuery-File-Upload-9.7.2/js/cors/jquery.xdr-transport.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
        //echo $view;
    }

    // 上傳檔案
    public function do_upload()
    {
        $upload_path_url = base_url() . 'uploads/';

        $config['upload_path'] = './uploads/';// 儲存路徑
        //$config['upload_path'] = $upload_path_url;
        $config['allowed_types'] = '*';// 不限制file type
        $config['encrypt_name'] = TRUE;// 隨機命名
        $config['max_size'] = 0;// 不限檔案大小

        $this->load->library('upload', $config);

        $files = array();
        unset($this->upload->error_msg);

        $info = new stdClass();
        if ( ! $this->upload->do_upload('files'))
        {
            $error = $this->upload->display_errors();
            $info->error = substr($error, stripos("<p>", $error)+3, stripos("</p>", $error) );
            $files[] = $info;
        }
        else
        {
            $data = $this->upload->data();

            $info->sha512 = hash_file('sha512', $upload_path_url.$data['file_name']) ;
            $info->tmp_sha512 = file_exists($_FILES['files']['tmp_name']) ? hash_file('sha512', $_FILES['files']['tmp_name']) : '' ;
            if( !empty($info->tmp_sha512) && $info->sha512==$info->tmp_sha512 )
            {
                // uploads' file and tmp file have same hash_file value
                $thumbnailUrl = '' ;
                if( $data['is_image'] && file_exists($data['full_path']) )
                {
                    // to re-size for thumbnail images un-comment and set path here and in json array
                    $config = array();
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $data['full_path'];
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 75;
                    $config['height'] = 50;
                    //$config['new_image'] = $data['file_path'].'thumbs/'.$data['file_name'];
                    //$config['thumb_marker'] = '';
                    //$this->load->library('image_lib', $config);
                    $this->load->library('image_lib');
                    // Set your config up
                    $this->image_lib->initialize($config);
                    // Do your manipulation
                    $this->image_lib->clear();
                    if ( $this->image_lib->resize() )
                    {
                        $thumbnailUrl = $upload_path_url.'thumbs/'.$data['file_name'] ;
                    }
                    else
                    {
                        $thumbnailUrl = $upload_path_url.$data['file_name'];
                        //exit( $this->image_lib->display_errors() ) ;
                    }
                }
                //set the data for the json array
                $info->name = $data['file_name'];
                $info->size = $data['file_size'];
                $info->osize = $_FILES['files']['size'];
                $info->type = $data['file_type'];
                $info->url = $upload_path_url . $data['file_name'];
                // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
                $info->thumbnailUrl = $thumbnailUrl ;
                $info->deleteUrl = base_url() . 'js_test/deleteImage/' . $data['file_name'];
                $info->deleteType = 'DELETE';
                $info->error = null;
            }
            else
            {
                $info->error = 'hash files error';
            }
            $files[] = $info;
        }

        if(!empty($files))
        {
            echo json_encode(array("files" => $files,'_FILES'=>$_FILES));
        }
    }

    // 刪除檔案
    public function deleteImage($file)
    {
        $success = 'ERROR' ;
        $is_file = 'ERROR' ;
        $info = new stdClass();
        //gets the job done but you might want to add error checking and security
        if( file_exists(FCPATH . 'uploads/' . $file) )
        {
            $success = unlink(FCPATH . './uploads/' . $file);
            if( file_exists(FCPATH . 'uploads/thumbs/' . $file) )
            {
                unlink(FCPATH . 'uploads/thumbs/' . $file);
            }
            $info->file = is_file(FCPATH.'uploads/'.$file);
        }
        //info to see if it is doing what it is supposed to
        $info->sucess = $success;
        $info->path = base_url().'uploads/'.$file;

        echo json_encode(array($info));
    }

    // VIEW 檔案大小
    public function get_filesize()
    {
        // 標題 內容顯示
        $data = array(
            'title' => 'JS file upload 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
            '_FILES'=>$_FILES,
            'base_url'=>base_url(),
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('jquery_test/get_filesize_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $html_date['js'][] = 'js/js_test/get_filesize.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // 1. 滑動效果
    // 2. attr() / prop()
    // 3. on() / bind()
    // 4. append() preppend() ...
    // 5. call / apply
    public function jquery_test($in='1')
    {
        // 標題 內容顯示
        $data = array(
            'title' => 'jQuery 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
            '_FILES'=>$_FILES,
            'base_url'=>base_url(),
            'space_4'=>$this->pub->n2nbsp(4),
        );

        switch ($in) {
            case '1':
                $data['title'] .= ' -- 滑動效果' ;
                break;
            case '2':
                $data['title'] .= ' -- attr() / prop()' ;
                break;
            case '3':
                $data['title'] .= ' -- on() / bind()' ;
                break;
            case '4':
                $data['title'] .= ' -- append() preppend() ...' ;
                break;
            case '5':
                $data['title'] .= ' -- call / apply' ;
                break;
            case '6':
                $data['title'] .= ' -- parent() parents() closest()' ;
                break;
            case '7':
                $data['title'] .= ' -- next() prev()' ;
                break;
            case '8':
                $data['title'] .= ' -- typeof' ;
                break;
            case '9':
                $data['title'] .= ' -- push' ;
                break;
            case '10':
                $data['title'] .= ' -- document ready/window.onload' ;
                break;
            default:
                $in = '' ;
                break;
        }
        if( !empty($in) )
        {
            $data['js'][] = 'js/js_test/jquery_test_'.$in.'.js';
        }

        // 中間挖掉的部分
        $content_div = empty($in) ? '' : $this->parser->parse('jquery_test/jquery_test_'.$in.'_view', $data, true);

        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // jQuery mobile
    public function jqm()
    {
        // 取得列表資料
        $head_list = array();
        $head_1 = $this->pub->CurlPost(base_url().'welcome/getPageList','jqm') ;
        //var_dump($head_1);
        $head_1 = json_decode($head_1);
        //var_dump($head_1);
        $head_1 = $this->pub->o2a($head_1);
        //var_dump($head_1);
        //exit;

        if( !empty($head_1) )
        {
            foreach ($head_1 as $v)
            {
                if( !empty($v['c']) )
                {
                    $head_2 = $this->pub->o2a(json_decode($this->pub->CurlPost(base_url().$v['c'].'/getPageList','jqm'))) ;
                }
                else
                {
                    $head_2 = array();
                }
                $v['children'] = $head_2 ;
                $head_list[] = $v ;
            }
        }

        // 標題 內容顯示
        $data = array(
            'title' => 'JQuery mobile 測試',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'base_url'=>base_url(),
        );
        $username = $this->session->userdata('username');
        $username = !empty($username) ? $username : 'plz login' ;

        $data['header_view'] = $this->parser->parse('jqm/jqm_header_view', array('title'=>'JQuery mobile 測試','username'=>$username), true);
        $data['menu_view'] = $this->load->view('jqm/jqm_menu_view', array('head_list' =>$head_list), true);
        $data['info_view'] = $this->parser->parse('jqm/jqm_info_view', array(), true);
        $data['footer_view'] = $this->parser->parse('jqm/jqm_footer_view', array(), true);

        $data['content'] = $this->parser->parse('jqm/jqm_index_view', $data, true);

        $view = $this->parser->parse('jqm/jqm_outer_view', $data, true);
        $this->pub->remove_view_space($view);
    }

    // jQuery UI 套件
    public function ui()
    {
        // 標題 內容顯示
        $data = array(
            'title' => 'jQuery UI',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
            '_FILES'=>$_FILES,
            'base_url'=>base_url(),
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('jquery_test/jquery_UI_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        // $html_date['css'][] = 'js/jquery-ui-1.11.2.custom/jquery-ui.min.css';
        $html_date['css'][] = 'js/jquery-ui-1.12.0/jquery-ui.min.css';
        // $html_date['js'][] = 'js/jquery-ui-1.11.2.custom/jquery-ui.min.js';
        $html_date['js'][] = 'js/jquery-ui-1.12.0/jquery-ui.min.js';

        $html_date['css'][] = 'js/jquery-timepicker-master/jquery.timepicker.css';
        $html_date['js'][] = 'js/jquery-timepicker-master/jquery.timepicker.min.js';
        $html_date['js'][] = 'js/js_test/ui.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    // 密碼強度判斷
    public function pwStrength()
    {
        // 標題 內容顯示
        $data = array(
            'title' => 'pwStrength',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
            '_FILES'=>$_FILES,
            'base_url'=>base_url(),
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('jquery_test/pwStrength_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        $html_date['js'][] = 'js/js_test/pwStrength.js';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }

    public function get_top_pwds()
    {
        $this->load->model('php_test_model','',TRUE) ;
        $reports = $this->php_test_model->query_hash_test('',1,991) ;
        $pwds =array('password','passwords') ;
        foreach ($reports['data'] as $row)
        {
            $pwds[] = $row['hash_key'] ;
        }
        header('content-type: application/javascript') ;
        echo 'var top_pwds = '.json_encode($pwds).';' ;
    }

    public function xss_test()
    {
        // 標題 內容顯示
        $data = array(
            'title' => 'xss_images_test',
            'current_title' => $this->current_title,
            'current_page' => strtolower(__CLASS__), // 當下類別
            'current_fun' => strtolower(__FUNCTION__), // 當下function
            'content' => '',
            '_FILES'=>$_FILES,
            'base_url'=>base_url(),
        );

        // 中間挖掉的部分
        $content_div = $this->parser->parse('jquery_test/xss_images_view', $data, true);
        // 中間部分塞入外框
        $html_date = $data ;
        $html_date['content_div'] = $content_div ;
        //$html_date['js'][] = 'js/xss.js';
        //$html_date['js'][] = 'images/new_oops.png';

        $view = $this->parser->parse('index_view', $html_date, true);
        $this->pub->remove_view_space($view);
    }
}
?>