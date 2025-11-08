<?php

namespace org\iso\helpers;

use DateInterval;
use org\iso\Iso8601Duration as ISO8601 ;

/**
 * Converts a DateInterval object to its ISO 8601 duration string representation.
 *
 * This function generates a normalized ISO 8601 duration string from a PHP DateInterval object.
 * The ISO 8601 duration format follows the pattern: P[n]Y[n]M[n]DT[n]H[n]M[n]S
 * where P is the duration designator, T separates date and time components.
 *
 * Components:
 * - Y: years
 * - M: months (before T) or minutes (after T)
 * - D: days
 * - H: hours
 * - M: minutes
 * - S: seconds
 *
 * Only non-zero components are included in the output string.
 * If all components are zero, returns "P0D" (zero duration).
 *
 * @param DateInterval $interval The DateInterval object to convert
 *
 * @return string The ISO 8601 duration string (e.g., "P1Y2M3DT4H5M6S", "PT30M", "P0D")
 *
 * @example
 * ```php
 * // Create a duration of 1 year, 2 months, and 3 days
 * $interval = new DateInterval('P1Y2M3D');
 * echo toIso8601Duration($interval); // Output: "P1Y2M3D"
 * ```
 *
 * @example
 * ```php
 * // Create a duration of 4 hours and 30 minutes
 * $interval = new DateInterval('PT4H30M');
 * echo toIso8601Duration($interval); // Output: "PT4H30M"
 * ```
 *
 * @example
 * ```php
 * // Create a complex duration
 * $interval = new DateInterval('P2Y3M15DT12H45M30S');
 * echo toIso8601Duration($interval); // Output: "P2Y3M15DT12H45M30S"
 * ```
 *
 * @example
 * ```php
 * // Create an interval from date difference
 * $start = new DateTime('2024-01-01');
 * $end = new DateTime('2024-12-31');
 * $interval = $start->diff($end);
 * echo toIso8601Duration($interval); // Output: "P11M30D"
 * ```
 *
 * @example
 * ```php
 * // Zero duration
 * $interval = new DateInterval('PT0S');
 * echo toIso8601Duration($interval); // Output: "P0D"
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Durations ISO 8601 Duration specification
 * @link https://www.php.net/manual/en/class.dateinterval.php PHP DateInterval documentation
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
function toIso8601Duration( DateInterval $interval ) :string
{
    $iso = ISO8601::PERIOD ;

    if ( $interval->y > 0 ) $iso .= $interval->y . ISO8601::YEAR ;
    if ( $interval->m > 0 ) $iso .= $interval->m . ISO8601::MONTH ;
    if ( $interval->d > 0 ) $iso .= $interval->d . ISO8601::DAY ;

    $timePart = '' ;

    if ( $interval->h > 0 ) $timePart .= $interval->h . ISO8601::HOUR ;
    if ( $interval->i > 0 ) $timePart .= $interval->i . ISO8601::MINUTE ;
    if ( $interval->s > 0 ) $timePart .= $interval->s . ISO8601::SECOND ;

    if ( $timePart !== '' )
    {
        $iso .= ISO8601::TIME . $timePart ;
    }

    return ( $iso === ISO8601::PERIOD ) ? ISO8601::ZERO : $iso ;
}