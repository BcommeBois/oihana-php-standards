<?php

namespace tests\org\iso\helpers;

use DateMalformedStringException;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use org\iso\TimePrecision;
use PHPUnit\Framework\TestCase;

use function org\iso\helpers\toIso8601DateTime;

/**
 * Unit tests for the toIso8601DateTime function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class ToIso8601DateTimeTest extends TestCase
{
    /**
     * @throws DateMalformedStringException
     */
    public function testUtcRendersZulu(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('UTC'));
        $this->assertSame('2026-05-14T08:15:30Z', toIso8601DateTime($dt));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testPositiveOffset(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));
        $this->assertSame('2026-05-14T08:15:30+02:00', toIso8601DateTime($dt));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testNegativeOffset(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('-05:00'));
        $this->assertSame('2026-05-14T08:15:30-05:00', toIso8601DateTime($dt));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testMinuteOffset(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+05:30'));
        $this->assertSame('2026-05-14T08:15:30+05:30', toIso8601DateTime($dt));
    }

    public function testMillisecondsPrecision(): void
    {
        $dt = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s.u',
            '2026-05-14 08:15:30.123456',
            new DateTimeZone('UTC')
        );
        $this->assertSame('2026-05-14T08:15:30.123Z', toIso8601DateTime($dt, TimePrecision::MILLISECONDS));
    }

    public function testMicrosecondsPrecision(): void
    {
        $dt = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s.u',
            '2026-05-14 08:15:30.123456',
            new DateTimeZone('+02:00')
        );
        $this->assertSame('2026-05-14T08:15:30.123456+02:00', toIso8601DateTime($dt, TimePrecision::MICROSECONDS));
    }

    public function testSecondsPrecisionTruncatesFractions(): void
    {
        $dt = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s.u',
            '2026-05-14 08:15:30.999999',
            new DateTimeZone('UTC')
        );
        $this->assertSame('2026-05-14T08:15:30Z', toIso8601DateTime($dt));
    }

    /**
     * @return void
     * @throws DateMalformedStringException
     */
    public function testZuluConvertsToUtc(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));
        $this->assertSame('2026-05-14T06:15:30Z', toIso8601DateTime($dt, TimePrecision::SECONDS, true));
    }

    public function testZuluWithMilliseconds(): void
    {
        $dt = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s.u',
            '2026-05-14 08:15:30.500000',
            new DateTimeZone('+02:00')
        );
        $this->assertSame('2026-05-14T06:15:30.500Z', toIso8601DateTime($dt, TimePrecision::MILLISECONDS, true));
    }

    /**
     * @return void
     * @throws DateMalformedStringException
     */
    public function testWorksWithMutableDateTime(): void
    {
        $dt = new DateTime('2026-05-14 08:15:30', new DateTimeZone('-07:00'));
        $this->assertSame('2026-05-14T08:15:30-07:00', toIso8601DateTime($dt));
    }

    /**
     * @return void
     * @throws DateMalformedStringException
     */
    public function testInvalidPrecisionThrows(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('UTC'));
        $this->expectException(InvalidArgumentException::class);
        toIso8601DateTime($dt, 'nanoseconds');
    }
}
