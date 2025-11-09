<?php

namespace tests\org\iso\helpers;

use PHPUnit\Framework\TestCase;

use function org\iso\helpers\isIso8601Time;

/**
 * Unit tests for the isIso8601Duration validation function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
final class IsIso8601TimeTest extends TestCase
{
    /**
     * Test valid ISO 8601 times (non-strict)
     */
    public function testValidTimesNonStrict(): void
    {
        $this->assertTrue( isIso8601Time('T00:00:00'));
        $this->assertTrue( isIso8601Time('T23:59:59'));
        $this->assertTrue( isIso8601Time('T14:30:00Z'));
        $this->assertTrue( isIso8601Time('T08:15:30+02:00'));
        $this->assertTrue( isIso8601Time('T12:34:56.789')); // fractional seconds
        $this->assertTrue( isIso8601Time('14:30:00')); // non-strict allows parser fallback
    }

    /**
     * Test invalid ISO 8601 times (non-strict)
     */
    public function testInvalidTimesNonStrict(): void
    {
        $this->assertFalse( isIso8601Time('INVALID'));
        $this->assertFalse( isIso8601Time('T24:00:00')); // invalid hour
        $this->assertFalse( isIso8601Time('T12:60:00')); // invalid minute
        $this->assertFalse( isIso8601Time('T12:00:60')); // invalid second
        $this->assertFalse( isIso8601Time('T'));          // no time components
    }

    /**
     * Test valid ISO 8601 times (strict mode)
     */
    public function testValidTimesStrict(): void
    {
        $this->assertTrue( isIso8601Time('T00:00:00', true));
        $this->assertTrue( isIso8601Time('T23:59:59', true));
        $this->assertTrue( isIso8601Time('T14:30:00Z', true));
        $this->assertTrue( isIso8601Time('T08:15:30+02:00', true));
        $this->assertTrue( isIso8601Time('T12:34:56.789', true)); // fractional seconds allowed
    }

    /**
     * Test invalid ISO 8601 times (strict mode)
     */
    public function testInvalidTimesStrict(): void
    {
        $this->assertFalse( isIso8601Time('14:30:00', true ) ) ; // missing T
        $this->assertFalse( isIso8601Time('INVALID', true ) ) ;
        $this->assertFalse( isIso8601Time('T24:00:00', true ) ) ;
        $this->assertFalse( isIso8601Time('T12:60:00', true ) ) ;
        $this->assertFalse( isIso8601Time('T12:00:60', true ) ) ;
        $this->assertFalse( isIso8601Time('T' ) ) ; // no components
    }
}