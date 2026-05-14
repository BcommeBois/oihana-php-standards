<?php

namespace org\iso\helpers;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use org\iso\TimePrecision;

/**
 * Converts a DateTimeInterface object to its ISO 8601 date-time string.
 *
 * Output shape:
 * - `YYYY-MM-DDTHH:MM:SS[.fff...]Z`           when offset is zero
 * - `YYYY-MM-DDTHH:MM:SS[.fff...]±HH:MM`      otherwise
 *
 * The offset is normalized to `±HH:MM` (or `Z` for UTC) regardless of the
 * underlying timezone object, mirroring the behavior of {@see toIso8601Time()}.
 *
 * @param DateTimeInterface $dt        The date-time to convert
 * @param string            $precision One of the {@see TimePrecision} constants (default: {@see TimePrecision::SECONDS})
 * @param bool              $zulu      If true, the value is first converted to UTC and rendered with the `Z` suffix (default: false)
 *
 * @return string The ISO 8601 date-time string
 *
 * @throws InvalidArgumentException If `$precision` is not a recognized value
 *
 * @example
 * ```php
 * use org\iso\helpers\toIso8601DateTime;
 * use org\iso\TimePrecision;
 * use DateTimeImmutable;
 * use DateTimeZone;
 *
 * $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));
 *
 * echo toIso8601DateTime($dt);                                    // "2026-05-14T08:15:30+02:00"
 * echo toIso8601DateTime($dt, TimePrecision::MILLISECONDS);       // "2026-05-14T08:15:30.000+02:00"
 * echo toIso8601DateTime($dt, TimePrecision::SECONDS, true);      // "2026-05-14T06:15:30Z"
 *
 * $utc = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('UTC'));
 * echo toIso8601DateTime($utc);                         // "2026-05-14T08:15:30Z"
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations ISO 8601 combined representations
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function toIso8601DateTime( DateTimeInterface $dt , string $precision = TimePrecision::SECONDS , bool $zulu = false ) :string
{
    if ( $zulu )
    {
        $dt = ( $dt instanceof DateTimeImmutable ? $dt : DateTimeImmutable::createFromInterface( $dt ) )
            ->setTimezone( new DateTimeZone('UTC') ) ;
    }

    $fraction = match ( $precision )
    {
        TimePrecision::SECONDS      => '' ,
        TimePrecision::MILLISECONDS => '.' . substr( $dt->format('u') , 0 , 3 ) ,
        TimePrecision::MICROSECONDS => '.' . $dt->format('u') ,
        default                     => throw new InvalidArgumentException(
            "Invalid precision: '$precision' (expected one of: " . implode(', ', TimePrecision::enums()) . ')'
        ) ,
    } ;

    $offset = $dt->getOffset() ;

    if ( $offset === 0 )
    {
        $suffix = 'Z' ;
    }
    else
    {
        $hours  = intdiv( abs( $offset ) , 3600 ) ;
        $mins   = intdiv( abs( $offset ) % 3600 , 60 ) ;
        $sign   = $offset >= 0 ? '+' : '-' ;
        $suffix = sprintf( '%s%02d:%02d' , $sign , $hours , $mins ) ;
    }

    return $dt->format('Y-m-d\TH:i:s') . $fraction . $suffix ;
}
