<?php

namespace tests\org\iso;

use oihana\reflect\exceptions\ConstantException;
use org\iso\ISO639_2;
use org\iso\ISO639_2B;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the ISO639_2 class (canonical alpha-3 form).
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
final class ISO639_2Test extends TestCase
{
    protected function setUp(): void
    {
        ISO639_2::resetCaches();
    }

    public function testIncludesCanonicalCodes(): void
    {
        // Terminologic-preferred codes
        $this->assertTrue(ISO639_2::includes(ISO639_2::FRA));   // French
        $this->assertTrue(ISO639_2::includes(ISO639_2::DEU));   // German
        $this->assertTrue(ISO639_2::includes(ISO639_2::ZHO));   // Chinese
        $this->assertTrue(ISO639_2::includes('eng'));            // English (no B variant)
        $this->assertTrue(ISO639_2::includes('spa'));            // Spanish
    }

    public function testExcludesBibliographicCodes(): void
    {
        // These are bibliographic-only codes — must NOT appear here
        $this->assertFalse(ISO639_2::includes('fre'));   // French B
        $this->assertFalse(ISO639_2::includes('ger'));   // German B
        $this->assertFalse(ISO639_2::includes('chi'));   // Chinese B
        $this->assertFalse(ISO639_2::includes('dut'));   // Dutch B
        $this->assertFalse(ISO639_2::includes('gre'));   // Greek B
        $this->assertFalse(ISO639_2::includes('ice'));   // Icelandic B
    }

    public function testSpecialPurposeCodes(): void
    {
        $this->assertTrue(ISO639_2::includes('mis'));  // Uncoded languages
        $this->assertTrue(ISO639_2::includes('mul'));  // Multiple languages
        $this->assertTrue(ISO639_2::includes('und'));  // Undetermined
        $this->assertTrue(ISO639_2::includes('zxx'));  // No linguistic content
        $this->assertSame('und', ISO639_2::UND);
    }

    public function testQaaQtzRangeIsNotEnumerated(): void
    {
        // The qaa-qtz range is reserved for local use and intentionally omitted
        $this->assertFalse(ISO639_2::includes('qaa'));
        $this->assertFalse(ISO639_2::includes('qtz'));
        $this->assertFalse(ISO639_2::includes('qaa-qtz'));
    }

    public function testInvalidCodes(): void
    {
        $this->assertFalse(ISO639_2::includes(''));
        $this->assertFalse(ISO639_2::includes('zzz'));
        $this->assertFalse(ISO639_2::includes('fr'));    // 2 letters → use ISO639_1
        $this->assertFalse(ISO639_2::includes('FRA'));   // uppercase
    }

    public function testAllConstantsAreThreeLowercaseLetters(): void
    {
        foreach (ISO639_2::getAll() as $name => $value)
        {
            $this->assertMatchesRegularExpression('/^[A-Z]{3}$/', $name, "Constant name $name should be 3 uppercase letters");
            $this->assertMatchesRegularExpression('/^[a-z]{3}$/', $value, "Constant value $value should be 3 lowercase letters");
        }
    }

    public function testGetAllHasExpectedCardinality(): void
    {
        $count = count(ISO639_2::getAll());
        // ~486 entries (487 in LoC minus the qaa-qtz range marker)
        $this->assertGreaterThan(480, $count, "ISO639_2 should have at least 480 constants, got $count");
        $this->assertLessThan(495, $count, "ISO639_2 should have less than 495 constants, got $count");
    }

    public function testEnumsConsistencyWithGetAll(): void
    {
        $all    = ISO639_2::getAll();
        $values = ISO639_2::enums();

        $this->assertIsArray($values);
        $this->assertSameSize(array_unique(array_values($all)), $values);
        $this->assertContains('fra', $values);
        $this->assertContains('und', $values);
    }

    public function testGetReturnsDefaultOnInvalid(): void
    {
        $this->assertSame('fra', ISO639_2::get('fra', 'und'));
        $this->assertSame('und', ISO639_2::get('zzz', 'und'));
    }

    /**
     * @throws ConstantException
     */
    public function testValidate(): void
    {
        ISO639_2::validate('fra');
        ISO639_2::validate(ISO639_2::DEU);

        $this->expectException(ConstantException::class);
        ISO639_2::validate('zzz');
    }

    public function testGetConstantFromValue(): void
    {
        $this->assertSame('FRA', ISO639_2::getConstant('fra'));
        $this->assertSame('DEU', ISO639_2::getConstant('deu'));
        $this->assertSame('UND', ISO639_2::getConstant('und'));
        $this->assertNull(ISO639_2::getConstant('zzz'));
    }

    public function testBiblioTerminologicSeparation(): void
    {
        // Each B/T pair: T is in ISO639_2, B is NOT.
        foreach (ISO639_2B::getBibliographicToTerminologicMap() as $bib => $term)
        {
            $this->assertTrue(ISO639_2::includes($term), "Terminologic $term should be in ISO639_2");
            $this->assertFalse(ISO639_2::includes($bib), "Bibliographic $bib should NOT be in ISO639_2");
        }
    }
}
