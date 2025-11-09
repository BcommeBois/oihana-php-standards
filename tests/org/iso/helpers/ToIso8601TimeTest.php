<?php

namespace tests\org\iso\helpers;

use DateMalformedStringException;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

use function org\iso\helpers\toIso8601Time;

/**
 * Unit tests for the toIso8601Time function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
class ToIso8601TimeTest extends TestCase
{
    /**
     * @throws DateMalformedStringException
     */
    public function testConvertsUtcToZ(): void
    {
        $time = new DateTimeImmutable('14:30:15', new DateTimeZone('UTC'));
        $this->assertSame('T14:30:15Z', toIso8601Time($time));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testConvertsPositiveOffset(): void
    {
        $time = new DateTimeImmutable('08:15:05', new DateTimeZone('+02:00'));
        $this->assertSame('T08:15:05+02:00', toIso8601Time($time));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testConvertsNegativeOffset(): void
    {
        $time = new DateTimeImmutable('20:00:00', new DateTimeZone('-05:00'));
        $this->assertSame('T20:00:00-05:00', toIso8601Time($time));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testConvertsMinuteOffset(): void
    {
        $time = new DateTimeImmutable('10:00:00', new DateTimeZone('+05:30'));
        $this->assertSame('T10:00:00+05:30', toIso8601Time($time));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testConvertsNegativeMinuteOffset(): void
    {
        $time = new DateTimeImmutable('12:30:00', new DateTimeZone('-09:45'));
        $this->assertSame('T12:30:00-09:45', toIso8601Time($time));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testHandlesMidnight(): void
    {
        $time = new DateTimeImmutable('00:00:00', new DateTimeZone('UTC'));
        $this->assertSame('T00:00:00Z', toIso8601Time($time));

        $timeOffset = new DateTimeImmutable('00:00:00', new DateTimeZone('+01:00'));
        $this->assertSame('T00:00:00+01:00', toIso8601Time($timeOffset));
    }

    /**
     * Teste que la fonction fonctionne avec un objet DateTime mutable.
     * @throws DateMalformedStringException
     */
    public function testWorksWithMutableDateTime(): void
    {
        $time = new DateTime('01:02:03', new DateTimeZone('-07:00'));
        $this->assertSame('T01:02:03-07:00', toIso8601Time($time));
    }

    /**
     * Teste que les microsecondes sont tronquées, conformément au
     * format ISO8601::FORMAT (H:i:s).
     */
    public function testTruncatesMicroseconds(): void
    {
        $time = DateTimeImmutable::createFromFormat(
            'H:i:s.u',
            '10:20:30.123456',
            new DateTimeZone('UTC')
        );

        $this->assertSame('T10:20:30Z', toIso8601Time($time));

        $timeOffset = DateTimeImmutable::createFromFormat(
            'H:i:s.u',
            '11:22:33.987',
            new DateTimeZone('+02:00')
        );

        $this->assertSame('T11:22:33+02:00', toIso8601Time($timeOffset));
    }
}