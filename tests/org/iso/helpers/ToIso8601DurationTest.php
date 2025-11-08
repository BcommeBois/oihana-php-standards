<?php

namespace tests\org\iso\helpers;

use DateInterval;
use DateMalformedIntervalStringException;
use DateTime;

use PHPUnit\Framework\TestCase;

use function org\iso\helpers\toIso8601Duration;

class ToIso8601DurationTest extends TestCase
{
    /**
     * Tests conversion of a zero duration.
     */
    public function testZeroDuration(): void
    {
        $interval = new DateInterval('PT0S');
        $result = toIso8601Duration($interval);

        $this->assertSame('P0D', $result);
    }

    /**
     * Tests conversion of date-only durations (years, months, days).
     */
    public function testDateOnlyDuration(): void
    {
        $interval = new DateInterval('P1Y2M3D');
        $result = toIso8601Duration($interval);

        $this->assertSame('P1Y2M3D', $result);
    }

    /**
     * Tests conversion of time-only durations (hours, minutes, seconds).
     */
    public function testTimeOnlyDuration(): void
    {
        $interval = new DateInterval('PT4H30M15S');
        $result = toIso8601Duration($interval);

        $this->assertSame('PT4H30M15S', $result);
    }

    /**
     * Tests conversion of combined date and time duration.
     */
    public function testCombinedDuration(): void
    {
        $interval = new DateInterval('P2Y3M15DT12H45M30S');
        $result = toIso8601Duration($interval);

        $this->assertSame('P2Y3M15DT12H45M30S', $result);
    }

    /**
     * Tests conversion with only years.
     */
    public function testYearOnly(): void
    {
        $interval = new DateInterval('P5Y');
        $result = toIso8601Duration($interval);

        $this->assertSame('P5Y', $result);
    }

    /**
     * Tests conversion with only months.
     */
    public function testMonthOnly(): void
    {
        $interval = new DateInterval('P3M');
        $result = toIso8601Duration($interval);

        $this->assertSame('P3M', $result);
    }

    /**
     * Tests conversion with only days.
     */
    public function testDayOnly(): void
    {
        $interval = new DateInterval('P10D');
        $result = toIso8601Duration($interval);

        $this->assertSame('P10D', $result);
    }

    /**
     * Tests conversion with only hours.
     */
    public function testHourOnly(): void
    {
        $interval = new DateInterval('PT8H');
        $result = toIso8601Duration($interval);

        $this->assertSame('PT8H', $result);
    }

    /**
     * Tests conversion with only minutes.
     */
    public function testMinuteOnly(): void
    {
        $interval = new DateInterval('PT45M');
        $result = toIso8601Duration($interval);

        $this->assertSame('PT45M', $result);
    }

    /**
     * Tests conversion with only seconds.
     */
    public function testSecondOnly(): void
    {
        $interval = new DateInterval('PT30S');
        $result = toIso8601Duration($interval);

        $this->assertSame('PT30S', $result);
    }

    /**
     * Tests conversion from DateTime::diff() result.
     */
    public function testFromDateDifference(): void
    {
        $start = new DateTime('2024-01-01 10:00:00');
        $end = new DateTime('2024-01-01 12:30:45');
        $interval = $start->diff($end);

        $result = toIso8601Duration($interval);

        $this->assertSame('PT2H30M45S', $result);
    }

    /**
     * Tests conversion from date difference spanning multiple months.
     */
    public function testFromDateDifferenceMultipleMonths(): void
    {
        $start = new DateTime('2024-01-01');
        $end = new DateTime('2024-12-31');
        $interval = $start->diff($end);

        $result = toIso8601Duration($interval);

        // 11 months and 30 days (2024 is a leap year)
        $this->assertSame('P11M30D', $result);
    }

    /**
     * Tests conversion with large values.
     */
    public function testLargeValues(): void
    {
        $interval = new DateInterval('P100Y50M999D');
        $result = toIso8601Duration($interval);

        $this->assertSame('P100Y50M999D', $result);
    }

    /**
     * Tests conversion with hours and minutes only.
     */
    public function testHoursAndMinutes(): void
    {
        $interval = new DateInterval('PT2H30M');
        $result = toIso8601Duration($interval);

        $this->assertSame('PT2H30M', $result);
    }

    /**
     * Tests conversion with minutes and seconds only.
     */
    public function testMinutesAndSeconds(): void
    {
        $interval = new DateInterval('PT15M45S');
        $result = toIso8601Duration($interval);

        $this->assertSame('PT15M45S', $result);
    }

    /**
     * Tests conversion with years and days only.
     */
    public function testYearsAndDays(): void
    {
        $interval = new DateInterval('P1Y15D');
        $result = toIso8601Duration($interval);

        $this->assertSame('P1Y15D', $result);
    }

    /**
     * Tests conversion with partial date and time components.
     */
    public function testPartialComponents(): void
    {
        $interval = new DateInterval('P1YT30M');
        $result = toIso8601Duration($interval);

        $this->assertSame('P1YT30M', $result);
    }

    /**
     * Tests conversion with single digit values.
     */
    public function testSingleDigitValues(): void
    {
        $interval = new DateInterval('P1Y2M3DT4H5M6S');
        $result = toIso8601Duration($interval);

        $this->assertSame('P1Y2M3DT4H5M6S', $result);
    }

    /**
     * Tests that the function handles DateInterval created manually.
     */
    public function testManuallyCreatedInterval(): void
    {
        $interval = new DateInterval('P0D');
        $interval->y = 2;
        $interval->m = 6;
        $interval->d = 15;
        $interval->h = 10;
        $interval->i = 30;
        $interval->s = 45;

        $result = toIso8601Duration($interval);

        $this->assertSame('P2Y6M15DT10H30M45S', $result);
    }

    /**
     * Tests conversion of a one-week duration.
     * Note: DateInterval converts 'P1W' to 'P7D' internally.
     */
    public function testWeekDuration(): void
    {
        $interval = new DateInterval('P1W');
        $result = toIso8601Duration($interval);

        // PHP converts P1W to P7D internally
        $this->assertSame('P7D', $result);
    }

    /**
     * Tests conversion with only time component (no date).
     */
    public function testTimeComponentOnly(): void
    {
        $interval = new DateInterval('PT1H2M3S');
        $result = toIso8601Duration($interval);

        $this->assertSame('PT1H2M3S', $result);
    }

    /**
     * Tests conversion with maximum reasonable values.
     */
    public function testMaximumValues(): void
    {
        $interval = new DateInterval('P999Y12M31DT23H59M59S');
        $result = toIso8601Duration($interval);

        $this->assertSame('P999Y12M31DT23H59M59S', $result);
    }

    /**
     * Tests idempotency: converting back and forth should yield same result.
     * @throws DateMalformedIntervalStringException
     */
    public function testIdempotency(): void
    {
        $original = 'P1Y2M3DT4H5M6S';
        $interval = new DateInterval($original);
        $result = toIso8601Duration($interval);

        $this->assertSame($original, $result);
    }
}