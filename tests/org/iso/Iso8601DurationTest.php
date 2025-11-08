<?php

namespace tests\org\iso ;

use DateInterval;
use DateInvalidOperationException;
use DateTime;
use InvalidArgumentException;
use org\iso\Iso8601Duration;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the Iso8601Duration class.
 *
 * @package org\iso\tests
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
class Iso8601DurationTest extends TestCase
{
    // ========================================================================
    // Constructor Tests
    // ========================================================================

    /**
     * Tests construction with an ISO 8601 string.
     */
    public function testConstructWithIsoString(): void
    {
        $duration = new Iso8601Duration('P1Y2M3D');

        $this->assertSame('P1Y2M3D', $duration->iso);
    }

    /**
     * Tests construction with a DateInterval object.
     */
    public function testConstructWithDateInterval(): void
    {
        $interval = new DateInterval('PT2H30M');
        $duration = new Iso8601Duration($interval);

        $this->assertSame('PT2H30M', $duration->iso);
    }

    /**
     * Tests construction with null (default zero duration).
     */
    public function testConstructWithNull(): void
    {
        $duration = new Iso8601Duration(null);

        $this->assertSame('P0D', $duration->iso);
    }

    /**
     * Tests construction without parameter (default zero duration).
     */
    public function testConstructWithoutParameter(): void
    {
        $duration = new Iso8601Duration();

        $this->assertSame('P0D', $duration->iso);
        $this->assertSame(0, $duration->toSeconds());
    }

    /**
     * Tests construction with invalid ISO string throws exception.
     */
    public function testConstructWithInvalidIsoStringThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ISO 8601 duration');

        new Iso8601Duration('INVALID');
    }

    /**
     * Tests construction with date difference from DateTime::diff().
     */
    public function testConstructWithDateDifference(): void
    {
        $start = new DateTime('2024-01-01');
        $end = new DateTime('2024-01-10');
        $interval = $start->diff($end);

        $duration = new Iso8601Duration($interval);

        $this->assertSame('P9D', $duration->iso);
    }

    // ========================================================================
    // Constants Tests
    // ========================================================================

    /**
     * Tests that all constants have correct values.
     */
    public function testConstants(): void
    {
        $this->assertSame('P', Iso8601Duration::PERIOD);
        $this->assertSame('T', Iso8601Duration::TIME);
        $this->assertSame('Y', Iso8601Duration::YEAR);
        $this->assertSame('M', Iso8601Duration::MONTH);
        $this->assertSame('D', Iso8601Duration::DAY);
        $this->assertSame('W', Iso8601Duration::WEEK);
        $this->assertSame('H', Iso8601Duration::HOUR);
        $this->assertSame('M', Iso8601Duration::MINUTE);
        $this->assertSame('S', Iso8601Duration::SECOND);
        $this->assertSame('P0D', Iso8601Duration::ZERO);
    }

    /**
     * Tests using ZERO constant for construction.
     */
    public function testConstructWithZeroConstant(): void
    {
        $duration = new Iso8601Duration(Iso8601Duration::ZERO);

        $this->assertSame('P0D', $duration->iso);
        $this->assertSame(0, $duration->toSeconds());
    }

    // ========================================================================
    // Property: $iso (getter/setter) Tests
    // ========================================================================

    /**
     * Tests getting the iso property.
     */
    public function testGetIsoProperty(): void
    {
        $duration = new Iso8601Duration('P5D');

        $this->assertSame('P5D', $duration->iso);
    }

    /**
     * Tests setting the iso property with valid string.
     */
    public function testSetIsoProperty(): void
    {
        $duration = new Iso8601Duration('P1D');
        $duration->iso = 'PT2H';

        $this->assertSame('PT2H', $duration->iso);
        $this->assertSame(7200, $duration->toSeconds());
    }

    /**
     * Tests that setting iso property updates the interval.
     */
    public function testSetIsoPropertyUpdatesInterval(): void
    {
        $duration = new Iso8601Duration('P1D');
        $duration->iso = 'P5D';

        $this->assertSame(5, $duration->interval->d);
    }

    /**
     * Tests setting iso property with invalid string throws exception.
     */
    public function testSetIsoPropertyWithInvalidStringThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $duration = new Iso8601Duration('P1D');
        $duration->iso = 'NOT_VALID';
    }

    // ========================================================================
    // Property: $interval (getter/setter) Tests
    // ========================================================================

    /**
     * Tests getting the interval property.
     */
    public function testGetIntervalProperty(): void
    {
        $duration = new Iso8601Duration('P3D');
        $interval = $duration->interval;

        $this->assertInstanceOf(DateInterval::class, $interval);
        $this->assertSame(3, $interval->d);
    }

    /**
     * Tests setting the interval property.
     */
    public function testSetIntervalProperty(): void
    {
        $duration = new Iso8601Duration('P1D');
        $newInterval = new DateInterval('PT5H');

        $duration->interval = $newInterval;

        $this->assertSame('PT5H', $duration->iso);
        $this->assertSame(5, $duration->interval->h);
    }

    /**
     * Tests that setting interval clones the object (no reference).
     */
    public function testSetIntervalPropertyClonesObject(): void
    {
        $duration = new Iso8601Duration('P1D');
        $externalInterval = new DateInterval('P5D');

        $duration->interval = $externalInterval;
        $externalInterval->d = 10; // Modify external

        $this->assertSame(5, $duration->interval->d); // Should not be affected
    }

    /**
     * Tests that setting interval property updates the iso string.
     */
    public function testSetIntervalPropertyUpdatesIso(): void
    {
        $duration = new Iso8601Duration('P1D');
        $duration->interval = new DateInterval('P2Y3M');

        $this->assertSame('P2Y3M', $duration->iso);
    }

    // ========================================================================
    // Method: toSeconds() Tests
    // ========================================================================

    /**
     * Tests toSeconds with zero duration.
     */
    public function testToSecondsZero(): void
    {
        $duration = new Iso8601Duration('P0D');

        $this->assertSame(0, $duration->toSeconds());
    }

    /**
     * Tests toSeconds with hours only.
     */
    public function testToSecondsHours(): void
    {
        $duration = new Iso8601Duration('PT2H');

        $this->assertSame(7200, $duration->toSeconds());
    }

    /**
     * Tests toSeconds with minutes only.
     */
    public function testToSecondsMinutes(): void
    {
        $duration = new Iso8601Duration('PT30M');

        $this->assertSame(1800, $duration->toSeconds());
    }

    /**
     * Tests toSeconds with seconds only.
     */
    public function testToSecondsSeconds(): void
    {
        $duration = new Iso8601Duration('PT45S');

        $this->assertSame(45, $duration->toSeconds());
    }

    /**
     * Tests toSeconds with days only.
     */
    public function testToSecondsDays(): void
    {
        $duration = new Iso8601Duration('P1D');

        $this->assertSame(86400, $duration->toSeconds());
    }

    /**
     * Tests toSeconds with months (approximate: 30 days).
     */
    public function testToSecondsMonths(): void
    {
        $duration = new Iso8601Duration('P1M');

        $this->assertSame(2592000, $duration->toSeconds()); // 30 * 86400
    }

    /**
     * Tests toSeconds with years (approximate: 365 days).
     */
    public function testToSecondsYears(): void
    {
        $duration = new Iso8601Duration('P1Y');

        $this->assertSame(31536000, $duration->toSeconds()); // 365 * 86400
    }

    /**
     * Tests toSeconds with complex duration.
     */
    public function testToSecondsComplex(): void
    {
        $duration = new Iso8601Duration('P1Y2M3DT4H5M6S');

        $expected = (365 + 60 + 3) * 86400 + 4 * 3600 + 5 * 60 + 6;
        $this->assertSame($expected, $duration->toSeconds());
    }

    /**
     * Tests toSeconds with hours, minutes, and seconds.
     */
    public function testToSecondsTimeComponents(): void
    {
        $duration = new Iso8601Duration('PT1H30M45S');

        $expected = 3600 + 1800 + 45;
        $this->assertSame($expected, $duration->toSeconds());
    }

    // ========================================================================
    // Method: addTo() Tests
    // ========================================================================

    /**
     * Tests addTo with days.
     */
    public function testAddToDays(): void
    {
        $duration = new Iso8601Duration('P5D');
        $date = new DateTime('2024-01-01');

        $result = $duration->addTo($date);

        $this->assertSame('2024-01-06', $result->format('Y-m-d'));
    }

    /**
     * Tests addTo with months handling leap year.
     */
    public function testAddToMonthsLeapYear(): void
    {
        $duration = new Iso8601Duration('P1M');
        $date = new DateTime('2024-01-31');

        $result = $duration->addTo($date);

        $this->assertSame('2024-03-02', $result->format('Y-m-d'));
    }

    /**
     * Tests addTo with time components.
     */
    public function testAddToTime(): void
    {
        $duration = new Iso8601Duration('PT2H30M');
        $date = new DateTime('2024-01-01 10:00:00');

        $result = $duration->addTo($date);

        $this->assertSame('2024-01-01 12:30:00', $result->format('Y-m-d H:i:s'));
    }

    /**
     * Tests that addTo does not modify the original date.
     */
    public function testAddToDoesNotModifyOriginal(): void
    {
        $duration = new Iso8601Duration('P5D');
        $original = new DateTime('2024-01-01');
        $originalString = $original->format('Y-m-d');

        $duration->addTo($original);

        $this->assertSame($originalString, $original->format('Y-m-d'));
    }

    /**
     * Tests addTo with zero duration.
     */
    public function testAddToZero(): void
    {
        $duration = new Iso8601Duration('P0D');
        $date = new DateTime('2024-01-01 12:00:00');

        $result = $duration->addTo($date);

        $this->assertSame('2024-01-01 12:00:00', $result->format('Y-m-d H:i:s'));
    }

    /**
     * Tests addTo with years.
     */
    public function testAddToYears(): void
    {
        $duration = new Iso8601Duration('P2Y');
        $date = new DateTime('2024-01-01');

        $result = $duration->addTo($date);

        $this->assertSame('2026-01-01', $result->format('Y-m-d'));
    }

    // ========================================================================
    // Method: subtractFrom() Tests
    // ========================================================================

    /**
     * Tests subtractFrom with days.
     * @throws DateInvalidOperationException
     */
    public function testSubtractFromDays(): void
    {
        $duration = new Iso8601Duration('P5D');
        $date = new DateTime('2024-01-10');

        $result = $duration->subtractFrom($date);

        $this->assertSame('2024-01-05', $result->format('Y-m-d'));
    }

    /**
     * Tests subtractFrom with months handling leap year.
     * @throws DateInvalidOperationException
     */
    public function testSubtractFromMonthsLeapYear(): void
    {
        $duration = new Iso8601Duration('P1M');
        $date = new DateTime('2024-03-31');

        $result = $duration->subtractFrom($date);

        $this->assertSame('2024-03-02', $result->format('Y-m-d'));
    }

    /**
     * Tests subtractFrom with time components.
     */
    public function testSubtractFromTime(): void
    {
        $duration = new Iso8601Duration('PT1H30M');
        $date = new DateTime('2024-01-01 12:00:00');

        $result = $duration->subtractFrom($date);

        $this->assertSame('2024-01-01 10:30:00', $result->format('Y-m-d H:i:s'));
    }

    /**
     * Tests that subtractFrom does not modify the original date.
     */
    public function testSubtractFromDoesNotModifyOriginal(): void
    {
        $duration = new Iso8601Duration('P5D');
        $original = new DateTime('2024-01-10');
        $originalString = $original->format('Y-m-d');

        $duration->subtractFrom($original);

        $this->assertSame($originalString, $original->format('Y-m-d'));
    }

    /**
     * Tests subtractFrom with zero duration.
     */
    public function testSubtractFromZero(): void
    {
        $duration = new Iso8601Duration('P0D');
        $date = new DateTime('2024-01-01 12:00:00');

        $result = $duration->subtractFrom($date);

        $this->assertSame('2024-01-01 12:00:00', $result->format('Y-m-d H:i:s'));
    }

    /**
     * Tests subtractFrom with years.
     */
    public function testSubtractFromYears(): void
    {
        $duration = new Iso8601Duration('P2Y');
        $date = new DateTime('2024-01-01');

        $result = $duration->subtractFrom($date);

        $this->assertSame('2022-01-01', $result->format('Y-m-d'));
    }

    // ========================================================================
    // Method: __toString() Tests
    // ========================================================================

    /**
     * Tests __toString magic method.
     */
    public function testToString(): void
    {
        $duration = new Iso8601Duration('P1Y2M3D');

        $this->assertSame('P1Y2M3D', (string) $duration);
    }

    /**
     * Tests __toString in string concatenation.
     */
    public function testToStringInConcatenation(): void
    {
        $duration = new Iso8601Duration('PT30M');
        $result = "Duration: " . $duration;

        $this->assertSame("Duration: PT30M", $result);
    }

    /**
     * Tests __toString with echo/print.
     */
    public function testToStringWithEcho(): void
    {
        $duration = new Iso8601Duration('P5D');

        ob_start();
        echo $duration;
        $output = ob_get_clean();

        $this->assertSame('P5D', $output);
    }

    // ========================================================================
    // Integration Tests
    // ========================================================================

    /**
     * Tests complete workflow: construct, modify, use.
     */
    public function testCompleteWorkflow(): void
    {
        // Create
        $duration = new Iso8601Duration('P1D');
        $this->assertSame('P1D', $duration->iso);

        // Modify via iso
        $duration->iso = 'P5D';
        $this->assertSame(5, $duration->interval->d);

        // Modify via interval
        $duration->interval = new DateInterval('PT2H');
        $this->assertSame('PT2H', $duration->iso);

        // Use in calculation
        $date = new DateTime('2024-01-01 10:00:00');
        $result = $duration->addTo($date);
        $this->assertSame('2024-01-01 12:00:00', $result->format('Y-m-d H:i:s'));
    }

    /**
     * Tests synchronization between iso and interval properties.
     */
    public function testPropertySynchronization(): void
    {
        $duration = new Iso8601Duration('P1Y');

        // Change via iso
        $duration->iso = 'P2Y3M';
        $this->assertSame(2, $duration->interval->y);
        $this->assertSame(3, $duration->interval->m);

        // Change via interval
        $duration->interval = new DateInterval('P5D');
        $this->assertSame('P5D', $duration->iso);
    }

    /**
     * Tests week duration conversion (P1W becomes P7D).
     */
    public function testWeekConversion(): void
    {
        $duration = new Iso8601Duration('P1W');

        // PHP preserves the original P1W format
        $this->assertSame('P1W' , $duration->iso );
        $this->assertSame(7     , $duration->interval->d );

        // But when we regenerate from interval, it becomes P7D
        $duration->interval = new DateInterval('P1W');
        $this->assertSame('P7D', $duration->iso); // Now converted
    }

    /**
     * Tests complex real-world scenario.
     */
    public function testRealWorldScenario(): void
    {
        // Calculate project duration from start to end
        $projectStart = new DateTime('2024-01-01');
        $projectEnd = new DateTime('2024-06-30');
        $interval = $projectStart->diff($projectEnd);

        $duration = new Iso8601Duration($interval);

        // Verify we can add this duration to another date
        $nextProjectStart = new DateTime('2024-07-01');
        $nextProjectEnd = $duration->addTo($nextProjectStart);

        // 2024-01-01 to 2024-06-30 = 181 days (leap year)
        // 2024-07-01 + 181 days = 2024-12-30
        $this->assertSame('2024-12-30', $nextProjectEnd->format('Y-m-d'));
    }

    /**
     * Tests immutability of operations.
     */
    public function testImmutabilityOfOperations(): void
    {
        $duration = new Iso8601Duration('P5D');
        $date1 = new DateTime('2024-01-01');
        $date2 = new DateTime('2024-01-01');

        $result1 = $duration->addTo($date1);
        $result2 = $duration->addTo($date2);

        $this->assertSame($date1->format('Y-m-d'), $date2->format('Y-m-d'));
        $this->assertSame($result1->format('Y-m-d'), $result2->format('Y-m-d'));
    }
}