<?php

/**
 * Regenerates ISO 639-2 PHP classes from the official Library of Congress dataset.
 *
 * Generates two files:
 *   - src/org/iso/ISO639_2.php  — canonical alpha-3 language codes (487 entries):
 *     terminologic (T) form when both B and T exist, else the single alpha-3.
 *     This matches the BCP 47 / IANA preferred form (RFC 5646 §4.1.2).
 *
 *   - src/org/iso/ISO639_2B.php — the 20 bibliographic-only codes (B forms)
 *     plus a BIBLIOGRAPHIC_TO_TERMINOLOGIC map for B → T resolution.
 *
 * Upstream source (versioned at tools/data/iso639-2.txt):
 *   https://www.loc.gov/standards/iso639-2/ISO-639-2_utf-8.txt
 *
 * Format: pipe-separated, one record per line:
 *   <alpha3-bibliographic>|<alpha3-terminologic>|<alpha2>|<English name>|<French name>
 *
 * The terminologic field is empty when the language has a single alpha-3 code.
 *
 * Usage:
 *   php tools/generate-iso639-2.php
 *
 * To refresh the dataset against upstream:
 *   curl -o tools/data/iso639-2.txt https://www.loc.gov/standards/iso639-2/ISO-639-2_utf-8.txt
 *   php tools/generate-iso639-2.php
 *
 * @package tools
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */

declare(strict_types=1);

const DATA_FILE        = __DIR__ . '/data/iso639-2.txt' ;
const TARGET_FILE      = __DIR__ . '/../src/org/iso/ISO639_2.php' ;
const TARGET_FILE_B    = __DIR__ . '/../src/org/iso/ISO639_2B.php' ;

/**
 * @return array{
 *   canonical: array<string, array{name: string, alpha2: ?string, hasBiblio: bool}>,
 *   bibliographic: array<string, array{name: string, terminologic: string, alpha2: ?string}>
 * }
 */
function parseDataset(): array
{
    $lines = file( DATA_FILE , FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) ;
    if ( $lines === false )
    {
        fwrite( STDERR , "Cannot read " . DATA_FILE . "\n" ) ;
        exit( 1 ) ;
    }

    $canonical     = [] ;
    $bibliographic = [] ;

    foreach ( $lines as $raw )
    {
        // Strip BOM from first line if present
        $line = preg_replace( '/^\xEF\xBB\xBF/' , '' , $raw ) ;
        $parts = explode( '|' , $line ) ;
        if ( count( $parts ) !== 5 )
        {
            fwrite( STDERR , "Skipping malformed line: $line\n" ) ;
            continue ;
        }

        [ $biblio , $term , $alpha2 , $english , $french ] = $parts ;
        $alpha2 = $alpha2 !== '' ? $alpha2 : null ;
        $hasBiblio = $term !== '' ; // when both fields are filled, there is a separate B form

        // Skip the qaa-qtz range marker (reserved for local use, no individual codes)
        if ( !preg_match( '/^[a-z]{3}$/' , $biblio ) )
        {
            continue ;
        }

        // The canonical alpha-3 is T when present, else B
        $canonicalCode = $term !== '' ? $term : $biblio ;

        $canonical[ $canonicalCode ] = [
            'name'      => $english ,
            'alpha2'    => $alpha2 ,
            'hasBiblio' => $hasBiblio ,
        ] ;

        if ( $hasBiblio )
        {
            $bibliographic[ $biblio ] = [
                'name'         => $english ,
                'terminologic' => $term ,
                'alpha2'       => $alpha2 ,
            ] ;
        }
    }

    return [
        'canonical'     => $canonical ,
        'bibliographic' => $bibliographic ,
    ] ;
}

/**
 * @param array<string, array{name: string, alpha2: ?string, hasBiblio: bool}> $canonical
 */
function generateISO639_2( array $canonical ): string
{
    ksort( $canonical ) ;

    $header = <<<'PHP'
<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants representing language codes as defined by the ISO 639-2 standard
 * (canonical alpha-3 form).
 *
 * ISO 639-2 assigns 3-letter codes to languages. For ~20 major languages, two codes coexist:
 * a **bibliographic (B)** form historically used in librarianship and a **terminologic (T)**
 * form designed for general use. IETF BCP 47 / RFC 5646 §4.1.2 prescribes the **terminologic**
 * form as canonical.
 *
 * This class lists the **canonical** alpha-3 code for every ISO 639-2 language:
 * - the **T** form when both B and T exist (e.g. `fra` for French, `deu` for German, `zho` for Chinese),
 * - the single alpha-3 code otherwise (e.g. `eng`, `spa`, `ita`).
 *
 * For the bibliographic forms and the B → T conversion map, see {@see \org\iso\ISO639_2B}.
 *
 * Includes ISO 639-2 special purpose codes:
 *   `mis` (Uncoded languages), `mul` (Multiple languages),
 *   `und` (Undetermined), `zxx` (No linguistic content).
 *
 * The `qaa-qtz` range (reserved for local use) is **intentionally not enumerated**:
 * those codes are not individually assigned by ISO and should be defined locally
 * by consumers if needed (similar to `Qaaa`-`Qabx` in {@see \org\iso\ISO15924}).
 *
 * Example usage:
 *   $french = ISO639_2::FRA;            // 'fra'
 *   $german = ISO639_2::DEU;            // 'deu'
 *
 *   ISO639_2::includes('eng');          // true (English)
 *   ISO639_2::includes('fre');          // false ('fre' is bibliographic — see ISO639_2B)
 *   ISO639_2::includes('zzz');          // false
 *
 * @see \org\iso\ISO639_2B Bibliographic forms and B → T conversion
 * @see \org\iso\ISO639_1  Alpha-2 form (subset: 184 languages with alpha-2)
 * @see \org\iso\ISO639_5  Alpha-3 codes for language families/groups
 * @see https://www.loc.gov/standards/iso639-2/ Official LoC ISO 639-2 registry
 * @see https://www.rfc-editor.org/rfc/rfc5646#section-4.1.2 RFC 5646 — Preferred form
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class ISO639_2
{
    use ConstantsTrait;

PHP;

    $body = '' ;
    foreach ( $canonical as $code => $info )
    {
        $constName = strtoupper( $code ) ;
        $name      = $info[ 'name' ] ;
        $doc       = rtrim( $name , '.' ) . '.' ;

        $body .= <<<PHP

    /**
     * {$doc}
     */
    public const string {$constName} = '{$code}';

PHP;
    }

    return $header . $body . "}\n" ;
}

/**
 * @param array<string, array{name: string, terminologic: string, alpha2: ?string}> $bibliographic
 */
function generateISO639_2B( array $bibliographic ): string
{
    ksort( $bibliographic ) ;

    $header = <<<'PHP'
<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides the **bibliographic (B) form** of ISO 639-2 alpha-3 language codes,
 * for the ~20 languages that have both a bibliographic and a terminologic code.
 *
 * ISO 639-2 assigns two alpha-3 codes to some major languages:
 * - **B** (bibliographic): historically used by libraries and US MARC records
 *   (`fre`, `ger`, `chi`, `dut`, `gre`, `ice`, `rum`, …);
 * - **T** (terminologic): designed for general purposes and **preferred by IETF BCP 47**
 *   (`fra`, `deu`, `zho`, `nld`, `ell`, `isl`, `ron`, …).
 *
 * This class enumerates the **B** forms only. For the canonical (T-or-unique) form,
 * use {@see \org\iso\ISO639_2}. The {@see BIBLIOGRAPHIC_TO_TERMINOLOGIC} map and
 * the {@see toTerminologic()} helper convert a B code to its T equivalent.
 *
 * Example usage:
 *   ISO639_2B::FRE;                              // 'fre' (French, bibliographic)
 *   ISO639_2B::includes('fre');                  // true
 *   ISO639_2B::includes('fra');                  // false (terminologic — see ISO639_2)
 *   ISO639_2B::toTerminologic('fre');            // 'fra'
 *   ISO639_2B::toTerminologic('eng');            // null (not a bibliographic code)
 *   ISO639_2B::getBibliographicToTerminologicMap(); // ['alb' => 'sqi', 'arm' => 'hye', …]
 *
 * @see \org\iso\ISO639_2 Canonical (T-or-unique) form
 * @see https://www.loc.gov/standards/iso639-2/ Official LoC ISO 639-2 registry
 * @see https://www.rfc-editor.org/rfc/rfc5646#section-4.1.2 RFC 5646 — Preferred form
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class ISO639_2B
{
    use ConstantsTrait;

PHP;

    $body = '' ;
    foreach ( $bibliographic as $code => $info )
    {
        $constName = strtoupper( $code ) ;
        $name      = $info[ 'name' ] ;
        $term      = $info[ 'terminologic' ] ;
        $doc       = rtrim( $name , '.' ) . " (bibliographic; terminologic equivalent: `{$term}`)." ;

        $body .= <<<PHP

    /**
     * {$doc}
     */
    public const string {$constName} = '{$code}';

PHP;
    }

    // Append the conversion map as a static method + cache (NOT a class
    // constant, because ReflectionClass::getConstants() — used by
    // ConstantsTrait::getAll() — returns private constants as well, which
    // would pollute the enumeration with the array map).
    $body .= "\n    /**\n     * Returns the full map from bibliographic to terminologic alpha-3 codes.\n     *\n     * @return array<string, string>\n     */\n    public static function getBibliographicToTerminologicMap(): array\n    {\n        return self::\$map ??= [\n" ;
    foreach ( $bibliographic as $code => $info )
    {
        $term = $info[ 'terminologic' ] ;
        $body .= "            '{$code}' => '{$term}',\n" ;
    }
    $body .= "        ];\n    }\n" ;

    // Append the converter method + cache property
    $body .= <<<'PHP'

    /**
     * Returns the terminologic (T) equivalent of a bibliographic (B) alpha-3 code,
     * or null if the input is not a known bibliographic code.
     *
     * @param string $code The bibliographic alpha-3 code (e.g. 'fre', 'ger').
     * @return string|null The terminologic alpha-3 code (e.g. 'fra', 'deu'), or null.
     */
    public static function toTerminologic( string $code ): ?string
    {
        return self::getBibliographicToTerminologicMap()[ $code ] ?? null ;
    }

    /**
     * Cached B→T map (lazy-initialized by {@see getBibliographicToTerminologicMap()}).
     *
     * @var array<string, string>|null
     */
    private static ?array $map = null ;
PHP;

    return $header . $body . "\n}\n" ;
}

function main(): void
{
    echo "Parsing " . DATA_FILE . "...\n" ;
    $data = parseDataset() ;

    $canonicalCount     = count( $data[ 'canonical' ] ) ;
    $bibliographicCount = count( $data[ 'bibliographic' ] ) ;

    echo "Parsed {$canonicalCount} canonical entries, {$bibliographicCount} bibliographic entries.\n" ;

    echo "Generating " . TARGET_FILE . "...\n" ;
    file_put_contents( TARGET_FILE , generateISO639_2( $data[ 'canonical' ] ) ) ;

    echo "Generating " . TARGET_FILE_B . "...\n" ;
    file_put_contents( TARGET_FILE_B , generateISO639_2B( $data[ 'bibliographic' ] ) ) ;

    echo "Done.\n" ;
}

main() ;
