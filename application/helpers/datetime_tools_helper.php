<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * chang datetime input for DB format
 * 18-AUG-2016
 * @param  string $dt input time value
 * @return  string datetime value
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
if (!function_exists('chk_datetime_input'))
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

/**
 * chang datetime input for DB format
 * 18-AUG-2016
 * @param  string $in_dt        datetime value
 * @param  string $to_tz        which timezone you want to change
 * @param  string $format    which format you want
 * @param  string $in_tz        form timezone
 * @param  string $use_dst   used dst or not
 * @return  string datetime value
 * @author Charlie Liu <liuchangli0107@gmail.com>
 */
if (!function_exists('conv_datetime'))
{
    function conv_datetime($in_dt, $to_tz, $format = 'Y/m/d H:i:s', $in_tz = 'Asia/Taipei', $use_dst = TRUE)
    {
        // change $in_dt to Y/m/d H:i:s
        $in_dt = chk_datetime_input($in_dt, 'Y/m/d H:i:s');

        // $in_dt does not datetime value or $to_tz does not exists
        if (empty($in_dt) || empty($to_tz)) return '';

        $in_tz_obj = new DateTimeZone($in_tz);

        $convTimeZone = new DateTime($in_dt, $in_tz_obj);

        $in_timestamp = $convTimeZone->getTimestamp();

        $in_is_dst = $in_tz_obj->getTransitions($in_timestamp, $in_timestamp)[0]['isdst'];

        $to_tz_obj = new DateTimeZone($to_tz);

        $convTimeZone->setTimeZone($to_tz_obj);

        if (!$use_dst)
        {
            $to_timestamp = $convTimeZone->getTimestamp();

            $to_is_dst = $to_tz_obj->getTransitions($to_timestamp, $to_timestamp)[0]['isdst'];

            if ( $to_is_dst == '1' && $in_is_dst == '0' )
            {
                $convTimeZone->setTimestamp($to_timestamp - 3600);
            }
            else if ( $to_is_dst == '0' && $in_is_dst == '1' )
            {
                $convTimeZone->setTimestamp($to_timestamp + 3600);
            }
        }

        return $convTimeZone->format($format);
    }
}

if (!function_exists('zone_format'))
{
    function time_zone_format($dt='', $timezone='', $formate='')
    {
        // change $in_dt to Y/m/d H:i:s
        $dt = chk_datetime_input($dt, 'Y/m/d H:i:s');

        $date_symbol_set = [
            'Europe/Rome'                => '/',
            'America/Los_Angeles'   => '-',
            'America/Denver'            => '-',
            'America/New_York'       => '-',
        ];
        $date_symbol_df = (!empty($date_symbol_set[$timezone])) ? $date_symbol_set[$timezone] : '';

        $format_set = [
            'Europe/Rome'                => 'dmY His',
            'America/Los_Angeles'   => 'mdY His',
            'America/Denver'            => 'mdY His',
            'America/New_York'       => 'mdY His',
        ];
        $formate_df = (!empty($format_set[$timezone])) ? $format_set[$timezone] : 'Ymd His';

        $date_symbol = $date_symbol_df;
        $date_format = $formate_df;
        if (!empty($formate))
        {
            $formate = str_replace('/', '', $formate);
            $formate = str_replace('-', '', $formate);
            $formate = str_replace(':', '', $formate);
            $date_format = $formate;

            $date_symbol = preg_match('/\-/', $formate) ? '-' : '/';
        }
        $date_symbol = empty($date_symbol) ? '/' : $date_symbol;

        $use_date_ary = [];
        $use_time_ary = [];
        foreach (str_split($date_format) as $char)
        {
            $pos = strpos(strtolower($formate_df), strtolower($char));

            if (FALSE !== $pos)
            {
                switch (strtolower($char))
                {
                    case 'y':
                    case 'm':
                    case 'd':
                        $use_date_ary[$pos] = $char;
                        break;
                    default:
                        $use_time_ary[$pos] = $char;
                        break;
                }
            }
        }

        ksort($use_date_ary);
        ksort($use_time_ary);

        $datetime_format = implode($date_symbol, $use_date_ary).' '.implode(':', $use_time_ary);
        $convTimeZone = new DateTime($dt);

        $in_timestamp = $convTimeZone->getTimestamp();

        return $convTimeZone->format($datetime_format);
    }
}
?>