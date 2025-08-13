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