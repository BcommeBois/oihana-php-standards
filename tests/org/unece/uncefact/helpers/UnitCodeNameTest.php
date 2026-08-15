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
       No code may be claimed by both families
       ------------------------------------------------------------------ */

    /**
     * The helper resolves a code against the measures first and the packages second,
     * so a code claimed by both would silently return the measure reading. No such
     * code exists today — `PT` and `DB` used to collide, but only because MeasureCode
     * declared them wrongly: `PT` is a pint and `DB` a dry pound in Rec 20, never a
     * Point nor a Decibel. Correcting the codes against the official dataset removed
     * the ambiguity rather than arbitrating it.
     *
     * This test keeps it removed.
     */
    public function testNoCodeIsClaimedByBothFamilies(): void
    {
        $shared = array_values(array_unique(array_intersect(
            MeasureCode::getConstantValues() ,
            PackageCode::getConstantValues()
        ))) ;

        $this->assertSame([] , $shared , 'Codes claimed by both the measure and the package family') ;
    }

    public function testPackageCodesFormerlyShadowedResolveToTheirPackage(): void
    {
        $this->assertSame('Pot' , unitCodeName('PT')) ;
        $this->assertSame('Crate, multiple layer, wooden' , unitCodeName('DB')) ;
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
