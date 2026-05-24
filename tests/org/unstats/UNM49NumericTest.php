<?php

namespace tests\org\unstats;

use oihana\reflect\exceptions\ConstantException;
use org\unstats\UNM49Numeric;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the UNM49Numeric class.
 *
 * @package tests\org\unstats
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
final class UNM49NumericTest extends TestCase
{
    protected function setUp(): void
    {
        UNM49Numeric::resetCaches();
    }

    public function testIncludesValidAndInvalid(): void
    {
        // Country codes
        $this->assertTrue(UNM49Numeric::includes(UNM49Numeric::M_250));   // France
        $this->assertTrue(UNM49Numeric::includes(UNM49Numeric::M_840));   // USA
        $this->assertTrue(UNM49Numeric::includes('004'));                  // Afghanistan

        // Region codes
        $this->assertTrue(UNM49Numeric::includes(UNM49Numeric::M_001));   // World
        $this->assertTrue(UNM49Numeric::includes(UNM49Numeric::M_419));   // Latin America and the Caribbean
        $this->assertTrue(UNM49Numeric::includes('150'));                  // Europe

        // Unknown
        $this->assertFalse(UNM49Numeric::includes('999'));
        $this->assertFalse(UNM49Numeric::includes('001 '));               // trailing space
        $this->assertFalse(UNM49Numeric::includes('1'));                   // unpadded
        $this->assertFalse(UNM49Numeric::includes(''));
    }

    public function testZeroPaddingIsPreserved(): void
    {
        $this->assertSame('001', UNM49Numeric::M_001);
        $this->assertSame('004', UNM49Numeric::M_004);
        $this->assertSame('010', UNM49Numeric::M_010);
        $this->assertSame('250', UNM49Numeric::M_250);
    }

    public function testGetAllHasExpectedEntries(): void
    {
        $all = UNM49Numeric::getAll();

        $this->assertIsArray($all);
        $this->assertArrayHasKey('M_001', $all);
        $this->assertArrayHasKey('M_250', $all);
        $this->assertArrayHasKey('M_840', $all);
        $this->assertArrayHasKey('M_419', $all);
        $this->assertSame('001', $all['M_001']);
        $this->assertSame('250', $all['M_250']);
    }

    public function testAllConstantsAreThreeDigitStrings(): void
    {
        foreach (UNM49Numeric::getAll() as $name => $value)
        {
            $this->assertMatchesRegularExpression('/^M_\d{3}$/', $name, "Constant name $name should match M_NNN");
            $this->assertMatchesRegularExpression('/^\d{3}$/', $value, "Constant value $value should be 3 digits");
        }
    }

    public function testEnumsConsistencyWithGetAll(): void
    {
        $all    = UNM49Numeric::getAll();
        $values = UNM49Numeric::enums();

        $this->assertIsArray($values);
        $this->assertSameSize(array_unique(array_values($all)), $values);
        $this->assertContains('001', $values);
        $this->assertContains('250', $values);
        $this->assertContains('419', $values);
    }

    public function testGetReturnsDefaultOnInvalid(): void
    {
        $this->assertSame('250', UNM49Numeric::get('250', '999'));
        $this->assertSame('999', UNM49Numeric::get('XYZ', '999'));
    }

    /**
     * @throws ConstantException
     */
    public function testValidate(): void
    {
        UNM49Numeric::validate('250');
        UNM49Numeric::validate(UNM49Numeric::M_840);

        $this->expectException(ConstantException::class);
        UNM49Numeric::validate('999');
    }

    public function testGetConstantFromValue(): void
    {
        $this->assertSame('M_001', UNM49Numeric::getConstant('001'));
        $this->assertSame('M_250', UNM49Numeric::getConstant('250'));
        $this->assertSame('M_419', UNM49Numeric::getConstant('419'));
        $this->assertNull(UNM49Numeric::getConstant('999'));
    }

    public function testMajorRegionCodesArePresent(): void
    {
        // M49 regions used in BCP 47 region subtags
        $bcp47Regions = [
            '001', '002', '003', '005', '009', '011', '013', '014', '015',
            '017', '018', '019', '021', '029', '030', '034', '035', '039',
            '053', '054', '057', '061', '142', '143', '145', '150', '151',
            '154', '155', '202', '419',
        ];

        foreach ($bcp47Regions as $code)
        {
            $this->assertTrue(UNM49Numeric::includes($code), "M49 region $code should be present for BCP 47 use");
        }
    }

    public function testApproximateCardinality(): void
    {
        // ~283 entries expected (248 countries + 36 regions − 1 overlap on 010 Antarctica)
        $count = count(UNM49Numeric::getAll());
        $this->assertGreaterThan(280, $count, "UNM49Numeric should have at least 280 constants, got $count");
        $this->assertLessThan(295, $count, "UNM49Numeric should have less than 295 constants, got $count");
    }
}
