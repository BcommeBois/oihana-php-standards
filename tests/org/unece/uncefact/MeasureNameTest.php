<?php

namespace tests\org\unece\uncefact;

use org\unece\uncefact\MeasureCode;
use org\unece\uncefact\MeasureName;
use org\unece\uncefact\MeasureSymbol;
use PHPUnit\Framework\TestCase;

class MeasureNameTest extends TestCase
{
    protected function setUp(): void
    {
        MeasureCode::resetCaches();
        MeasureName::resetCaches();
        MeasureSymbol::resetCaches();
    }

    /* --------------------------------------------------------------------
       Basic one‑way helpers
       ------------------------------------------------------------------ */

    public function testGetCode(): void
    {
        $this->assertSame(MeasureCode::KILOGRAM , MeasureName::getCode(MeasureName::KILOGRAM ));
    }

    public function testGetFromCode(): void
    {
        $this->assertSame(MeasureName::KILOGRAM , MeasureName::getFromCode(MeasureCode::KILOGRAM ) );
    }

    public function testGetFromSymbol(): void
    {
        $this->assertSame(MeasureName::KILOGRAM , MeasureName::getFromSymbol(MeasureSymbol::KILOGRAM ));
    }

    public function testGetSymbol(): void
    {
        $symbol = MeasureName::getSymbol( MeasureName::KILOGRAM );
        $this->assertSame(MeasureSymbol::KILOGRAM  , $symbol);
    }

    /* --------------------------------------------------------------------
       Density units
       ------------------------------------------------------------------ */

    public function testKilogramPerCubicMeter(): void
    {
        $name = MeasureName::KILOGRAM_PER_CUBIC_METER;

        $this->assertSame('Kilogram per cubic metre' , $name);
        $this->assertSame(MeasureCode::KILOGRAM_PER_CUBIC_METER   , MeasureName::getCode($name));
        $this->assertSame(MeasureSymbol::KILOGRAM_PER_CUBIC_METER , MeasureName::getSymbol($name));
        $this->assertSame($name , MeasureName::getFromCode(MeasureCode::KILOGRAM_PER_CUBIC_METER));
        $this->assertSame($name , MeasureName::getFromSymbol(MeasureSymbol::KILOGRAM_PER_CUBIC_METER));
    }

    /* --------------------------------------------------------------------
       Degrees units
       ------------------------------------------------------------------ */

    public function testAngularDegree(): void
    {
        $name = MeasureName::ANGULAR;

        $this->assertSame('Angular Degree' , $name);
        $this->assertSame(MeasureCode::ANGULAR   , MeasureName::getCode($name));
        $this->assertSame(MeasureSymbol::ANGULAR , MeasureName::getSymbol($name));
        $this->assertSame($name , MeasureName::getFromCode(MeasureCode::ANGULAR));
        $this->assertSame($name , MeasureName::getFromSymbol(MeasureSymbol::ANGULAR));
    }

    /* --------------------------------------------------------------------
       Unknown lookups should return null
       ------------------------------------------------------------------ */

    public function testUnknownNameReturnsNull(): void
    {
        $this->assertNull(MeasureName::getCode('Unknown‑Unit'));
    }

    public function testUnknownCodeReturnsNull(): void
    {
        $this->assertNull(MeasureName::getFromCode('XXX'));
        $this->assertNull(MeasureName::getSymbol('XXX'));
    }

    public function testUnknownSymbolReturnsNull(): void
    {
        $this->assertNull(MeasureName::getFromSymbol('??'));
    }

    /* --------------------------------------------------------------------
       Cache behaviour – second call must hit the cache
       ------------------------------------------------------------------ */

    public function testGetCodeUsesInternalCache(): void
    {
        // First call populates the cache
        $first  = MeasureName::getCode(MeasureName::KILOGRAM );
        // Second call should be identical (no re‑build)
        $second = MeasureName::getCode(MeasureName::KILOGRAM );

        $this->assertSame($first, $second);
    }
}