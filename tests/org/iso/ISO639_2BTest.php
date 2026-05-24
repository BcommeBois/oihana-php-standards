<?php

namespace tests\org\iso;

use oihana\reflect\exceptions\ConstantException;
use org\iso\ISO639_2B;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the ISO639_2B class (bibliographic alpha-3 codes).
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
final class ISO639_2BTest extends TestCase
{
    protected function setUp(): void
    {
        ISO639_2B::resetCaches();
    }

    public function testIncludesBibliographicCodes(): void
    {
        $this->assertTrue(ISO639_2B::includes('fre'));   // French B
        $this->assertTrue(ISO639_2B::includes('ger'));   // German B
        $this->assertTrue(ISO639_2B::includes('chi'));   // Chinese B
        $this->assertTrue(ISO639_2B::includes('dut'));   // Dutch B
        $this->assertSame('fre', ISO639_2B::FRE);
        $this->assertSame('ger', ISO639_2B::GER);
    }

    public function testExcludesTerminologicCodes(): void
    {
        // T codes are in ISO639_2, not here
        $this->assertFalse(ISO639_2B::includes('fra'));   // French T
        $this->assertFalse(ISO639_2B::includes('deu'));   // German T
        $this->assertFalse(ISO639_2B::includes('zho'));   // Chinese T
        $this->assertFalse(ISO639_2B::includes('eng'));   // English (no B variant at all)
    }

    public function testToTerminologic(): void
    {
        $this->assertSame('fra', ISO639_2B::toTerminologic('fre'));
        $this->assertSame('deu', ISO639_2B::toTerminologic('ger'));
        $this->assertSame('zho', ISO639_2B::toTerminologic('chi'));
        $this->assertSame('nld', ISO639_2B::toTerminologic('dut'));
        $this->assertSame('mkd', ISO639_2B::toTerminologic('mac'));
    }

    public function testToTerminologicReturnsNullForUnknown(): void
    {
        $this->assertNull(ISO639_2B::toTerminologic('fra'));   // already terminologic
        $this->assertNull(ISO639_2B::toTerminologic('eng'));   // no B variant
        $this->assertNull(ISO639_2B::toTerminologic('zzz'));   // unknown
        $this->assertNull(ISO639_2B::toTerminologic(''));
    }

    public function testBibliographicToTerminologicMapIsComplete(): void
    {
        $map = ISO639_2B::getBibliographicToTerminologicMap();
        $this->assertCount(20, $map);

        // Spot-check well-known pairs
        $this->assertSame('sqi', $map['alb']);
        $this->assertSame('hye', $map['arm']);
        $this->assertSame('eus', $map['baq']);
        $this->assertSame('mya', $map['bur']);
        $this->assertSame('zho', $map['chi']);
        $this->assertSame('ces', $map['cze']);
        $this->assertSame('nld', $map['dut']);
        $this->assertSame('fra', $map['fre']);
        $this->assertSame('kat', $map['geo']);
        $this->assertSame('deu', $map['ger']);
        $this->assertSame('ell', $map['gre']);
        $this->assertSame('isl', $map['ice']);
        $this->assertSame('mkd', $map['mac']);
        $this->assertSame('mri', $map['mao']);
        $this->assertSame('msa', $map['may']);
        $this->assertSame('fas', $map['per']);
        $this->assertSame('ron', $map['rum']);
        $this->assertSame('slk', $map['slo']);
        $this->assertSame('bod', $map['tib']);
        $this->assertSame('cym', $map['wel']);
    }

    public function testMapKeysMatchConstants(): void
    {
        // Every B code as a constant must also appear in the conversion map
        foreach (ISO639_2B::getAll() as $name => $value)
        {
            $this->assertArrayHasKey($value, ISO639_2B::getBibliographicToTerminologicMap(),
                "Constant $name ($value) should appear in BIBLIOGRAPHIC_TO_TERMINOLOGIC");
        }
    }

    public function testAllConstantsAreThreeLowercaseLetters(): void
    {
        foreach (ISO639_2B::getAll() as $name => $value)
        {
            $this->assertMatchesRegularExpression('/^[A-Z]{3}$/', $name);
            $this->assertMatchesRegularExpression('/^[a-z]{3}$/', $value);
        }
    }

    public function testCardinality(): void
    {
        // Exactly 20 bibliographic codes per the LoC ISO 639-2 spec
        $this->assertCount(20, ISO639_2B::getAll());
    }

    public function testEnumsConsistencyWithGetAll(): void
    {
        $all    = ISO639_2B::getAll();
        $values = ISO639_2B::enums();
        $this->assertSameSize(array_unique(array_values($all)), $values);
        $this->assertContains('fre', $values);
        $this->assertContains('ger', $values);
    }

    /**
     * @throws ConstantException
     */
    public function testValidate(): void
    {
        ISO639_2B::validate('fre');
        ISO639_2B::validate(ISO639_2B::GER);

        $this->expectException(ConstantException::class);
        ISO639_2B::validate('fra'); // terminologic — not here
    }

    public function testGetConstantFromValue(): void
    {
        $this->assertSame('FRE', ISO639_2B::getConstant('fre'));
        $this->assertSame('GER', ISO639_2B::getConstant('ger'));
        $this->assertNull(ISO639_2B::getConstant('zzz'));
    }
}
