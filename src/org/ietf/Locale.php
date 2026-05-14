<?php

namespace org\ietf;

use InvalidArgumentException;

use function org\ietf\helpers\isLocale;
use function org\ietf\helpers\parseLocaleTag;

/**
 * Represents and manipulates IETF BCP 47 / RFC 5646 locale tags.
 *
 * Combines ISO 639-1 (language), ISO 15924 (script) and ISO 3166-1 (region)
 * codes in a single value-object. Supports the minimal grammar:
 * `language[-script][-region][-variant…][-x-private…]`.
 *
 * Two validation levels are available:
 * - **Tolerant** (default): only the BCP 47 syntax is checked.
 * - **Strict** : components are cross-validated against the ISO classes
 *   ({@see \org\iso\ISO639_1}, {@see \org\iso\ISO15924},
 *   {@see \org\iso\ISO3166_1}).
 *
 * Subtags are normalized to canonical case on input: language lowercase,
 * script Titlecase, region uppercase, variants lowercase.
 *
 * Example usage:
 * ```php
 * use org\ietf\Locale;
 *
 * $l = new Locale('fr-FR');
 * echo $l->language; // "fr"
 * echo $l->region;   // "FR"
 *
 * $l = new Locale('zh-Hant-TW');
 * echo $l->script;   // "Hant"
 *
 * $l = new Locale('en-x-pig-latin');
 * echo $l->privateUse; // "x-pig-latin"
 *
 * // Strict mode rejects unknown ISO codes
 * new Locale('zz-ZZ', strict: true); // throws InvalidArgumentException
 *
 * // Tolerant mode still allows checking ISO compliance on demand
 * $tolerant = new Locale('zz-ZZ');
 * $tolerant->isStrict(); // false
 * ```
 *
 * @link https://www.rfc-editor.org/rfc/rfc5646 BCP 47 / RFC 5646
 *
 * @package org\ietf
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class Locale
{
    /**
     * Creates a new Locale instance.
     *
     * @param string|null $tag    BCP 47 locale tag, or null for the {@see ZERO} default
     * @param bool        $strict If true, cross-validate against ISO classes (default: false)
     *
     * @throws InvalidArgumentException If the tag is invalid (or fails strict validation)
     */
    public function __construct( ?string $tag = null , bool $strict = false )
    {
        $this->_strict = $strict ;
        $this->tag     = $tag ?? self::ZERO ;
    }

    /**
     * Subtag separator.
     */
    public const string SEPARATOR = '-' ;

    /**
     * Default zero value: ISO 639-2 `und` (undetermined language).
     */
    public const string ZERO = 'und' ;

    /**
     * The canonical BCP 47 tag (e.g. `fr-FR`, `zh-Hant-TW`).
     *
     * @throws InvalidArgumentException If the value is not a valid tag (or fails strict validation if enabled)
     */
    public string $tag
    {
        get => $this->_tag ;
        set
        {
            if ( !isLocale( $value , $this->_strict ) )
            {
                $hint = $this->_strict ? ' (strict ISO validation)' : '' ;
                throw new InvalidArgumentException( "Invalid BCP 47 locale tag$hint: $value" ) ;
            }

            $parsed = parseLocaleTag( $value ) ;

            $this->_language   = $parsed[ 'language' ] ;
            $this->_script     = $parsed[ 'script' ] ;
            $this->_region     = $parsed[ 'region' ] ;
            $this->_variants   = $parsed[ 'variants' ] ;
            $this->_privateUse = $parsed[ 'privateUse' ] ;

            // Canonical re-serialization (normalizes case)
            $this->_tag = $this->serialize() ;
        }
    }

    /**
     * Language subtag (e.g. `fr`). Lowercase.
     */
    public string $language
    {
        get => $this->_language ;
    }

    /**
     * Optional script subtag (e.g. `Hant`). Titlecase, or null.
     */
    public ?string $script
    {
        get => $this->_script ;
    }

    /**
     * Optional region subtag (2 letters uppercase, or 3 digits, or null).
     */
    public ?string $region
    {
        get => $this->_region ;
    }

    /**
     * List of variant subtags (e.g. `["1996"]`). Lowercase. Empty array if none.
     *
     * @var array<int,string>
     */
    public array $variants
    {
        get => $this->_variants ;
    }

    /**
     * Optional private-use subtag (e.g. `x-pig-latin`), or null.
     */
    public ?string $privateUse
    {
        get => $this->_privateUse ;
    }

    /**
     * Returns true when the components cross-validate against the ISO classes
     * (regardless of the strict mode used at construction).
     */
    public function isStrict(): bool
    {
        return isLocale( $this->_tag , true ) ;
    }

    /**
     * String cast returns the canonical tag.
     */
    public function __toString(): string
    {
        return $this->_tag ;
    }

    // --------------------- INTERNALS ---------------------

    /**
     * Re-assembles the canonical tag from the parsed components.
     */
    private function serialize(): string
    {
        $parts = [ $this->_language ] ;
        if ( $this->_script !== null )
        {
            $parts[] = $this->_script ;
        }
        if ( $this->_region !== null )
        {
            $parts[] = $this->_region ;
        }
        foreach ( $this->_variants as $v )
        {
            $parts[] = $v ;
        }
        $tag = implode( self::SEPARATOR , $parts ) ;
        if ( $this->_privateUse !== null )
        {
            $tag .= self::SEPARATOR . $this->_privateUse ;
        }
        return $tag ;
    }

    /**
     * @var string
     */
    private string $_tag ;

    /**
     * @var string
     */
    private string $_language ;

    /**
     * @var string|null
     */
    private ?string $_script = null ;

    /**
     * @var string|null
     */
    private ?string $_region = null ;

    /**
     * @var array<int,string>
     */
    private array $_variants = [] ;

    /**
     * @var string|null
     */
    private ?string $_privateUse = null ;

    /**
     * @var bool
     */
    private bool $_strict ;
}
