<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Standard ISO 8601 date and time format patterns.
 *
 * Provides a single entry point for the most commonly used ISO 8601 format
 * strings, compatible with PHP's {@see \DateTimeInterface::format()}.
 *
 * Two representations are supported:
 * - **Extended** : separators are used (e.g. `2026-05-14T08:15:30+02:00`)
 * - **Basic**    : separators are omitted (e.g. `20260514T081530+0200`)
 *
 * Example usage:
 * ```php
 * use org\iso\Iso8601Format;
 *
 * $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
 *
 * echo $now->format( Iso8601Format::DATE );           // "2026-05-14"
 * echo $now->format( Iso8601Format::DATE_TIME_ZULU ); // "2026-05-14T08:15:30Z"
 * echo $now->format( Iso8601Format::DATE_TIME );      // "2026-05-14T08:15:30+00:00"
 *
 * Iso8601Format::includes('Y-m-d');                   // true
 * Iso8601Format::getConstant('Y-m-d\TH:i:s\Z');       // "DATE_TIME_ZULU"
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601 ISO 8601 specification
 * @link https://www.php.net/manual/en/datetime.format.php PHP date format characters
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class Iso8601Format
{
    use ConstantsTrait ;

    /**
     * Calendar date in extended format: `Y-m-d` (e.g. "2026-05-14").
     */
    public const string DATE = 'Y-m-d' ;

    /**
     * Calendar date in basic format: `Ymd` (e.g. "20260514").
     */
    public const string DATE_BASIC = 'Ymd' ;

    /**
     * Local date and time in extended format, without timezone: `Y-m-d\TH:i:s`
     * (e.g. "2026-05-14T08:15:30").
     */
    public const string DATE_TIME_LOCAL = 'Y-m-d\TH:i:s' ;

    /**
     * Date and time in extended format with timezone offset: `Y-m-d\TH:i:sP`
     * (e.g. "2026-05-14T08:15:30+02:00").
     */
    public const string DATE_TIME = 'Y-m-d\TH:i:sP' ;

    /**
     * Date and time in extended format in UTC ("Zulu"): `Y-m-d\TH:i:s\Z`
     * (e.g. "2026-05-14T08:15:30Z").
     */
    public const string DATE_TIME_ZULU = 'Y-m-d\TH:i:s\Z' ;

    /**
     * Date and time with milliseconds and timezone offset: `Y-m-d\TH:i:s.vP`
     * (e.g. "2026-05-14T08:15:30.123+02:00").
     */
    public const string DATE_TIME_MILLI = 'Y-m-d\TH:i:s.vP' ;

    /**
     * Date and time with milliseconds in UTC ("Zulu"): `Y-m-d\TH:i:s.v\Z`
     * (e.g. "2026-05-14T08:15:30.123Z").
     */
    public const string DATE_TIME_MILLI_ZULU = 'Y-m-d\TH:i:s.v\Z' ;

    /**
     * Date and time with microseconds and timezone offset: `Y-m-d\TH:i:s.uP`
     * (e.g. "2026-05-14T08:15:30.123456+02:00").
     */
    public const string DATE_TIME_MICRO = 'Y-m-d\TH:i:s.uP' ;

    /**
     * Date and time with microseconds in UTC ("Zulu"): `Y-m-d\TH:i:s.u\Z`
     * (e.g. "2026-05-14T08:15:30.123456Z").
     */
    public const string DATE_TIME_MICRO_ZULU = 'Y-m-d\TH:i:s.u\Z' ;

    /**
     * Date and time in basic format with offset: `Ymd\THisO`
     * (e.g. "20260514T081530+0200").
     */
    public const string DATE_TIME_BASIC = 'Ymd\THisO' ;

    /**
     * Date and time in basic format in UTC ("Zulu"): `Ymd\THis\Z`
     * (e.g. "20260514T081530Z").
     */
    public const string DATE_TIME_BASIC_ZULU = 'Ymd\THis\Z' ;

    /**
     * Time of day in extended format, without timezone: `H:i:s` (e.g. "08:15:30").
     */
    public const string TIME = 'H:i:s' ;

    /**
     * Time of day with timezone offset: `H:i:sP` (e.g. "08:15:30+02:00").
     */
    public const string TIME_OFFSET = 'H:i:sP' ;

    /**
     * Time of day in UTC ("Zulu"): `H:i:s\Z` (e.g. "08:15:30Z").
     */
    public const string TIME_ZULU = 'H:i:s\Z' ;

    /**
     * Time of day in basic format: `His` (e.g. "081530").
     */
    public const string TIME_BASIC = 'His' ;

    /**
     * ISO 8601 ordinal date: `Y-z` (e.g. "2026-134").
     *
     * Note: PHP's `z` format yields a zero-based day of year (0–365), whereas
     * the ISO ordinal day is 1-based. Prefer building the string manually
     * when strict compliance is required.
     */
    public const string ORDINAL_DATE = 'Y-z' ;

    /**
     * ISO 8601 week date in extended format: `o-\WW-N`
     * (e.g. "2026-W20-4" for the 4th day of week 20 of ISO year 2026).
     */
    public const string WEEK_DATE = 'o-\WW-N' ;

    /**
     * ISO 8601 week date in basic format: `o\WWN` (e.g. "2026W204").
     */
    public const string WEEK_DATE_BASIC = 'o\WWN' ;

    /**
     * ISO 8601 week (without day): `o-\WW` (e.g. "2026-W20").
     */
    public const string WEEK = 'o-\WW' ;

    /**
     * Year and month: `Y-m` (e.g. "2026-05").
     */
    public const string YEAR_MONTH = 'Y-m' ;

    /**
     * Year only: `Y` (e.g. "2026").
     */
    public const string YEAR = 'Y' ;
}
