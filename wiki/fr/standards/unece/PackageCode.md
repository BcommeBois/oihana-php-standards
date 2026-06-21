# PackageCode

> 🇬🇧 [English version](../../../en/standards/unece/PackageCode.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommandation 21](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\PackageCode` |
> | **Type** | Classe de constantes (`ConstantsTrait`) avec lookups croisés |
> | **Source** | [PackageCode.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageCode.php) |

## Vue d'ensemble

`PackageCode` énumère les codes alphanumériques UN/CEFACT pour les **types d'emballage** utilisés en logistique internationale (`BX` = Box, `CT` = Carton, etc.). C'est la classe maître ; elle expose des méthodes de lookup vers [`PackageName`](PackageName.md).

## Échantillon de constantes courantes

| Constante | Code | Type |
|---|---|---|
| `BAG` | `BG` | Sac |
| `BARREL` | `BA` | Baril |
| `BASKET` | `BK` | Panier |
| `BOX` | `BX` | Boîte |
| `BOTTLE` | `BO` | Bouteille |
| `CARTON` | `CT` | Carton |
| `CASE` | `CS` | Caisse |
| `CONTAINER` | `CN` | Conteneur |
| `CRATE` | `CR` | Cageot |
| `DRUM` | `DR` | Fût |
| `PALLET` | `PX` | Palette |
| `ROLL` | `RO` | Rouleau |
| `TANK` | `TK` | Réservoir |
| `TUBE` | `TU` | Tube |

> 📋 **Liste complète** : voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/PackageCode.php).

## Méthodes statiques de lookup

| Signature | Description |
|---|---|
| `getName(string $code): ?string` | Renvoie le nom anglais du code |
| `getFromName(string $name): ?string` | Recherche inverse depuis un nom |
| `resetCaches(): void` | Réinitialise les caches internes |

Plus toutes les méthodes héritées de [`ConstantsTrait`](../../guides/constants-trait.md).

## Exemples

### Accès et lookups

```php
use org\unece\uncefact\PackageCode;

PackageCode::BOX;                          // "BX"
PackageCode::includes('CT');               // true

// Lookups croisés
PackageCode::getName('BX');                // "Box"
PackageCode::getFromName('Pallet');        // "PX"
```

### Cas d'usage métier — étiquetage de colis

```php
use org\unece\uncefact\PackageCode;

function packageLabel(string $code, int $qty): string
{
    $name = PackageCode::getName($code);
    if ($name === null)
    {
        throw new \InvalidArgumentException("Code emballage inconnu : $code");
    }
    return "$qty × $name ($code)";
}

packageLabel(PackageCode::BOX, 24); // "24 × Box (BX)"
```

## Lié

- [`PackageName`](PackageName.md) — noms anglais
- [`MeasureCode`](MeasureCode.md) — unités de mesure (Rec. 20)
- Index UN/CEFACT : [README.md](README.md)

## Voir aussi

- [UN/CEFACT Recommendation 21](https://unece.org/trade/uncefact/cl-recommendations)
- [ConstantsTrait](../../guides/constants-trait.md)
