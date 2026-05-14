<?php

namespace org\iso\helpers;

use DateTimeInterface;
use org\iso\Iso8601Format;

/**
 * Converts a DateTimeInterface object to its ISO 8601 calendar date string.
 *
 * The output format is `YYYY-MM-DD` by default (ISO 8601 extended), or
 * `YYYYMMDD` if `$basic` is true (ISO 8601 basic).
 *
 * The time and timezone components of the input are ignored; only the
 * calendar date (year, month, day) in the object's own timezone is used.
 *
 * @param DateTimeInterface $date  The date to convert
 * @param bool              $basic If true, returns the basic format `YYYYMMDD` (default: false)
 *
 * @return string The ISO 8601 date string, e.g. "2026-05-14" or "20260514"
 *
 * @example
 * ```php
 * use org\iso\helpers\toIso8601Date;
 * use DateTimeImmutable;
 *
 * $dt = new DateTimeImmutable('2026-05-14 08:15:30');
 * echo toIso8601Date($dt);         // "2026-05-14"
 * echo toIso8601Date($dt, true);   // "20260514"
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates ISO 8601 calendar dates
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function toIso8601Date( DateTimeInterface $date , bool $basic = false ) :string
{
    return $date->format( $basic ? Iso8601Format::DATE_BASIC : Iso8601Format::DATE ) ;
}
