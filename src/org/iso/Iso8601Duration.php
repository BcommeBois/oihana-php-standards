<?php

namespace org\iso;

use DateInterval;
use DateInvalidOperationException;
use DateTime;
use Exception;

use InvalidArgumentException;

use function org\iso\helpers\toIso8601Duration;

/**
 * Represents and manipulates ISO 8601 duration strings.
 *
 * This class provides a convenient wrapper around PHP's DateInterval with additional
 * functionality for working with ISO 8601 duration format. It maintains synchronization
 * between the string representation and the DateInterval object.
 *
 * ISO 8601 duration format: P[n]Y[n]M[n]DT[n]H[n]M[n]S
 * - P: duration designator (required)
 * - T: time designator (separates date and time components)
 * - Y/M/D: years, months, days
 * - H/M/S: hours, minutes, seconds (after T)
 *
 * @example
 * ```php
 * // Create from ISO 8601 string
 * $duration = new Iso8601Duration('P1Y2M3D');
 * echo $duration->iso; // "P1Y2M3D"
 *
 * // Create from DateInterval
 * $interval = new DateInterval('PT30M');
 * $duration = new Iso8601Duration($interval);
 * echo $duration->toSeconds(); // 1800
 *
 * // Modify using ISO string
 * $duration->iso = 'PT30M';
 *
 * // Modify using DateInterval
 * $duration->interval = new DateInterval('P5D');
 * echo $duration->iso; // "P5D"
 *
 * // Add to a date
 * $date = new DateTime('2024-01-01');
 * $newDate = $duration->addTo($date);
 * echo $newDate->format('Y-m-d'); // "2024-01-06"
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Durations ISO 8601 Duration specification
 * @link https://www.php.net/manual/en/class.dateinterval.php PHP DateInterval documentation
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
class Iso8601Duration
{
    /**
     * Creates a new Iso8601Duration instance from an ISO 8601 string or a DateInterval.
     *
     * @param string|DateInterval|null $duration ISO 8601 duration string (e.g., "P1Y2M", "PT4H30M", "P1W"),
     *                                           a DateInterval object, or null for zero duration (P0D)
     *
     * @throws InvalidArgumentException If the ISO 8601 string is invalid or malformed
     *
     * @example
     * ```php
     * // From ISO 8601 string
     * $duration = new Iso8601Duration('P1Y2M3D');
     * $duration = new Iso8601Duration('PT2H30M');
     * $duration = new Iso8601Duration('P1W'); // 1 week
     *
     * // From DateInterval
     * $interval = new DateInterval('P5D');
     * $duration = new Iso8601Duration($interval);
     *
     * // From date difference
     * $start = new DateTime('2024-01-01');
     * $end = new DateTime('2024-12-31');
     * $duration = new Iso8601Duration($start->diff($end));
     *
     * // Zero duration (default)
     * $duration = new Iso8601Duration(); // Equivalent to 'P0D'
     * $duration = new Iso8601Duration(null); // Same as above
     * ```
     */
    public function __construct( string|DateInterval|null $duration = null )
    {
        if ( $duration instanceof DateInterval )
        {
            $this->interval = $duration;
        }
        else
        {
            $this->iso = $duration ?? self::ZERO ;
        }
    }

    /**
     * Duration designator (required at the start of every duration string).
     */
    public const string PERIOD = 'P' ;

    /**
     * Time designator (separates date and time components).
     */
    public const string TIME = 'T';

    /**
     * Year designator.
     */
    public const string YEAR = 'Y';

    /**
     * Month designator (used in date component before T).
     */
    public const string MONTH = 'M';

    /**
     * Day designator.
     */
    public const string DAY = 'D';

    /**
     * Week designator (alternative to day specification).
     */
    public const string WEEK = 'W';

    /**
     * Hour designator.
     */
    public const string HOUR = 'H';

    /**
     * Minute designator (used in time component after T).
     */
    public const string MINUTE = 'M';

    /**
     * Second designator.
     */
    public const string SECOND = 'S';

    /**
     * Zero duration constant.
     */
    public const string ZERO = 'P0D' ;

    /**
     * Gets or sets the DateInterval representation of the duration.
     *
     * When setting this property, the internal DateInterval is cloned to prevent
     * external modifications, and the ISO 8601 string is automatically regenerated.
     *
     * @var DateInterval
     *
     * @example
     * ```php
     * $duration = new Iso8601Duration('P1D');
     * $interval = $duration->interval; // Get DateInterval
     *
     * $duration->interval = new DateInterval('PT30M'); // Set new interval
     * echo $duration->iso; // "PT30M" (automatically updated)
     * ```
     */
    public DateInterval $interval
    {
        get => $this->_interval ;
        set
        {
            $this->_interval = clone $value ;
            $this->_iso      = toIso8601Duration( $value ) ;
        }
    }

    /**
     * Gets or sets the ISO 8601 string representation of the duration.
     *
     * When setting this property, the DateInterval is automatically updated
     * and validated. Invalid ISO 8601 strings will throw an exception.
     *
     * @var string
     *
     * @throws InvalidArgumentException If the provided ISO 8601 string is invalid
     *
     * @example
     * ```php
     * $duration = new Iso8601Duration('P1D');
     * echo $duration->iso; // "P1D"
     *
     * $duration->iso = 'PT2H'; // Update duration
     * echo $duration->toSeconds(); // 7200
     * ```
     */
    public string $iso
    {
        get => $this->_iso ;
        set
        {
            try
            {
                $this->_interval = new DateInterval( $value );
                $this->_iso = $value;
            }
            catch (Exception $exception )
            {
                throw new InvalidArgumentException("Invalid ISO 8601 duration: $value" , 0 , $exception ) ;
            }
        }
    }

    /**
     * Adds this duration to a given DateTime and returns a new DateTime object.
     *
     * The original DateTime is not modified; a clone is created and modified instead.
     * This method properly handles calendar arithmetic including leap years,
     * varying month lengths, and daylight saving time transitions.
     *
     * @param DateTime $date The reference date to add the duration to
     *
     * @return DateTime A new DateTime object with the duration added
     *
     * @example
     * ```php
     * $duration = new Iso8601Duration('P1M');
     * $date = new DateTime('2024-01-31');
     * $result = $duration->addTo($date);
     * echo $result->format('Y-m-d'); // "2024-02-29" (leap year)
     *
     * $duration = new Iso8601Duration('PT2H30M');
     * $date = new DateTime('2024-03-10 01:30:00'); // DST transition
     * $result = $duration->addTo($date);
     * echo $result->format('Y-m-d H:i:s'); // Properly handles DST
     * ```
     */
    public function addTo( DateTime $date ): DateTime
    {
        $newDate = clone $date;
        return $newDate->add( $this->_interval ) ;
    }

    /**
     * Subtracts this duration from a given DateTime and returns a new DateTime object.
     *
     * The original DateTime is not modified; a clone is created and modified instead.
     * This method properly handles calendar arithmetic including leap years,
     * varying month lengths, and daylight saving time transitions.
     *
     * @param DateTime $date The reference date to subtract the duration from
     *
     * @return DateTime A new DateTime object with the duration subtracted
     *
     * @throws DateInvalidOperationException If the subtraction would result in an invalid date
     *
     * @example
     * ```php
     * $duration = new Iso8601Duration('P1M');
     * $date = new DateTime('2024-03-31');
     * $result = $duration->subtractFrom($date);
     * echo $result->format('Y-m-d'); // "2024-02-29" (leap year)
     *
     * $duration = new Iso8601Duration('P5D');
     * $date = new DateTime('2024-01-10');
     * $result = $duration->subtractFrom($date);
     * echo $result->format('Y-m-d'); // "2024-01-05"
     * ```
     */
    public function subtractFrom( DateTime $date ): DateTime
    {
        $newDate = clone $date;

        return $newDate->sub( $this->_interval ) ;
    }
    
    /**
     * Converts the duration to an approximate number of seconds.
     *
     * This method provides an estimation by converting:
     * - 1 year = 365 days
     * - 1 month = 30 days
     * - 1 day = 86400 seconds
     *
     * For exact calculations that account for actual calendar variations
     * (leap years, different month lengths), use addTo() with a specific
     * reference date instead.
     *
     * @return int The approximate number of seconds in the duration
     *
     * @example
     * ```php
     * $duration = new Iso8601Duration('PT1H30M');
     * echo $duration->toSeconds(); // 5400 (1.5 hours)
     *
     * $duration = new Iso8601Duration('P1Y');
     * echo $duration->toSeconds(); // 31536000 (365 days)
     *
     * $duration = new Iso8601Duration('P1M');
     * echo $duration->toSeconds(); // 2592000 (30 days - approximate)
     * ```
     */
    public function toSeconds(): int
    {
        $days    = $this->_interval->d + ($this->_interval->m * 30) + ($this->_interval->y * 365) ;
        $hours   = $this->_interval->h ;
        $minutes = $this->_interval->i ;
        $seconds = $this->_interval->s ;
        return $seconds + ($minutes * 60) + ($hours * 3600) + ($days * 86400);
    }

    /**
     * Returns the string representation of the duration.
     *
     * This magic method allows the object to be used in string contexts,
     * returning the ISO 8601 duration string.
     *
     * @return string The ISO 8601 duration string
     *
     * @example
     * ```php
     * $duration = new Iso8601Duration('P1Y2M3D');
     * echo $duration; // "P1Y2M3D"
     * echo "Duration: " . $duration; // "Duration: P1Y2M3D"
     * ```
     */
    public function __toString(): string
    {
        return $this->_iso;
    }

    /**
     * The internal DateInterval representing the duration.
     *
     * @var DateInterval
     */
    private DateInterval $_interval ;

    /**
     * The ISO 8601 string representation of the duration.
     *
     * @var string
     */
    private string $_iso ;
}