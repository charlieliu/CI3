<?php

namespace Services;

use DateTimeInterface;

DateTime implements DateTimeInterface {
    /* Constants */
    const string ATOM = "Y-m-d\TH:i:sP" ;
    const string COOKIE = "l, d-M-Y H:i:s T" ;
    const string ISO8601 = "Y-m-d\TH:i:sO" ;
    const string RFC822 = "D, d M y H:i:s O" ;
    const string RFC850 = "l, d-M-y H:i:s T" ;
    const string RFC1036 = "D, d M y H:i:s O" ;
    const string RFC1123 = "D, d M Y H:i:s O" ;
    const string RFC2822 = "D, d M Y H:i:s O" ;
    const string RFC3339 = "Y-m-d\TH:i:sP" ;
    const string RSS = "D, d M Y H:i:s O" ;
    const string W3C = "Y-m-d\TH:i:sP" ;
    /* Methods */
    public __construct ([ string $time = "now" [, DateTimeZone $timezone = NULL ]] )
    public DateTime add ( DateInterval $interval )
    public static DateTime createFromFormat ( string $format , string $time [, DateTimeZone $timezone = date_default_timezone_get() ] )
    public static array getLastErrors ( void )
    public DateTime modify ( string $modify )
    public static DateTime __set_state ( array $array )
    public DateTime setDate ( int $year , int $month , int $day )
    public DateTime setISODate ( int $year , int $week [, int $day = 1 ] )
    public DateTime setTime ( int $hour , int $minute [, int $second = 0 ] )
    public DateTime setTimestamp ( int $unixtimestamp )
    public DateTime setTimezone ( DateTimeZone $timezone )
    public DateTime sub ( DateInterval $interval )
    public DateInterval diff ( DateTimeInterface $datetime2 [, bool $absolute = false ] )
    public string format ( string $format )
    public int getOffset ( void )
    public int getTimestamp ( void )
    public DateTimeZone getTimezone ( void )
    public __wakeup ( void )
}