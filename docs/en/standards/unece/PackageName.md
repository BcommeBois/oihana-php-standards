# PackageName

> 🇫🇷 [Version française](../../../fr/standards/unece/PackageName.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommendation 21](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\PackageName` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [PackageName.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageName.php) |

## Overview

`PackageName` enumerates English names of UN/CEFACT package types (mirror of [`PackageCode`](PackageCode.md)).

## Sample

| Constant | Name |
|---|---|
| `BOX` | `Box` |
| `CARTON` | `Carton` |
| `PALLET` | `Pallet` |
| `BAG` | `Bag` |
| `CONTAINER` | `Container` |

> 📋 **Full list**: see the [source code on GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageName.php).

## Inherited methods

See [ConstantsTrait](../../guides/constants-trait.md).

## Examples

```php
use org\unece\uncefact\PackageName;
use org\unece\uncefact\PackageCode;

PackageName::BOX;                          // "Box"
PackageName::includes('Pallet');           // true

// Reverse lookup via PackageCode
PackageCode::getFromName(PackageName::BOX); // "BX"
```

## Related

- [`PackageCode`](PackageCode.md) — codes (master)
- UN/CEFACT index: [README.md](README.md)

## See also

- [ConstantsTrait](../../guides/constants-trait.md)
