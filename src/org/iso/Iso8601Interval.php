<?php

namespace org\iso;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

use function org\iso\helpers\isIso8601DateTime;
use function org\iso\helpers\isIso8601Duration;
use function org\iso\helpers\isIso8601Interval;

/**
 * Represents and manipulates ISO 8601 time intervals.
 *
 * An interval is two ISO 8601 expressions joined by a `/` separator. Three
 * bounded forms are supported:
 * - `<start>/<end>`         — two strict date-times
 * - `<start>/<duration>`    — a start date-time and a duration
 * - `<duration>/<end>`      — a duration and an end date-time
 *
 * The single-`<duration>` short form is intentionally rejected (use
 * {@see Iso8601Duration} for that). Open intervals (`--/<end>` and
 * `<start>/--`) are not supported in this release.
 *
 * `start` and `end` are always available as {@see Iso8601DateTime} objects.
 * When the input form omits one of them, it is computed from the duration.
 * The `duration` property reflects the input: it is `null` when the input
 * form was `<start>/<end>`. The `iso` round-trip preserves the original form.
 *
 * Example usage:
 * ```php
 * use org\iso\Iso8601Interval;
 *
 * $i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');
 * echo $i->start->iso;             // "2026-05-14T00:00:00Z"
 * echo $i->end->iso;               // "2026-05-15T00:00:00Z" (computed)
 * echo $i->duration->iso;          // "P1D"
 * echo $i->iso;                    // "2026-05-14T00:00:00Z/P1D" (form preserved)
 *
 * $i->contains(new DateTimeImmutable('2026-05-14T12:00:00Z')); // true
 *
 * $other = new Iso8601Interval('2026-05-14T18:00:00Z/2026-05-16T00:00:00Z');
 * $i->overlaps($other);                                         // true
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Time_intervals ISO 8601 Time intervals
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class Iso8601Interval
{
    /**
     * Creates a new Iso8601Interval instance.
     *
     * @param string|null $iso ISO 8601 interval string, or null for the zero interval ({@see ZERO})
     *
     * @throws InvalidArgumentException If the input is not a valid bounded interval
     */
    public function __construct( ?string $iso = null )
    {
        $this->iso = $iso ?? self::ZERO ;
    }

    /**
     * Interval separator.
     */
    public const string SEPARATOR = '/' ;

    /**
     * Zero interval constant: a zero-duration interval anchored at the Unix epoch.
     */
    public const string ZERO = '1970-01-01T00:00:00Z/PT0S' ;

    /**
     * ISO string representation. Round-trip preserves the input form.
     *
     * @throws InvalidArgumentException If the value is not a valid interval
     */
    public string $iso
    {
        get => $this->_iso ;
        set
        {
            if ( !isIso8601Interval( $value ) )
            {
                throw new InvalidArgumentException( "Invalid ISO 8601 interval: $value" ) ;
            }

            [ $left , $right ] = explode( self::SEPARATOR , $value ) ;

            $leftIsDt  = isIso8601DateTime( $left  , true ) ;
            $rightIsDt = isIso8601DateTime( $right , true ) ;

            if ( $leftIsDt && $rightIsDt )
            {
                $start    = new Iso8601DateTime( $left ) ;
                $end      = new Iso8601DateTime( $right ) ;
                $duration = null ;
            }
            else if ( $leftIsDt )
            {
                $start    = new Iso8601DateTime( $left ) ;
                $duration = new Iso8601Duration( $right ) ;
                $end      = new Iso8601DateTime( $start->dateTime->add( $duration->interval ) ) ;
            }
            else
            {
                $duration = new Iso8601Duration( $left ) ;
                $end      = new Iso8601DateTime( $right ) ;
                $start    = new Iso8601DateTime( $end->dateTime->sub( $duration->interval ) ) ;
            }

            if ( $start->dateTime > $end->dateTime )
            {
                throw new InvalidArgumentException( "Invalid ISO 8601 interval (end precedes start): $value" ) ;
            }

            $this->_start    = $start ;
            $this->_end      = $end ;
            $this->_duration = $duration ;
            $this->_iso      = $value ;
        }
    }

    /**
     * Start of the interval (always available, computed if needed).
     */
    public Iso8601DateTime $start
    {
        get => $this->_start ;
    }

    /**
     * End of the interval (always available, computed if needed).
     */
    public Iso8601DateTime $end
    {
        get => $this->_end ;
    }

    /**
     * Duration of the interval as written in the input.
     * `null` when the input form was `<start>/<end>`.
     */
    public ?Iso8601Duration $duration
    {
        get => $this->_duration ;
    }

    /**
     * Tests whether the given instant lies within the interval.
     *
     * The interval is treated as half-open: `[start, end)`. The `start` instant
     * is included, the `end` instant is excluded.
     */
    public function contains( DateTimeInterface|Iso8601DateTime $instant ): bool
    {
        $dt = $instant instanceof Iso8601DateTime ? $instant->dateTime : $instant ;
        return $dt >= $this->_start->dateTime && $dt < $this->_end->dateTime ;
    }

    /**
     * Tests whether this interval overlaps another.
     *
     * Two half-open intervals `[a1, a2)` and `[b1, b2)` overlap iff
     * `a1 < b2 && b1 < a2`. Adjacent intervals (one ending where the other
     * begins) do not overlap.
     */
    public function overlaps( self $other ): bool
    {
        return $this->_start->dateTime < $other->_end->dateTime
            && $other->_start->dateTime < $this->_end->dateTime ;
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
     * @var Iso8601DateTime
     */
    private Iso8601DateTime $_start ;

    /**
     * @var Iso8601DateTime
     */
    private Iso8601DateTime $_end ;

    /**
     * @var Iso8601Duration|null
     */
    private ?Iso8601Duration $_duration = null ;

    /**
     * @var string
     */
    private string $_iso ;
}
