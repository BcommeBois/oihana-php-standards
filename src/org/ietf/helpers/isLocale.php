<?php

namespace org\ietf\helpers;

use org\iso\ISO15924;
use org\iso\ISO3166_1;
use org\iso\ISO639_1;
use org\unstats\UNM49Numeric;

/**
 * Validates whether a string is a valid IETF BCP 47 / RFC 5646 locale tag.
 *
 * Recognized minimal grammar:
 * `language[-script][-region][-variant...][-x-private...]`
 *
 * - language: 2 or 3 letters (e.g. `fr`, `en`, `und`)
 * - script:   4 letters (e.g. `Latn`, `Hant`)
 * - region:   2 letters (ISO 3166-1) or 3 digits (UN M49)
 * - variant:  5–8 alphanumerics, or a digit followed by 3 alphanumerics (e.g. `1996`, `scotland`)
 * - private:  `x-` followed by one or more 1–8 alphanumeric subtags
 *
 * Case is normalized (subtags are case-insensitive in BCP 47). Extlangs,
 * Unicode/transformation extensions (`-u-`, `-t-`) and grandfathered tags are
 * intentionally **not** supported in this minimal implementation.
 *
 * When `$strict` is true, the parsed components are cross-validated against
 * the existing standards classes:
 * - `language` (2 letters)  → {@see ISO639_1}
 * - `script`                 → {@see ISO15924}
 * - `region`   (2 letters)  → {@see ISO3166_1}
 * - `region`   (3 digits)   → {@see UNM49Numeric}
 *
 * 3-letter languages are not cross-validated (ISO 639-2/3 classes are not
 * available yet — see the future `org\iso\ISO639_2` and `org\iso\ISO639_5`).
 *
 * @param string $tag    The locale tag to validate
 * @param bool   $strict If true, cross-validate against ISO classes (default: false)
 *
 * @return bool True if the tag is a valid BCP 47 locale, false otherwise
 *
 * @example
 * ```php
 * isLocale('fr-FR');                  // true
 * isLocale('zh-Hant-TW');             // true
 * isLocale('de-CH-1996');             // true
 * isLocale('en-x-pig-latin');         // true (private use)
 * isLocale('zz-ZZ');                  // true (syntax OK)
 * isLocale('zz-ZZ', strict: true);    // false (zz is not in ISO 639-1)
 * isLocale('fr-FR', strict: true);    // true
 * isLocale('');                       // false
 * ```
 *
 * @link https://www.rfc-editor.org/rfc/rfc5646 BCP 47 / RFC 5646
 *
 * @package org\ietf\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function isLocale( string $tag , bool $strict = false ): bool
{
    $parsed = parseLocaleTag( $tag ) ;
    if ( $parsed === null )
    {
        return false ;
    }

    if ( !$strict )
    {
        return true ;
    }

    // Language: 2 letters → ISO 639-1 ; 3 letters → not validated
    if ( strlen( $parsed[ 'language' ] ) === 2 && !ISO639_1::includes( $parsed[ 'language' ] ) )
    {
        return false ;
    }

    if ( $parsed[ 'script' ] !== null && !ISO15924::includes( $parsed[ 'script' ] ) )
    {
        return false ;
    }

    // Region: 2 letters → ISO 3166-1 ; 3 digits → UN M49 numeric
    if ( $parsed[ 'region' ] !== null )
    {
        if ( ctype_alpha( $parsed[ 'region' ] ) && !ISO3166_1::includes( $parsed[ 'region' ] ) )
        {
            return false ;
        }

        if ( ctype_digit( $parsed[ 'region' ] ) && !UNM49Numeric::includes( $parsed[ 'region' ] ) )
        {
            return false ;
        }
    }

    return true ;
}

/**
 * Parses a BCP 47 locale tag into its canonical components.
 *
 * Returns an associative array with keys `language`, `script`, `region`,
 * `variants` (array), `privateUse` (full `x-...` string or null). Returns
 * `null` if the input does not match the supported grammar.
 *
 * Subtags are normalized to canonical case:
 * - language → lowercase
 * - script   → Titlecase
 * - region   → uppercase
 * - variants → lowercase
 *
 * @param string $tag The locale tag to parse
 *
 * @return array|null :?string,region:?string,variants:array<int,string>,privateUse:?string}|null
 *
 * @package org\ietf\helpers
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
function parseLocaleTag( string $tag ): ?array
{
    if ( $tag === '' )
    {
        return null ;
    }

    $parts = explode( '-' , $tag ) ;
    $count = count( $parts ) ;
    $i     = 0 ;

    // language: 2 or 3 letters
    if ( !isset( $parts[ $i ] ) || !preg_match( '/^[a-zA-Z]{2,3}$/' , $parts[ $i ] ) )
    {
        return null ;
    }
    $language = strtolower( $parts[ $i ] ) ;
    $i++ ;

    $script = null ;
    if ( isset( $parts[ $i ] ) && preg_match( '/^[a-zA-Z]{4}$/' , $parts[ $i ] ) )
    {
        $script = ucfirst( strtolower( $parts[ $i ] ) ) ;
        $i++ ;
    }

    $region = null ;
    if ( isset( $parts[ $i ] ) && preg_match( '/^([a-zA-Z]{2}|\d{3})$/' , $parts[ $i ] ) )
    {
        $region = ctype_alpha( $parts[ $i ] ) ? strtoupper( $parts[ $i ] ) : $parts[ $i ] ;
        $i++ ;
    }

    $variants = [] ;
    while ( isset( $parts[ $i ] ) && strtolower( $parts[ $i ] ) !== 'x'
        && preg_match( '/^([a-zA-Z0-9]{5,8}|\d[a-zA-Z0-9]{3})$/' , $parts[ $i ] ) )
    {
        $variants[] = strtolower( $parts[ $i ] ) ;
        $i++ ;
    }

    $privateUse = null ;
    if ( isset( $parts[ $i ] ) && strtolower( $parts[ $i ] ) === 'x' )
    {
        $i++ ;
        $privateParts = [] ;
        while ( isset( $parts[ $i ] ) && preg_match( '/^[a-zA-Z0-9]{1,8}$/' , $parts[ $i ] ) )
        {
            $privateParts[] = strtolower( $parts[ $i ] ) ;
            $i++ ;
        }
        if ( empty( $privateParts ) )
        {
            return null ; // dangling 'x' with no subtag
        }
        $privateUse = 'x-' . implode( '-' , $privateParts ) ;
    }

    if ( $i !== $count )
    {
        return null ; // leftover unrecognized subtags
    }

    return [
        'language'   => $language ,
        'script'     => $script ,
        'region'     => $region ,
        'variants'   => $variants ,
        'privateUse' => $privateUse ,
    ] ;
}
