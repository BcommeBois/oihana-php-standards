<?php

namespace tests\org\iso\helpers;

use PHPUnit\Framework\TestCase;

use function org\iso\helpers\isIso8601Date;

/**
 * Unit tests for the isIso8601Date validation function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class IsIso8601DateTest extends TestCase
{
    public function testValidExtendedDates(): void
    {
        $this->assertTrue( isIso8601Date('2026-05-14') ) ;
        $this->assertTrue( isIso8601Date('2000-01-01') ) ;
        $this->assertTrue( isIso8601Date('2024-02-29') ) ; // leap year
        $this->assertTrue( isIso8601Date('1999-12-31') ) ;
    }

    public function testValidBasicDates(): void
    {
        $this->assertTrue( isIso8601Date('20260514') ) ;
        $this->assertTrue( isIso8601Date('20240229') ) ;
    }

    public function testStrictRejectsBasic(): void
    {
        $this->assertFalse( isIso8601Date('20260514', true ) ) ;
        $this->assertTrue ( isIso8601Date('2026-05-14', true ) ) ;
    }

    public function testInvalidCalendarDates(): void
    {
        $this->assertFalse( isIso8601Date('2026-02-30') ) ;
        $this->assertFalse( isIso8601Date('2023-02-29') ) ; // not a leap year
        $this->assertFalse( isIso8601Date('2026-04-31') ) ; // April has 30 days
        $this->assertFalse( isIso8601Date('2026-13-01') ) ; // invalid month
        $this->assertFalse( isIso8601Date('2026-00-10') ) ; // month 00
        $this->assertFalse( isIso8601Date('2026-05-00') ) ; // day 00
    }

    public function testInvalidFormats(): void
    {
        $this->assertFalse( isIso8601Date('') ) ;
        $this->assertFalse( isIso8601Date('INVALID') ) ;
        $this->assertFalse( isIso8601Date('2026-5-14') ) ;  // not zero-padded
        $this->assertFalse( isIso8601Date('2026/05/14') ) ; // wrong separator
        $this->assertFalse( isIso8601Date('26-05-14') ) ;   // 2-digit year
        $this->assertFalse( isIso8601Date('2026-05-14T00:00:00') ) ; // includes time
    }
}
