<?php

namespace org\iso\helpers;

use DateTimeInterface;
use org\iso\Iso8601Time as ISO8601 ;

/**
 * Converts a DateTimeInterface object to its ISO 8601 time string representation.
 *
 * This function generates a normalized ISO 8601 time string from any PHP DateTimeInterface
 * object (`DateTime` or `DateTimeImmutable`). The output format is:
 *
 * - "THH:MM:SSZ" for UTC (zero offset)
 * - "THH:MM:SS±HH:MM" for non-zero offsets
 *
 * The 'T' prefix separates the time from a potential date component, and the timezone
 * designator can be 'Z' for UTC or a ±HH:MM offset.
 *
 * @param DateTimeInterface $time The time to convert to ISO 8601 format
 *
 * @return string The ISO 8601 time string, e.g. "T14:30:00Z" or "T08:15:30+02:00"
 *
 * @example
 * ```php
 * use org\iso\helpers\toIso8601Time;
 * use DateTimeImmutable;
 * use DateTimeZone;
 *
 * $dt = new DateTimeImmutable('14:30:00', new DateTimeZone('UTC'));
 * echo toIso8601Time($dt); // "T14:30:00Z"
 *
 * $dt2 = new DateTimeImmutable('08:15:30', new DateTimeZone('+02:00'));
 * echo toIso8601Time($dt2); // "T08:15:30+02:00"
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Times ISO 8601 Time specification
 * @link https://www.php.net/manual/en/class.datetimeinterface.php PHP DateTimeInterface documentation
 * @link https://www.php.net/manual/en/class.datetimeimmutable.php PHP DateTimeImmutable documentation
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
function toIso8601Time( DateTimeInterface $time ) :string
{
    $offset = $time->getOffset() ;

    if ( $offset === 0 )
    {
        $suffix = ISO8601::TIME_ZONE ;
    }
    else
    {
        $hours  = intdiv( abs( $offset ) , 3600 ) ;
        $mins   = intdiv(abs($offset) % 3600, 60 ) ;
        $sign   = $offset >= 0 ? '+' : '-' ;
        $suffix = sprintf('%s%02d:%02d' , $sign , $hours , $mins ) ;
    }

    return ISO8601::TIME . $time->format(ISO8601::FORMAT ) . $suffix ;
}