<?php

namespace org\iso\helpers;

/**
 * Validates whether a string is a valid ISO 8601 recurring interval.
 *
 * The format is `R[n]/<interval>` where:
 * - `R` is the recurrence designator (required)
 * - `n` is an optional non-negative integer count (absent means infinite)
 * - `<interval>` is any valid ISO 8601 bounded interval — see {@see isIso8601Interval()}
 *
 * @param string $value The recurrence string to validate
 *
 * @return bool True if the string is a valid ISO 8601 recurrence, false otherwise
 *
 * @example
 * ```php
 * isIso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');     // true (infinite)
 * isIso8601Recurrence('R5/2026-05-14T00:00:00Z/P1D');    // true (5 occurrences)
 * isIso8601Recurrence('R0/2026-05-14T00:00:00Z/PT0S');   // true (zero, degenerate)
 * isIso8601Recurrence('R10/P1D/2026-05-15T00:00:00Z');   // true
 * isIso8601Recurrence('2026-05-14T00:00:00Z/P1D');       // false (missing R)
 * isIso8601Recurrence('R-1/P1D/2026-05-15T00:00:00Z');   // false (negative count)
 * isIso8601Recurrence('R/P1D');                          // false (interval must be bounded)
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Repeating_intervals ISO 8601 Repeating intervals
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function isIso8601Recurrence( string $value ): bool
{
    if ( !preg_match( '/^R(\d*)\/(.+)$/' , $value , $m ) )
    {
        return false ;
    }

    return isIso8601Interval( $m[2] ) ;
}
