# UNM49

> 🇬🇧 [English version](../../../en/standards/unstats/UNM49.md)
>
> | | |
> |---|---|
> | **Standard** | [UN M49 — Standard Country or Area Codes](https://unstats.un.org/unsd/methodology/m49/) |
> | **Namespace** | `org\unstats\UNM49` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [UNM49.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unstats/UNM49.php) |

## Vue d'ensemble

`UNM49` énumère les codes pays/zones **alpha-3** publiés par la Division statistique des Nations Unies (M49). Ces codes alpha-3 correspondent à la colonne ISO 3166-1 alpha-3.

> Pour les codes alpha-2 (`FR`, `US`, …), voir [`ISO3166_1`](../iso/ISO3166_1.md).

## Échantillon de constantes courantes

| Constante | Code | Pays |
|---|---|---|
| `FRA` | `FRA` | France |
| `USA` | `USA` | États-Unis |
| `GBR` | `GBR` | Royaume-Uni |
| `DEU` | `DEU` | Allemagne |
| `ESP` | `ESP` | Espagne |
| `ITA` | `ITA` | Italie |
| `JPN` | `JPN` | Japon |
| `CHN` | `CHN` | Chine |
| `CAN` | `CAN` | Canada |
| `AUS` | `AUS` | Australie |
| `BRA` | `BRA` | Brésil |
| `RUS` | `RUS` | Russie |
| `IND` | `IND` | Inde |
| `MEX` | `MEX` | Mexique |
| `ZAF` | `ZAF` | Afrique du Sud |
| `KOR` | `KOR` | Corée du Sud |
| `NLD` | `NLD` | Pays-Bas |

> 📋 **Liste complète** (~250 codes) : voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unstats/UNM49.php).

## Méthodes héritées

Voir [ConstantsTrait](../../guides/constants-trait.md).

## Exemples

```php
use org\unstats\UNM49;

UNM49::FRA;                  // "FRA"
UNM49::includes('USA');      // true
UNM49::enums();              // ['ABW', 'AFG', ..., 'ZWE']
```

### Cas d'usage — conversion alpha-2 → alpha-3

```php
use org\iso\ISO3166_1;
use org\unstats\UNM49;

// Mapping basique main FR → FRA
$alpha2to3 = [
    'FR' => UNM49::FRA,
    'US' => UNM49::USA,
    'GB' => UNM49::GBR,
    // ...
];
```

## Lié

- [`ISO3166_1`](../iso/ISO3166_1.md) — codes alpha-2

## Voir aussi

- [UN M49 — méthodologie](https://unstats.un.org/unsd/methodology/m49/)
- [ConstantsTrait](../../guides/constants-trait.md)
