<?php

namespace tests\org\iso\helpers;

use PHPUnit\Framework\TestCase;

use function org\iso\helpers\isIso8601Recurrence;

/**
 * Unit tests for the isIso8601Recurrence validation function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class IsIso8601RecurrenceTest extends TestCase
{
    public function testInfiniteRecurrence(): void
    {
        $this->assertTrue(isIso8601Recurrence('R/2026-05-14T00:00:00Z/P1D'));
        $this->assertTrue(isIso8601Recurrence('R/2026-05-14T00:00:00Z/2026-05-15T00:00:00Z'));
    }

    public function testFiniteRecurrence(): void
    {
        $this->assertTrue(isIso8601Recurrence('R5/2026-05-14T00:00:00Z/P1D'));
        $this->assertTrue(isIso8601Recurrence('R0/2026-05-14T00:00:00Z/PT0S'));
        $this->assertTrue(isIso8601Recurrence('R10/P1D/2026-05-15T00:00:00Z'));
    }

    public function testMissingDesignatorIsRejected(): void
    {
        $this->assertFalse(isIso8601Recurrence('2026-05-14T00:00:00Z/P1D'));
    }

    public function testNegativeCountIsRejected(): void
    {
        $this->assertFalse(isIso8601Recurrence('R-1/2026-05-14T00:00:00Z/P1D'));
    }

    public function testUnboundedIntervalIsRejected(): void
    {
        $this->assertFalse(isIso8601Recurrence('R/P1D'));
        $this->assertFalse(isIso8601Recurrence('R5/P1D/P2D'));
    }

    public function testMalformed(): void
    {
        $this->assertFalse(isIso8601Recurrence(''));
        $this->assertFalse(isIso8601Recurrence('R'));
        $this->assertFalse(isIso8601Recurrence('R/'));
        $this->assertFalse(isIso8601Recurrence('R5/INVALID'));
    }
}
