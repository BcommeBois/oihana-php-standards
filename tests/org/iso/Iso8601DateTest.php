<?php

namespace tests\org\iso;

use DateTime;
use DateTimeImmutable;
use InvalidArgumentException;
use org\iso\Iso8601Date;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Iso8601Date class.
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class Iso8601DateTest extends TestCase
{
    public function testDefaultConstructorIsEpoch(): void
    {
        $date = new Iso8601Date();
        $this->assertSame('1970-01-01', $date->iso);
        $this->assertSame(1970, $date->year);
        $this->assertSame(1, $date->month);
        $this->assertSame(1, $date->day);
    }

    public function testConstructorWithIsoString(): void
    {
        $date = new Iso8601Date('2026-05-14');
        $this->assertSame('2026-05-14', $date->iso);
        $this->assertSame(2026, $date->year);
        $this->assertSame(5,    $date->month);
        $this->assertSame(14,   $date->day);
    }

    public function testConstructorWithDateTimeImmutable(): void
    {
        $dt   = new DateTimeImmutable('2024-02-29 12:34:56');
        $date = new Iso8601Date($dt);
        $this->assertSame('2024-02-29', $date->iso);
        $this->assertSame(2024, $date->year);
        $this->assertSame(2,    $date->month);
        $this->assertSame(29,   $date->day);
    }

    public function testConstructorWithMutableDateTime(): void
    {
        $dt   = new DateTime('2030-12-31');
        $date = new Iso8601Date($dt);
        $this->assertSame('2030-12-31', $date->iso);
    }

    public function testConstructorWithNullDefaultsToZero(): void
    {
        $date = new Iso8601Date(null);
        $this->assertSame(Iso8601Date::ZERO, $date->iso);
    }

    public function testSetIsoUpdatesComponents(): void
    {
        $date = new Iso8601Date();
        $date->iso = '2030-06-15';
        $this->assertSame(2030, $date->year);
        $this->assertSame(6,    $date->month);
        $this->assertSame(15,   $date->day);
    }

    public function testSetDateUpdatesIso(): void
    {
        $date = new Iso8601Date();
        $date->date = new DateTimeImmutable('2025-07-04');
        $this->assertSame('2025-07-04', $date->iso);
    }

    public function testWeekday(): void
    {
        // 2024-01-01 is a Monday (ISO weekday 1)
        $monday = new Iso8601Date('2024-01-01');
        $this->assertSame(1, $monday->weekday);

        // 2024-02-29 is a Thursday (ISO weekday 4)
        $thursday = new Iso8601Date('2024-02-29');
        $this->assertSame(4, $thursday->weekday);

        // 2026-05-17 is a Sunday (ISO weekday 7)
        $sunday = new Iso8601Date('2026-05-17');
        $this->assertSame(7, $sunday->weekday);
    }

    public function testDayOfYearIsOneBased(): void
    {
        // 2024-01-01 must be 1
        $this->assertSame(1, (new Iso8601Date('2024-01-01'))->dayOfYear);

        // 2024-02-29 (leap year, 60th day)
        $this->assertSame(60, (new Iso8601Date('2024-02-29'))->dayOfYear);

        // 2024-12-31 (leap year, 366th day)
        $this->assertSame(366, (new Iso8601Date('2024-12-31'))->dayOfYear);

        // 2025-12-31 (non-leap year, 365th day)
        $this->assertSame(365, (new Iso8601Date('2025-12-31'))->dayOfYear);
    }

    public function testTimeComponentsAreResetByIsoSetter(): void
    {
        $date = new Iso8601Date('2026-05-14');
        // createFromFormat('!Y-m-d', ...) must reset hours/minutes/seconds to 00
        $this->assertSame('00:00:00', $date->date->format('H:i:s'));
    }

    public function testToStringReturnsIso(): void
    {
        $date = new Iso8601Date('2026-05-14');
        $this->assertSame('2026-05-14', (string) $date);
    }

    public function testInvalidIsoStringThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Date('INVALID');
    }

    public function testBasicFormatIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Date('20260514');
    }

    public function testInvalidCalendarDateThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Date('2023-02-29'); // not a leap year
    }

    public function testNonZeroPaddedMonthIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Date('2026-5-14');
    }
}
