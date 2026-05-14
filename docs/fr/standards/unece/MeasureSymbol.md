# MeasureSymbol

> 🇬🇧 [English version](../../../en/standards/unece/MeasureSymbol.md)
>
> | | |
> |---|---|
> | **Standard** | [UN/CEFACT Recommandation 20](https://unece.org/trade/uncefact/cl-recommendations) |
> | **Namespace** | `org\unece\uncefact\MeasureSymbol` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [MeasureSymbol.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureSymbol.php) |

## Vue d'ensemble

`MeasureSymbol` énumère les symboles d'unités de mesure (mirror de [`MeasureCode`](MeasureCode.md)). Les symboles sont les notations courantes (`kg`, `m`, `L`, etc.).

## Échantillon

| Constante | Symbole |
|---|---|
| `KILOGRAM` | `kg` |
| `METER` | `m` |
| `LITER` | `L` |
| `SECOND` | `s` |

> 📋 **Liste complète** : voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unece/uncefact/MeasureSymbol.php).

## Méthodes héritées

Voir [ConstantsTrait](../../guides/constants-trait.md).

## Exemples

```php
use org\unece\uncefact\MeasureSymbol;
use org\unece\uncefact\MeasureCode;

MeasureSymbol::KILOGRAM;                 // "kg"
MeasureSymbol::includes('m');            // true

// Lookup vers le code via MeasureCode
MeasureCode::getFromSymbol('kg');        // "KGM"
```

## Lié

- [`MeasureCode`](MeasureCode.md) — codes alphanumériques (master)
- [`MeasureName`](MeasureName.md) — noms anglais
- Index UN/CEFACT : [README.md](README.md)

## Voir aussi

- [ConstantsTrait](../../guides/constants-trait.md)
