<?php

namespace org\iso;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;

use function org\iso\helpers\isIso8601Date;
use function org\iso\helpers\toIso8601Date;

/**
 * Represents and manipulates ISO 8601 calendar date strings (without time component).
 *
 * This class provides a convenient wrapper around PHP's `DateTimeImmutable` for
 * handling dates expressed in ISO 8601 extended format (`YYYY-MM-DD`). It maintains
 * synchronization between the ISO 8601 string representation and the internal
 * immutable date object.
 *
 * Only the **extended** format is accepted in the `iso` setter; the basic format
 * (`YYYYMMDD`) is rejected by design. Calendar validity is enforced via
 * {@see checkdate()} through {@see isIso8601Date()}.
 *
 * ISO 8601 date examples:
 * - "2026-05-14"
 * - "2024-02-29" (leap year)
 *
 * Example usage:
 * ```php
 * use org\iso\Iso8601Date;
 *
 * // From ISO 8601 string
 * $date = new Iso8601Date('2026-05-14');
 * echo $date->year;       // 2026
 * echo $date->month;      // 5
 * echo $date->day;        // 14
 * echo $date->weekday;    // 4 (Thursday, ISO 1-7 from Monday)
 * echo $date->dayOfYear;  // 134 (1-based)
 *
 * // From DateTimeInterface
 * $dt   = new DateTimeImmutable('2024-02-29');
 * $date = new Iso8601Date($dt);
 * echo $date->iso;        // "2024-02-29"
 *
 * // Round-trip via setter
 * $date->iso = '2030-12-31';
 * echo $date->year;       // 2030
 * ```
 *
 * @link https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates ISO 8601 calendar dates
 * @link https://www.php.net/manual/en/class.datetimeimmutable.php PHP DateTimeImmutable documentation
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class Iso8601Date
{
    /**
     * Creates a new Iso8601Date instance.
     *
     * @param string|DateTimeInterface|null $date ISO extended string, DateTime, or null for the epoch ({@see ZERO})
     *
     * @throws InvalidArgumentException If the input is invalid
     */
    public function __construct( string|DateTimeInterface|null $date = null )
    {
        $this->_date = new DateTimeImmutable( self::ZERO ) ;
        $this->_iso  = self::ZERO ;
        if ( $date instanceof DateTimeInterface )
        {
            $this->date = $date ;
        }
        else if ( $date !== null )
        {
            $this->iso = $date ;
        }
    }

    /**
     * ISO 8601 calendar date pattern (extended format only): `YYYY-MM-DD`.
     */
    public const string PATTERN = '/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/' ;

    /**
     * The full date format (`Y-m-d`).
     */
    public const string FORMAT = 'Y-m-d' ;

    /**
     * The 'year' format character (4-digit year).
     */
    public const string YEAR = 'Y' ;

    /**
     * The 'month' format character (numeric, zero-padded).
     */
    public const string MONTH = 'm' ;

    /**
     * The 'day' format character (numeric, zero-padded).
     */
    public const string DAY = 'd' ;

    /**
     * The ISO-8601 'day of week' format character (1 = Monday, 7 = Sunday).
     */
    public const string WEEKDAY = 'N' ;

    /**
     * The 'day of year' format character (0-based in PHP; this class exposes a 1-based value).
     */
    public const string DAY_OF_YEAR = 'z' ;

    /**
     * Epoch date constant (Unix epoch, used as the default zero value).
     */
    public const string ZERO = '1970-01-01' ;

    /**
     * ISO string representation (e.g. "2026-05-14").
     */
    public string $iso
    {
        get => $this->_iso ;
        set
        {
            if ( !isIso8601Date( $value , true ) )
            {
                throw new InvalidArgumentException( "Invalid ISO 8601 date: $value" ) ;
            }

            try
            {
                $dt = DateTimeImmutable::createFromFormat( '!' . self::FORMAT , $value ) ;
            }
            catch ( Exception $e )
            {
                throw new InvalidArgumentException( "Invalid date value: $value" , 0 , $e ) ;
            }

            $this->_date = $dt ;
            $this->_iso  = toIso8601Date( $dt ) ;
        }
    }

    /**
     * The internal immutable date representation.
     * @var DateTimeInterface
     */
    public DateTimeInterface $date
    {
        get => $this->_date ;
        set
        {
            $this->_date = $value instanceof DateTimeImmutable ? $value : DateTimeImmutable::createFromInterface( $value ) ;
            $this->_iso  = toIso8601Date( $value ) ;
        }
    }

    /**
     * Gets the 4-digit year (e.g. 2026).
     */
    public int $year
    {
        get => (int) $this->_date->format( self::YEAR ) ;
    }

    /**
     * Gets the month component (1–12).
     */
    public int $month
    {
        get => (int) $this->_date->format( self::MONTH ) ;
    }

    /**
     * Gets the day-of-month component (1–31).
     */
    public int $day
    {
        get => (int) $this->_date->format( self::DAY ) ;
    }

    /**
     * Gets the ISO 8601 day-of-week (1 = Monday, 7 = Sunday).
     */
    public int $weekday
    {
        get => (int) $this->_date->format( self::WEEKDAY ) ;
    }

    /**
     * Gets the 1-based day of year (1 = January 1st, 365 or 366 = December 31st).
     */
    public int $dayOfYear
    {
        get => (int) $this->_date->format( self::DAY_OF_YEAR ) + 1 ;
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
     * The internal DateTimeImmutable representing the date.
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $_date ;

    /**
     * @var string
     */
    private string $_iso ;
}
