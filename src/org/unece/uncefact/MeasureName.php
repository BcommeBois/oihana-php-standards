<?php

namespace org\unece\uncefact;

use oihana\reflect\traits\ConstantsTrait;

/**
 * UN/CEFACT Unit of Measure Names Enumeration Class (Recommendation 20).
 *
 * This class provides an extended selection of the most commonly used codes
 * across various commercial and logistical contexts.
 *
 * It mirrors {@see MeasureCode} and {@see MeasureSymbol} : the three classes declare
 * the same constant names, which is what the cross lookups below rely on.
 *
 * For an exhaustive list and official documentation, please consult:
 * @see https://unece.org/trade/uncefact/cl-recommendations
 * @example
 * ```php
 * use org\unece\uncefact\MeasureCode;
 * use org\unece\uncefact\MeasureName;
 * use org\unece\uncefact\MeasureSymbol;
 *
 * MeasureName::PERCENT ; // 'Percent'
 *
 * MeasureName::getCode  ( MeasureName::PERCENT ) ; // 'PC1'
 * MeasureName::getSymbol( MeasureName::PERCENT ) ; // '%'
 *
 * MeasureName::getFromCode  ( MeasureCode::PERCENT   ) ; // 'Percent'
 * MeasureName::getFromSymbol( MeasureSymbol::PERCENT ) ; // 'Percent'
 * ```
 */
class MeasureName
{
    use ConstantsTrait
    {
        resetCaches as internalResetCaches ;
    }

    // =====================================================================
    // Quantity Units
    // =====================================================================

    public const string PIECE     = 'Piece' ;
    public const string UNIT      = 'Unit' ; // "Each" ou "Unit"
    public const string PAIR      = 'Pair' ;
    public const string DOZEN     = 'Dozen' ;
    public const string GROSS     = 'Gross' ;
    public const string HUNDRED   = 'Hundred' ;
    public const string THOUSAND  = 'Thousand' ;
    public const string TEN_PAIRS = 'Ten Pairs' ;

    // =====================================================================
    // Mass Units (Weight)
    // =====================================================================

    public const string KILOGRAM   = 'Kilogram';
    public const string GRAM       = 'Gram';
    public const string MILLIGRAM  = 'Milligram';
    public const string METRIC_TON = 'Metric Ton';
    public const string POUND      = 'Pound';
    public const string OUNCE      = 'Ounce';
    public const string CARAT      = 'Carat';

    // =====================================================================
    // Length Units
    // =====================================================================

    public const string METER      = 'Meter' ;
    public const string CENTIMETER = 'Centimeter' ;
    public const string HECTOMETER = 'Hectometer' ;
    public const string MILLIMETER = 'Millimeter' ;
    public const string KILOMETER  = 'Kilometer' ;
    public const string INCH       = 'Inch' ;
    public const string FOOT       = 'Foot' ;
    public const string YARD       = 'Yard' ;
    public const string MILE       = 'Mile' ;

    // =====================================================================
    // Area Units
    // =====================================================================

    public const string ACRE              = 'Acre';
    public const string ACRE_FOOT         = 'Acre-Foot'; // Note: This is typically a volume unit.
    public const string HECTARE           = 'Hectare';
    public const string SQUARE_CENTIMETER = 'Square Centimeter';
    public const string SQUARE_DECIMETER  = 'Square Decimeter';
    public const string SQUARE_FOOT       = 'Square Foot';
    public const string SQUARE_INCH       = 'Square Inch';
    public const string SQUARE_KILOMETER  = 'Square Kilometer';
    public const string SQUARE_METER      = 'Square Meter';
    public const string SQUARE_MILLIMETER = 'Square Millimeter';
    public const string SQUARE_MILE       = 'Square Mile';
    public const string SQUARE_YARD       = 'Square Yard';

    // =====================================================================
    // Volume Units
    // =====================================================================

    public const string BARREL           = 'Barrel';
    public const string CENTILITRE       = 'Centilitre' ;
    public const string CUBIC_FOOT       = 'Cubic Foot';
    public const string CUBIC_METER      = 'Cubic Meter';
    public const string CUBIC_CENTIMETER = 'Cubic Centimeter';
    public const string CUBIC_DECIMETER  = 'Cubic Decimeter';
    public const string IMPERIAL_GALLON  = 'Imperial Gallon';
    public const string LITER            = 'Liter';
    public const string MILLILITER       = 'Milliliter';
    public const string US_GALLON        = 'US Gallon';

    // =====================================================================
    // Time Units
    // =====================================================================

    public const string DAY    = 'Day'    ;
    public const string HOUR   = 'Hour'   ;
    public const string MINUTE = 'Minute' ;
    public const string SECOND = 'Second' ;
    public const string MONTH  = 'Month'  ;
    public const string YEAR   = 'Year'   ;
    public const string WEEK   = 'Week'   ;

    // =====================================================================
    //  Percentage and Ratio Units
    // =====================================================================

    public const string PERCENT           = 'Percent' ;
    public const string PER_THOUSAND      = 'Per Thousand' ;
    public const string PARTS_PER_MILLION = 'Parts Per Million' ;

    // =====================================================================
    // Energy Units
    // =====================================================================

    public const string CALORIE       = 'Calorie' ;
    public const string JOULE         = 'Joule' ;
    public const string KILOCALORIE   = 'Kilocalorie' ;
    public const string KILOJOULE     = 'Kilojoule' ;
    public const string KILOWATT_HOUR = 'Kilowatt-Hour' ;

    // =====================================================================
    // Pressure Units
    // =====================================================================

    public const string PASCAL                = 'Pascal';
    public const string BAR                   = 'Bar';
    public const string MILLIBAR              = 'Millibar';
    public const string POUND_PER_SQUARE_INCH = 'Pound per Square Inch';

    // =====================================================================
    // Temperature Units
    // =====================================================================

    public const string CELSIUS    = 'Degree Celsius';
    public const string FAHRENHEIT = 'Degree Fahrenheit';
    public const string KELVIN     = 'Kelvin';

    // =====================================================================
    // Generic / Dimensionless Units & Factors
    // =====================================================================

    public const string COUNT           = 'Count';
    // public const string DIMENSION_LESS  = 'Dimensionless'; // Use UNIT
    public const string NUMBER          = 'Number';
    public const string RATIO           = 'Ratio';
    public const string UNIT_OF_CAPITAL = 'Unit of Capital';
    public const string SCORE           = 'Score';
    public const string POINT           = 'Point';

    // =====================================================================
    // Degrees Units
    // =====================================================================

    public const string ANGULAR = 'Angular Degree';
    public const string RADIAN  = 'Radian';

    // =====================================================================
    // Density Units
    // =====================================================================

    public const string KILOGRAM_PER_CUBIC_METER = 'Kilogram per cubic metre';

    // =====================================================================
    // Common Miscellaneous Units
    // =====================================================================

    public const string AMPERE                = 'Ampere';
    public const string BECQUEREL             = 'Becquerel';
    public const string BIT                   = 'Bit';
    public const string BYTE                  = 'Byte';
    public const string COULOMB               = 'Coulomb';
    public const string DECIBEL               = 'Decibel';
    public const string FARAD                 = 'Farad';
    public const string GIGABYTE              = 'Gigabyte';
    public const string GRAY                  = 'Gray';
    public const string HENRY                 = 'Henry';
    public const string HERTZ                 = 'Hertz';
    public const string KILOHERTZ             = 'Kilohertz';
    public const string KILOBYTE              = 'Kilobyte';
    public const string KILOWATT              = 'Kilowatt';
    public const string LUMEN                 = 'Lumen';
    public const string LUX                   = 'Lux';
    public const string MEGAHERTZ             = 'Megahertz';
    public const string MEGABYTE              = 'Megabyte';
    public const string NEWTON                = 'Newton';
    public const string OHM                   = 'Ohm';
    public const string POUND_FORCE           = 'Pound-force';
    public const string REVOLUTION_PER_MINUTE = 'Revolution per Minute';
    public const string SIEVERT               = 'Sievert';
    public const string SIEMENS               = 'Siemens';
    public const string TESLA                 = 'Tesla';
    public const string VOLT                  = 'Volt';
    public const string WATT                  = 'Watt';
    public const string WEBER                 = 'Weber';

    // =====================================================================
    // Private
    // =====================================================================

    private static ?array $CODES   = null ;
    private static ?array $SYMBOLS = null ;

    // =====================================================================
    // Methods
    // =====================================================================

    /**
     * Returns the official UN/CEFACT code for a given name.
     * @param string $name The UN/CEFACT name (e.g., 'Kilogram').
     * @return string|null The UN/CEFACT code (e.g., 'KGM') or null if not found.
     */
    public static function getCode( string $name ): ?string
    {
        if( static::$CODES === null )
        {
            static::$CODES = MeasureCode::getAll() ;
        }
        return static::$CODES[ self::getConstant( $name ) ] ?? null;
    }

    /**
     * Returns the name matching a specific unit code.
     * @param string $code The UN/CEFACT code (e.g., 'KGM').
     * @return string|null The UN/CEFACT name (e.g., 'Kilogram') or null if not found.
     */
    public static function getFromCode( string $code ): ?string
    {
        return MeasureCode::getName( $code ) ;
    }

    /**
     * Returns the name matching a specific unit symbol.
     * @param string $symbol The UN/CEFACT symbol (e.g., 'kg').
     * @return string|null The UN/CEFACT name (e.g., 'Kilogram') or null if not found.
     */
    public static function getFromSymbol( string $symbol ): ?string
    {
        return MeasureSymbol::getName( $symbol ) ;
    }

    /**
     * Returns the official UN/CEFACT symbol for a given name.
     * @param string $name The UN/CEFACT name (e.g., 'Kilogram').
     * @return string|null The UN/CEFACT symbol (e.g., 'kg') or null if not found.
     */
    public static function getSymbol( string $name ): ?string
    {
        if( static::$SYMBOLS === null )
        {
            static::$SYMBOLS = MeasureSymbol::getAll() ;
        }
        return static::$SYMBOLS[ self::getConstant( $name ) ] ?? null;
    }

    /**
     * Reset the internal cache of the static methods.
     * @return void
     */
    public static function resetCaches(): void
    {
        static::internalResetCaches();
        static::$CODES   = null ;
        static::$SYMBOLS = null ;
    }
}