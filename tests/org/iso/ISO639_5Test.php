<?php

namespace tests\org\iso;

use oihana\reflect\exceptions\ConstantException;
use org\iso\ISO639_2;
use org\iso\ISO639_5;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the ISO639_5 class (language families and groups).
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
final class ISO639_5Test extends TestCase
{
    protected function setUp(): void
    {
        ISO639_5::resetCaches();
    }

    public function testIncludesMajorFamilies(): void
    {
        // Major language families
        $this->assertTrue(ISO639_5::includes(ISO639_5::ROA));   // Romance
        $this->assertTrue(ISO639_5::includes(ISO639_5::GEM));   // Germanic
        $this->assertTrue(ISO639_5::includes(ISO639_5::SLA));   // Slavic
        $this->assertTrue(ISO639_5::includes(ISO639_5::CEL));   // Celtic
        $this->assertTrue(ISO639_5::includes(ISO639_5::SEM));   // Semitic
        $this->assertTrue(ISO639_5::includes(ISO639_5::BNT));   // Bantu
        $this->assertTrue(ISO639_5::includes(ISO639_5::AUS));   // Australian
        $this->assertTrue(ISO639_5::includes(ISO639_5::MYN));   // Mayan
        $this->assertTrue(ISO639_5::includes(ISO639_5::AFA));   // Afro-Asiatic
    }

    public function testExcludesIndividualLanguages(): void
    {
        // Individual languages live in ISO639_1 / ISO639_2, not here
        $this->assertFalse(ISO639_5::includes('fra'));   // French
        $this->assertFalse(ISO639_5::includes('eng'));   // English
        $this->assertFalse(ISO639_5::includes('deu'));   // German
        $this->assertFalse(ISO639_5::includes('zho'));   // Chinese
    }

    public function testInvalidCodes(): void
    {
        $this->assertFalse(ISO639_5::includes(''));
        $this->assertFalse(ISO639_5::includes('zzz'));
        $this->assertFalse(ISO639_5::includes('ROA'));   // uppercase
        $this->assertFalse(ISO639_5::includes('ro'));    // 2 letters
    }

    public function testAllConstantsAreThreeLowercaseLetters(): void
    {
        foreach (ISO639_5::getAll() as $name => $value)
        {
            $this->assertMatchesRegularExpression('/^[A-Z]{3}$/', $name);
            $this->assertMatchesRegularExpression('/^[a-z]{3}$/', $value);
        }
    }

    public function testCardinality(): void
    {
        // ~115 entries per the LoC ISO 639-5 registry
        $count = count(ISO639_5::getAll());
        $this->assertGreaterThan(110, $count, "ISO639_5 should have at least 110 constants, got $count");
        $this->assertLessThan(125, $count, "ISO639_5 should have less than 125 constants, got $count");
    }

    public function testEnumsConsistencyWithGetAll(): void
    {
        $all    = ISO639_5::getAll();
        $values = ISO639_5::enums();

        $this->assertIsArray($values);
        $this->assertSameSize(array_unique(array_values($all)), $values);
        $this->assertContains('roa', $values);
        $this->assertContains('gem', $values);
    }

    public function testGetReturnsDefaultOnInvalid(): void
    {
        $this->assertSame('roa', ISO639_5::get('roa', 'mis'));
        $this->assertSame('mis', ISO639_5::get('zzz', 'mis'));
    }

    /**
     * @throws ConstantException
     */
    public function testValidate(): void
    {
        ISO639_5::validate('roa');
        ISO639_5::validate(ISO639_5::GEM);

        $this->expectException(ConstantException::class);
        ISO639_5::validate('zzz');
    }

    public function testGetConstantFromValue(): void
    {
        $this->assertSame('ROA', ISO639_5::getConstant('roa'));
        $this->assertSame('GEM', ISO639_5::getConstant('gem'));
        $this->assertNull(ISO639_5::getConstant('zzz'));
    }

    public function testKnownOverlapWithISO639_2(): void
    {
        // ~65 codes are present in both ISO 639-2 and ISO 639-5 (historical
        // family codes assigned in ISO 639-2 before ISO 639-5 was formalized).
        // Spot-check that this overlap is real and documented.
        $overlapping = ['afa', 'alg', 'aus', 'bnt', 'cel', 'gem', 'roa', 'sem', 'sla'];

        foreach ($overlapping as $code)
        {
            $this->assertTrue(ISO639_5::includes($code), "$code should be in ISO639_5");
            $this->assertTrue(ISO639_2::includes($code), "$code should also be in ISO639_2");
        }
    }
}
