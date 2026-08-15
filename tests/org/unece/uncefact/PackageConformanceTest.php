<?php

namespace tests\org\unece\uncefact;

use org\unece\uncefact\PackageCode;
use org\unece\uncefact\PackageName;
use PHPUnit\Framework\TestCase;

/**
 * Conformance of PackageCode / PackageName against UN/CEFACT Recommendation 21.
 *
 * Unlike the Measure classes, these two are maintained by hand — one error in 108
 * entries did not justify a generator. This test is what replaces it: it reads the
 * official dataset versioned at tools/data/uncefact-rec21.csv and fails on any code
 * or name that departs from it.
 *
 * It is what would have caught `PARCEL = 'PA'`, which is the packet in Rec 21, the
 * parcel being `PC`.
 *
 * Deliberate departures belong in {@see self::KNOWN_DEVIATIONS}, so the debt stays
 * visible and bounded instead of silent.
 *
 * @package tests\org\unece\uncefact
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.1.0
 */
final class PackageConformanceTest extends TestCase
{
    private const string DATASET = __DIR__ . '/../../../../tools/data/uncefact-rec21.csv' ;

    /**
     * Constants whose name intentionally differs from the official wording.
     *
     * @var array<string,string> constant => why
     */
    private const array KNOWN_DEVIATIONS =
    [
        // The official cell concatenates the name and its description:
        // "Pallet, box Combined open-ended box and pallet". Only the name is kept.
        'PALLET_BOX' => 'official cell merges name and description',
    ] ;

    /**
     * @return array<string,array{name:string,status:string}> The official codes, keyed by code.
     */
    private function officialCodes(): array
    {
        $handle = fopen(self::DATASET , 'r') ;
        $this->assertNotFalse($handle , 'Missing dataset: ' . self::DATASET) ;

        $header = fgetcsv($handle , escape: '') ;
        $codes  = [] ;

        while (($row = fgetcsv($handle , escape: '')) !== false)
        {
            if ($row === [null])
            {
                continue ;
            }

            $row = array_combine($header , array_pad($row , count($header) , '')) ;

            if ($row['code'] !== '')
            {
                $codes[$row['code']] = [ 'name' => $row['name'] , 'status' => $row['status'] ] ;
            }
        }

        fclose($handle) ;

        return $codes ;
    }

    public function testDatasetIsReadable(): void
    {
        $this->assertGreaterThan(400 , count($this->officialCodes()) , 'Rec 21 Rev 12 declares 406 codes') ;
    }

    /* --------------------------------------------------------------------
       Every declared code must exist in the standard
       ------------------------------------------------------------------ */

    public function testEveryCodeExistsInRec21(): void
    {
        $official = $this->officialCodes() ;
        $unknown  = [] ;

        foreach (PackageCode::getAll() as $constant => $code)
        {
            if (!isset($official[$code]))
            {
                $unknown[] = "$constant ('$code')" ;
            }
        }

        $this->assertSame([] , $unknown , 'Codes absent from UN/CEFACT Rec 21 Rev 12') ;
    }

    /* --------------------------------------------------------------------
       Every declared name must be the official one
       ------------------------------------------------------------------ */

    public function testEveryNameMatchesTheOfficialWording(): void
    {
        $official = $this->officialCodes() ;
        $wrong    = [] ;

        foreach (PackageCode::getAll() as $constant => $code)
        {
            if (!isset($official[$code]) || isset(self::KNOWN_DEVIATIONS[$constant]))
            {
                continue ;
            }

            $declared = PackageName::getAll()[$constant] ?? null ;

            if ($declared === null)
            {
                $wrong[] = "$constant : missing from PackageName" ;
                continue ;
            }

            if (mb_strtolower($declared) !== mb_strtolower($official[$code]['name']))
            {
                $wrong[] = "$constant ('$code') : '$declared' but Rec 21 says '{$official[$code]['name']}'" ;
            }
        }

        $this->assertSame([] , $wrong , 'Names departing from UN/CEFACT Rec 21 Rev 12') ;
    }

    /* --------------------------------------------------------------------
       A deviation that is no longer one should be removed from the list
       ------------------------------------------------------------------ */

    public function testKnownDeviationsAreStillDeclared(): void
    {
        $stale = array_diff(array_keys(self::KNOWN_DEVIATIONS) , array_keys(PackageCode::getAll())) ;

        $this->assertSame([] , array_values($stale) , 'KNOWN_DEVIATIONS names a constant that no longer exists') ;
    }

    /* --------------------------------------------------------------------
       The two classes mirror each other
       ------------------------------------------------------------------ */

    public function testBothClassesDeclareTheSameConstants(): void
    {
        $codes = PackageCode::getConstantKeys() ;
        $names = PackageName::getConstantKeys() ;

        $this->assertSame([] , array_values(array_diff($codes , $names)) , 'Constants missing from PackageName') ;
        $this->assertSame([] , array_values(array_diff($names , $codes)) , 'Constants missing from PackageCode') ;
    }

    public function testValuesAreUniqueWithinEachClass(): void
    {
        foreach ([ PackageCode::class , PackageName::class ] as $class)
        {
            $duplicates = array_keys(array_filter(
                array_count_values($class::getConstantValues()) ,
                fn(int $count) => $count > 1
            )) ;

            $this->assertSame([] , $duplicates , 'Duplicated values in ' . $class) ;
        }
    }
}
