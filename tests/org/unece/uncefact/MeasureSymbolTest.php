<?php

namespace org\unece\uncefact;

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