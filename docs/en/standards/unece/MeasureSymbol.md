# MeasureSymbol

> 🇫🇷 [Version française](../../../fr/standards/unece/MeasureSymbol.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommendation 20](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\MeasureSymbol` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [MeasureSymbol.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureSymbol.php) |

## Overview

`MeasureSymbol` enumerates unit symbols (mirror of [`MeasureCode`](MeasureCode.md)). Symbols are the commonly used notations (`kg`, `m`, `L`, etc.).

## Sample

| Constant | Symbol |
|---|---|
| `KILOGRAM` | `kg` |
| `METER` | `m` |
| `LITER` | `L` |
| `SECOND` | `s` |

> 📋 **Full list**: see the [source code on GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureSymbol.php).

## Inherited methods

See [ConstantsTrait](../../guides/constants-trait.md).

## Examples

```php
use org\unece\uncefact\MeasureSymbol;
use org\unece\uncefact\MeasureCode;

MeasureSymbol::KILOGRAM;                 // "kg"
MeasureSymbol::includes('m');            // true

// Lookup to the code via MeasureCode
MeasureCode::getFromSymbol('kg');        // "KGM"
```

## Related

- [`MeasureCode`](MeasureCode.md) — alphanumeric codes (master)
- [`MeasureName`](MeasureName.md) — English names
- UN/CEFACT index: [README.md](README.md)

## See also

- [ConstantsTrait](../../guides/constants-trait.md)
