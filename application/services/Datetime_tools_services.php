<?php

namespace Services;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Collection;

class Datetime_tools_services
{
    // public $CI;
    public function __construct()
    {
        // $this->CI = & get_instance();
    }

    public function get_show_date()
    {
        // $this->CI->load->helper('date') ;
        $date_ary = [];

        $date_ary['PHP_date'] = date('Y-m-d H:i:s') ;

        $time = time() ;
        $date_ary['PHP_time'] = $time ;

        // eturns the current time as a Unix timestamp
        $date_ary['PHP_now'] = now() ;

        // If a timestamp is not included in the second parameter the current time will be used.
        $datestring = "Year: %Y Month: %m Day: %d - %h:%i %a" ;
        $date_ary['PHP_mdate'] = mdate($datestring, $time);

        // Lets you generate a date string in one of several standardized formats
        //$date_ary['standard_date'] = array() ;
        $format = array() ;
        $format[] = 'DATE_ATOM';
        $format[] = 'DATE_COOKIE';
        $format[] = 'DATE_ISO8601';
        $format[] = 'DATE_RFC822';
        $format[] = 'DATE_RFC850';
        $format[] = 'DATE_RFC1036';
        $format[] = 'DATE_RFC1123';
        $format[] = 'DATE_RFC2822';
        $format[] = 'DATE_RSS';
        $format[] = 'DATE_W3C';
        foreach ($format as $value) {
            //$date_ary['standard_date']['CI_'.$value] = standard_date($value, $time) ;
            $date_ary['CI_'.$value] = standard_date($value, $time) ;
        }

        // Takes a Unix timestamp as input and returns it as GMT
        $date_ary['PHP_local_to_gmt'] = local_to_gmt($time) ;

        // Takes a timezone reference (for a list of valid timezones，see the "Timezone Reference" below) and returns the number of hours offset from UTC.
        $date_ary['PHP_timezones'] = timezones('UM8') ;


        $dt = new DateTime();

        $TPTTZ = new DateTimeZone('Asia/Taipei');
        $dt->setTimezone($TPTTZ);
        $date_ary['Asia/Taipei'] = $dt->format(DATE_RFC822);

        $MNTTZ = new DateTimeZone('America/Denver');
        $dt->setTimezone($MNTTZ);
        $date_ary['America/Denver'] = $dt->format(DATE_RFC822);

        $ESTTZ = new DateTimeZone('America/New_York');
        $dt->setTimezone($ESTTZ);
        $date_ary['America/New_York'] = $dt->format(DATE_RFC822);

        $date_ary['Note'] = 'Dates in the m/d/y or d-m-y formats are disambiguated by looking at the separator between the various components: if the separator is a slash (/), then the American m/d/y is assumed; whereas if the separator is a dash (-) or a dot (.), then the European d-m-y format is assumed. If, however, the year is given in a two digit format and the separator is a dash (-, the date string is parsed as y-m-d. To avoid potential ambiguity, it\'s best to use ISO 8601 (YYYY-MM-DD) dates or DateTime::createFromFormat() when possible.';

        $date_ary["strtotime('01/08/2016')"] = strtotime('01/08/2016');
        $date_ary["strtotime('01-08-2016')"] = strtotime('01-08-2016');
        $date_ary["strtotime('08/01/2016')"] = strtotime('08/01/2016');
        $date_ary["strtotime('08-01-2016')"] = strtotime('08-01-2016');
        $date_ary["strtotime('2016/08/01)"] = strtotime('2016/08/01');
        $date_ary["strtotime('2016-08-01')"] = strtotime('2016-08-01');

        $date_ary["strtotime('16/08/2016')"] = strtotime('16/08/2016');
        $date_ary["strtotime('16-08-2016')"] = strtotime('16-08-2016');
        $date_ary["strtotime('08/16/2016')"] = strtotime('08/16/2016');
        $date_ary["strtotime('08-16-2016')"] = strtotime('08-16-2016');
        $date_ary["strtotime('2016/08/16)"] = strtotime('2016/08/16');
        $date_ary["strtotime('2016-08-16')"] = strtotime('2016-08-16');

        return $date_ary ;
    }
}