<?php

namespace tests\org\common;

use DateTimeImmutable;
use DateTimeZone;
use org\common\DateFormat;
use org\iso\Iso8601Format;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the DateFormat class.
 *
 * @package tests\org\common
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class DateFormatTest extends TestCase
{
    private DateTimeImmutable $sample;
    private DateTimeImmutable $utc;

    protected function setUp(): void
    {
        $this->sample = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));
        $this->utc    = new DateTimeImmutable('2026-05-14 06:15:30', new DateTimeZone('UTC'));
    }

    public function testRfc1123Format(): void
    {
        $this->assertSame('Thu, 14 May 2026 08:15:30 +0200', $this->sample->format(DateFormat::RFC1123));
    }

    public function testRfc2822Format(): void
    {
        $this->assertSame('Thu, 14 May 2026 08:15:30 +0200', $this->sample->format(DateFormat::RFC2822));
    }

    public function testRfc822FormatHasTwoDigitYear(): void
    {
        $this->assertSame('Thu, 14 May 26 08:15:30 +0200', $this->sample->format(DateFormat::RFC822));
    }

    public function testRfc850Format(): void
    {
        $this->assertSame('Thursday, 14-May-26 06:15:30 UTC', $this->utc->format(DateFormat::RFC850));
    }

    public function testRfc1036Format(): void
    {
        $this->assertSame('Thu, 14 May 26 08:15:30 +0200', $this->sample->format(DateFormat::RFC1036));
    }

    public function testRfc7231AlwaysGmt(): void
    {
        $this->assertSame('Thu, 14 May 2026 06:15:30 GMT', $this->utc->format(DateFormat::RFC7231));
    }

    public function testRssFormat(): void
    {
        $this->assertSame('Thu, 14 May 2026 08:15:30 +0200', $this->sample->format(DateFormat::RSS));
    }

    public function testCookieFormat(): void
    {
        $this->assertSame('Thursday, 14-May-2026 06:15:30 UTC', $this->utc->format(DateFormat::COOKIE));
    }

    public function testMysqlFormat(): void
    {
        $this->assertSame('2026-05-14 08:15:30', $this->sample->format(DateFormat::MYSQL));
    }

    public function testUnixTimestamp(): void
    {
        $this->assertSame((string) $this->utc->getTimestamp(), $this->utc->format(DateFormat::UNIX));
    }

    public function testInheritsIsoConstants(): void
    {
        $this->assertSame(Iso8601Format::DATE, DateFormat::DATE);
        $this->assertSame(Iso8601Format::DATE_TIME_ZULU, DateFormat::DATE_TIME_ZULU);
        $this->assertSame('2026-05-14T06:15:30Z', $this->utc->format(DateFormat::DATE_TIME_ZULU));
    }

    public function testIncludesAcceptsInheritedAndOwnConstants(): void
    {
        $this->assertTrue(DateFormat::includes(Iso8601Format::DATE));
        $this->assertTrue(DateFormat::includes(DateFormat::RFC2822));
        $this->assertTrue(DateFormat::includes('U'));
        $this->assertFalse(DateFormat::includes('not-a-format'));
    }

    public function testGetConstantReverseLookup(): void
    {
        $this->assertSame('MYSQL',   DateFormat::getConstant('Y-m-d H:i:s'));
        $this->assertSame('RFC7231', DateFormat::getConstant('D, d M Y H:i:s \G\M\T'));
        $this->assertSame('UNIX',    DateFormat::getConstant('U'));
    }

    public function testEnumsIncludeBothIsoAndNonIso(): void
    {
        $values = DateFormat::enums();
        $this->assertContains(Iso8601Format::DATE, $values);
        $this->assertContains(DateFormat::MYSQL, $values);
        $this->assertContains(DateFormat::RFC7231, $values);
    }
}
