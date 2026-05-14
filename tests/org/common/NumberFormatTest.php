<?php

namespace tests\org\common;

use org\common\NumberFormat;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the NumberFormat constants class.
 *
 * @package tests\org\common
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
final class NumberFormatTest extends TestCase
{
    public function testEuFormatting(): void
    {
        $formatted = number_format(
            1234567.89,
            2,
            NumberFormat::DECIMAL_SEP_EU,
            NumberFormat::THOUSANDS_SEP_EU
        );
        $this->assertSame('1.234.567,89', $formatted);
    }

    public function testUsFormatting(): void
    {
        $formatted = number_format(
            1234567.89,
            2,
            NumberFormat::DECIMAL_SEP_US,
            NumberFormat::THOUSANDS_SEP_US
        );
        $this->assertSame('1,234,567.89', $formatted);
    }

    public function testFrFormattingUsesNarrowNoBreakSpace(): void
    {
        $formatted = number_format(
            1234567.89,
            2,
            NumberFormat::DECIMAL_SEP_FR,
            NumberFormat::THOUSANDS_SEP_FR
        );
        $this->assertSame("1\u{202F}234\u{202F}567,89", $formatted);
    }

    public function testChFormattingUsesApostrophe(): void
    {
        $formatted = number_format(
            1234567.89,
            2,
            NumberFormat::DECIMAL_SEP_CH,
            NumberFormat::THOUSANDS_SEP_CH
        );
        $this->assertSame("1'234'567.89", $formatted);
    }

    public function testNoThousandsSeparator(): void
    {
        $formatted = number_format(
            1234567.89,
            2,
            NumberFormat::DECIMAL_SEP_US,
            NumberFormat::THOUSANDS_SEP_NONE
        );
        $this->assertSame('1234567.89', $formatted);
    }

    public function testSymbolValues(): void
    {
        $this->assertSame('%',   NumberFormat::PERCENT_SYMBOL);
        $this->assertSame('‰',   NumberFormat::PERMILLE_SYMBOL);
        $this->assertSame('∞',   NumberFormat::INFINITY);
        $this->assertSame('-∞',  NumberFormat::NEGATIVE_INFINITY);
        $this->assertSame('NaN', NumberFormat::NAN_SYMBOL);
        $this->assertSame('e',   NumberFormat::SCIENTIFIC_E_LOWER);
        $this->assertSame('E',   NumberFormat::SCIENTIFIC_E_UPPER);
    }

    public function testIncludesAcceptsAnyConstant(): void
    {
        $this->assertTrue(NumberFormat::includes(','));
        $this->assertTrue(NumberFormat::includes('.'));
        $this->assertTrue(NumberFormat::includes('%'));
        $this->assertTrue(NumberFormat::includes("\u{202F}"));
        $this->assertFalse(NumberFormat::includes('||'));
    }

    public function testReverseLookup(): void
    {
        // Multiple constants share ',' and '.' (e.g. DECIMAL_SEP_EU and DECIMAL_SEP_FR),
        // so getConstant() returns an array of names for those values.
        $namesForComma = (array) NumberFormat::getConstant(',');
        $this->assertContains('DECIMAL_SEP_EU', $namesForComma);
        $this->assertContains('DECIMAL_SEP_FR', $namesForComma);

        $this->assertSame('PERCENT_SYMBOL', NumberFormat::getConstant('%'));
        $this->assertSame('NAN_SYMBOL',     NumberFormat::getConstant('NaN'));
    }
}
