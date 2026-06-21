# MeasureName

> 🇬🇧 [English version](../../../en/standards/unece/MeasureName.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommandation 20](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\MeasureName` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [MeasureName.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureName.php) |

## Vue d'ensemble

`MeasureName` énumère les noms anglais des unités de mesure UN/CEFACT (mirror de [`MeasureCode`](MeasureCode.md)). Les noms sont stockés en anglais (`Kilogram`, `Meter`, etc.).

## Échantillon

| Constante | Nom |
|---|---|
| `KILOGRAM` | `Kilogram` |
| `METER` | `Meter` |
| `LITER` | `Liter` |
| `SECOND` | `Second` |
| `PIECE` | `Piece / Each` |

> 📋 **Liste complète** : voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureName.php).

## Méthodes héritées

Voir [ConstantsTrait](../../guides/constants-trait.md).

## Exemples

```php
use org\unece\uncefact\MeasureName;
use org\unece\uncefact\MeasureCode;

MeasureName::KILOGRAM;                 // "Kilogram"
MeasureName::includes('Meter');        // true

// Lookup vers le code via MeasureCode
MeasureCode::getFromName(MeasureName::KILOGRAM); // "KGM"
```

## Lié

- [`MeasureCode`](MeasureCode.md) — codes alphanumériques (master)
- [`MeasureSymbol`](MeasureSymbol.md) — symboles
- Index UN/CEFACT : [README.md](README.md)

## Voir aussi

- [ConstantsTrait](../../guides/constants-trait.md)
