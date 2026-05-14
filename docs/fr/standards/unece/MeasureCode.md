# MeasureCode

> 🇬🇧 [English version](../../../en/standards/unece/MeasureCode.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommandation 20](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\MeasureCode` |
> | **Type** | Classe de constantes (`ConstantsTrait`) avec lookups croisés |
> | **Source** | [MeasureCode.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureCode.php) |

## Vue d'ensemble

`MeasureCode` énumère les codes alphanumériques UN/CEFACT pour les unités de mesure utilisées dans le commerce international (`KGM` = kilogram, `MTR` = meter, etc.). C'est la classe **maître** : elle expose des méthodes de lookup vers les classes miroir [`MeasureName`](MeasureName.md) et [`MeasureSymbol`](MeasureSymbol.md).

## Échantillon de constantes courantes

| Constante | Code | Unité |
|---|---|---|
| **Quantités** | | |
| `PIECE` | `PCE` | Pièce / Each |
| `UNIT` | `C62` | Unité |
| `PAIR` | `PR` | Paire |
| `DOZEN` | `DZN` | Douzaine |
| **Masse** | | |
| `GRAM` | `GRM` | Gramme |
| `KILOGRAM` | `KGM` | Kilogramme |
| `METRIC_TON` | `TNE` | Tonne métrique |
| `MILLIGRAM` | `MGM` | Milligramme |
| `OUNCE` | `OZA` | Once |
| `POUND` | `LBR` | Livre |
| **Longueur** | | |
| `CENTIMETER` | `CMT` | Centimètre |
| `METER` | `MTR` | Mètre |
| `KILOMETER` | `KMT` | Kilomètre |
| `MILLIMETER` | `MMT` | Millimètre |
| **Volume** | | |
| `LITER` | `LTR` | Litre |
| `MILLILITER` | `MLT` | Millilitre |
| `CUBIC_METER` | `MTQ` | Mètre cube |
| **Temps** | | |
| `SECOND` | `SEC` | Seconde |
| `MINUTE` | `MIN` | Minute |
| `HOUR` | `HUR` | Heure |
| `DAY` | `DAY` | Jour |

> 📋 **Liste complète** (~hundreds) : voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureCode.php).

## Méthodes statiques de lookup

| Signature | Description |
|---|---|
| `getName(string $code): ?string` | Renvoie le nom anglais associé au code |
| `getSymbol(string $code): ?string` | Renvoie le symbole associé au code |
| `getFromName(string $name): ?string` | Recherche inverse depuis un nom |
| `getFromSymbol(string $symbol): ?string` | Recherche inverse depuis un symbole |
| `resetCaches(): void` | Réinitialise les caches internes |

Toutes les méthodes héritées de [`ConstantsTrait`](../../guides/constants-trait.md) (`enums()`, `includes()`, etc.) sont également disponibles.

## Exemples

### Accès direct

```php
use org\unece\uncefact\MeasureCode;

$code = MeasureCode::KILOGRAM;             // "KGM"
MeasureCode::includes('MTR');              // true
```

### Lookups croisés

```php
use org\unece\uncefact\MeasureCode;

$code   = MeasureCode::KILOGRAM;            // "KGM"
$name   = MeasureCode::getName($code);      // "Kilogram"
$symbol = MeasureCode::getSymbol($code);    // "kg"

// Recherches inverses
MeasureCode::getFromName('Meter');          // "MTR"
MeasureCode::getFromSymbol('kg');           // "KGM"
```

### Cas d'usage métier — normaliser une saisie utilisateur

```php
use org\unece\uncefact\MeasureCode;

function normalizeMeasureCode(string $input): ?string
{
    // L'utilisateur peut entrer un code, un nom anglais ou un symbole
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

## Lié

- [`MeasureName`](MeasureName.md) — noms anglais
- [`MeasureSymbol`](MeasureSymbol.md) — symboles
- [`PackageCode`](PackageCode.md) — codes d'emballage (Rec. 21)
- Index UN/CEFACT : [README.md](README.md)

## Voir aussi

- [UN/CEFACT Recommendation 20](https://unece.org/trade/uncefact/cl-recommendations)
- [ConstantsTrait](../../guides/constants-trait.md)
