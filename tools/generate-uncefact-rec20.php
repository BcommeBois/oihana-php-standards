<?php

/**
 * Regenerates the UN/CEFACT Recommendation 20 PHP classes from the official dataset.
 *
 * Generates three mirror classes, which must always declare the same constant names —
 * the cross lookups resolve a value to its constant name and read the same key in the
 * sibling class:
 *
 *   - src/org/unece/uncefact/MeasureCode.php   — the UN/CEFACT common codes
 *   - src/org/unece/uncefact/MeasureName.php   — the official English names
 *   - src/org/unece/uncefact/MeasureSymbol.php — the notation symbols
 *
 * Two inputs, both versioned:
 *
 *   - tools/data/uncefact-rec20.csv — the full official list, 2136 entries, extracted
 *     from rec20_Rev17e-2021.xlsx (sheet "Annex II & Annex III").
 *
 *   - tools/data/uncefact-rec20-selection.csv — the curated subset this library exposes.
 *     One row per constant: `constant,code,section,name_override,symbol_override,status`.
 *
 * The selection file is the only thing to edit by hand. Adding a unit means adding one
 * row; its name and symbol are then read from the official dataset, never typed again.
 *
 * `name_override` and `symbol_override` keep a display string that deliberately differs
 * from the official one — American spelling, title case. An empty cell means "use the
 * official value". Every override is therefore an explicit, reviewable decision, which
 * is what a hand-maintained list could not offer: this class had drifted to 58
 * non-conforming entries out of 105 before this generator existed.
 *
 * A row whose `code` is empty is reported and skipped — it marks a constant whose
 * official equivalent is still to be decided.
 *
 * Upstream source (Revision 17, 2021):
 *   https://unece.org/trade/uncefact/cl-recommendations
 *
 * Usage:
 *   php tools/generate-uncefact-rec20.php            # writes the three classes
 *   php tools/generate-uncefact-rec20.php --dry-run  # reports, writes nothing
 *
 * @package tools
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.1.0
 */

declare(strict_types=1);

const OFFICIAL_FILE  = __DIR__ . '/data/uncefact-rec20.csv' ;
const SELECTION_FILE = __DIR__ . '/data/uncefact-rec20-selection.csv' ;
const TARGET_DIR     = __DIR__ . '/../src/org/unece/uncefact' ;

$dryRun = in_array( '--dry-run' , $argv , true ) ;

// ---------------------------------------------------------------------------
// Reading
// ---------------------------------------------------------------------------

/**
 * Reads a CSV file into a list of associative rows keyed by its header.
 *
 * @param string $path The absolute path of the CSV file.
 * @return array<int,array<string,string>> The rows, header excluded.
 */
function readCsv( string $path ): array
{
    $handle = fopen( $path , 'r' ) ;

    if ( $handle === false )
    {
        fwrite( STDERR , "Cannot read $path\n" ) ;
        exit( 1 ) ;
    }

    // PHP 8.4 requires $escape explicitly ; '' is the future default and the RFC 4180 behaviour.
    $header = fgetcsv( $handle , escape : '' ) ;
    $rows   = [] ;

    while ( ( $line = fgetcsv( $handle , escape : '' ) ) !== false )
    {
        if ( $line === [ null ] )
        {
            continue ; // blank line
        }
        $rows[] = array_combine( $header , array_pad( $line , count( $header ) , '' ) ) ;
    }

    fclose( $handle ) ;

    return $rows ;
}

$official = [] ;

foreach ( readCsv( OFFICIAL_FILE ) as $row )
{
    $official[ $row[ 'code' ] ] = $row ;
}

$selection = readCsv( SELECTION_FILE ) ;

// ---------------------------------------------------------------------------
// Validation — a generated class that breaks an invariant is worse than none
// ---------------------------------------------------------------------------

$entries  = [] ;
$errors   = [] ;
$skipped  = [] ;
$seenCode = [] ;

foreach ( $selection as $row )
{
    $constant = trim( $row[ 'constant' ] ) ;
    $code     = trim( $row[ 'code'     ] ) ;

    if ( $code === '' )
    {
        $skipped[] = $constant ;
        continue ;
    }

    if ( !isset( $official[ $code ] ) )
    {
        $errors[] = "$constant : code '$code' absent from the official Rec 20 dataset" ;
        continue ;
    }

    if ( isset( $seenCode[ $code ] ) )
    {
        $errors[] = "$constant : code '$code' already used by {$seenCode[ $code ]}" ;
        continue ;
    }

    $seenCode[ $code ] = $constant ;

    $entries[] =
    [
        'constant' => $constant ,
        'section'  => $row[ 'section' ] !== '' ? $row[ 'section' ] : 'Other Units' ,
        'code'     => $code ,
        'name'     => $row[ 'name_override'   ] !== '' ? $row[ 'name_override'   ] : $official[ $code ][ 'name'   ] ,
        'symbol'   => $row[ 'symbol_override' ] !== '' ? $row[ 'symbol_override' ] : $official[ $code ][ 'symbol' ] ,
    ] ;
}

// A duplicated value makes ConstantsTrait::getConstant() return an array instead of a
// string, which silently breaks every cross lookup. Guard the three classes.
foreach ( [ 'code' => 'MeasureCode' , 'name' => 'MeasureName' , 'symbol' => 'MeasureSymbol' ] as $field => $class )
{
    $seen = [] ;

    foreach ( $entries as $entry )
    {
        $value = $entry[ $field ] ;

        if ( $value === '' )
        {
            $errors[] = "{$entry[ 'constant' ]} : empty $field, $class cannot expose it" ;
            continue ;
        }

        if ( isset( $seen[ $value ] ) )
        {
            $errors[] = "$class : '$value' shared by {$seen[ $value ]} and {$entry[ 'constant' ]}" ;
        }

        $seen[ $value ] = $entry[ 'constant' ] ;
    }
}

if ( $errors !== [] )
{
    fwrite( STDERR , 'Refusing to generate — ' . count( $errors ) . " problem(s):\n" ) ;

    foreach ( $errors as $error )
    {
        fwrite( STDERR , "  - $error\n" ) ;
    }

    exit( 1 ) ;
}

// ---------------------------------------------------------------------------
// Rendering
// ---------------------------------------------------------------------------

/**
 * Renders one complete PHP class file.
 *
 * @param string $class The class short name.
 * @param string $field The entry field holding the constant value: code, name or symbol.
 * @param string $intro The first line of the class docblock.
 * @param array<int,array<string,string>> $entries The constants to declare, in selection order.
 * @param bool $comment Whether to trail each constant with the unit name.
 * @return string The complete file contents.
 */
function renderClass( string $class , string $field , string $intro , array $entries , bool $comment ): string
{
    $siblings = array_values( array_diff( [ 'MeasureCode' , 'MeasureName' , 'MeasureSymbol' ] , [ $class ] ) ) ;

    $out  = "<?php\n\n" ;
    $out .= "namespace org\\unece\\uncefact;\n\n" ;
    $out .= "use oihana\\reflect\\traits\\ConstantsTrait;\n\n" ;
    $out .= "/**\n" ;
    $out .= " * $intro\n" ;
    $out .= " *\n" ;
    $out .= " * This class exposes an extended selection of the most commonly used codes across\n" ;
    $out .= " * various commercial and logistical contexts.\n" ;
    $out .= " *\n" ;
    $out .= " * It mirrors {@see {$siblings[0]}} and {@see {$siblings[1]}} : the three classes declare\n" ;
    $out .= " * the same constant names, which is what the cross lookups rely on.\n" ;
    $out .= " *\n" ;
    $out .= " * ⚠️ Generated by tools/generate-uncefact-rec20.php — do not edit by hand.\n" ;
    $out .= " * Edit tools/data/uncefact-rec20-selection.csv and run the generator instead.\n" ;
    $out .= " *\n" ;
    $out .= " * @see https://unece.org/trade/uncefact/cl-recommendations\n" ;
    $out .= " */\n" ;
    $out .= "class $class\n{\n" ;
    $out .= "    use ConstantsTrait\n    {\n        resetCaches as internalResetCaches ;\n    }\n\n" ;

    $bySection = [] ;

    foreach ( $entries as $entry )
    {
        $bySection[ $entry[ 'section' ] ][] = $entry ;
    }

    $width = 0 ;

    foreach ( $entries as $entry )
    {
        $width = max( $width , strlen( $entry[ 'constant' ] ) ) ;
    }

    foreach ( $bySection as $section => $rows )
    {
        $out .= "    // =====================================================================\n" ;
        $out .= "    // $section\n" ;
        $out .= "    // =====================================================================\n\n" ;

        foreach ( $rows as $row )
        {
            $value = str_replace( [ '\\' , "'" ] , [ '\\\\' , "\\'" ] , $row[ $field ] ) ;
            $line  = sprintf( "    public const string %-{$width}s = '%s' ;" , $row[ 'constant' ] , $value ) ;

            if ( $comment )
            {
                $line .= ' // ' . $row[ 'name' ] ;
            }

            $out .= $line . "\n" ;
        }

        $out .= "\n" ;
    }

    return $out ;
}

/**
 * Renders the lookup methods and the cache reset of one class.
 *
 * Each class caches the two sibling maps it reads through, and clears them alongside
 * the ConstantsTrait caches.
 *
 * @param string $class The class short name.
 * @return string The methods section, closing brace included.
 */
function renderMethods( string $class ): string
{
    $shapes =
    [
        'MeasureCode'   => [ [ 'Name' , 'MeasureName' , 'code' ] , [ 'Symbol' , 'MeasureSymbol' , 'code' ] ] ,
        'MeasureName'   => [ [ 'Code' , 'MeasureCode' , 'name' ] , [ 'Symbol' , 'MeasureSymbol' , 'name' ] ] ,
        'MeasureSymbol' => [ [ 'Code' , 'MeasureCode' , 'symbol' ] , [ 'Name' , 'MeasureName' , 'symbol' ] ] ,
    ] ;

    $examples = [ 'code' => "'KGM'" , 'name' => "'Kilogram'" , 'symbol' => "'kg'" ] ;
    $out      = '' ;
    $caches   = [] ;

    $out .= "    // =====================================================================\n" ;
    $out .= "    // Private\n" ;
    $out .= "    // =====================================================================\n\n" ;

    foreach ( $shapes[ $class ] as [ $what , , ] )
    {
        $caches[] = '$' . strtoupper( $what ) . 'S' ;
        $out     .= '    private static ?array $' . strtoupper( $what ) . "S = null ;\n" ;
    }

    $out .= "\n" ;
    $out .= "    // =====================================================================\n" ;
    $out .= "    // Methods\n" ;
    $out .= "    // =====================================================================\n\n" ;

    foreach ( $shapes[ $class ] as [ $what , $sibling , $input ] )
    {
        $cache = strtoupper( $what ) . 'S' ;
        $lower = strtolower( $what ) ;

        $out .= "    /**\n" ;
        $out .= "     * Returns the official UN/CEFACT $lower for a given $input.\n" ;
        $out .= "     * @param string \$$input The UN/CEFACT $input (e.g., {$examples[ $input ]}).\n" ;
        $out .= "     * @return string|null The UN/CEFACT $lower (e.g., {$examples[ $lower ]}) or null if not found.\n" ;
        $out .= "     */\n" ;
        $out .= "    public static function get$what( string \$$input ): ?string\n    {\n" ;
        $out .= "        if( static::\$$cache === null )\n        {\n" ;
        $out .= "            static::\$$cache = $sibling::getAll() ;\n        }\n" ;
        $out .= "        return static::\${$cache}[ self::getConstant( \$$input ) ] ?? null;\n" ;
        $out .= "    }\n\n" ;
    }

    foreach ( $shapes[ $class ] as [ $what , $sibling , $input ] )
    {
        $other = $what === 'Code' ? 'Code' : $what ;
        $from  = $sibling === 'MeasureCode' ? 'code' : ( $sibling === 'MeasureName' ? 'name' : 'symbol' ) ;
        $self  = $input ;

        $out .= "    /**\n" ;
        $out .= "     * Returns the $self matching a specific unit $from.\n" ;
        $out .= "     * @param string \$$from The UN/CEFACT $from (e.g., {$examples[ $from ]}).\n" ;
        $out .= "     * @return string|null The UN/CEFACT $self (e.g., {$examples[ $self ]}) or null if not found.\n" ;
        $out .= "     */\n" ;
        $out .= "    public static function getFrom$other( string \$$from ): ?string\n    {\n" ;
        $out .= "        return $sibling::get" . ucfirst( $self ) . "( \$$from ) ;\n" ;
        $out .= "    }\n\n" ;
    }

    $out .= "    /**\n     * Reset the internal cache of the static methods.\n     * @return void\n     */\n" ;
    $out .= "    public static function resetCaches(): void\n    {\n        static::internalResetCaches();\n" ;

    foreach ( $caches as $cache )
    {
        $out .= "        static::$cache = null ;\n" ;
    }

    $out .= "    }\n}\n" ;

    return $out ;
}

// ---------------------------------------------------------------------------
// Output
// ---------------------------------------------------------------------------

$classes =
[
    'MeasureCode'   => [ 'code'   , 'UN/CEFACT Unit of Measure Codes Enumeration Class (Recommendation 20).'   , true  ] ,
    'MeasureName'   => [ 'name'   , 'UN/CEFACT Unit of Measure Names Enumeration Class (Recommendation 20).'   , false ] ,
    'MeasureSymbol' => [ 'symbol' , 'UN/CEFACT Unit of Measure Symbols Enumeration Class (Recommendation 20).' , true  ] ,
] ;

echo 'UN/CEFACT Rec 20 Rev 17 — ' . count( $official ) . " official codes\n" ;
echo 'Selection               — ' . count( $entries ) . " constants\n" ;

$overrides = 0 ;

foreach ( $selection as $row )
{
    if ( $row[ 'name_override' ] !== '' || $row[ 'symbol_override' ] !== '' )
    {
        $overrides++ ;
    }
}

echo "Display overrides       — $overrides row(s) keep a non-official name or symbol\n" ;

if ( $skipped !== [] )
{
    echo 'Undecided, skipped      — ' . count( $skipped ) . ' : ' . implode( ', ' , $skipped ) . "\n" ;
}

echo "\n" ;

foreach ( $classes as $class => [ $field , $intro , $comment ] )
{
    $contents = renderClass( $class , $field , $intro , $entries , $comment ) . renderMethods( $class ) ;
    $target   = TARGET_DIR . "/$class.php" ;

    if ( $dryRun )
    {
        $current = is_file( $target ) ? file_get_contents( $target ) : '' ;
        $status  = $current === $contents ? 'unchanged' : 'would change' ;
        printf( "  %-14s %s (%d bytes)\n" , $class , $status , strlen( $contents ) ) ;
        continue ;
    }

    file_put_contents( $target , $contents ) ;
    printf( "  %-14s written (%d bytes)\n" , $class , strlen( $contents ) ) ;
}

if ( $dryRun )
{
    echo "\nDry run — nothing written.\n" ;
}
