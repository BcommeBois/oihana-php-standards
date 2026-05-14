<?php

namespace tests\org\iso\helpers;

use PHPUnit\Framework\TestCase;

use function org\iso\helpers\isIso8601DateTime;

/**
 * Unit tests for the isIso8601DateTime validation function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class IsIso8601DateTimeTest extends TestCase
{
    public function testValidDateTimes(): void
    {
        $this->assertTrue( isIso8601DateTime('2026-05-14T08:15:30') ) ;
        $this->assertTrue( isIso8601DateTime('2026-05-14T08:15:30Z') ) ;
        $this->assertTrue( isIso8601DateTime('2026-05-14T08:15:30+02:00') ) ;
        $this->assertTrue( isIso8601DateTime('2026-05-14T08:15:30-05:00') ) ;
        $this->assertTrue( isIso8601DateTime('2026-05-14T08:15:30+0200') ) ;
        $this->assertTrue( isIso8601DateTime('2026-05-14T08:15:30.123Z') ) ;
        $this->assertTrue( isIso8601DateTime('2026-05-14T08:15:30.123456+02:00') ) ;
    }

    public function testSpaceSeparatorAllowedByDefault(): void
    {
        $this->assertTrue( isIso8601DateTime('2026-05-14 08:15:30') ) ;
        $this->assertTrue( isIso8601DateTime('2026-05-14 08:15:30Z') ) ;
    }

    public function testStrictRequiresT(): void
    {
        $this->assertFalse( isIso8601DateTime('2026-05-14 08:15:30', true ) ) ;
        $this->assertTrue ( isIso8601DateTime('2026-05-14T08:15:30', true ) ) ;
    }

    public function testInvalidCalendarDates(): void
    {
        $this->assertFalse( isIso8601DateTime('2026-02-30T00:00:00Z') ) ;
        $this->assertFalse( isIso8601DateTime('2023-02-29T12:00:00Z') ) ; // not a leap year
        $this->assertTrue ( isIso8601DateTime('2024-02-29T12:00:00Z') ) ; // leap year OK
    }

    public function testInvalidTimes(): void
    {
        $this->assertFalse( isIso8601DateTime('2026-05-14T24:00:00') ) ;
        $this->assertFalse( isIso8601DateTime('2026-05-14T12:60:00') ) ;
        $this->assertFalse( isIso8601DateTime('2026-05-14T12:00:60') ) ;
    }

    public function testInvalidFormats(): void
    {
        $this->assertFalse( isIso8601DateTime('') ) ;
        $this->assertFalse( isIso8601DateTime('INVALID') ) ;
        $this->assertFalse( isIso8601DateTime('2026-05-14') ) ;     // date only
        $this->assertFalse( isIso8601DateTime('T08:15:30Z') ) ;     // time only
        $this->assertFalse( isIso8601DateTime('2026-05-14T8:15:30') ) ;  // hour not padded
        $this->assertFalse( isIso8601DateTime('2026/05/14T08:15:30') ) ;
    }
}
