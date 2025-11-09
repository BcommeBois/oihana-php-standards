<?php

namespace org\iso\helpers;

use DateInterval;
use Exception;

use org\iso\Iso8601Duration as ISO8601 ;

/**
 * Validates whether a string is a valid ISO 8601 duration format.
 *
 * This function checks if a given string conforms to the ISO 8601 duration specification.
 * The ISO 8601 duration format follows the pattern: P[n]Y[n]M[n]W[n]DT[n]H[n]M[n]S
 *
 * Valid formats include:
 * - Date components: P[n]Y[n]M[n]W[n]D (years, months, weeks, days)
 * - Time components: PT[n]H[n]M[n]S (hours, minutes, seconds)
 * - Combined: P[n]Y[n]M[n]DT[n]H[n]M[n]S
 * - Zero duration: P0D, PT0S, P0Y, etc.
 *
 * Rules:
 * - Must start with 'P' (period designator)
 * - 'T' separates date and time components (required if time components are present)
 * - At least one component must be present
 * - Components must be in correct order: Y, M, W/D, then T, then H, M, S
 * - Negative durations are not part of ISO 8601 standard but PHP accepts them
 *
 * @param string $duration The duration string to validate
 * @param bool   $strict   If true, uses regex validation; if false, uses PHP's DateInterval parser (default: false)
 *
 * @return bool True if the string is a valid ISO 8601 duration, false otherwise
 *
 * @example
 * ```php
 * validateIso8601Duration('P1Y2M3D'); // true
 * validateIso8601Duration('PT4H30M'); // true
 * validateIso8601Duration('P1W'); // true
 * validateIso8601Duration('P0D'); // true
 * validateIso8601Duration('INVALID'); // false
 * validateIso8601Duration('P'); // false (no components)
 * validateIso8601Duration('1Y2M'); // false (missing P)
 * ```
 *
 * @example
 * ```php
 * // Strict mode validation (regex-based)
 * validateIso8601Duration('P1Y2M3D', true); // true
 * validateIso8601Duration('P1.5Y', true); // false (no decimals in strict mode)
 * ```
 *
 * @example
 * ```php
 * // Form validation
 * if (!validateIso8601Duration($_POST['duration'])) {
 *     throw new Exception('Invalid duration format');
 * }
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Durations ISO 8601 Duration specification
 * @link https://www.php.net/manual/en/dateinterval.construct.php PHP DateInterval constructor
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
function isIso8601Duration( string $duration, bool $strict = false ) :bool
{
    if ( $strict )
    {
        if ( !preg_match(ISO8601::PATTERN , $duration, $matches ) )
        {
            return false ;
        }

        // Check that at least one component is present
        // matches[0] is the full match, matches[1-8] are the capture groups
        $hasComponent = false ;
        for  ($i = 1 ; $i < count($matches) ; $i++ )
        {
            if ( !empty( $matches[$i] ) )
            {
                $hasComponent = true ;
                break ;
            }
        }

        if ( !$hasComponent )
        {
            return false ; // "P" or "PT" alone are not valid
        }

        // If 'T' is present, check that at least one time component follows
        if ( str_contains( $duration , ISO8601::TIME ) )
        {
            // Extract the part after T
            $parts = explode(ISO8601::TIME , $duration ) ;
            if ( count( $parts ) !== 2 || empty( $parts[1] ) )
            {
                return false ; // "PT" without time components
            }
        }

        return true ;
    }

    try
    {
        new DateInterval( $duration ) ;
        return true;
    }
    catch (Exception $exception )
    {
        return false ;
    }
}