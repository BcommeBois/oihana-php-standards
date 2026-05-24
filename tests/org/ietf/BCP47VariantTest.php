<?php

namespace tests\org\ietf;

use oihana\reflect\exceptions\ConstantException;
use org\ietf\BCP47Variant;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the BCP47Variant class.
 *
 * @package tests\org\ietf
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
final class BCP47VariantTest extends TestCase
{
    protected function setUp(): void
    {
        BCP47Variant::resetCaches();
    }

    public function testIncludesAlphabeticVariants(): void
    {
        $this->assertTrue(BCP47Variant::includes(BCP47Variant::VALENCIA));
        $this->assertTrue(BCP47Variant::includes(BCP47Variant::FONIPA));
        $this->assertTrue(BCP47Variant::includes(BCP47Variant::TARASK));
        $this->assertTrue(BCP47Variant::includes('pinyin'));
        $this->assertTrue(BCP47Variant::includes('wadegile'));
    }

    public function testIncludesNumericVariants(): void
    {
        $this->assertSame('1996', BCP47Variant::V_1996);
        $this->assertSame('1901', BCP47Variant::V_1901);
        $this->assertSame('1606nict', BCP47Variant::V_1606NICT);
        $this->assertSame('1694acad', BCP47Variant::V_1694ACAD);

        $this->assertTrue(BCP47Variant::includes('1996'));
        $this->assertTrue(BCP47Variant::includes('1606nict'));
    }

    public function testIncludesDeprecatedVariants(): void
    {
        // Deprecated variants are still listed (they're valid syntax for legacy content)
        $this->assertTrue(BCP47Variant::includes('arevela'));   // Eastern Armenian (deprecated 2018)
        $this->assertTrue(BCP47Variant::includes('arevmda'));   // Western Armenian (deprecated 2018)
        $this->assertTrue(BCP47Variant::includes('heploc'));    // Hepburn LoC (deprecated 2010)
    }

    public function testInvalidVariants(): void
    {
        $this->assertFalse(BCP47Variant::includes(''));
        $this->assertFalse(BCP47Variant::includes('xyz'));
        $this->assertFalse(BCP47Variant::includes('VALENCIA'));   // uppercase
        $this->assertFalse(BCP47Variant::includes('1234'));        // not registered
    }

    public function testAllConstantsHaveValidGrammar(): void
    {
        // BCP 47 variant grammar: 5-8 alphanum, OR 4 chars (digit + 3 alphanum)
        $pattern = '/^([a-z0-9]{5,8}|[0-9][a-z0-9]{3})$/';
        foreach (BCP47Variant::getAll() as $name => $value)
        {
            $this->assertMatchesRegularExpression($pattern, $value,
                "Variant value $value (constant $name) should match RFC 5646 variant grammar");
        }
    }

    public function testNumericVariantsArePrefixed(): void
    {
        // Every numeric subtag value must be exposed via a V_-prefixed constant
        foreach (BCP47Variant::getAll() as $name => $value)
        {
            if (preg_match('/^[0-9]/', $value))
            {
                $this->assertStringStartsWith('V_', $name,
                    "Numeric variant $value should have V_-prefixed constant, got $name");
            }
        }
    }

    public function testCardinality(): void
    {
        // ~139 variants in the IANA registry as of 2026-05
        $count = count(BCP47Variant::getAll());
        $this->assertGreaterThan(130, $count, "BCP47Variant should have at least 130 constants, got $count");
        $this->assertLessThan(180, $count, "BCP47Variant should have less than 180 constants, got $count");
    }

    public function testEnumsConsistencyWithGetAll(): void
    {
        $all    = BCP47Variant::getAll();
        $values = BCP47Variant::enums();

        $this->assertIsArray($values);
        $this->assertSameSize(array_unique(array_values($all)), $values);
        $this->assertContains('1996', $values);
        $this->assertContains('valencia', $values);
    }

    public function testGetReturnsDefaultOnInvalid(): void
    {
        $this->assertSame('1996', BCP47Variant::get('1996', 'fonipa'));
        $this->assertSame('fonipa', BCP47Variant::get('xyz', 'fonipa'));
    }

    /**
     * @throws ConstantException
     */
    public function testValidate(): void
    {
        BCP47Variant::validate('1996');
        BCP47Variant::validate(BCP47Variant::VALENCIA);

        $this->expectException(ConstantException::class);
        BCP47Variant::validate('xyz');
    }

    public function testGetConstantFromValue(): void
    {
        $this->assertSame('V_1996', BCP47Variant::getConstant('1996'));
        $this->assertSame('VALENCIA', BCP47Variant::getConstant('valencia'));
        $this->assertSame('FONIPA', BCP47Variant::getConstant('fonipa'));
        $this->assertNull(BCP47Variant::getConstant('xyz'));
    }
}
