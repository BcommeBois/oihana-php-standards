<?php

namespace org\common;

use oihana\reflect\traits\ConstantsTrait;

/**
 * Common number formatting separators and symbols.
 *
 * Provides the building blocks needed to format numbers per regional
 * conventions. The constants are designed to be passed straight to PHP's
 * {@see number_format()} (decimal separator + thousands separator), but can
 * be used anywhere a single separator or symbol is needed.
 *
 * Notation summary:
 * - **EU**: comma decimal, dot thousands — `1.234.567,89` (DE, IT, ES, NL…)
 * - **US**: dot decimal, comma thousands — `1,234,567.89` (US, UK, JP, CN…)
 * - **FR**: comma decimal, narrow no-break space thousands — `1 234 567,89` (FR, per typographic rules)
 * - **CH**: dot decimal, apostrophe thousands — `1'234'567.89` (Switzerland)
 *
 * Example usage:
 * ```php
 * use org\common\NumberFormat;
 *
 * echo number_format(1234567.89, 2,
 *     NumberFormat::DECIMAL_SEP_EU,
 *     NumberFormat::THOUSANDS_SEP_EU
 * ); // "1.234.567,89"
 *
 * echo number_format(1234567.89, 2,
 *     NumberFormat::DECIMAL_SEP_FR,
 *     NumberFormat::THOUSANDS_SEP_FR
 * ); // "1 234 567,89" (with narrow no-break space)
 *
 * NumberFormat::includes(',');         // true
 * NumberFormat::getConstant('%');      // "PERCENT_SYMBOL"
 * ```
 *
 * @package org\common
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class NumberFormat
{
    use ConstantsTrait ;

    /**
     * Decimal separator — European convention: comma (`,`).
     */
    public const string DECIMAL_SEP_EU = ',' ;

    /**
     * Decimal separator — US/UK/Asia convention: dot (`.`).
     */
    public const string DECIMAL_SEP_US = '.' ;

    /**
     * Decimal separator — French convention: comma (`,`).
     */
    public const string DECIMAL_SEP_FR = ',' ;

    /**
     * Decimal separator — Swiss convention: dot (`.`).
     */
    public const string DECIMAL_SEP_CH = '.' ;

    /**
     * Thousands separator — European convention: dot (`.`).
     */
    public const string THOUSANDS_SEP_EU = '.' ;

    /**
     * Thousands separator — US/UK/Asia convention: comma (`,`).
     */
    public const string THOUSANDS_SEP_US = ',' ;

    /**
     * Thousands separator — French convention: narrow no-break space (U+202F).
     */
    public const string THOUSANDS_SEP_FR = "\u{202F}" ;

    /**
     * Thousands separator — Swiss convention: apostrophe (`'`).
     */
    public const string THOUSANDS_SEP_CH = "'" ;

    /**
     * No thousands separator (empty string).
     */
    public const string THOUSANDS_SEP_NONE = '' ;

    /**
     * Scientific notation exponent marker, lowercase (`e`), as in `1.23e+45`.
     */
    public const string SCIENTIFIC_E_LOWER = 'e' ;

    /**
     * Scientific notation exponent marker, uppercase (`E`), as in `1.23E+45`.
     */
    public const string SCIENTIFIC_E_UPPER = 'E' ;

    /**
     * Percent sign (`%`).
     */
    public const string PERCENT_SYMBOL = '%' ;

    /**
     * Per-mille sign (`‰`, U+2030).
     */
    public const string PERMILLE_SYMBOL = '‰' ;

    /**
     * Infinity symbol (`∞`, U+221E).
     */
    public const string INFINITY = '∞' ;

    /**
     * Negative infinity (`-∞`).
     */
    public const string NEGATIVE_INFINITY = '-∞' ;

    /**
     * "Not a Number" symbol (`NaN`).
     */
    public const string NAN_SYMBOL = 'NaN' ;
}
