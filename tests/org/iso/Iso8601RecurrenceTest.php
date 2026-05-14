<?php

namespace tests\org\iso;

use InvalidArgumentException;
use LogicException;
use org\iso\Iso8601Interval;
use org\iso\Iso8601Recurrence;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Iso8601Recurrence class.
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class Iso8601RecurrenceTest extends TestCase
{
    public function testDefaultConstructorIsZero(): void
    {
        $r = new Iso8601Recurrence();
        $this->assertSame(Iso8601Recurrence::ZERO, $r->iso);
        $this->assertSame(0, $r->count);
        $this->assertInstanceOf(Iso8601Interval::class, $r->interval);
        $this->assertSame('1970-01-01T00:00:00Z', $r->interval->start->iso);
    }

    public function testInfiniteRecurrenceHasNullCount(): void
    {
        $r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');
        $this->assertNull($r->count);
    }

    public function testFiniteRecurrenceParsesCount(): void
    {
        $r = new Iso8601Recurrence('R5/2026-05-14T00:00:00Z/P1D');
        $this->assertSame(5, $r->count);
    }

    public function testIsoRoundTripPreservesForm(): void
    {
        $cases = [
            'R/2026-05-14T00:00:00Z/P1D',
            'R5/2026-05-14T00:00:00Z/P1D',
            'R10/P1D/2026-05-15T00:00:00Z',
            'R3/2026-05-14T00:00:00Z/2026-05-15T00:00:00Z',
        ];

        foreach ($cases as $iso)
        {
            $r = new Iso8601Recurrence($iso);
            $this->assertSame($iso, $r->iso, "Round-trip failed for: $iso");
        }
    }

    public function testOccurrencesFinite(): void
    {
        $r        = new Iso8601Recurrence('R3/2026-05-14T00:00:00Z/P1D');
        $results  = iterator_to_array($r->occurrences(), false);

        $this->assertCount(3, $results);
        $this->assertSame('2026-05-14', $results[0]->format('Y-m-d'));
        $this->assertSame('2026-05-15', $results[1]->format('Y-m-d'));
        $this->assertSame('2026-05-16', $results[2]->format('Y-m-d'));
    }

    public function testOccurrencesInfiniteRequiresMax(): void
    {
        $r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');

        $results = iterator_to_array($r->occurrences(max: 3), false);
        $this->assertCount(3, $results);
        $this->assertSame('2026-05-14', $results[0]->format('Y-m-d'));
        $this->assertSame('2026-05-16', $results[2]->format('Y-m-d'));
    }

    public function testOccurrencesInfiniteWithoutMaxThrows(): void
    {
        $r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');
        $this->expectException(LogicException::class);
        iterator_to_array($r->occurrences(), false);
    }

    public function testOccurrencesMaxCapsFiniteCount(): void
    {
        $r       = new Iso8601Recurrence('R10/2026-05-14T00:00:00Z/P1D');
        $results = iterator_to_array($r->occurrences(max: 4), false);
        $this->assertCount(4, $results);
    }

    public function testOccurrencesFiniteCountCapsMax(): void
    {
        $r       = new Iso8601Recurrence('R3/2026-05-14T00:00:00Z/P1D');
        $results = iterator_to_array($r->occurrences(max: 100), false);
        $this->assertCount(3, $results);
    }

    public function testOccurrencesWithStartEndForm(): void
    {
        // Interval expressed as <start>/<end>, no explicit duration → diff used
        $r       = new Iso8601Recurrence('R3/2026-05-14T00:00:00Z/2026-05-14T12:00:00Z');
        $results = iterator_to_array($r->occurrences(), false);

        $this->assertCount(3, $results);
        $this->assertSame('2026-05-14T00:00:00+00:00', $results[0]->format('Y-m-d\TH:i:sP'));
        $this->assertSame('2026-05-14T12:00:00+00:00', $results[1]->format('Y-m-d\TH:i:sP'));
        $this->assertSame('2026-05-15T00:00:00+00:00', $results[2]->format('Y-m-d\TH:i:sP'));
    }

    public function testZeroCountYieldsNoOccurrences(): void
    {
        $r       = new Iso8601Recurrence('R0/2026-05-14T00:00:00Z/P1D');
        $results = iterator_to_array($r->occurrences(), false);
        $this->assertCount(0, $results);
    }

    public function testSetIsoUpdatesAllParts(): void
    {
        $r = new Iso8601Recurrence();
        $r->iso = 'R7/2026-05-14T08:00:00Z/PT1H';

        $this->assertSame(7, $r->count);
        $this->assertSame('2026-05-14T08:00:00Z', $r->interval->start->iso);
        $this->assertSame('PT1H', $r->interval->duration->iso);
    }

    public function testToStringReturnsIso(): void
    {
        $r = new Iso8601Recurrence('R5/2026-05-14T00:00:00Z/P1D');
        $this->assertSame('R5/2026-05-14T00:00:00Z/P1D', (string) $r);
    }

    public function testInvalidStringThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Recurrence('INVALID');
    }

    public function testMissingDesignatorThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Recurrence('2026-05-14T00:00:00Z/P1D');
    }

    public function testNegativeCountThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Recurrence('R-1/2026-05-14T00:00:00Z/P1D');
    }

    public function testInvalidInnerIntervalThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Recurrence('R5/P1D'); // unbounded
    }
}
