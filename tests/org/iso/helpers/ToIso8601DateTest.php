<?php

namespace tests\org\iso\helpers;

use DateMalformedStringException;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

use function org\iso\helpers\toIso8601Date;

/**
 * Unit tests for the toIso8601Date function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class ToIso8601DateTest extends TestCase
{
    /**
     * @throws DateMalformedStringException
     */
    public function testExtendedFormat(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('UTC'));
        $this->assertSame('2026-05-14', toIso8601Date($dt));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testBasicFormat(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('UTC'));
        $this->assertSame('20260514', toIso8601Date($dt, true));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testIgnoresTimeAndTimezone(): void
    {
        $dt = new DateTimeImmutable('2026-05-14 23:59:59', new DateTimeZone('+10:00'));
        $this->assertSame('2026-05-14', toIso8601Date($dt));
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testWorksWithMutableDateTime(): void
    {
        $dt = new DateTime('2024-02-29 00:00:00', new DateTimeZone('UTC'));
        $this->assertSame('2024-02-29', toIso8601Date($dt));
        $this->assertSame('20240229', toIso8601Date($dt, true));
    }
}
