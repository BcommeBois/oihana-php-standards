# NumberFormat

> 🇬🇧 [English version](../../../en/standards/common/NumberFormat.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\common\NumberFormat` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [NumberFormat.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/common/NumberFormat.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`NumberFormat` regroupe les **séparateurs et symboles numériques** courants pour formater les nombres selon les conventions régionales. Pensées pour être passées directement à [`number_format()`](https://www.php.net/manual/fr/function.number-format.php).

Conventions notation :
- **EU** : virgule décimale, point milliers — `1.234.567,89` (DE, IT, ES, NL…)
- **US** : point décimal, virgule milliers — `1,234,567.89` (US, UK, JP, CN…)
- **FR** : virgule décimale, espace fine insécable milliers — `1 234 567,89` (typographie française)
- **CH** : point décimal, apostrophe milliers — `1'234'567.89` (Suisse)

## Constantes

### Séparateurs décimaux

| Constante | Valeur | Usage |
|---|---|---|
| `DECIMAL_SEP_EU` | `','` | Europe continentale |
| `DECIMAL_SEP_US` | `'.'` | US, UK, Asie |
| `DECIMAL_SEP_FR` | `','` | France |
| `DECIMAL_SEP_CH` | `'.'` | Suisse |

### Séparateurs de milliers

| Constante | Valeur | Usage |
|---|---|---|
| `THOUSANDS_SEP_EU` | `'.'` | Europe continentale |
| `THOUSANDS_SEP_US` | `','` | US, UK, Asie |
| `THOUSANDS_SEP_FR` | `"\u{202F}"` | France (espace fine insécable U+202F) |
| `THOUSANDS_SEP_CH` | `"'"` | Suisse |
| `THOUSANDS_SEP_NONE` | `''` | Aucun |

### Notation scientifique

| Constante | Valeur | Exemple |
|---|---|---|
| `SCIENTIFIC_E_LOWER` | `'e'` | `1.23e+45` |
| `SCIENTIFIC_E_UPPER` | `'E'` | `1.23E+45` |

### Symboles

| Constante | Valeur | Description |
|---|---|---|
| `PERCENT_SYMBOL` | `'%'` | Pourcent |
| `PERMILLE_SYMBOL` | `'‰'` | Per-mille (U+2030) |
| `INFINITY` | `'∞'` | Infini (U+221E) |
| `NEGATIVE_INFINITY` | `'-∞'` | Infini négatif |
| `NAN_SYMBOL` | `'NaN'` | "Not a Number" |

## Méthodes héritées

Voir [ConstantsTrait](../../guides/constants-trait.md).

## Exemples

### Formatage régional

```php
use org\common\NumberFormat;

$n = 1234567.89;

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_EU, NumberFormat::THOUSANDS_SEP_EU);
// "1.234.567,89"

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_US, NumberFormat::THOUSANDS_SEP_US);
// "1,234,567.89"

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_FR, NumberFormat::THOUSANDS_SEP_FR);
// "1 234 567,89" (avec espace fine insécable)

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_CH, NumberFormat::THOUSANDS_SEP_CH);
// "1'234'567.89"
```

### Sans séparateur de milliers

```php
echo number_format(1234567.89, 2, NumberFormat::DECIMAL_SEP_US, NumberFormat::THOUSANDS_SEP_NONE);
// "1234567.89"
```

### Cas d'usage métier — formatter selon la locale utilisateur

```php
use org\common\NumberFormat;
use org\ietf\Locale;

function formatMoney(float $amount, Locale $locale): string
{
    [$dec, $thou] = match ($locale->region) {
        'FR'        => [NumberFormat::DECIMAL_SEP_FR, NumberFormat::THOUSANDS_SEP_FR],
        'CH'        => [NumberFormat::DECIMAL_SEP_CH, NumberFormat::THOUSANDS_SEP_CH],
        'US', 'GB'  => [NumberFormat::DECIMAL_SEP_US, NumberFormat::THOUSANDS_SEP_US],
        default     => [NumberFormat::DECIMAL_SEP_EU, NumberFormat::THOUSANDS_SEP_EU],
    };

    return number_format($amount, 2, $dec, $thou);
}

formatMoney(1234567.89, new Locale('fr-FR')); // "1 234 567,89"
formatMoney(1234567.89, new Locale('en-US')); // "1,234,567.89"
```

### Lookup inverse

```php
NumberFormat::includes('%');                          // true
NumberFormat::includes("\u{202F}");                   // true
NumberFormat::getConstant('%');                       // "PERCENT_SYMBOL"
NumberFormat::getConstant(',');                       // ['DECIMAL_SEP_EU', 'DECIMAL_SEP_FR'] (partagent la valeur)
```

## ⚠️ Note

Pour des règles avancées (devises avec symbole positionné par locale, pluriels, formats CLDR), ce catalogue de constantes pures n'est pas suffisant. Voir le projet futur `oihana/php-format` (à venir) ou l'extension [`ext-intl`](https://www.php.net/manual/fr/book.intl.php) de PHP.

## Lié

- Index Common : [README.md](README.md)

## Voir aussi

- [PHP `number_format()`](https://www.php.net/manual/fr/function.number-format.php)
- [ConstantsTrait](../../guides/constants-trait.md)
