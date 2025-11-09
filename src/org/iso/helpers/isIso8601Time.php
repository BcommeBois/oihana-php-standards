<?php

namespace org\iso\helpers;

use org\iso\Iso8601Time;

/**
 * Validates whether a string is a valid ISO 8601 time format.
 *
 * This function checks if a given string conforms to the ISO 8601 time specification.
 * ISO 8601 time format includes:
 * - Optional 'T' prefix
 * - Hours (00-23)
 * - Optional minutes (00-59)
 * - Optional seconds (00-59, can be fractional)
 * - Optional timezone offset (Z for UTC or ±HH:MM)
 *
 * Examples of valid formats:
 * - "T14:30:00Z"       → 14:30:00 UTC
 * - "T08:15:30+02:00"  → 08:15:30 in UTC+2
 * - "T23:59:59"        → 23:59:59 local time (no offset)
 *
 * Rules:
 * - Hours must be 00-23
 * - Minutes and seconds, if present, must be 00-59
 * - Fractional seconds are allowed
 * - Timezone, if present, must be 'Z' or ±HH:MM
 *
 * @param string $time   The time string to validate
 * @param bool   $strict If true, validates strictly with regex; if false, uses DateTimeImmutable parser (default: false)
 *
 * @return bool True if the string is a valid ISO 8601 time, false otherwise
 *
 * @example
 * ```php
 * isIso8601Time('T14:30:00Z');       // true
 * isIso8601Time('T08:15:30+02:00');  // true
 * isIso8601Time('T23:59:59');        // true
 * isIso8601Time('14:30:00');         // false (missing T)
 * isIso8601Time('INVALID');           // false
 * ```
 *
 * @example
 * ```php
 * // Strict mode validation
 * isIso8601Time('T14:30:00.123Z', true); // true (fractional seconds allowed)
 * isIso8601Time('T14:60:00', true);      // false (invalid minutes)
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Times ISO 8601 Time specification
 * @link https://www.php.net/manual/en/class.datetimeimmutable.php PHP DateTimeImmutable documentation
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
function isIso8601Time( string $time, bool $strict = false ): bool
{
    if ( !preg_match(Iso8601Time::PATTERN , $time ) )
    {
        return false ;
    }

    if ( $strict )
    {
        return str_starts_with( $time, Iso8601Time::TIME ) ;
    }

    return true ;
}