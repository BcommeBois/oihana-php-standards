# PackageCode

> 🇫🇷 [Version française](../../../fr/standards/unece/PackageCode.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommendation 21](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\PackageCode` |
> | **Type** | Constants class (`ConstantsTrait`) with cross lookups |
> | **Source** | [PackageCode.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageCode.php) |

## Overview

`PackageCode` enumerates UN/CEFACT alphanumeric codes for **package types** used in international logistics (`BX` = Box, `CT` = Carton, etc.). It is the master class; it exposes lookup methods toward [`PackageName`](PackageName.md).

## Sample of common constants

| Constant | Code | Type |
|---|---|---|
| `BAG` | `BG` | Bag |
| `BARREL` | `BA` | Barrel |
| `BASKET` | `BK` | Basket |
| `BOX` | `BX` | Box |
| `BOTTLE` | `BO` | Bottle |
| `CARTON` | `CT` | Carton |
| `CASE` | `CS` | Case |
| `CONTAINER` | `CN` | Container |
| `CRATE` | `CR` | Crate |
| `DRUM` | `DR` | Drum |
| `PALLET` | `PX` | Pallet |
| `ROLL` | `RO` | Roll |
| `TANK` | `TK` | Tank |
| `TUBE` | `TU` | Tube |

> 📋 **Full list**: see the [source code on GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageCode.php).

## Static lookup methods

| Signature | Description |
|---|---|
| `getName(string $code): ?string` | Returns the English name for the code |
| `getFromName(string $name): ?string` | Reverse lookup from a name |
| `resetCaches(): void` | Clears internal caches |

Plus all inherited [`ConstantsTrait`](../../guides/constants-trait.md) methods.

## Examples

### Access and lookups

```php
use org\unece\uncefact\PackageCode;

PackageCode::BOX;                          // "BX"
PackageCode::includes('CT');               // true

// Cross lookups
PackageCode::getName('BX');                // "Box"
PackageCode::getFromName('Pallet');        // "PX"
```

### Domain use case — package labeling

```php
use org\unece\uncefact\PackageCode;

function packageLabel(string $code, int $qty): string
{
    $name = PackageCode::getName($code);
    if ($name === null)
    {
        throw new \InvalidArgumentException("Unknown package code: $code");
    }
    return "$qty × $name ($code)";
}

packageLabel(PackageCode::BOX, 24); // "24 × Box (BX)"
```

## Related

- [`PackageName`](PackageName.md) — English names
- [`MeasureCode`](MeasureCode.md) — units of measure (Rec. 20)
- UN/CEFACT index: [README.md](README.md)

## See also

- [UN/CEFACT Recommendation 21](https://unece.org/trade/uncefact/cl-recommendations)
- [ConstantsTrait](../../guides/constants-trait.md)
