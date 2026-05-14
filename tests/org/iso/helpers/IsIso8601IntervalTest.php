<?php

namespace tests\org\iso\helpers;

use PHPUnit\Framework\TestCase;

use function org\iso\helpers\isIso8601Interval;

/**
 * Unit tests for the isIso8601Interval validation function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class IsIso8601IntervalTest extends TestCase
{
    public function testValidStartEnd(): void
    {
        $this->assertTrue(isIso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z'));
        $this->assertTrue(isIso8601Interval('2026-05-14T08:15:30+02:00/2026-05-14T18:00:00+02:00'));
    }

    public function testValidStartDuration(): void
    {
        $this->assertTrue(isIso8601Interval('2026-05-14T00:00:00Z/P1D'));
        $this->assertTrue(isIso8601Interval('2026-05-14T00:00:00Z/PT1H30M'));
    }

    public function testValidDurationEnd(): void
    {
        $this->assertTrue(isIso8601Interval('P1D/2026-05-15T00:00:00Z'));
        $this->assertTrue(isIso8601Interval('PT2H/2026-05-14T18:00:00Z'));
    }

    public function testSingleDurationIsRejected(): void
    {
        $this->assertFalse(isIso8601Interval('P1D'));
    }

    public function testTwoDurationsAreRejected(): void
    {
        $this->assertFalse(isIso8601Interval('P1D/P2D'));
    }

    public function testOpenIntervalsAreRejected(): void
    {
        $this->assertFalse(isIso8601Interval('--/2026-05-15T00:00:00Z'));
        $this->assertFalse(isIso8601Interval('2026-05-14T00:00:00Z/--'));
    }

    public function testEmptyOrMalformed(): void
    {
        $this->assertFalse(isIso8601Interval(''));
        $this->assertFalse(isIso8601Interval('/'));
        $this->assertFalse(isIso8601Interval('2026-05-14T00:00:00Z/'));
        $this->assertFalse(isIso8601Interval('/2026-05-15T00:00:00Z'));
        $this->assertFalse(isIso8601Interval('2026-05-14T00:00:00Z'));
        $this->assertFalse(isIso8601Interval('INVALID/STUFF'));
    }

    public function testNonStrictDateTimeIsRejected(): void
    {
        // space separator instead of T
        $this->assertFalse(isIso8601Interval('2026-05-14 00:00:00Z/P1D'));
    }
}
