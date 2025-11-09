<?php

namespace org\iso;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use InvalidArgumentException;

/**
 * Represents and manipulates ISO 8601 time strings (without date part).
 *
 * ISO 8601 time examples:
 * - "T14:30:00Z"       → 14:30:00 UTC
 * - "T08:15:30+02:00"  → 08:15:30 in UTC+2
 * - "T23:59:59"        → 23:59:59 local time (no offset)
 *
 * @example
 * ```php
 * $time = new Iso8601Time('T14:30:00Z');
 * echo $time->hours; // 14
 * echo $time->iso;   // "T14:30:00Z"
 *
 * $t2 = new Iso8601Time('T08:15:30+02:00');
 * echo $t2->toDateTime()->format('H:i:s P'); // "08:15:30 +02:00"
 * ```
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
        $this->_time = new DateTimeImmutable('00:00:00' ) ;
        $this->_iso  = 'T00:00:00';

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
     * ISO string representation (e.g. "T14:30:00Z").
     */
    public string $iso
    {
        get => $this->_iso ;
        set
        {
            $this->_setFromIso( $value ) ;
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
            $this->_iso  = $this->_formatIso( $value ) ;
        }
    }

    /**
     * Gets the hours component (0–23).
     */
    public int $hours
    {
        get => (int) $this->_time->format('H');
    }

    /**
     * Gets the minutes component (0–59).
     */
    public int $minutes
    {
        get => (int) $this->_time->format('i');
    }

    /**
     * Gets the seconds component (0–59).
     */
    public int $seconds
    {
        get => (int) $this->_time->format('s');
    }

    /**
     * Gets the timezone object (or null if none specified).
     */
    public ?DateTimeZone $timezone
    {
        get => $this->_time->getTimezone() ;
    }



    /**
     * Converts this ISO time to a DateTimeImmutable (on today's date).
     */
    public function toDateTime(): DateTimeImmutable
    {
        return $this->_time;
    }

    /**
     * String cast returns the ISO representation.
     */
    public function __toString(): string
    {
        return $this->_iso;
    }

    // --------------------- INTERNALS ---------------------

    /**
     * The internal DateTimeImmutable representing the time.
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $_time ;

    private string $_iso ;

    private function _setFromIso( string $value ) :void
    {
        if ( !preg_match(self::PATTERN , $value , $matches ) )
        {
            throw new InvalidArgumentException("Invalid ISO 8601 time: $value") ;
        }

        [, $h, $m, $s, $tz] = array_pad( $matches, 5, null);
        $m ??= '00' ;
        $s ??= '00' ;

        $tzObj = null;
        if ($tz) {
            $tzObj = ($tz === 'Z') ? new DateTimeZone('UTC') : new DateTimeZone($tz);
        }

        try {
            $dt = new DateTimeImmutable( sprintf('%02d:%02d:%s', $h, $m, $s), $tzObj );
        } catch (Exception $e) {
            throw new InvalidArgumentException("Invalid time value: $value", 0, $e);
        }

        $this->_time = $dt ;
        $this->_iso  = $this->_formatIso( $dt ) ;
    }

    private function _formatIso( DateTimeInterface $time ) :string
    {
        $offset = $time->getOffset();
        if ( $offset === 0 )
        {
            $suffix = 'Z' ;
        }
        else
        {
            $hours  = intdiv(abs($offset), 3600);
            $mins   = (abs($offset) % 3600) / 60;
            $sign   = $offset >= 0 ? '+' : '-';
            $suffix = sprintf('%s%02d:%02d', $sign, $hours, $mins);
        }

        return 'T' . $time->format('H:i:s') . $suffix;
    }
}