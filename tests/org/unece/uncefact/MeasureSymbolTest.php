<?php

namespace tests\org\unece\uncefact;

use org\unece\uncefact\MeasureCode;
use org\unece\uncefact\MeasureName;
use org\unece\uncefact\MeasureSymbol;
use PHPUnit\Framework\TestCase;

class MeasureSymbolTest extends TestCase
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
        $this->assertSame(MeasureCode::KILOGRAM , MeasureSymbol::getCode(MeasureSymbol::KILOGRAM ));
    }

    public function testGetFromCode(): void
    {
        $this->assertSame(MeasureSymbol::KILOGRAM , MeasureSymbol::getFromCode(MeasureCode::KILOGRAM ) );
    }

    public function testGetFromName(): void
    {
        $this->assertSame(MeasureSymbol::KILOGRAM , MeasureSymbol::getFromName(MeasureName::KILOGRAM ));
    }

    public function testGetName(): void
    {
        $name = MeasureSymbol::getName( MeasureSymbol::KILOGRAM );
        $this->assertSame(MeasureName::KILOGRAM  , $name);
    }

    /* --------------------------------------------------------------------
       Density units
       ------------------------------------------------------------------ */

    public function testKilogramPerCubicMeter(): void
    {
        $symbol = MeasureSymbol::KILOGRAM_PER_CUBIC_METER;

        $this->assertSame('kg/m³' , $symbol);
        $this->assertSame(MeasureCode::KILOGRAM_PER_CUBIC_METER , MeasureSymbol::getCode($symbol));
        $this->assertSame(MeasureName::KILOGRAM_PER_CUBIC_METER , MeasureSymbol::getName($symbol));
        $this->assertSame($symbol , MeasureSymbol::getFromCode(MeasureCode::KILOGRAM_PER_CUBIC_METER));
        $this->assertSame($symbol , MeasureSymbol::getFromName(MeasureName::KILOGRAM_PER_CUBIC_METER));
    }

    /* --------------------------------------------------------------------
       Degrees units
       ------------------------------------------------------------------ */

    public function testAngularDegree(): void
    {
        $symbol = MeasureSymbol::ANGULAR;

        $this->assertSame('°' , $symbol);
        $this->assertSame(MeasureCode::ANGULAR , MeasureSymbol::getCode($symbol));
        $this->assertSame(MeasureName::ANGULAR , MeasureSymbol::getName($symbol));
        $this->assertSame($symbol , MeasureSymbol::getFromCode(MeasureCode::ANGULAR));
        $this->assertSame($symbol , MeasureSymbol::getFromName(MeasureName::ANGULAR));
    }

    /* --------------------------------------------------------------------
       Unknown lookups should return null
       ------------------------------------------------------------------ */

    public function testUnknownReturnsNull(): void
    {
        $this->assertNull(MeasureSymbol::getCode('Unknown‑Unit'));
        $this->assertNull(MeasureSymbol::getFromCode('XXX'));
        $this->assertNull(MeasureSymbol::getName('XXX'));
        $this->assertNull(MeasureSymbol::getFromName('??'));
    }

    /* --------------------------------------------------------------------
       Cache behaviour – second call must hit the cache
       ------------------------------------------------------------------ */

    public function testGetCodeUsesInternalCache(): void
    {
        $first  = MeasureSymbol::getCode(MeasureName::KILOGRAM );
        $second = MeasureSymbol::getCode(MeasureName::KILOGRAM );
        $this->assertSame($first, $second);
    }
}