# UNM49

> 🇫🇷 [Version française](../../../fr/standards/unstats/UNM49.md)
>
> | | |
> |---|---|
> | **Standard** | [UN M49 — Standard Country or Area Codes](https://unstats.un.org/unsd/methodology/m49/) |
> | **Namespace** | `org\unstats\UNM49` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [UNM49.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unstats/UNM49.php) |

## Overview

`UNM49` enumerates **alpha-3** country/area codes published by the UN Statistics Division (M49). These alpha-3 codes match the ISO 3166-1 alpha-3 column.

> For alpha-2 codes (`FR`, `US`, …), see [`ISO3166_1`](../iso/ISO3166_1.md).

## Sample of common constants

| Constant | Code | Country |
|---|---|---|
| `FRA` | `FRA` | France |
| `USA` | `USA` | United States |
| `GBR` | `GBR` | United Kingdom |
| `DEU` | `DEU` | Germany |
| `ESP` | `ESP` | Spain |
| `ITA` | `ITA` | Italy |
| `JPN` | `JPN` | Japan |
| `CHN` | `CHN` | China |
| `CAN` | `CAN` | Canada |
| `AUS` | `AUS` | Australia |
| `BRA` | `BRA` | Brazil |
| `RUS` | `RUS` | Russia |
| `IND` | `IND` | India |
| `MEX` | `MEX` | Mexico |
| `ZAF` | `ZAF` | South Africa |
| `KOR` | `KOR` | South Korea |
| `NLD` | `NLD` | Netherlands |

> 📋 **Full list** (~250 codes): see the [source code on GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unstats/UNM49.php).

## Inherited methods

See [ConstantsTrait](../../guides/constants-trait.md).

## Examples

```php
use org\unstats\UNM49;

UNM49::FRA;                  // "FRA"
UNM49::includes('USA');      // true
UNM49::enums();              // ['ABW', 'AFG', ..., 'ZWE']
```

### Use case — alpha-2 → alpha-3 conversion

```php
use org\iso\ISO3166_1;
use org\unstats\UNM49;

// Simple FR → FRA mapping
$alpha2to3 = [
    'FR' => UNM49::FRA,
    'US' => UNM49::USA,
    'GB' => UNM49::GBR,
    // ...
];
```

## Related

- [`ISO3166_1`](../iso/ISO3166_1.md) — alpha-2 codes

## See also

- [UN M49 — methodology](https://unstats.un.org/unsd/methodology/m49/)
- [ConstantsTrait](../../guides/constants-trait.md)
