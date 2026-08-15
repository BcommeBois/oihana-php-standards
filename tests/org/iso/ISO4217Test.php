<?php

namespace tests\org\iso;

use org\iso\ISO4217;
use PHPUnit\Framework\TestCase;

/**
 * Conformance of ISO4217 against the official currency list.
 *
 * Reference: `tools/data/iso4217.csv`, ISO 4217 list one published 2026-01-01.
 *
 * The class keeps a handful of withdrawn currencies so that historical data stays
 * readable. That is deliberate, and declared in {@see self::WITHDRAWN}. What is not
 * acceptable is keeping a withdrawn code *without* its replacement, which is how
 * `ANG`, `SLL` and `ZWL` outlived `XCG`, `SLE` and `ZWG` for a while.
 *
 * @package tests\org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.1.0
 */
final class ISO4217Test extends TestCase
{
    private const string DATASET = __DIR__ . '/../../../tools/data/iso4217.csv' ;

    /**
     * Withdrawn codes kept on purpose, mapped to the code that replaced them.
     *
     * @var array<string,string|null> code => replacement, or null when the currency
     *                                simply ceased to exist (adoption of the euro).
     */
    private const array WITHDRAWN =
    [
        'ANG' => 'XCG' ,
        'SLL' => 'SLE' ,
        'ZWL' => 'ZWG' ,
        'BGN' => null ,   // Bulgaria adopted the euro on 1 January 2026
        'HRK' => null ,   // Croatia adopted the euro in 2023
    ] ;

    /**
     * @return array<string,string> The official alpha codes, mapped to the currency name.
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

            if ($row['alpha'] !== '')
            {
                $codes[$row['alpha']] = $row['currency'] ;
            }
        }

        fclose($handle) ;

        return $codes ;
    }

    public function testDatasetIsReadable(): void
    {
        $this->assertGreaterThan(150 , count($this->officialCodes())) ;
    }

    /* --------------------------------------------------------------------
       Every declared code is either active or a documented withdrawal
       ------------------------------------------------------------------ */

    public function testEveryCodeIsActiveOrDocumentedAsWithdrawn(): void
    {
        $official = $this->officialCodes() ;
        $unknown  = [] ;

        foreach (ISO4217::getAll() as $constant => $code)
        {
            if (!isset($official[$code]) && !isset(self::WITHDRAWN[$code]) && !array_key_exists($code , self::WITHDRAWN))
            {
                $unknown[] = "$constant ('$code')" ;
            }
        }

        $this->assertSame([] , $unknown , 'Codes neither active in ISO 4217 nor declared as withdrawn') ;
    }

    /* --------------------------------------------------------------------
       A withdrawn code may not outlive its replacement
       ------------------------------------------------------------------ */

    public function testWithdrawnCodesShipWithTheirReplacement(): void
    {
        $declared = ISO4217::getConstantValues() ;
        $orphans  = [] ;

        foreach (self::WITHDRAWN as $code => $replacement)
        {
            if ($replacement !== null && !in_array($replacement , $declared , true))
            {
                $orphans[] = "$code was replaced by $replacement, which the class does not declare" ;
            }
        }

        $this->assertSame([] , $orphans) ;
    }

    public function testWithdrawnCodesAreStillDeclared(): void
    {
        $declared = ISO4217::getConstantValues() ;
        $stale    = array_values(array_diff(array_keys(self::WITHDRAWN) , $declared)) ;

        $this->assertSame([] , $stale , 'WITHDRAWN names a code the class no longer declares') ;
    }

    /* --------------------------------------------------------------------
       Structure
       ------------------------------------------------------------------ */

    public function testValuesAreUniqueAndMatchTheirConstantName(): void
    {
        $mismatched = [] ;

        foreach (ISO4217::getAll() as $constant => $code)
        {
            if ($constant !== $code)
            {
                $mismatched[] = "$constant = '$code'" ;
            }
        }

        $this->assertSame([] , $mismatched , 'Each constant is named after its own code') ;

        $duplicates = array_keys(array_filter(
            array_count_values(ISO4217::getConstantValues()) ,
            fn(int $count) => $count > 1
        )) ;

        $this->assertSame([] , $duplicates , 'Duplicated currency codes') ;
    }

    public function testTheFourRecentCurrenciesArePresent(): void
    {
        $this->assertSame('XCG' , ISO4217::XCG) ; // Caribbean guilder, replaces ANG
        $this->assertSame('SLE' , ISO4217::SLE) ; // Sierra Leonean leone, redenominated from SLL
        $this->assertSame('ZWG' , ISO4217::ZWG) ; // Zimbabwe Gold, replaces ZWL
        $this->assertSame('VED' , ISO4217::VED) ; // Venezuelan bolívar digital
    }
}
