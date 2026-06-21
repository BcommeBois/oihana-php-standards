# MeasureName

> 🇫🇷 [Version française](../../../fr/standards/unece/MeasureName.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommendation 20](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\MeasureName` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [MeasureName.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureName.php) |

## Overview

`MeasureName` enumerates English names of UN/CEFACT units of measure (mirror of [`MeasureCode`](MeasureCode.md)). Names are stored in English (`Kilogram`, `Meter`, etc.).

## Sample

| Constant | Name |
|---|---|
| `KILOGRAM` | `Kilogram` |
| `METER` | `Meter` |
| `LITER` | `Liter` |
| `SECOND` | `Second` |
| `PIECE` | `Piece / Each` |

> 📋 **Full list**: see the [source code on GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureName.php).

## Inherited methods

See [ConstantsTrait](../../guides/constants-trait.md).

## Examples

```php
use org\unece\uncefact\MeasureName;
use org\unece\uncefact\MeasureCode;

MeasureName::KILOGRAM;                 // "Kilogram"
MeasureName::includes('Meter');        // true

// Lookup to the code via MeasureCode
MeasureCode::getFromName(MeasureName::KILOGRAM); // "KGM"
```

## Related

- [`MeasureCode`](MeasureCode.md) — alphanumeric codes (master)
- [`MeasureSymbol`](MeasureSymbol.md) — symbols
- UN/CEFACT index: [README.md](README.md)

## See also

- [ConstantsTrait](../../guides/constants-trait.md)
