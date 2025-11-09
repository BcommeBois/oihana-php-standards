<?php

namespace tests\org\iso;

use DateInterval;
use DateTime;
use org\iso\Iso8601Duration;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the toIso8601Duration function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
class Iso8601DurationTest extends TestCase
{
    // ========================================================================
    // Constants Tests
    // ========================================================================

    /**
     * Tests PERIOD constant.
     */
    public function testPeriodConstant(): void
    {
        $this->assertSame('P', Iso8601Duration::PERIOD);
    }

    /**
     * Tests TIME constant.
     */
    public function testTimeConstant(): void
    {
        $this->assertSame('T', Iso8601Duration::TIME);
    }

    /**
     * Tests YEAR constant.
     */
    public function testYearConstant(): void
    {
        $this->assertSame('Y', Iso8601Duration::YEAR);
    }

    /**
     * Tests MONTH constant.
     */
    public function testMonthConstant(): void
    {
        $this->assertSame('M', Iso8601Duration::MONTH);
    }

    /**
     * Tests DAY constant.
     */
    public function testDayConstant(): void
    {
        $this->assertSame('D', Iso8601Duration::DAY);
    }

    /**
     * Tests WEEK constant.
     */
    public function testWeekConstant(): void
    {
        $this->assertSame('W', Iso8601Duration::WEEK);
    }

    /**
     * Tests HOUR constant.
     */
    public function testHourConstant(): void
    {
        $this->assertSame('H', Iso8601Duration::HOUR);
    }

    /**
     * Tests MINUTE constant.
     */
    public function testMinuteConstant(): void
    {
        $this->assertSame('M', Iso8601Duration::MINUTE);
    }

    /**
     * Tests SECOND constant.
     */
    public function testSecondConstant(): void
    {
        $this->assertSame('S', Iso8601Duration::SECOND);
    }

    /**
     * Tests ZERO constant.
     */
    public function testZeroConstant(): void
    {
        $this->assertSame('P0D', Iso8601Duration::ZERO);
    }

    /**
     * Tests PATTERN constant is a valid regex.
     */
    public function testPatternConstantIsValidRegex(): void
    {
        // Test that the pattern is a valid regex
        $this->assertIsString(Iso8601Duration::PATTERN);
        $this->assertStringStartsWith('/^P', Iso8601Duration::PATTERN);
        $this->assertStringEndsWith('$/', Iso8601Duration::PATTERN);

        // Test it matches valid durations
        $this->assertMatchesRegularExpression(Iso8601Duration::PATTERN, 'P1Y2M3D');
        $this->assertMatchesRegularExpression(Iso8601Duration::PATTERN, 'PT4H30M');
        $this->assertMatchesRegularExpression(Iso8601Duration::PATTERN, 'P1Y2M3DT4H5M6S');
    }

    /**
     * Tests constants can be used to build duration strings.
     */
    public function testBuildDurationWithConstants(): void
    {
        $duration = Iso8601Duration::PERIOD . '1' . Iso8601Duration::YEAR
            . '2' . Iso8601Duration::MONTH
            . '3' . Iso8601Duration::DAY;

        $this->assertSame('P1Y2M3D', $duration);

        // Test with time
        $duration = Iso8601Duration::PERIOD . Iso8601Duration::TIME
            . '4' . Iso8601Duration::HOUR
            . '30' . Iso8601Duration::MINUTE;

        $this->assertSame('PT4H30M', $duration);
    }

    /**
     * Tests ZERO constant can be used to create zero duration.
     */
    public function testZeroConstantUsage(): void
    {
        $duration = new Iso8601Duration(Iso8601Duration::ZERO);

        $this->assertSame('P0D', $duration->iso);
        $this->assertSame(0, $duration->toSeconds());
    }

    // ========================================================================
    // Component Properties Tests
    // ========================================================================

    /**
     * Tests years property getter.
     */
    public function testYearsProperty(): void
    {
        $duration = new Iso8601Duration('P5Y');

        $this->assertSame(5, $duration->years);
    }

    /**
     * Tests months property getter.
     */
    public function testMonthsProperty(): void
    {
        $duration = new Iso8601Duration('P3M');

        $this->assertSame(3, $duration->months);
    }

    /**
     * Tests days property getter.
     */
    public function testDaysProperty(): void
    {
        $duration = new Iso8601Duration('P10D');

        $this->assertSame(10, $duration->days);
    }

    /**
     * Tests hours property getter.
     */
    public function testHoursProperty(): void
    {
        $duration = new Iso8601Duration('PT8H');

        $this->assertSame(8, $duration->hours);
    }

    /**
     * Tests minutes property getter.
     */
    public function testMinutesProperty(): void
    {
        $duration = new Iso8601Duration('PT45M');

        $this->assertSame(45, $duration->minutes);
    }

    /**
     * Tests seconds property getter.
     */
    public function testSecondsProperty(): void
    {
        $duration = new Iso8601Duration('PT30S');

        $this->assertSame(30, $duration->seconds);
    }

    /**
     * Tests all component properties with complex duration.
     */
    public function testAllComponentProperties(): void
    {
        $duration = new Iso8601Duration('P2Y3M15DT4H30M45S');

        $this->assertSame(2, $duration->years);
        $this->assertSame(3, $duration->months);
        $this->assertSame(15, $duration->days);
        $this->assertSame(4, $duration->hours);
        $this->assertSame(30, $duration->minutes);
        $this->assertSame(45, $duration->seconds);
    }

    /**
     * Tests component properties with zero duration.
     */
    public function testComponentPropertiesWithZeroDuration(): void
    {
        $duration = new Iso8601Duration('P0D');

        $this->assertSame(0, $duration->years);
        $this->assertSame(0, $duration->months);
        $this->assertSame(0, $duration->days);
        $this->assertSame(0, $duration->hours);
        $this->assertSame(0, $duration->minutes);
        $this->assertSame(0, $duration->seconds);
    }

    /**
     * Tests that component properties update when iso is changed.
     */
    public function testComponentPropertiesUpdateWithIso(): void
    {
        $duration = new Iso8601Duration('P1D');
        $this->assertSame(1, $duration->days);

        $duration->iso = 'P5D';
        $this->assertSame(5, $duration->days);
    }

    /**
     * Tests that component properties update when interval is changed.
     */
    public function testComponentPropertiesUpdateWithInterval(): void
    {
        $duration = new Iso8601Duration('P1D');
        $this->assertSame(1, $duration->days);

        $duration->interval = new DateInterval('P10D');
        $this->assertSame(10, $duration->days);
    }

    /**
     * Tests using component properties in calculations.
     */
    public function testComponentPropertiesInCalculations(): void
    {
        $duration = new Iso8601Duration('P2Y3M15D');

        $totalMonths = ($duration->years * 12) + $duration->months;
        $this->assertSame(27, $totalMonths);

        $approximateDays = $totalMonths * 30 + $duration->days;
        $this->assertSame(825, $approximateDays);
    }

    /**
     * Tests component properties with DateInterval from diff.
     */
    public function testComponentPropertiesFromDiff(): void
    {
        $start = new DateTime('2024-01-01');
        $end = new DateTime('2024-06-15');
        $interval = $start->diff($end);

        $duration = new Iso8601Duration($interval);

        $this->assertSame(5, $duration->months);
        $this->assertSame(14, $duration->days);
    }
}