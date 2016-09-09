<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// returns whether the input integer is odd
function odd($var){ return($var & 1); }

// returns whether the input integer is even
function even($var){ return(!($var & 1)); }

class Array_filter extends CI_Controller {

    /**
     * @author Charlie Liu <liuchangli0107@gmail.com>
     */
    public function index()
    {
        // 中間挖掉的部分
        $content_div = '';

        $entry = [0 => 'foo', 1 => false, 2 => -1, 3 => null, 4 => '', ];
        $content_div .= '$entry'.'<br>';
        $content_div .= print_r($entry, TRUE).'<br><br>';
        $content_div .= 'array_filter($entry)'.'<br>';
        $content_div .= print_r(array_filter($entry), TRUE).'<br><br>';

        $array1 = array("a"=>1, "b"=>2, "c"=>3, "d"=>4, "e"=>5);
        $content_div .= '$array1'.'<br>';
        $content_div .= print_r($array1, TRUE).'<br><br>';
        $content_div .= 'array_filter($array1, "odd")'.'<br>';
        $content_div .= print_r(array_filter($array1, "odd"), TRUE).'<br><br>';

        $array2 = array(6, 7, 8, 9, 10, 11, 12);
        $content_div .= '$array2'.'<br>';
        $content_div .= print_r($array2, TRUE).'<br><br>';
        $content_div .= 'array_filter($array2, "even")'.'<br>';
        $content_div .= print_r(array_filter($array2, "even"), TRUE).'<br><br>';

        $arr = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $content_div .= '$arr'.'<br>';
        $content_div .= print_r($arr, TRUE).'<br><br>';
        $content_div .= 'array_filter($arr, function($v) { return $v == "b";})'.'<br>';
        $content_div .= print_r(array_filter($arr, function($v) { return $v==3;}), TRUE).'<br><br>';

        $content_div .= 'array_map(function ($v) { return $v ?: null; }, $arr)'.'<br>';
        $content_div .=  print_r(array_map(function ($v) { return $v ?: null; }, $arr), TRUE).'<br><br>';

        // $content_div .= var_dump(array_filter($arr, function($v, $k) {
        //     return $k == 'b' || $v == 4;
        // }, 1));

        // 中間部分塞入外框
        $html_date = [
            'title' => 'Array_filter 測試',
            'current_title' => 'Array_filter 測試',
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