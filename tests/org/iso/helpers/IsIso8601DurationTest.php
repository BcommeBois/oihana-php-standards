<?php

namespace tests\org\iso\helpers;

use PHPUnit\Framework\TestCase;

use function org\iso\helpers\isIso8601Duration;

/**
 * Unit tests for the isIso8601Duration validation function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
class IsIso8601DurationTest extends TestCase
{
    // ========================================================================
    // Non-Strict Mode Tests (Default - Uses PHP DateInterval Parser)
    // ========================================================================

    /**
     * Tests validation of valid date-only durations.
     */
    public function testValidDateOnlyDuration(): void
    {
        $this->assertTrue(isIso8601Duration('P1Y'));
        $this->assertTrue(isIso8601Duration('P2M'));
        $this->assertTrue(isIso8601Duration('P3D'));
        $this->assertTrue(isIso8601Duration('P1Y2M3D'));
    }

    /**
     * Tests validation of valid time-only durations.
     */
    public function testValidTimeOnlyDuration(): void
    {
        $this->assertTrue(isIso8601Duration('PT1H'));
        $this->assertTrue(isIso8601Duration('PT30M'));
        $this->assertTrue(isIso8601Duration('PT45S'));
        $this->assertTrue(isIso8601Duration('PT2H30M15S'));
    }

    /**
     * Tests validation of valid combined durations.
     */
    public function testValidCombinedDuration(): void
    {
        $this->assertTrue(isIso8601Duration('P1Y2M3DT4H5M6S'));
        $this->assertTrue(isIso8601Duration('P5DT12H'));
        $this->assertTrue(isIso8601Duration('P1YT30M'));
    }

    /**
     * Tests validation of valid week durations.
     */
    public function testValidWeekDuration(): void
    {
        $this->assertTrue(isIso8601Duration('P1W'));
        $this->assertTrue(isIso8601Duration('P4W'));
    }

    /**
     * Tests validation of zero durations.
     */
    public function testValidZeroDuration(): void
    {
        $this->assertTrue(isIso8601Duration('P0D'));
        $this->assertTrue(isIso8601Duration('PT0S'));
        $this->assertTrue(isIso8601Duration('P0Y'));
    }

    /**
     * Tests validation of large values.
     */
    public function testValidLargeValues(): void
    {
        $this->assertTrue(isIso8601Duration('P999Y'));
        $this->assertTrue(isIso8601Duration('P100Y50M999D'));
        $this->assertTrue(isIso8601Duration('PT9999H'));
    }

    /**
     * Tests validation rejects invalid formats.
     */
    public function testInvalidFormats(): void
    {
        $this->assertFalse(isIso8601Duration(''));
        $this->assertFalse(isIso8601Duration('INVALID'));
        $this->assertFalse(isIso8601Duration('1Y2M3D'));  // Missing P
        $this->assertFalse(isIso8601Duration('P'));       // No components
        $this->assertFalse(isIso8601Duration('PT'));      // No time components
        $this->assertFalse(isIso8601Duration('D5'));      // Wrong order
    }

    /**
     * Tests validation rejects malformed durations.
     */
    public function testMalformedDurations(): void
    {
        $this->assertFalse(isIso8601Duration('PY1'));     // Number after designator
        $this->assertFalse(isIso8601Duration('P1Y2'));    // No designator for 2
        $this->assertFalse(isIso8601Duration('P1Y2M3'));  // No designator for 3
        $this->assertFalse(isIso8601Duration('PT1H2'));   // No designator for 2
    }

    /**
     * Tests validation of edge cases.
     */
    public function testEdgeCases(): void
    {
        $this->assertFalse(isIso8601Duration('P T'));     // Space between P and T
        $this->assertFalse(isIso8601Duration('P1Y T1H')); // Space in duration
        $this->assertFalse(isIso8601Duration('p1y'));     // Lowercase (PHP may accept)
    }

    // ========================================================================
    // Strict Mode Tests (Regex-Based Validation)
    // ========================================================================

    /**
     * Tests strict validation of valid date durations.
     */
    public function testStrictValidDateDurations(): void
    {
        $this->assertTrue(isIso8601Duration('P1Y', true));
        $this->assertTrue(isIso8601Duration('P2M', true));
        $this->assertTrue(isIso8601Duration('P3D', true));
        $this->assertTrue(isIso8601Duration('P1Y2M3D', true));
    }

    /**
     * Tests strict validation of valid time durations.
     */
    public function testStrictValidTimeDurations(): void
    {
        $this->assertTrue(isIso8601Duration('PT1H', true));
        $this->assertTrue(isIso8601Duration('PT30M', true));
        $this->assertTrue(isIso8601Duration('PT45S', true));
        $this->assertTrue(isIso8601Duration('PT2H30M15S', true));
    }

    /**
     * Tests strict validation of valid combined durations.
     */
    public function testStrictValidCombinedDurations(): void
    {
        $this->assertTrue(isIso8601Duration('P1Y2M3DT4H5M6S', true));
        $this->assertTrue(isIso8601Duration('P5DT12H', true));
        $this->assertTrue(isIso8601Duration('P1YT30M', true));
    }

    /**
     * Tests strict validation of valid week durations.
     */
    public function testStrictValidWeekDurations(): void
    {
        $this->assertTrue(isIso8601Duration('P1W', true));
        $this->assertTrue(isIso8601Duration('P52W', true));
    }

    /**
     * Tests strict validation of zero durations.
     */
    public function testStrictValidZeroDurations(): void
    {
        $this->assertTrue( isIso8601Duration('P0D' , true ) ) ;
        $this->assertTrue( isIso8601Duration('PT0S', true ) ) ;
        $this->assertTrue( isIso8601Duration('P0Y' , true ) ) ;
    }

    /**
     * Tests strict validation rejects P alone.
     */
    public function testStrictRejectsPAlone(): void
    {
        $this->assertFalse(isIso8601Duration('P', true));
    }

    /**
     * Tests strict validation rejects PT alone.
     */
    public function testStrictRejectsPTAlone(): void
    {
        $this->assertFalse(isIso8601Duration('PT', true));
    }

    /**
     * Tests strict validation rejects invalid formats.
     */
    public function testStrictRejectsInvalidFormats(): void
    {
        $this->assertFalse(isIso8601Duration('', true));
        $this->assertFalse(isIso8601Duration('INVALID', true));
        $this->assertFalse(isIso8601Duration('1Y2M3D', true));  // Missing P
        $this->assertFalse(isIso8601Duration('D5', true));      // Wrong order
    }

    /**
     * Tests strict validation with decimal seconds.
     */
    public function testStrictDecimalSeconds(): void
    {
        $this->assertTrue(isIso8601Duration('PT1.5S', true));
        $this->assertTrue(isIso8601Duration('PT30.25S', true));
        $this->assertTrue(isIso8601Duration('PT0.001S', true));
    }

    /**
     * Tests strict validation rejects decimals in other components.
     */
    public function testStrictRejectsDecimalsInNonSeconds(): void
    {
        $this->assertFalse(isIso8601Duration('P1.5Y', true));
        $this->assertFalse(isIso8601Duration('P2.5M', true));
        $this->assertFalse(isIso8601Duration('P3.5D', true));
        $this->assertFalse(isIso8601Duration('PT1.5H', true));
        $this->assertFalse(isIso8601Duration('PT30.5M', true));
    }

    /**
     * Tests strict validation rejects wrong component order.
     */
    public function testStrictRejectsWrongOrder(): void
    {
        $this->assertFalse(isIso8601Duration('P1D2Y', true));     // Days before years
        $this->assertFalse(isIso8601Duration('P1M2Y', true));     // Months before years
        $this->assertFalse(isIso8601Duration('PT1M2H', true));    // Minutes before hours
    }

    /**
     * Tests strict validation handles T without time components.
     */
    public function testStrictHandlesTWithoutTimeComponents(): void
    {
        $this->assertFalse(isIso8601Duration('P1YT', true));
        $this->assertFalse(isIso8601Duration('P5DT', true));
    }

    /**
     * Tests strict validation with mixed valid components.
     */
    public function testStrictMixedValidComponents(): void
    {
        $this->assertTrue(isIso8601Duration('P1Y3D', true));      // Year and day (no month)
        $this->assertTrue(isIso8601Duration('P2MT4H', true));     // Month and hour (no day)
        $this->assertTrue(isIso8601Duration('PT2H45S', true));    // Hour and second (no minute)
    }

    /**
     * Tests strict validation with large numbers.
     */
    public function testStrictLargeNumbers(): void
    {
        $this->assertTrue(isIso8601Duration('P999Y', true));
        $this->assertTrue(isIso8601Duration('P9999D', true));
        $this->assertTrue(isIso8601Duration('PT99999H', true));
    }

    // ========================================================================
    // Comparison Tests (Strict vs Non-Strict)
    // ========================================================================

    /**
     * Tests that both modes accept standard valid durations.
     */
    public function testBothModesAcceptStandardDurations(): void
    {
        $validDurations = [
            'P1Y2M3D',
            'PT4H30M',
            'P1Y2M3DT4H5M6S',
            'P0D',
            'P1W'
        ];

        foreach ($validDurations as $duration) {
            $this->assertTrue(
                isIso8601Duration($duration, false),
                "Non-strict should accept: $duration"
            );
            $this->assertTrue(
                isIso8601Duration($duration, true),
                "Strict should accept: $duration"
            );
        }
    }

    /**
     * Tests that both modes reject clearly invalid durations.
     */
    public function testBothModesRejectInvalidDurations(): void
    {
        $invalidDurations = [
            '',
            'INVALID',
            '1Y2M3D',
            'P1Y2M3X',
        ];

        foreach ($invalidDurations as $duration) {
            $this->assertFalse(
                isIso8601Duration($duration, false),
                "Non-strict should reject: $duration"
            );
            $this->assertFalse(
                isIso8601Duration($duration, true),
                "Strict should reject: $duration"
            );
        }
    }

    /**
     * Tests that strict mode is more restrictive than non-strict.
     */
    public function testStrictModeIsMoreRestrictive(): void
    {
        // P alone
        $this->assertFalse(isIso8601Duration('P', true));

        // PT alone
        $this->assertFalse(isIso8601Duration('PT', true));

        // These may or may not be accepted by PHP parser, but strict rejects
        $strictRejects = ['P', 'PT', 'P1YT'];

        foreach ($strictRejects as $duration) {
            $this->assertFalse(
                isIso8601Duration($duration, true),
                "Strict should reject: $duration"
            );
        }
    }

    // ========================================================================
    // Real-World Usage Tests
    // ========================================================================

    /**
     * Tests validation of typical user input scenarios.
     */
    public function testTypicalUserInputs(): void
    {
        // Valid typical inputs
        $this->assertTrue(isIso8601Duration('PT30M'));     // 30 minutes
        $this->assertTrue(isIso8601Duration('PT1H'));      // 1 hour
        $this->assertTrue(isIso8601Duration('P1D'));       // 1 day
        $this->assertTrue(isIso8601Duration('P1W'));       // 1 week
        $this->assertTrue(isIso8601Duration('P1M'));       // 1 month
        $this->assertTrue(isIso8601Duration('P1Y'));       // 1 year

        // Invalid typical inputs
        $this->assertFalse(isIso8601Duration('30 minutes'));
        $this->assertFalse(isIso8601Duration('1 hour'));
        $this->assertFalse(isIso8601Duration('1day'));
        $this->assertFalse(isIso8601Duration('1h30m'));
    }

    /**
     * Tests validation can be used for form validation.
     */
    public function testFormValidationScenario(): void
    {
        $userInputs = [
            'P1Y' => true,
            'PT2H' => true,
            'invalid' => false,
            '' => false,
            'P1Y2M3DT4H5M6S' => true,
        ];

        foreach ($userInputs as $input => $expected) {
            $this->assertSame(
                $expected,
                isIso8601Duration($input),
                "Input '$input' should be " . ($expected ? 'valid' : 'invalid')
            );
        }
    }

    /**
     * Tests validation with common mistakes.
     */
    public function testCommonMistakes(): void
    {
        // Missing P
        $this->assertFalse(isIso8601Duration('1Y2M3D'));

        // Wrong separators
        $this->assertFalse(isIso8601Duration('P1Y-2M-3D'));
        $this->assertFalse(isIso8601Duration('P1Y 2M 3D'));

        // Wrong case (depends on PHP parser, but generally invalid)
        // Lowercase may be accepted by some parsers

        // Using colons (time format confusion)
        $this->assertFalse(isIso8601Duration('PT1:30:00'));
    }

    /**
     * Tests validation performance with batch processing.
     */
    public function testBatchValidation(): void
    {
        $durations =
        [
            'P1Y', 'P2M', 'P3D', 'PT4H', 'PT5M', 'PT6S',
            'P1Y2M', 'P2M3D', 'PT4H5M', 'PT5M6S',
            'P1Y2M3D', 'PT4H5M6S', 'P1Y2M3DT4H5M6S'
        ];

        foreach ($durations as $duration)
        {
            $this->assertTrue
            (
                isIso8601Duration($duration),
                "Should validate: $duration"
            );
        }
    }

    /**
     * Tests validation with edge case numeric values.
     */
    public function testEdgeCaseNumericValues(): void
    {
        $this->assertTrue(isIso8601Duration('P0D'));
        $this->assertTrue(isIso8601Duration('PT0S'));
        $this->assertTrue(isIso8601Duration('P1Y', true));
        $this->assertTrue(isIso8601Duration('P999Y', true));

        // Very large numbers
        $this->assertTrue(isIso8601Duration('P99999D'));
    }
}