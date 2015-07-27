<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// 載入html使用的相關檔案
if(!function_exists('load_html_file'))
{
    function load_html_file($link)
    {
        $html = '';
        if( isset($link['href']) && !empty($link['href']) )
        {
            $file_type = strtolower(pathinfo($link['href'],PATHINFO_EXTENSION));
            switch($file_type)
            {
                case'js':
                    if( isset($link['href']) && !empty($link['href']) )
                    {
                        $html = '<script type="text/javascript" src="'.$link['href'];
                        if( isset($link['ver']) && !empty($link['ver']) )
                        {
                            $html .= '?'.$link['ver'];
                        }
                        $html .= '" integrity="sha512-'.hash_file('sha512',$link['href']).'" crossorigin="anonymous"></script>';
                    }
                    break;
                case'css':
                    if( isset($link['href']) && !empty($link['href']) )
                    {
                        $html = '<link';
                        if( isset($link['rel']) && !empty($link['rel']) )
                        {
                            $html .= ' rel="'.$link['rel'].'"';
                        }
                        else
                        {
                            $html .= ' rel="stylesheet"';
                        }
                        if( isset($link['type']) && !empty($link['type']) )
                        {
                            $html .= ' type="'.$link['type'].'"';
                        }
                        else
                        {
                            $html .= ' type="text/css" ';
                        }
                        $html .= ' href="'.$link['href'];
                        if( isset($link['ver']) && !empty($link['ver']) )
                        {
                            $html .= '?'.$link['ver'];
                        }
                        $html .= '" integrity="sha512-'.hash_file('sha512',$link['href']).'" crossorigin="anonymous" />';
                    }
                    break;
                default:
                    if( isset($link['type']) && $link['type']=='image/x-icon' )
                    {
                        $html = '<link rel="shortcut icon" type="image/x-icon" href="'.$link['href'].'" integrity="sha512-'.hash_file('sha512',$link['href']).'" crossorigin="anonymous" />';
                    }
                    break;
            }
        }
        return $html;
    }
}
?>