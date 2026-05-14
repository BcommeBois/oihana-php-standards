<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Time precision levels for ISO 8601 fractional second representations.
 *
 * Used by date-time helpers to control how many digits of the fractional
 * second component are rendered:
 * - {@see SECONDS}      — no fractional part (e.g. "08:15:30")
 * - {@see MILLISECONDS} — 3 digits (e.g. "08:15:30.123")
 * - {@see MICROSECONDS} — 6 digits (e.g. "08:15:30.123456")
 *
 * Example usage:
 * ```php
 * use org\iso\TimePrecision;
 * use function org\iso\helpers\toIso8601DateTime;
 *
 * toIso8601DateTime( $dt , TimePrecision::MILLISECONDS ) ;
 *
 * TimePrecision::includes('milliseconds');     // true
 * TimePrecision::getConstant('microseconds');  // "MICROSECONDS"
 * TimePrecision::enums();                      // ['microseconds','milliseconds','seconds']
 * ```
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class TimePrecision
{
    use ConstantsTrait ;

    /**
     * Microsecond precision (6 fractional digits).
     */
    public const string MICROSECONDS = 'microseconds' ;

    /**
     * Millisecond precision (3 fractional digits).
     */
    public const string MILLISECONDS = 'milliseconds' ;

    /**
     * Whole-second precision (no fractional part).
     */
    public const string SECONDS = 'seconds' ;
}
