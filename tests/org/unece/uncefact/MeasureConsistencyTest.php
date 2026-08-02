<?php

namespace tests\org\unece\uncefact;

use org\unece\uncefact\MeasureCode;
use org\unece\uncefact\MeasureName;
use org\unece\uncefact\MeasureSymbol;
use PHPUnit\Framework\TestCase;

/**
 * Structural guarantees shared by the three mirror classes.
 *
 * The cross lookups (getName/getSymbol/getFromName/getFromSymbol) resolve a value
 * to its *constant name* and then read the same key in the sibling class. They
 * therefore only work if the three classes expose exactly the same constant names
 * and if no value is duplicated inside a class.
 */
class MeasureConsistencyTest extends TestCase
{
    protected function setUp(): void
    {
        MeasureCode::resetCaches();
        MeasureName::resetCaches();
        MeasureSymbol::resetCaches();
    }

    /* --------------------------------------------------------------------
       The three classes must expose the same constant names
       ------------------------------------------------------------------ */

    public function testNameClassDeclaresTheSameConstantsAsTheCodeClass(): void
    {
        $codes = MeasureCode::getConstantKeys();
        $names = MeasureName::getConstantKeys();

        $this->assertSame([] , array_values(array_diff($codes , $names)) , 'Constants missing from MeasureName');
        $this->assertSame([] , array_values(array_diff($names , $codes)) , 'Constants missing from MeasureCode');
    }

    public function testSymbolClassDeclaresTheSameConstantsAsTheCodeClass(): void
    {
        $codes   = MeasureCode::getConstantKeys();
        $symbols = MeasureSymbol::getConstantKeys();

        $this->assertSame([] , array_values(array_diff($codes , $symbols)) , 'Constants missing from MeasureSymbol');
        $this->assertSame([] , array_values(array_diff($symbols , $codes)) , 'Constants missing from MeasureCode');
    }

    /* --------------------------------------------------------------------
       A duplicated value would make getConstant() return an array
       ------------------------------------------------------------------ */

    public function testValuesAreUniqueWithinEachClass(): void
    {
        $classes = [ MeasureCode::class , MeasureName::class , MeasureSymbol::class ];

        foreach ($classes as $class)
        {
            $values     = $class::getConstantValues();
            $duplicates = array_keys(array_filter(array_count_values($values) , fn(int $count) => $count > 1));

            $this->assertSame([] , $duplicates , 'Duplicated values in ' . $class);
        }
    }

    /* --------------------------------------------------------------------
       Every code must round-trip through its name and its symbol
       ------------------------------------------------------------------ */

    public function testEveryCodeResolvesToANameAndASymbol(): void
    {
        $failures = [];

        foreach (MeasureCode::getAll() as $constant => $code)
        {
            $name   = MeasureCode::getName($code);
            $symbol = MeasureCode::getSymbol($code);

            if ($name === null || $symbol === null)
            {
                $failures[] = $constant;
            }
        }

        $this->assertSame([] , $failures , 'Codes without a name or a symbol');
    }

    public function testEveryCodeRoundTripsFromItsNameAndItsSymbol(): void
    {
        $failures = [];

        foreach (MeasureCode::getAll() as $constant => $code)
        {
            $name   = MeasureCode::getName($code);
            $symbol = MeasureCode::getSymbol($code);

            if (MeasureCode::getFromName($name) !== $code || MeasureCode::getFromSymbol($symbol) !== $code)
            {
                $failures[] = $constant;
            }
        }

        $this->assertSame([] , $failures , 'Codes that do not round-trip');
    }
}
