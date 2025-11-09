<?php

namespace tests\org\iso;

use DateMalformedStringException;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use org\iso\Iso8601Time;
use DateTimeImmutable;
use InvalidArgumentException;

/**
 * Unit tests for the toIso8601Duration function.
 *
 * @package tests\org\iso\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.1
 */
class Iso8601TimeTest extends TestCase
{
    public function testDefaultConstructor(): void
    {
        $time = new Iso8601Time();
        $this->assertEquals('T00:00:00', $time->iso);
        $this->assertEquals(0, $time->hours);
        $this->assertEquals(0, $time->minutes);
        $this->assertEquals(0, $time->seconds);
    }

    public function testConstructorWithIsoString(): void
    {
        $time = new Iso8601Time('T14:30:15Z');
        $this->assertEquals(14, $time->hours);
        $this->assertEquals(30, $time->minutes);
        $this->assertEquals(15, $time->seconds);
        $this->assertEquals('T14:30:15Z', $time->iso);
    }

    public function testConstructorWithIsoStringAndOffset(): void
    {
        $time = new Iso8601Time('T08:15:30+02:00');
        $this->assertEquals(8, $time->hours);
        $this->assertEquals(15, $time->minutes);
        $this->assertEquals(30, $time->seconds);
        $this->assertStringContainsString('+02:00', $time->iso);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testConstructorWithDateTimeImmutable(): void
    {
        $dt = new DateTimeImmutable('15:45:00', new DateTimeZone('UTC'));
        $time = new Iso8601Time($dt);
        $this->assertEquals(15, $time->hours);
        $this->assertEquals(45, $time->minutes);
        $this->assertEquals(0, $time->seconds);
        $this->assertEquals('T15:45:00Z', $time->iso);
    }

    public function testSetIsoUpdatesTime(): void
    {
        $time = new Iso8601Time();
        $time->iso = 'T23:59:59+01:00';
        $this->assertEquals(23, $time->hours);
        $this->assertEquals(59, $time->minutes);
        $this->assertEquals(59, $time->seconds);
        $this->assertStringContainsString('+01:00', $time->iso);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function testSetTimeUpdatesIso(): void
    {
        $dt = new DateTimeImmutable('12:34:56', new DateTimeZone('UTC'));
        $time = new Iso8601Time();
        $time->time = $dt;
        $this->assertEquals('T12:34:56Z', $time->iso);
    }

    public function testInvalidIsoStringThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Iso8601Time('INVALID');
    }

    public function testIsoStringWithoutT(): void
    {
        $time = new Iso8601Time('23:45:01Z');
        $this->assertEquals('T23:45:01Z', $time->iso);
        $this->assertEquals(23, $time->hours);
        $this->assertEquals(45, $time->minutes);
        $this->assertEquals(1, $time->seconds);
    }
}