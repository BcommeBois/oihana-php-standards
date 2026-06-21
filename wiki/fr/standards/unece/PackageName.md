# PackageName

> 🇬🇧 [English version](../../../en/standards/unece/PackageName.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommandation 21](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\PackageName` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [PackageName.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageName.php) |

## Vue d'ensemble

`PackageName` énumère les noms anglais des types d'emballage UN/CEFACT (mirror de [`PackageCode`](PackageCode.md)).

## Échantillon

| Constante | Nom |
|---|---|
| `BOX` | `Box` |
| `CARTON` | `Carton` |
| `PALLET` | `Pallet` |
| `BAG` | `Bag` |
| `CONTAINER` | `Container` |

> 📋 **Liste complète** : voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageName.php).

## Méthodes héritées

Voir [ConstantsTrait](../../guides/constants-trait.md).

## Exemples

```php
use org\unece\uncefact\PackageName;
use org\unece\uncefact\PackageCode;

PackageName::BOX;                          // "Box"
PackageName::includes('Pallet');           // true

// Recherche inverse via PackageCode
PackageCode::getFromName(PackageName::BOX); // "BX"
```

## Lié

- [`PackageCode`](PackageCode.md) — codes (master)
- Index UN/CEFACT : [README.md](README.md)

## Voir aussi

- [ConstantsTrait](../../guides/constants-trait.md)
