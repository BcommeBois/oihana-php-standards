<?php

namespace org\iso\helpers;

/**
 * Validates whether a string is a valid ISO 8601 calendar date.
 *
 * Accepted formats:
 * - Extended: `YYYY-MM-DD` (e.g. "2026-05-14")
 * - Basic   : `YYYYMMDD`   (e.g. "20260514"), unless `$strict` is true
 *
 * The function checks both the syntactic format and the calendar validity
 * (i.e. February 30 is rejected, leap years are honored).
 *
 * @param string $date   The date string to validate
 * @param bool   $strict If true, only the extended format `YYYY-MM-DD` is accepted (default: false)
 *
 * @return bool True if the string is a valid ISO 8601 date, false otherwise
 *
 * @example
 * ```php
 * isIso8601Date('2026-05-14');         // true
 * isIso8601Date('20260514');           // true (basic)
 * isIso8601Date('20260514', true);     // false (strict rejects basic)
 * isIso8601Date('2026-02-30');         // false (invalid calendar date)
 * isIso8601Date('2024-02-29');         // true  (leap year)
 * isIso8601Date('2023-02-29');         // false (not a leap year)
 * isIso8601Date('2026-5-14');          // false (month not zero-padded)
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates ISO 8601 calendar dates
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function isIso8601Date( string $date, bool $strict = false ): bool
{
    if ( preg_match('/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/' , $date , $m ) )
    {
        return checkdate( (int) $m[2] , (int) $m[3] , (int) $m[1] ) ;
    }

    if ( !$strict && preg_match('/^(\d{4})(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])$/' , $date , $m ) )
    {
        return checkdate( (int) $m[2] , (int) $m[3] , (int) $m[1] ) ;
    }

    return false ;
}
