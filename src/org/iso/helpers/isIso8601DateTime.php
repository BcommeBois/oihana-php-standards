<?php

namespace org\iso\helpers;

/**
 * Validates whether a string is a valid ISO 8601 date-time.
 *
 * Accepted shape:
 * - Date  : `YYYY-MM-DD` (extended)
 * - Sep.  : `T` (mandatory in strict mode, space allowed otherwise)
 * - Time  : `HH:MM:SS`, optionally with fractional seconds (`.fff...`)
 * - Offset: optional `Z`, `±HH:MM` or `±HHMM`
 *
 * The function checks both the syntactic format and the calendar validity
 * (February 30 is rejected, leap years are honored).
 *
 * @param string $value  The date-time string to validate
 * @param bool   $strict If true, the `T` separator is mandatory (default: false)
 *
 * @return bool True if the string is a valid ISO 8601 date-time, false otherwise
 *
 * @example
 * ```php
 * isIso8601DateTime('2026-05-14T08:15:30Z');         // true
 * isIso8601DateTime('2026-05-14T08:15:30+02:00');    // true
 * isIso8601DateTime('2026-05-14T08:15:30.123Z');     // true (milliseconds)
 * isIso8601DateTime('2026-05-14 08:15:30');          // true (space separator)
 * isIso8601DateTime('2026-05-14 08:15:30', true);    // false (strict requires T)
 * isIso8601DateTime('2026-02-30T00:00:00Z');         // false (invalid calendar date)
 * isIso8601DateTime('2026-05-14T24:00:00');          // false (invalid hour)
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations ISO 8601 combined representations
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function isIso8601DateTime( string $value , bool $strict = false ): bool
{
    $separator = $strict ? 'T' : 'T ' ;

    $pattern = '/^'
        . '(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])'         // date
        . '[' . $separator . ']'                                   // separator
        . '([01]\d|2[0-3]):([0-5]\d):([0-5]\d)(?:\.\d+)?'         // time
        . '(?:Z|[+\-](?:[01]\d|2[0-3]):?[0-5]\d)?'                // optional offset
        . '$/' ;

    if ( !preg_match( $pattern , $value , $m ) )
    {
        return false ;
    }

    return checkdate( (int) $m[2] , (int) $m[3] , (int) $m[1] ) ;
}
