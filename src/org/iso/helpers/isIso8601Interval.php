<?php

namespace org\iso\helpers;

/**
 * Validates whether a string is a valid ISO 8601 time interval.
 *
 * An interval is two ISO 8601 expressions joined by a `/` separator, in one of
 * the following forms:
 * - `<start>/<end>`         — two strict date-times (e.g. `2026-05-14T00:00:00Z/2026-05-15T00:00:00Z`)
 * - `<start>/<duration>`    — a start date-time and a duration (e.g. `2026-05-14T00:00:00Z/P1D`)
 * - `<duration>/<end>`      — a duration and an end date-time (e.g. `P1D/2026-05-15T00:00:00Z`)
 *
 * The single-`<duration>` short form (e.g. `P1D` alone) is intentionally
 * rejected: use {@see org\iso\Iso8601Duration} for that case. Open intervals
 * (`--/<end>` and `<start>/--` from ISO 8601:2019) are also rejected for now.
 *
 * Date-time components are validated in strict mode (mandatory `T` separator).
 *
 * @param string $value The interval string to validate
 *
 * @return bool True if the string is a valid ISO 8601 interval, false otherwise
 *
 * @example
 * ```php
 * isIso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z'); // true
 * isIso8601Interval('2026-05-14T00:00:00Z/P1D');                  // true
 * isIso8601Interval('P1D/2026-05-15T00:00:00Z');                  // true
 * isIso8601Interval('P1D');                                        // false (use Iso8601Duration)
 * isIso8601Interval('P1D/P2D');                                    // false (two durations)
 * isIso8601Interval('--/2026-05-15T00:00:00Z');                    // false (open interval)
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Time_intervals ISO 8601 Time intervals
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function isIso8601Interval( string $value ): bool
{
    $parts = explode('/', $value);
    if ( count( $parts ) !== 2 )
    {
        return false ;
    }

    [ $left , $right ] = $parts ;

    if ( $left === '' || $right === '' )
    {
        return false ;
    }

    $leftIsDateTime  = isIso8601DateTime( $left  , true ) ;
    $leftIsDuration  = isIso8601Duration( $left  , true ) ;
    $rightIsDateTime = isIso8601DateTime( $right , true ) ;
    $rightIsDuration = isIso8601Duration( $right , true ) ;

    return match ( true )
    {
        $leftIsDateTime && $rightIsDateTime ,
        $leftIsDateTime && $rightIsDuration ,
        $leftIsDuration && $rightIsDateTime => true ,
        default                             => false ,
    } ;
}
