<?php

namespace tests\org\iso;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use org\iso\Iso8601DateTime;
use org\iso\Iso8601Duration;
use org\iso\Iso8601Interval;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Iso8601Interval class.
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class Iso8601IntervalTest extends TestCase
{
    public function testDefaultConstructorIsZero(): void
    {
        $i = new Iso8601Interval();
        $this->assertSame(Iso8601Interval::ZERO, $i->iso);
        $this->assertSame('1970-01-01T00:00:00Z', $i->start->iso);
        $this->assertSame('1970-01-01T00:00:00Z', $i->end->iso);
        $this->assertNotNull($i->duration);
        $this->assertSame('PT0S', $i->duration->iso);
    }

    public function testStartEndForm(): void
    {
        $i = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
        $this->assertSame('2026-05-14T00:00:00Z', $i->start->iso);
        $this->assertSame('2026-05-15T00:00:00Z', $i->end->iso);
        $this->assertNull($i->duration);
        $this->assertSame('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z', $i->iso);
    }

    public function testStartDurationFormComputesEnd(): void
    {
        $i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');
        $this->assertSame('2026-05-14T00:00:00Z', $i->start->iso);
        $this->assertSame('2026-05-15T00:00:00Z', $i->end->iso);
        $this->assertNotNull($i->duration);
        $this->assertSame('P1D', $i->duration->iso);
        // Round-trip preserves original form
        $this->assertSame('2026-05-14T00:00:00Z/P1D', $i->iso);
    }

    public function testDurationEndFormComputesStart(): void
    {
        $i = new Iso8601Interval('P1D/2026-05-15T00:00:00Z');
        $this->assertSame('2026-05-14T00:00:00Z', $i->start->iso);
        $this->assertSame('2026-05-15T00:00:00Z', $i->end->iso);
        $this->assertSame('P1D', $i->duration->iso);
        $this->assertSame('P1D/2026-05-15T00:00:00Z', $i->iso);
    }

    public function testContainsHalfOpen(): void
    {
        $i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');

        // start included
        $this->assertTrue($i->contains(new DateTimeImmutable('2026-05-14T00:00:00Z')));
        // middle
        $this->assertTrue($i->contains(new DateTimeImmutable('2026-05-14T12:00:00Z')));
        // end EXCLUDED
        $this->assertFalse($i->contains(new DateTimeImmutable('2026-05-15T00:00:00Z')));
        // before start
        $this->assertFalse($i->contains(new DateTimeImmutable('2026-05-13T23:59:59Z')));
    }

    public function testContainsAcceptsIso8601DateTime(): void
    {
        $i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');
        $this->assertTrue($i->contains(new Iso8601DateTime('2026-05-14T06:00:00Z')));
        $this->assertFalse($i->contains(new Iso8601DateTime('2026-05-16T00:00:00Z')));
    }

    public function testOverlapsTrue(): void
    {
        $a = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
        $b = new Iso8601Interval('2026-05-14T18:00:00Z/2026-05-16T00:00:00Z');
        $this->assertTrue($a->overlaps($b));
        $this->assertTrue($b->overlaps($a));
    }

    public function testOverlapsFalse(): void
    {
        $a = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
        $b = new Iso8601Interval('2026-05-16T00:00:00Z/2026-05-17T00:00:00Z');
        $this->assertFalse($a->overlaps($b));
    }

    public function testAdjacentIntervalsDoNotOverlap(): void
    {
        // Half-open: [a1,a2) and [a2,a3) are adjacent, not overlapping
        $a = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
        $b = new Iso8601Interval('2026-05-15T00:00:00Z/2026-05-16T00:00:00Z');
        $this->assertFalse($a->overlaps($b));
    }

    public function testSetIsoUpdatesAllParts(): void
    {
        $i = new Iso8601Interval();
        $i->iso = 'PT2H/2026-05-14T10:00:00Z';
        $this->assertSame('2026-05-14T08:00:00Z', $i->start->iso);
        $this->assertSame('2026-05-14T10:00:00Z', $i->end->iso);
        $this->assertSame('PT2H', $i->duration->iso);
    }

    public function testToStringReturnsIso(): void
    {
        $i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');
        $this->assertSame('2026-05-14T00:00:00Z/P1D', (string) $i);
    }

    public function testEndPrecedingStartThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Interval('2026-05-15T00:00:00Z/2026-05-14T00:00:00Z');
    }

    public function testSingleDurationThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Interval('P1D');
    }

    public function testTwoDurationsThrow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Interval('P1D/P2D');
    }

    public function testInvalidStringThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Interval('INVALID');
    }

    public function testInvalidCalendarDateThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Interval('2023-02-29T00:00:00Z/P1D');
    }
}
