<?php

/**
 * Generates BCP 47 / RFC 5646 PHP constants classes from the official IANA
 * Language Subtag Registry.
 *
 * Capable of generating any of:
 *   - src/org/ietf/BCP47Variant.php       (Type: variant)
 *   - src/org/ietf/BCP47Grandfathered.php (Type: grandfathered)
 *   - src/org/ietf/BCP47Redundant.php     (Type: redundant)
 *
 * Upstream source (versioned at tools/data/iana-language-subtag-registry.txt):
 *   https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry
 *
 * Format: record-jar (records separated by `%%`), fields are `Key: Value`,
 * with continuation lines starting with two spaces.
 *
 * Usage:
 *   php tools/generate-bcp47-iana.php [--variant] [--grandfathered] [--redundant]
 *
 * With no flag, generates all three. Each flag enables a single target.
 *
 * To refresh the registry against upstream:
 *   curl -o tools/data/iana-language-subtag-registry.txt \
 *     https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry
 *   php tools/generate-bcp47-iana.php
 *
 * @package tools
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */

declare(strict_types=1);

const DATA_FILE                = __DIR__ . '/data/iana-language-subtag-registry.txt' ;
const TARGET_VARIANT           = __DIR__ . '/../src/org/ietf/BCP47Variant.php' ;
const TARGET_GRANDFATHERED     = __DIR__ . '/../src/org/ietf/BCP47Grandfathered.php' ;
const TARGET_REDUNDANT         = __DIR__ . '/../src/org/ietf/BCP47Redundant.php' ;

/**
 * Parses the IANA registry into an array of records.
 *
 * @return list<array<string, string|list<string>>>
 */
function parseRegistry(): array
{
    $content = file_get_contents( DATA_FILE ) ;
    if ( $content === false )
    {
        fwrite( STDERR , "Cannot read " . DATA_FILE . "\n" ) ;
        exit( 1 ) ;
    }

    $records = [] ;

    // Skip the File-Date header (first chunk before the first %%)
    $chunks = preg_split( '/^%%$/m' , $content ) ;
    array_shift( $chunks ) ;

    foreach ( $chunks as $chunk )
    {
        $record = parseRecord( $chunk ) ;
        if ( $record !== null )
        {
            $records[] = $record ;
        }
    }

    return $records ;
}

/**
 * Parses a single record-jar record. Handles continuation lines (2-space indent).
 *
 * @return array<string, string|list<string>>|null
 */
function parseRecord( string $chunk ): ?array
{
    $lines = explode( "\n" , trim( $chunk , "\n" ) ) ;
    $record = [] ;
    $currentKey = null ;

    foreach ( $lines as $line )
    {
        if ( $line === '' )
        {
            continue ;
        }

        // Continuation line (starts with whitespace)
        if ( $currentKey !== null && preg_match( '/^\s+(.*)$/' , $line , $m ) )
        {
            $value = trim( $m[ 1 ] ) ;
            if ( is_array( $record[ $currentKey ] ) )
            {
                $last = array_key_last( $record[ $currentKey ] ) ;
                $record[ $currentKey ][ $last ] .= ' ' . $value ;
            }
            else
            {
                $record[ $currentKey ] .= ' ' . $value ;
            }
            continue ;
        }

        if ( preg_match( '/^([A-Za-z\-]+):\s*(.*)$/' , $line , $m ) )
        {
            $key   = $m[ 1 ] ;
            $value = $m[ 2 ] ;

            // Multi-valued keys (Description, Comments) → store as list
            if ( isset( $record[ $key ] ) )
            {
                if ( !is_array( $record[ $key ] ) )
                {
                    $record[ $key ] = [ $record[ $key ] ] ;
                }
                $record[ $key ][] = $value ;
            }
            else
            {
                $record[ $key ] = $value ;
            }

            $currentKey = $key ;
        }
    }

    return $record === [] ? null : $record ;
}

/**
 * Returns a valid PHP identifier for a BCP 47 subtag.
 *
 * Numeric subtags (starting with a digit) are prefixed with `V_` since PHP
 * identifiers cannot start with a digit. The `-` separator in grandfathered/
 * redundant tags is replaced with `_`.
 */
function toConstantName( string $subtag ): string
{
    $upper = strtoupper( $subtag ) ;
    $name  = str_replace( '-' , '_' , $upper ) ;
    if ( preg_match( '/^[0-9]/' , $name ) )
    {
        $name = 'V_' . $name ;
    }
    return $name ;
}

/**
 * @param list<array<string, string|list<string>>> $records
 * @return list<array<string, string|list<string>>>
 */
function filterByType( array $records , string $type ): array
{
    return array_values( array_filter( $records , fn( $r ) => ( $r[ 'Type' ] ?? null ) === $type ) ) ;
}

/**
 * Returns a Description string, joining list values with " / ".
 *
 * @param string|list<string> $desc
 */
function describe( string|array $desc ): string
{
    if ( is_array( $desc ) )
    {
        return implode( ' / ' , $desc ) ;
    }
    return $desc ;
}

function generateVariant( array $records ): string
{
    $variants = filterByType( $records , 'variant' ) ;

    // Sort by subtag for determinism
    usort( $variants , fn( $a , $b ) => strcmp( $a[ 'Subtag' ] , $b[ 'Subtag' ] ) ) ;

    $header = <<<'PHP'
<?php

namespace org\ietf;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants for BCP 47 / RFC 5646 **variant** subtags as
 * registered in the IANA Language Subtag Registry.
 *
 * Variant subtags refine the language/script/region triple with notation,
 * orthography or dialect specifications: `1996` (post-reform German orthography),
 * `valencia` (Valencian Catalan), `fonipa` (IPA phonetic transcription),
 * `tarask` (Belarusian Taraškievica), `pinyin`, `wadegile`, etc.
 *
 * In a BCP 47 tag, variants appear after the language/script/region components:
 *   `de-CH-1996`     — Swiss German with 1996 orthography
 *   `ca-ES-valencia` — Catalan, Valencian variant, in Spain
 *   `sl-Latn-fonipa` — IPA transcription of Slovenian
 *
 * Naming convention:
 * - Alphabetic subtags → uppercase constant name (e.g. `VALENCIA = 'valencia'`).
 * - Numeric or digit-leading subtags → prefixed with `V_` because PHP
 *   identifiers cannot start with a digit (e.g. `V_1996 = '1996'`,
 *   `V_1606NICT = '1606nict'`).
 *
 * **Prefix constraints** (e.g. `valencia` requires `ca`) and **deprecation**
 * metadata are documented in the per-constant PHPDoc but **not enforced** by
 * this class. For full BCP 47 validation, see {@see \org\ietf\helpers\isLocale}.
 *
 * Example usage:
 *   BCP47Variant::V_1996;            // '1996'
 *   BCP47Variant::VALENCIA;          // 'valencia'
 *   BCP47Variant::FONIPA;            // 'fonipa'
 *   BCP47Variant::includes('1996');  // true
 *   BCP47Variant::includes('xyz');   // false
 *
 * @see \org\ietf\Locale
 * @see \org\ietf\BCP47Grandfathered Legacy grandfathered tags (full tags, not subtags)
 * @see \org\ietf\BCP47Redundant     Redundant registered tags
 * @see https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry IANA registry
 * @see https://www.rfc-editor.org/rfc/rfc5646#section-2.2.5 RFC 5646 §2.2.5 — Variant Subtags
 *
 * @package org\ietf
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class BCP47Variant
{
    use ConstantsTrait;

PHP;

    $body = '' ;
    foreach ( $variants as $rec )
    {
        $subtag    = $rec[ 'Subtag' ] ;
        $constName = toConstantName( $subtag ) ;
        $desc      = describe( $rec[ 'Description' ] ?? '' ) ;
        $prefix    = $rec[ 'Prefix' ] ?? null ;
        $deprecated = $rec[ 'Deprecated' ] ?? null ;

        $docParts = [ rtrim( $desc , '.' ) . '.' ] ;
        if ( $prefix !== null )
        {
            $prefixStr = is_array( $prefix ) ? implode( ', ' , $prefix ) : $prefix ;
            $docParts[] = "Prefix: `{$prefixStr}`.";
        }
        if ( $deprecated !== null )
        {
            $docParts[] = "**Deprecated** since {$deprecated}.";
        }
        $doc = implode( ' ' , $docParts ) ;

        $body .= <<<PHP

    /**
     * {$doc}
     */
    public const string {$constName} = '{$subtag}';

PHP;
    }

    return $header . $body . "}\n" ;
}

function generateGrandfathered( array $records ): string
{
    $entries = filterByType( $records , 'grandfathered' ) ;
    usort( $entries , fn( $a , $b ) => strcmp( $a[ 'Tag' ] , $b[ 'Tag' ] ) ) ;

    $header = <<<'PHP'
<?php

namespace org\ietf;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants for BCP 47 / RFC 5646 **grandfathered** tags.
 *
 * Grandfathered tags are registered language tags that predate the structured
 * grammar of RFC 4646 (the predecessor of RFC 5646). They are preserved for
 * historical compatibility — e.g. `i-klingon`, `art-lojban`, `zh-min-nan`,
 * `cel-gaulish`, `no-bok`, `i-default`.
 *
 * Most grandfathered tags have a **Preferred-Value** that consumers should use
 * in new content (`i-klingon` → `tlh`, `art-lojban` → `jbo`, `zh-min-nan` → `nan`).
 * Use {@see toPreferred()} to look up the canonical replacement.
 *
 * Naming convention: the `-` separator is replaced with `_` to form valid PHP
 * identifiers (e.g. `I_KLINGON = 'i-klingon'`).
 *
 * Example usage:
 *   BCP47Grandfathered::I_KLINGON;                       // 'i-klingon'
 *   BCP47Grandfathered::includes('art-lojban');          // true
 *   BCP47Grandfathered::toPreferred('i-klingon');        // 'tlh'
 *   BCP47Grandfathered::toPreferred('i-default');        // null (no replacement)
 *
 * @see \org\ietf\BCP47Variant       Variant subtags
 * @see \org\ietf\BCP47Redundant     Redundant registered tags
 * @see https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry IANA registry
 * @see https://www.rfc-editor.org/rfc/rfc5646#section-2.2.8 RFC 5646 §2.2.8 — Grandfathered and Redundant
 *
 * @package org\ietf
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class BCP47Grandfathered
{
    use ConstantsTrait;

PHP;

    $body  = '' ;
    $map   = [] ;
    foreach ( $entries as $rec )
    {
        $tag      = $rec[ 'Tag' ] ;
        $constName = toConstantName( $tag ) ;
        $desc     = describe( $rec[ 'Description' ] ?? '' ) ;
        $preferred = $rec[ 'Preferred-Value' ] ?? null ;
        $deprecated = $rec[ 'Deprecated' ] ?? null ;

        $docParts = [ rtrim( $desc , '.' ) . '.' ] ;
        if ( $preferred !== null )
        {
            $docParts[] = "Preferred-Value: `{$preferred}`.";
        }
        if ( $deprecated !== null )
        {
            $docParts[] = "**Deprecated** since {$deprecated}.";
        }
        $doc = implode( ' ' , $docParts ) ;

        $body .= <<<PHP

    /**
     * {$doc}
     */
    public const string {$constName} = '{$tag}';

PHP;

        $map[ $tag ] = $preferred ;
    }

    // Append the static accessor + map
    $body .= "\n    /**\n     * Returns the full map from grandfathered tag to its IANA Preferred-Value\n     * (or null when no replacement is defined).\n     *\n     * @return array<string, string|null>\n     */\n    public static function getPreferredValueMap(): array\n    {\n        return self::\$map ??= [\n" ;
    foreach ( $map as $tag => $pref )
    {
        $val = $pref === null ? 'null' : "'{$pref}'" ;
        $body .= "            '{$tag}' => {$val},\n" ;
    }
    $body .= "        ];\n    }\n" ;

    $body .= <<<'PHP'

    /**
     * Returns the IANA Preferred-Value replacement for a grandfathered tag,
     * or null if the tag is unknown or has no defined replacement.
     *
     * @param string $tag The grandfathered tag (e.g. 'i-klingon', 'art-lojban').
     * @return string|null The preferred tag (e.g. 'tlh', 'jbo'), or null.
     */
    public static function toPreferred( string $tag ): ?string
    {
        return self::getPreferredValueMap()[ $tag ] ?? null ;
    }

    /**
     * Cached preferred-value map (lazy-initialized).
     *
     * @var array<string, string|null>|null
     */
    private static ?array $map = null ;
PHP;

    return $header . $body . "\n}\n" ;
}

function generateRedundant( array $records ): string
{
    $entries = filterByType( $records , 'redundant' ) ;
    usort( $entries , fn( $a , $b ) => strcmp( $a[ 'Tag' ] , $b[ 'Tag' ] ) ) ;

    $header = <<<'PHP'
<?php

namespace org\ietf;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Provides a set of constants for BCP 47 / RFC 5646 **redundant** tags.
 *
 * Redundant tags are full language tags that are formable from the structured
 * subtag grammar but were registered in the past for historical reasons —
 * e.g. `zh-Hans`, `de-1996`, `sgn-BR`, `mn-Mong`, `ja-Latn-hepburn`.
 *
 * Some redundant tags carry a **Preferred-Value** indicating a canonical
 * replacement that should be used in new content. Use {@see toPreferred()} to
 * look up the replacement when defined.
 *
 * Naming convention: the `-` separator is replaced with `_` to form valid PHP
 * identifiers (e.g. `ZH_HANS = 'zh-Hans'`, `DE_1996 = 'de-1996'`).
 *
 * Example usage:
 *   BCP47Redundant::ZH_HANS;                        // 'zh-Hans'
 *   BCP47Redundant::includes('de-1996');            // true
 *   BCP47Redundant::toPreferred('zh-cmn-Hans');     // 'cmn-Hans'
 *
 * @see \org\ietf\BCP47Variant        Variant subtags
 * @see \org\ietf\BCP47Grandfathered  Grandfathered tags
 * @see https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry IANA registry
 * @see https://www.rfc-editor.org/rfc/rfc5646#section-2.2.8 RFC 5646 §2.2.8 — Grandfathered and Redundant
 *
 * @package org\ietf
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.3
 */
class BCP47Redundant
{
    use ConstantsTrait;

PHP;

    $body  = '' ;
    $map   = [] ;
    foreach ( $entries as $rec )
    {
        $tag      = $rec[ 'Tag' ] ;
        $constName = toConstantName( $tag ) ;
        $desc     = describe( $rec[ 'Description' ] ?? '' ) ;
        $preferred = $rec[ 'Preferred-Value' ] ?? null ;
        $deprecated = $rec[ 'Deprecated' ] ?? null ;

        $docParts = [ rtrim( $desc , '.' ) . '.' ] ;
        if ( $preferred !== null )
        {
            $docParts[] = "Preferred-Value: `{$preferred}`.";
        }
        if ( $deprecated !== null )
        {
            $docParts[] = "**Deprecated** since {$deprecated}.";
        }
        $doc = implode( ' ' , $docParts ) ;

        $body .= <<<PHP

    /**
     * {$doc}
     */
    public const string {$constName} = '{$tag}';

PHP;

        $map[ $tag ] = $preferred ;
    }

    // Append the static accessor + map
    $body .= "\n    /**\n     * Returns the full map from redundant tag to its IANA Preferred-Value\n     * (or null when no replacement is defined).\n     *\n     * @return array<string, string|null>\n     */\n    public static function getPreferredValueMap(): array\n    {\n        return self::\$map ??= [\n" ;
    foreach ( $map as $tag => $pref )
    {
        $val = $pref === null ? 'null' : "'{$pref}'" ;
        $body .= "            '{$tag}' => {$val},\n" ;
    }
    $body .= "        ];\n    }\n" ;

    $body .= <<<'PHP'

    /**
     * Returns the IANA Preferred-Value replacement for a redundant tag,
     * or null if the tag is unknown or has no defined replacement.
     *
     * @param string $tag The redundant tag (e.g. 'zh-cmn-Hans').
     * @return string|null The preferred tag (e.g. 'cmn-Hans'), or null.
     */
    public static function toPreferred( string $tag ): ?string
    {
        return self::getPreferredValueMap()[ $tag ] ?? null ;
    }

    /**
     * Cached preferred-value map (lazy-initialized).
     *
     * @var array<string, string|null>|null
     */
    private static ?array $map = null ;
PHP;

    return $header . $body . "\n}\n" ;
}

function main(): void
{
    $args      = array_slice( $_SERVER[ 'argv' ] , 1 ) ;
    $doAll     = empty( $args ) ;
    $doVar     = $doAll || in_array( '--variant' , $args , true ) ;
    $doGrand   = $doAll || in_array( '--grandfathered' , $args , true ) ;
    $doRedun   = $doAll || in_array( '--redundant' , $args , true ) ;

    echo "Parsing " . DATA_FILE . "...\n" ;
    $records = parseRegistry() ;
    echo sprintf( "Parsed %d records.\n" , count( $records ) ) ;

    if ( $doVar )
    {
        echo "Generating " . TARGET_VARIANT . "...\n" ;
        file_put_contents( TARGET_VARIANT , generateVariant( $records ) ) ;
        echo sprintf( "  %d variants\n" , count( filterByType( $records , 'variant' ) ) ) ;
    }

    if ( $doGrand )
    {
        echo "Generating " . TARGET_GRANDFATHERED . "...\n" ;
        file_put_contents( TARGET_GRANDFATHERED , generateGrandfathered( $records ) ) ;
        echo sprintf( "  %d grandfathered\n" , count( filterByType( $records , 'grandfathered' ) ) ) ;
    }

    if ( $doRedun )
    {
        echo "Generating " . TARGET_REDUNDANT . "...\n" ;
        file_put_contents( TARGET_REDUNDANT , generateRedundant( $records ) ) ;
        echo sprintf( "  %d redundant\n" , count( filterByType( $records , 'redundant' ) ) ) ;
    }

    echo "Done.\n" ;
}

main() ;
