<?php

namespace org\iso;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use InvalidArgumentException;

use function org\iso\helpers\toIso8601Time;

/**
 * Represents and manipulates ISO 8601 time strings (without a date component).
 *
 * This class provides a convenient wrapper around PHP's `DateTimeImmutable` / `DateTimeInterface`
 * for handling times expressed in ISO 8601 format. It maintains synchronization between
 * the ISO 8601 string representation and the internal immutable time object.
 *
 * ISO 8601 time examples:
 * - "T14:30:00Z"       → 14:30:00 UTC
 * - "T08:15:30+02:00"  → 08:15:30 in UTC+2
 * - "T23:59:59"        → 23:59:59 local time (no offset)
 *
 * The time string may include hours, minutes, seconds (optionally fractional),
 * and a timezone offset ('Z' for UTC or ±HH:MM).
 *
 * Example usage:
 * ```php
 * use org\iso\Iso8601Time;
 *
 * // From ISO 8601 string
 * $time = new Iso8601Time('T14:30:00Z');
 * echo $time->hours;   // 14
 * echo $time->minutes; // 30
 * echo $time->seconds; // 0
 * echo $time->iso;     // "T14:30:00Z"
 *
 * // From DateTimeInterface
 * $dt = new DateTimeImmutable('08:15:30', new DateTimeZone('+02:00'));
 * $time2 = new Iso8601Time($dt);
 * echo $time2->toDateTime()->format('H:i:s P'); // "08:15:30 +02:00"
 *
 * // Modify the ISO string
 * $time2->iso = 'T12:00:00Z';
 *
 * // Modify using DateTimeInterface
 * $time2->time = new DateTimeImmutable('23:59:59');
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Times ISO 8601 Time specification
 * @link https://www.php.net/manual/en/class.datetimeimmutable.php PHP DateTimeImmutable documentation
 * @link https://www.php.net/manual/en/class.datetimeinterface.php PHP DateTimeInterface documentation
 *
 * @package org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
class Iso8601Time
{
    /**
     * Creates a new Iso8601Time instance.
     *
     * @param string|DateTimeImmutable|null $time ISO string, DateTime, or null for "T00:00:00"
     *
     * @throws InvalidArgumentException If the input is invalid
     */
    public function __construct( string|DateTimeInterface|null $time = null)
    {
        $this->_time = new DateTimeImmutable(self::ZERO ) ;
        $this->_iso  = self::TIME_ZERO;
        if ( $time instanceof DateTimeInterface )
        {
            $this->time = $time;
        }
        else if ( $time !== null )
        {
            $this->iso = $time;
        }
    }

    /**
     * ISO 8601 time pattern:
     * - Optional 'T' prefix
     * - Hours, optional minutes, optional seconds
     * - Optional timezone offset or 'Z'
     */
    public const string PATTERN =
        '/^T?'
        . '([01]\d|2[0-3])'              // hours (00-23)
        . '(?::([0-5]\d))?'              // optional minutes
        . '(?::([0-5]\d(?:\.\d+)?))?'    // optional seconds (can be decimal)
        . '(Z|[+\-](?:[01]\d|2[0-3]):?[0-5]\d)?$/' // optional timezone
    ;

    /**
     * The full time format.
     */
    public const string FORMAT = 'H:i:s' ;

    /**
     * The 24-hour format of an hour with leading zeros
     */
    public const string HOUR = 'H' ;

    /**
     * The 'minute' format character.
     * Minutes with leading zeros
     */
    public const string MINUTE = 'i' ;

    /**
     * The 'second' format character.
     * Seconds with leading zeros
     */
    public const string SECOND = 's' ;

    /**
     * Time designator (separates date and time components).
     */
    public const string TIME = 'T';

    /**
     * The Timezone designator.
     */
    public const string TIME_ZONE = 'Z' ;

    /**
     * Zero iso time constant.
     */
    public const string TIME_ZERO = 'T00:00:00' ;

    /**
     * Zero time constant.
     */
    public const string ZERO = '00:00:00' ;

    /**
     * ISO string representation (e.g. "T14:30:00Z").
     */
    public string $iso
    {
        get => $this->_iso ;
        set
        {
            if ( !preg_match(self::PATTERN , $value , $matches ) )
            {
                throw new InvalidArgumentException("Invalid ISO 8601 time: $value") ;
            }

            [, $h, $m, $s, $tz] = array_pad( $matches , 5 , null ) ;
            $m ??= '00' ;
            $s ??= '00' ;

            $tzObj = null;
            if ( $tz )
            {
                $tzObj = ( $tz === self::TIME_ZONE ) ? new DateTimeZone('UTC' ) : new DateTimeZone($tz);
            }

            try
            {
                $dt = new DateTimeImmutable( sprintf('%02d:%02d:%s', $h, $m, $s), $tzObj );
            }
            catch (Exception $e)
            {
                throw new InvalidArgumentException("Invalid time value: $value", 0, $e);
            }

            $this->_time = $dt ;
            $this->_iso  = toIso8601Time( $dt ) ;
        }
    }

    /**
     * The internal immutable time representation.
     * @var DateTimeInterface
     */
    public DateTimeInterface $time
    {
        get => $this->_time;
        set
        {
            $this->_time = $value instanceof DateTimeImmutable ? $value : DateTimeImmutable::createFromInterface($value);
            $this->_iso  = toIso8601Time( $value ) ;
        }
    }

    /**
     * Gets the hours component (0–23).
     */
    public int $hours
    {
        get => (int) $this->_time->format( self::HOUR ) ;
    }

    /**
     * Gets the minutes component (0–59).
     */
    public int $minutes
    {
        get => (int) $this->_time->format(self::MINUTE ) ;
    }

    /**
     * Gets the seconds component (0–59).
     */
    public int $seconds
    {
        get => (int) $this->_time->format( self::SECOND ) ;
    }

    /**
     * Gets the timezone object (or null if none specified).
     */
    public ?DateTimeZone $timezone
    {
        get => $this->_time->getTimezone() ;
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
     * The internal DateTimeImmutable representing the time.
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $_time ;

    /**
     * @var string
     */
    private string $_iso ;
}