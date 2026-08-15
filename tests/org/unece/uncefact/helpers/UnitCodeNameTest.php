<?php

namespace tests\org\unece\uncefact\helpers;

use org\unece\uncefact\MeasureCode;
use org\unece\uncefact\PackageCode;
use PHPUnit\Framework\TestCase;

use function org\unece\uncefact\helpers\unitCodeName;

/**
 * Unit tests for the unitCodeName helper function.
 *
 * @package tests\org\unece\uncefact\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.1.0
 */
final class UnitCodeNameTest extends TestCase
{
    protected function setUp(): void
    {
        MeasureCode::resetCaches();
        PackageCode::resetCaches();
    }

    /* --------------------------------------------------------------------
       Codes that measure
       ------------------------------------------------------------------ */

    public function testResolvesMeasureCodes(): void
    {
        $this->assertSame('Square Meter'             , unitCodeName('MTK')) ;
        $this->assertSame('Metric Ton'               , unitCodeName('TNE')) ;
        $this->assertSame('Kilogram'                 , unitCodeName('KGM')) ;
        $this->assertSame('Kilogram per cubic metre' , unitCodeName('KMQ')) ;
    }

    /* --------------------------------------------------------------------
       Codes that package
       ------------------------------------------------------------------ */

    public function testResolvesPackageCodes(): void
    {
        $this->assertSame('Box'    , unitCodeName('BX')) ;
        $this->assertSame('Parcel' , unitCodeName('PA')) ;
    }

    /* --------------------------------------------------------------------
       Absent or unknown codes
       ------------------------------------------------------------------ */

    public function testNullCodeReturnsNull(): void
    {
        $this->assertNull( unitCodeName( null ) ) ;
    }

    public function testEmptyCodeReturnsNull(): void
    {
        $this->assertNull(unitCodeName('')) ;
    }

    public function testUnknownCodeReturnsNull(): void
    {
        $this->assertNull(unitCodeName('ZZZ')) ;
        $this->assertNull(unitCodeName('Unknown-Unit')) ;
    }

    public function testLookupIsCaseSensitive(): void
    {
        $this->assertNull(unitCodeName('mtk')) ;
        $this->assertNull(unitCodeName('bx')) ;
    }

    /* --------------------------------------------------------------------
       Codes claimed by both families — the measure family wins
       ------------------------------------------------------------------ */

    public function testMeasureFamilyTakesPrecedenceOnSharedCodes(): void
    {
        // 'PT' is a Point (measure) and a Pot (package)
        $this->assertSame(MeasureCode::getName('PT') , unitCodeName('PT')) ;
        $this->assertSame('Point' , unitCodeName('PT')) ;

        // 'DB' is a Decibel (measure) and a multiple layer wooden Crate (package)
        $this->assertSame(MeasureCode::getName('DB') , unitCodeName('DB')) ;
        $this->assertSame('Decibel' , unitCodeName('DB')) ;
    }

    /* --------------------------------------------------------------------
       The helper must stay a pure delegation to the two families
       ------------------------------------------------------------------ */

    public function testEveryMeasureCodeResolvesToItsOfficialName(): void
    {
        $failures = [] ;

        foreach (MeasureCode::getAll() as $constant => $code)
        {
            if (unitCodeName($code) !== MeasureCode::getName($code))
            {
                $failures[] = $constant ;
            }
        }

        $this->assertSame([] , $failures , 'Measure codes not resolved by unitCodeName') ;
    }

    public function testEveryPackageCodeResolvesToItsOfficialName(): void
    {
        $measures = MeasureCode::getConstantValues() ;
        $failures = [] ;

        foreach ( PackageCode::getAll() as $constant => $code )
        {
            if (in_array($code , $measures , true)) // shadowed by the measure family
            {
                continue ;
            }

            if ( unitCodeName($code) !== PackageCode::getName($code) )
            {
                $failures[] = $constant ;
            }
        }

        $this->assertSame([] , $failures , 'Package codes not resolved by unitCodeName') ;
    }
}
