<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Services\Atm_services;
use Services\Tools_services;

class Composer_test extends CI_Controller {

    public $current_title = 'Composer 測試';
    public $UserAgent = array() ;

    public $page_list = '';
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

        $this->load->helper(array('form', 'url'));

        $this->load->model('php_test_model','',TRUE) ;

        $this->pub->check_login();

        $this->UserAgent = $this->pub->get_UserAgent() ;
        if( isset($this->UserAgent['O']) )
        {
            $this->php_test_model->query_user_agent($this->UserAgent) ;
        }

        // 顯示資料
        $content = [];
        $this->page_list = $content ;
    }

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function index()
    {
        $atm_services = new Atm_services;

        // 中間挖掉的部分
        $content_div = $atm_services->echo_class();

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
}
?>