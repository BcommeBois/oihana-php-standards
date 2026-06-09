<?php

namespace org\iso;

use DateInterval;
use DateTimeImmutable;
use Generator;
use InvalidArgumentException;
use LogicException;

/**
 * Represents and manipulates ISO 8601 recurring intervals.
 *
 * The format is `R[n]/<interval>` where `n` is an optional non-negative
 * integer count (absent means infinite) and `<interval>` is any bounded
 * {@see Iso8601Interval} form.
 *
 * Example usage:
 * ```php
 * use org\iso\Iso8601Recurrence;
 *
 * // Five daily occurrences starting 2026-05-14
 * $r = new Iso8601Recurrence('R5/2026-05-14T00:00:00Z/P1D');
 * echo $r->count;                          // 5
 * echo $r->interval->start->iso;           // "2026-05-14T00:00:00Z"
 *
 * foreach ($r->occurrences() as $instant) {
 *     echo $instant->format('Y-m-d') . PHP_EOL ;
 *     // 2026-05-14, 2026-05-15, 2026-05-16, 2026-05-17, 2026-05-18
 * }
 *
 * // Infinite recurrence — max is required
 * $r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');
 * foreach ($r->occurrences(max: 3) as $instant) { ... }
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Repeating_intervals ISO 8601 Repeating intervals
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class Iso8601Recurrence
{
    /**
     * Creates a new Iso8601Recurrence instance.
     *
     * @param string|null $iso ISO 8601 recurrence string, or null for the zero recurrence ({@see ZERO})
     *
     * @throws InvalidArgumentException If the input is not a valid recurrence
     */
    public function __construct( ?string $iso = null )
    {
        $this->iso = $iso ?? self::ZERO ;
    }

    /**
     * Recurrence designator (required prefix).
     */
    public const string DESIGNATOR = 'R' ;

    /**
     * Zero recurrence constant: zero occurrences of a zero-length interval at the Unix epoch.
     */
    public const string ZERO = 'R0/1970-01-01T00:00:00Z/PT0S' ;

    /**
     * ISO recurrence pattern: `R[n]/<interval>`.
     * Group 1 captures the (possibly empty) count; group 2 captures the inner interval.
     */
    public const string PATTERN = '/^R(\d*)\/(.+)$/' ;

    /**
     * ISO string representation. Round-trip preserves the input form.
     *
     * @throws InvalidArgumentException If the value is not a valid recurrence
     */
    public string $iso
    {
        get => $this->_iso ;
        set
        {
            if ( !preg_match( self::PATTERN , $value , $m ) )
            {
                throw new InvalidArgumentException( "Invalid ISO 8601 recurrence: $value" ) ;
            }

            $count    = $m[1] === '' ? null : (int) $m[1] ;
            $interval = new Iso8601Interval( $m[2] ) ;

            $this->_count    = $count ;
            $this->_interval = $interval ;
            $this->_iso      = $value ;
        }
    }

    /**
     * Number of repetitions. `null` means infinite.
     */
    public ?int $count
    {
        get => $this->_count ;
    }

    /**
     * The underlying bounded interval.
     */
    public Iso8601Interval $interval
    {
        get => $this->_interval ;
    }

    /**
     * Yields the start instant of each occurrence as a {@see DateTimeImmutable}.
     *
     * If the recurrence has a finite count, at most `count` occurrences are
     * yielded; when both `count` and `$max` are provided, the smaller of the
     * two wins. If `count` is `null` (infinite), `$max` is mandatory to avoid
     * unbounded iteration.
     *
     * @param int|null $max Optional cap on the number of yielded occurrences. Required when `count` is null.
     *
     * @throws LogicException If the recurrence is infinite and `$max` is not provided.
     *
     * @return Generator<int, DateTimeImmutable>
     */
    public function occurrences( ?int $max = null ): Generator
    {
        if ( $this->_count === null && $max === null )
        {
            throw new LogicException( 'Iso8601Recurrence::occurrences() requires $max for infinite recurrences.' ) ;
        }

        $limit = match ( true )
        {
            $this->_count === null => $max ,
            $max === null          => $this->_count ,
            default                => min( $this->_count , $max ) ,
        } ;

        $period  = $this->period() ;
        $current = $this->_interval->start->dateTime ;

        for ( $i = 0 ; $i < $limit ; $i++ )
        {
            yield $current ;
            $current = $current->add( $period ) ;
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
     * Returns the period between successive occurrences, using the interval's
     * declared duration when available, otherwise the diff between end and start.
     */
    private function period(): DateInterval
    {
        if ( $this->_interval->duration !== null )
        {
            return $this->_interval->duration->interval ;
        }
        return $this->_interval->start->dateTime->diff( $this->_interval->end->dateTime ) ;
    }

    /**
     * @var int|null
     */
    private ?int $_count = null ;

    /**
     * @var Iso8601Interval
     */
    private Iso8601Interval $_interval ;

    /**
     * @var string
     */
    private string $_iso ;
}
