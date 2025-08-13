<?php

namespace tests\org\unece\uncefact;

use org\unece\uncefact\MeasureCode;
use PHPUnit\Framework\TestCase;

class MeasureCodeTest extends TestCase
{
    protected function setUp(): void
    {
        MeasureCode::resetCaches(); // S'assurer que les caches sont réinitialisés avant chaque test
    }

    public function testGetName(): void
    {
        $code = MeasureCode::KILOGRAM;
        $name = MeasureCode::getName($code);
        $this->assertEquals('Kilogram', $name);
    }

    public function testGetSymbol(): void
    {
        $code = MeasureCode::KILOGRAM;
        $symbol = MeasureCode::getSymbol($code);
        $this->assertEquals('kg', $symbol); // Supposé, à adapter selon MeasureSymbol
    }

    public function testGetFromName(): void
    {
        $expected = MeasureCode::KILOGRAM;
        $code = MeasureCode::getFromName('Kilogram');
        $this->assertEquals($expected, $code);
    }

    public function testGetFromSymbol(): void
    {
        $expected = MeasureCode::KILOGRAM;
        $code = MeasureCode::getFromSymbol('kg');
        $this->assertEquals($expected, $code);
    }

    public function testGetNameWithUnknownCode(): void
    {
        $this->assertNull(MeasureCode::getName('XXX'));
    }

    public function testGetSymbolWithUnknownCode(): void
    {
        $this->assertNull(MeasureCode::getSymbol('XXX'));
    }

    public function testGetFromNameWithUnknownName(): void
    {
        $this->assertNull(MeasureCode::getFromName('UnknownUnit'));
    }

    public function testGetFromSymbolWithUnknownSymbol(): void
    {
        $this->assertNull(MeasureCode::getFromSymbol('??'));
    }
}