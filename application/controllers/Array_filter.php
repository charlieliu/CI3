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
        $data['content'] = [];

        $entry = [0 => 'foo', 1 => false, 2 => -1, 3 => null, 4 => '', 'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, ];
        $data['content'][] = [
            'class'=>'bg_gray_2',
            'string'=>'$entry<br>'.var_export($entry, TRUE).'<br>',
        ];
        $data['content'][] = [
            'class'=>'bg_gray_1',
            'string'=>'array_filter($entry)<br>'.var_export(array_filter($entry), TRUE).'<br>',
        ];
        $data['content'][] = [
            'class'=>'bg_gray_1',
            'string'=>'array_filter($entry, function($v) { return $v == "b";})<br>'.var_export(array_filter($entry, function($v) { return $v==3;}), TRUE).'<br>',
        ];
        $data['content'][] = [
            'class'=>'bg_gray_1',
            'string'=>'array_map(function ($v) { return $v ?: null; }, $entry)<br>'.var_export(array_map(function ($v) { return $v ?: null; }, $entry), TRUE).'<br>',
        ];

        $array1 = array("a"=>1, "b"=>2, "c"=>3, "d"=>4, "e"=>5);
        $data['content'][] = [
            'class'=>'bg_gray_2',
            'string'=>'$array1<br>'.var_export($array1, TRUE).'<br>',
        ];
        $data['content'][] = [
            'class'=>'bg_gray_1',
            'string'=>'function odd($var){ return($var & 1); }<br>array_filter($array1, "odd")<br>'.var_export(array_filter($array1, "odd"), TRUE).'<br>',
        ];

        $array2 = array(6, 7, 8, 9, 10, 11, 12);
        $data['content'][] = [
            'class'=>'bg_gray_2',
            'string'=>'$array2'.'<br>'.var_export($array2, TRUE).'<br>',
        ];
        $data['content'][] = [
            'class'=>'bg_gray_1',
            'string'=>'function even($var){ return(!($var & 1)); }<br>array_filter($array2, "even")<br>'.var_export(array_filter($array2, "even"), TRUE).'<br>',
        ];

        // $content_div .= var_dump(array_filter($arr, function($v, $k) {
        //     return $k == 'b' || $v == 4;
        // }, 1));

        $content_div = $this->parser->parse('php_test/array_filter_grid_view', $data, true);

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