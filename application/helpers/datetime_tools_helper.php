<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * chang datetime input for DB format
 * @param  string $dt input time value
 * @return  string datetime value
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
if(!function_exists('chk_datetime_input'))
{
    function chk_datetime_input($dt = NULL, $format = NULL)
    {
        // for integer
        if (is_numeric($dt)) $dt = date('Y/m/d H:i:s', $dt);

        if (empty($dt)) return '';

        // replace for d/m/Y
        if (FALSE == strtotime($dt)) $dt = str_replace('/', '-', $dt);

        // replace for m-d-Y
        if (FALSE == strtotime($dt)) $dt = str_replace('-', '/', $dt);

        // not datetime value
        if (FALSE === strtotime($dt)) return '';

        // default datetime format
        if (empty($format) && strlen($dt) == strlen('YYYY/mm/dd HH:ii:ss')) $format = 'Y/m/d H:i:s';
        if (empty($format) && strlen($dt) == strlen('YYYY/mm/dd HH:ii')) $format = 'Y/m/d H:i';
        if (empty($format) && strlen($dt) == strlen('YYYY/mm/dd')) $format = 'Y/m/d';

        if (empty($format)) return '';

        return date($format, strtotime($dt));
    }
}
?>