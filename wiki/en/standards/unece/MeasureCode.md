# MeasureCode

> 🇫🇷 [Version française](../../../fr/standards/unece/MeasureCode.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommendation 20](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\MeasureCode` |
> | **Type** | Constants class (`ConstantsTrait`) with cross lookups |
> | **Source** | [MeasureCode.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureCode.php) |

## Overview

`MeasureCode` enumerates UN/CEFACT alphanumeric codes for units of measure used in international trade (`KGM` = kilogram, `MTR` = meter, etc.). It is the **master** class: it exposes lookup methods toward the mirrored classes [`MeasureName`](MeasureName.md) and [`MeasureSymbol`](MeasureSymbol.md).

## Sample of common constants

| Constant | Code | Unit |
|---|---|---|
| **Quantities** | | |
| `PIECE` | `PCE` | Piece / Each |
| `UNIT` | `C62` | Unit |
| `PAIR` | `PR` | Pair |
| `DOZEN` | `DZN` | Dozen |
| **Mass** | | |
| `GRAM` | `GRM` | Gram |
| `KILOGRAM` | `KGM` | Kilogram |
| `METRIC_TON` | `TNE` | Metric Ton |
| `MILLIGRAM` | `MGM` | Milligram |
| `OUNCE` | `OZA` | Ounce |
| `POUND` | `LBR` | Pound |
| **Length** | | |
| `CENTIMETER` | `CMT` | Centimeter |
| `METER` | `MTR` | Meter |
| `KILOMETER` | `KMT` | Kilometer |
| `MILLIMETER` | `MMT` | Millimeter |
| **Volume** | | |
| `LITER` | `LTR` | Liter |
| `MILLILITER` | `MLT` | Milliliter |
| `CUBIC_METER` | `MTQ` | Cubic meter |
| **Time** | | |
| `SECOND` | `SEC` | Second |
| `MINUTE` | `MIN` | Minute |
| `HOUR` | `HUR` | Hour |
| `DAY` | `DAY` | Day |

> 📋 **Full list** (~hundreds): see the [source code on GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureCode.php).

## Static lookup methods

| Signature | Description |
|---|---|
| `getName(string $code): ?string` | Returns the English name for the code |
| `getSymbol(string $code): ?string` | Returns the symbol for the code |
| `getFromName(string $name): ?string` | Reverse lookup from a name |
| `getFromSymbol(string $symbol): ?string` | Reverse lookup from a symbol |
| `resetCaches(): void` | Clears internal caches |

All [`ConstantsTrait`](../../guides/constants-trait.md) inherited methods (`enums()`, `includes()`, etc.) are also available.

## Examples

### Direct access

```php
use org\unece\uncefact\MeasureCode;

$code = MeasureCode::KILOGRAM;             // "KGM"
MeasureCode::includes('MTR');              // true
```

### Cross lookups

```php
use org\unece\uncefact\MeasureCode;

$code   = MeasureCode::KILOGRAM;            // "KGM"
$name   = MeasureCode::getName($code);      // "Kilogram"
$symbol = MeasureCode::getSymbol($code);    // "kg"

// Reverse lookups
MeasureCode::getFromName('Meter');          // "MTR"
MeasureCode::getFromSymbol('kg');           // "KGM"
```

### Domain use case — normalize user input

```php
use org\unece\uncefact\MeasureCode;

function normalizeMeasureCode(string $input): ?string
{
    // User may type a code, an English name, or a symbol
    if (MeasureCode::includes($input))               return $input;
    if ($code = MeasureCode::getFromName($input))    return $code;
    if ($code = MeasureCode::getFromSymbol($input))  return $code;
    return null;
}

normalizeMeasureCode('KGM');      // "KGM"
normalizeMeasureCode('Kilogram'); // "KGM"
normalizeMeasureCode('kg');       // "KGM"
normalizeMeasureCode('???');      // null
```

## Related

- [`MeasureName`](MeasureName.md) — English names
- [`MeasureSymbol`](MeasureSymbol.md) — symbols
- [`PackageCode`](PackageCode.md) — package codes (Rec. 21)
- UN/CEFACT index: [README.md](README.md)

## See also

- [UN/CEFACT Recommendation 20](https://unece.org/trade/uncefact/cl-recommendations)
- [ConstantsTrait](../../guides/constants-trait.md)
