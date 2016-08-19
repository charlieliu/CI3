<?php

namespace Services

DateTimeZone {
    /* Constants */
    const integer AFRICA = 1 ;
    const integer AMERICA = 2 ;
    const integer ANTARCTICA = 4 ;
    const integer ARCTIC = 8 ;
    const integer ASIA = 16 ;
    const integer ATLANTIC = 32 ;
    const integer AUSTRALIA = 64 ;
    const integer EUROPE = 128 ;
    const integer INDIAN = 256 ;
    const integer PACIFIC = 512 ;
    const integer UTC = 1024 ;
    const integer ALL = 2047 ;
    const integer ALL_WITH_BC = 4095 ;
    const integer PER_COUNTRY = 4096 ;
    /* Methods */
    public __construct ( string $timezone )
    public array getLocation ( void )
    public string getName ( void )
    public int getOffset ( DateTime $datetime )
    public array getTransitions ([ int $timestamp_begin [, int $timestamp_end ]] )
    public static array listAbbreviations ( void )
    public static array listIdentifiers ([ int $what = DateTimeZone::ALL [, string $country = NULL ]] )
}