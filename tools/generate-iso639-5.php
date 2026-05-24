<?php

/**
 * Regenerates src/org/iso/ISO639_5.php from the official Library of Congress
 * ISO 639-5 dataset.
 *
 * ISO 639-5 enumerates alpha-3 codes for language **families and groups**
 * (`roa` Romance, `gem` Germanic, `sla` Slavic, etc.), as opposed to individual
 * languages covered by ISO 639-1/-2/-3.
 *
 * Upstream source (versioned at tools/data/iso639-5.tsv):
 *   https://id.loc.gov/vocabulary/iso639-5.tsv
 *
 * Format: tab-separated with header row, columns:
 *   URI  code  English label  French label
 *
 * Usage:
 *   php tools/generate-iso639-5.php
 *
 * To refresh the dataset against upstream:
 *   curl -o tools/data/iso639-5.tsv https://id.loc.gov/vocabulary/iso639-5.tsv
 *   php tools/generate-iso639-5.php
 *
 * @package tools
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */

declare(strict_types=1);

const DATA_FILE   = __DIR__ . '/data/iso639-5.tsv' ;
const TARGET_FILE = __DIR__ . '/../src/org/iso/ISO639_5.php' ;

/**
 * @return array<string, string> code → English label
 */
function parseDataset(): array
{
    $lines = file( DATA_FILE , FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) ;
    if ( $lines === false )
    {
        fwrite( STDERR , "Cannot read " . DATA_FILE . "\n" ) ;
        exit( 1 ) ;
    }

    $entries = [] ;
    $first   = true ;

    foreach ( $lines as $raw )
    {
        // Skip header
        if ( $first )
        {
            $first = false ;
            continue ;
        }

        $line  = preg_replace( '/^\xEF\xBB\xBF/' , '' , $raw ) ;
        $parts = explode( "\t" , $line ) ;
        if ( count( $parts ) < 3 )
        {
            fwrite( STDERR , "Skipping malformed line: $line\n" ) ;
            continue ;
        }

        [ , $code , $english ] = $parts ;

        if ( !preg_match( '/^[a-z]{3}$/' , $code ) )
        {
            fwrite( STDERR , "Skipping non-alpha-3 code: $code\n" ) ;
            continue ;
        }

        $entries[ $code ] = $english ;
    }

    return $entries ;
}

/**
 * @param array<string, string> $entries
 */
function generatePhpClass( array $entries ): string
{
    ksort( $entries ) ;

    $header = <<<'PHP'
<?php

namespace org\iso;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants representing alpha-3 codes for **language families
 * and groups** as defined by the ISO 639-5 standard.
 *
 * Unlike {@see \org\iso\ISO639_1} (individual languages, alpha-2) or
 * {@see \org\iso\ISO639_2} (individual languages, alpha-3), ISO 639-5 covers
 * **language collections**: language families (`roa` Romance, `gem` Germanic,
 * `sla` Slavic, `cel` Celtic), areal/geographic groupings (`aus` Australian,
 * `nai` North American Indian), and language phyla (`afa` Afro-Asiatic).
 *
 * Useful for **language fallback chains** (e.g. if French `fr` is unavailable,
 * fall back to any Romance language `roa`) and for **bibliographic / linguistic**
 * classification.
 *
 * Many ISO 639-5 codes (~65) coexist with ISO 639-2 — those codes were
 * originally assigned to language families in ISO 639-2 before ISO 639-5 was
 * formalized. Each registry remains independent and authoritative for its
 * intended use; this class enumerates only the ISO 639-5 inventory.
 *
 * Example usage:
 *   ISO639_5::ROA;                      // 'roa' (Romance languages)
 *   ISO639_5::GEM;                      // 'gem' (Germanic languages)
 *   ISO639_5::includes('sla');          // true (Slavic languages)
 *   ISO639_5::includes('fra');          // false (individual language → ISO 639-2)
 *
 * @see \org\iso\ISO639_2  Alpha-3 codes for individual languages
 * @see \org\iso\ISO639_1  Alpha-2 codes for individual languages
 * @see https://www.loc.gov/standards/iso639-5/ Official LoC ISO 639-5 registry
 * @see https://id.loc.gov/vocabulary/iso639-5.html LoC linked-data view
 *
 * @package org\iso
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class ISO639_5
{
    use ConstantsTrait;

PHP;

    $body = '' ;
    foreach ( $entries as $code => $english )
    {
        $constName = strtoupper( $code ) ;
        $doc       = rtrim( $english , '.' ) . '.' ;

        $body .= <<<PHP

    /**
     * {$doc}
     */
    public const string {$constName} = '{$code}';

PHP;
    }

    return $header . $body . "}\n" ;
}

function main(): void
{
    echo "Parsing " . DATA_FILE . "...\n" ;
    $entries = parseDataset() ;

    echo sprintf( "Parsed %d entries.\n" , count( $entries ) ) ;

    echo "Generating " . TARGET_FILE . "...\n" ;
    file_put_contents( TARGET_FILE , generatePhpClass( $entries ) ) ;

    echo "Done.\n" ;
}

main() ;
