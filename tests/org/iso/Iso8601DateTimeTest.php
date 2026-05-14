<?php

namespace tests\org\iso;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use org\iso\Iso8601Date;
use org\iso\Iso8601DateTime;
use org\iso\Iso8601Time;
use org\iso\TimePrecision;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Iso8601DateTime class.
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class Iso8601DateTimeTest extends TestCase
{
    public function testDefaultConstructorIsEpochZulu(): void
    {
        $dt = new Iso8601DateTime();
        $this->assertSame('1970-01-01T00:00:00Z', $dt->iso);
        $this->assertSame(TimePrecision::SECONDS, $dt->precision);
    }

    public function testConstructorWithZuluString(): void
    {
        $dt = new Iso8601DateTime('2026-05-14T08:15:30Z');
        $this->assertSame('2026-05-14T08:15:30Z', $dt->iso);
        $this->assertSame(TimePrecision::SECONDS, $dt->precision);
    }

    public function testConstructorWithOffset(): void
    {
        $dt = new Iso8601DateTime('2026-05-14T08:15:30+02:00');
        $this->assertSame('2026-05-14T08:15:30+02:00', $dt->iso);
    }

    public function testPrecisionAutoDetectedAsMilliseconds(): void
    {
        $dt = new Iso8601DateTime('2026-05-14T08:15:30.123Z');
        $this->assertSame(TimePrecision::MILLISECONDS, $dt->precision);
        $this->assertSame('2026-05-14T08:15:30.123Z', $dt->iso);
    }

    public function testPrecisionAutoDetectedAsMicroseconds(): void
    {
        $dt = new Iso8601DateTime('2026-05-14T08:15:30.123456+02:00');
        $this->assertSame(TimePrecision::MICROSECONDS, $dt->precision);
        $this->assertSame('2026-05-14T08:15:30.123456+02:00', $dt->iso);
    }

    public function testConstructorWithDateTimeImmutable(): void
    {
        $native = new DateTimeImmutable('2024-02-29 12:34:56', new DateTimeZone('UTC'));
        $dt     = new Iso8601DateTime($native);
        $this->assertSame('2024-02-29T12:34:56Z', $dt->iso);
    }

    public function testConstructorWithMutableDateTime(): void
    {
        $native = new DateTime('2030-12-31 23:59:59', new DateTimeZone('-05:00'));
        $dt     = new Iso8601DateTime($native);
        $this->assertSame('2030-12-31T23:59:59-05:00', $dt->iso);
    }

    public function testConstructorWithNullDefaultsToZero(): void
    {
        $dt = new Iso8601DateTime(null);
        $this->assertSame(Iso8601DateTime::ZERO, $dt->iso);
    }

    public function testSetIsoUpdatesDateTimeAndPrecision(): void
    {
        $dt = new Iso8601DateTime();
        $dt->iso = '2030-06-15T12:00:00.999Z';
        $this->assertSame(2030, $dt->datePart->year);
        $this->assertSame(12,   $dt->timePart->hours);
        $this->assertSame(TimePrecision::MILLISECONDS, $dt->precision);
    }

    public function testSetDateTimePreservesPrecision(): void
    {
        $dt = new Iso8601DateTime('2026-05-14T08:15:30.123Z');
        $this->assertSame(TimePrecision::MILLISECONDS, $dt->precision);

        $dt->dateTime = new DateTimeImmutable('2030-01-01 00:00:00', new DateTimeZone('UTC'));
        $this->assertSame('2030-01-01T00:00:00.000Z', $dt->iso);
    }

    public function testDatePartReturnsIso8601Date(): void
    {
        $dt   = new Iso8601DateTime('2024-02-29T12:34:56Z');
        $part = $dt->datePart;
        $this->assertInstanceOf(Iso8601Date::class, $part);
        $this->assertSame('2024-02-29', $part->iso);
        $this->assertSame(2024, $part->year);
        $this->assertSame(2,    $part->month);
        $this->assertSame(29,   $part->day);
    }

    public function testTimePartReturnsIso8601Time(): void
    {
        $dt   = new Iso8601DateTime('2026-05-14T08:15:30+02:00');
        $part = $dt->timePart;
        $this->assertInstanceOf(Iso8601Time::class, $part);
        $this->assertSame(8,  $part->hours);
        $this->assertSame(15, $part->minutes);
        $this->assertSame(30, $part->seconds);
    }

    public function testTimezoneGetter(): void
    {
        // PHP keeps the literal 'Z' designator from the parsed string
        $utc = new Iso8601DateTime('2026-05-14T08:15:30Z');
        $this->assertSame(0, $utc->timezone->getOffset(new DateTimeImmutable('2026-05-14T08:15:30')));

        $off = new Iso8601DateTime('2026-05-14T08:15:30+02:00');
        $this->assertSame('+02:00', $off->timezone->getName());
    }

    public function testPrecisionSetterRegeneratesIso(): void
    {
        $dt = new Iso8601DateTime('2026-05-14T08:15:30Z');

        $dt->precision = TimePrecision::MILLISECONDS;
        $this->assertSame('2026-05-14T08:15:30.000Z', $dt->iso);

        $dt->precision = TimePrecision::MICROSECONDS;
        $this->assertSame('2026-05-14T08:15:30.000000Z', $dt->iso);

        $dt->precision = TimePrecision::SECONDS;
        $this->assertSame('2026-05-14T08:15:30Z', $dt->iso);
    }

    public function testInvalidIsoStringThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601DateTime('INVALID');
    }

    public function testSpaceSeparatorIsRejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601DateTime('2026-05-14 08:15:30Z');
    }

    public function testInvalidCalendarDateThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601DateTime('2023-02-29T12:00:00Z');
    }

    public function testInvalidPrecisionThrows(): void
    {
        $dt = new Iso8601DateTime();
        $this->expectException(InvalidArgumentException::class);
        $dt->precision = 'nanoseconds';
    }

    public function testToStringReturnsIso(): void
    {
        $dt = new Iso8601DateTime('2026-05-14T08:15:30Z');
        $this->assertSame('2026-05-14T08:15:30Z', (string) $dt);
    }
}
