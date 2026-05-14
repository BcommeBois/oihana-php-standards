<?php

namespace org\iso;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use InvalidArgumentException;

use function org\iso\helpers\isIso8601DateTime;
use function org\iso\helpers\toIso8601DateTime;

/**
 * Represents and manipulates ISO 8601 date-time strings (combined date + time).
 *
 * Wraps a PHP `DateTimeImmutable` and keeps the ISO 8601 string representation
 * synchronized with both the internal date-time object and a configurable
 * output {@see precision}.
 *
 * Only the **strict** ISO 8601 form is accepted in the `iso` setter: the date
 * must be `YYYY-MM-DD`, the separator must be `T` (not a space), and the time
 * `HH:MM:SS[.fff…]` with an optional `Z` or `±HH:MM` offset.
 *
 * Output precision is governed by the {@see TimePrecision} constants:
 * - {@see TimePrecision::SECONDS}      — `2026-05-14T08:15:30Z`
 * - {@see TimePrecision::MILLISECONDS} — `2026-05-14T08:15:30.123Z`
 * - {@see TimePrecision::MICROSECONDS} — `2026-05-14T08:15:30.123456Z`
 *
 * When an ISO string is assigned, the precision is auto-detected from the
 * number of fractional digits present.
 *
 * Example usage:
 * ```php
 * use org\iso\Iso8601DateTime;
 * use org\iso\TimePrecision;
 *
 * // From ISO string
 * $dt = new Iso8601DateTime('2026-05-14T08:15:30+02:00');
 * echo $dt->datePart->year;     // 2026
 * echo $dt->timePart->hours;    // 8
 * echo $dt->timezone->getName();// "+02:00"
 *
 * // Switch precision (re-renders iso)
 * $dt->precision = TimePrecision::MILLISECONDS;
 * echo $dt->iso;                // "2026-05-14T08:15:30.000+02:00"
 *
 * // Round-trip via DateTimeImmutable
 * $dt->dateTime = new DateTimeImmutable('2030-01-01T00:00:00Z');
 * echo $dt->iso;                // "2030-01-01T00:00:00.000Z" (precision preserved)
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class Iso8601DateTime
{
    /**
     * Creates a new Iso8601DateTime instance.
     *
     * @param string|DateTimeInterface|null $dateTime ISO string (strict T separator), DateTime, or null for {@see ZERO}
     *
     * @throws InvalidArgumentException If the input is invalid
     */
    public function __construct( string|DateTimeInterface|null $dateTime = null )
    {
        $this->_dateTime  = new DateTimeImmutable( self::ZERO ) ;
        $this->_iso       = self::ZERO ;
        $this->_precision = TimePrecision::SECONDS ;

        if ( $dateTime instanceof DateTimeInterface )
        {
            $this->dateTime = $dateTime ;
        }
        else if ( $dateTime !== null )
        {
            $this->iso = $dateTime ;
        }
    }

    /**
     * Strict ISO 8601 date-time pattern: `YYYY-MM-DDTHH:MM:SS[.fff…][Z|±HH:MM]`.
     */
    public const string PATTERN =
        '/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])'
        . 'T([01]\d|2[0-3]):([0-5]\d):([0-5]\d)(?:\.(\d+))?'
        . '(Z|[+\-](?:[01]\d|2[0-3]):?[0-5]\d)?$/'
    ;

    /**
     * The base format (without fractional seconds or offset): `Y-m-d\TH:i:s`.
     */
    public const string FORMAT = 'Y-m-d\TH:i:s' ;

    /**
     * Time designator (separates date and time components).
     */
    public const string TIME = 'T' ;

    /**
     * Timezone designator for UTC.
     */
    public const string TIME_ZONE = 'Z' ;

    /**
     * Zero date-time constant (Unix epoch, UTC).
     */
    public const string ZERO = '1970-01-01T00:00:00Z' ;

    /**
     * ISO string representation (e.g. "2026-05-14T08:15:30Z").
     */
    public string $iso
    {
        get => $this->_iso ;
        set
        {
            if ( !isIso8601DateTime( $value , true ) )
            {
                throw new InvalidArgumentException( "Invalid ISO 8601 date-time: $value" ) ;
            }

            try
            {
                $dt = new DateTimeImmutable( $value ) ;
            }
            catch ( Exception $e )
            {
                throw new InvalidArgumentException( "Invalid date-time value: $value" , 0 , $e ) ;
            }

            $this->_dateTime  = $dt ;
            $this->_precision = self::detectPrecision( $value ) ;
            $this->_iso       = toIso8601DateTime( $dt , $this->_precision ) ;
        }
    }

    /**
     * The internal immutable date-time representation.
     * @var DateTimeInterface
     */
    public DateTimeInterface $dateTime
    {
        get => $this->_dateTime ;
        set
        {
            $this->_dateTime = $value instanceof DateTimeImmutable ? $value : DateTimeImmutable::createFromInterface( $value ) ;
            $this->_iso      = toIso8601DateTime( $this->_dateTime , $this->_precision ) ;
        }
    }

    /**
     * Derived {@see Iso8601Date} representing the calendar-date portion.
     * Returns a fresh object on each access; mutating it does not affect this instance.
     */
    public Iso8601Date $datePart
    {
        get => new Iso8601Date( $this->_dateTime ) ;
    }

    /**
     * Derived {@see Iso8601Time} representing the time-of-day portion.
     * Returns a fresh object on each access; mutating it does not affect this instance.
     */
    public Iso8601Time $timePart
    {
        get => new Iso8601Time( $this->_dateTime ) ;
    }

    /**
     * Timezone of the underlying date-time, or null if none is set.
     */
    public ?DateTimeZone $timezone
    {
        get => $this->_dateTime->getTimezone() ?: null ;
    }

    /**
     * Output precision used when rendering {@see iso}.
     *
     * Assigning a new precision regenerates the ISO string.
     *
     * @throws InvalidArgumentException If the value is not a {@see TimePrecision} constant.
     */
    public string $precision
    {
        get => $this->_precision ;
        set
        {
            if ( !TimePrecision::includes( $value ) )
            {
                throw new InvalidArgumentException(
                    "Invalid precision: '$value' (expected one of: " . implode(', ', TimePrecision::enums()) . ')'
                ) ;
            }
            $this->_precision = $value ;
            $this->_iso       = toIso8601DateTime( $this->_dateTime , $value ) ;
        }
    }

    /**
     * String cast returns the ISO representation.
     */
    public function __toString(): string
    {
        return $this->_iso ;
    }

    // --------------------- INTERNALS ---------------------

    /**
     * Detects the {@see TimePrecision} of an ISO 8601 date-time string from its
     * fractional-second component (0 digits → SECONDS, 1–3 → MILLISECONDS,
     * ≥4 → MICROSECONDS).
     */
    private static function detectPrecision( string $iso ): string
    {
        if ( preg_match( '/\.(\d+)(?:Z|[+\-]|$)/' , $iso , $m ) )
        {
            return strlen( $m[1] ) <= 3 ? TimePrecision::MILLISECONDS : TimePrecision::MICROSECONDS ;
        }
        return TimePrecision::SECONDS ;
    }

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $_dateTime ;

    /**
     * @var string
     */
    private string $_iso ;

    /**
     * @var string
     */
    private string $_precision ;
}
