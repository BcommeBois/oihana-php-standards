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

    /**
     * Albanian (bibliographic; terminologic equivalent: `sqi`).
     */
    public const string ALB = 'alb';

    /**
     * Armenian (bibliographic; terminologic equivalent: `hye`).
     */
    public const string ARM = 'arm';

    /**
     * Basque (bibliographic; terminologic equivalent: `eus`).
     */
    public const string BAQ = 'baq';

    /**
     * Burmese (bibliographic; terminologic equivalent: `mya`).
     */
    public const string BUR = 'bur';

    /**
     * Chinese (bibliographic; terminologic equivalent: `zho`).
     */
    public const string CHI = 'chi';

    /**
     * Czech (bibliographic; terminologic equivalent: `ces`).
     */
    public const string CZE = 'cze';

    /**
     * Dutch; Flemish (bibliographic; terminologic equivalent: `nld`).
     */
    public const string DUT = 'dut';

    /**
     * French (bibliographic; terminologic equivalent: `fra`).
     */
    public const string FRE = 'fre';

    /**
     * Georgian (bibliographic; terminologic equivalent: `kat`).
     */
    public const string GEO = 'geo';

    /**
     * German (bibliographic; terminologic equivalent: `deu`).
     */
    public const string GER = 'ger';

    /**
     * Modern Greek (1453-) (bibliographic; terminologic equivalent: `ell`).
     */
    public const string GRE = 'gre';

    /**
     * Icelandic (bibliographic; terminologic equivalent: `isl`).
     */
    public const string ICE = 'ice';

    /**
     * Macedonian (bibliographic; terminologic equivalent: `mkd`).
     */
    public const string MAC = 'mac';

    /**
     * Maori (bibliographic; terminologic equivalent: `mri`).
     */
    public const string MAO = 'mao';

    /**
     * Malay (bibliographic; terminologic equivalent: `msa`).
     */
    public const string MAY = 'may';

    /**
     * Persian (bibliographic; terminologic equivalent: `fas`).
     */
    public const string PER = 'per';

    /**
     * Romanian; Moldavian; Moldovan (bibliographic; terminologic equivalent: `ron`).
     */
    public const string RUM = 'rum';

    /**
     * Slovak (bibliographic; terminologic equivalent: `slk`).
     */
    public const string SLO = 'slo';

    /**
     * Tibetan (bibliographic; terminologic equivalent: `bod`).
     */
    public const string TIB = 'tib';

    /**
     * Welsh (bibliographic; terminologic equivalent: `cym`).
     */
    public const string WEL = 'wel';

    /**
     * Returns the full map from bibliographic to terminologic alpha-3 codes.
     *
     * @return array<string, string>
     */
    public static function getBibliographicToTerminologicMap(): array
    {
        return self::$map ??= [
            'alb' => 'sqi',
            'arm' => 'hye',
            'baq' => 'eus',
            'bur' => 'mya',
            'chi' => 'zho',
            'cze' => 'ces',
            'dut' => 'nld',
            'fre' => 'fra',
            'geo' => 'kat',
            'ger' => 'deu',
            'gre' => 'ell',
            'ice' => 'isl',
            'mac' => 'mkd',
            'mao' => 'mri',
            'may' => 'msa',
            'per' => 'fas',
            'rum' => 'ron',
            'slo' => 'slk',
            'tib' => 'bod',
            'wel' => 'cym',
        ];
    }

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
}
