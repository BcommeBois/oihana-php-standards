# Iso8601Format

> 🇬🇧 [English version](../../../en/standards/iso/Iso8601Format.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) |
> | **Namespace** | `org\iso\Iso8601Format` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [Iso8601Format.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Format.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`Iso8601Format` est un **catalogue de patterns de format** ISO 8601 utilisables directement avec [`DateTimeInterface::format()`](https://www.php.net/manual/fr/datetime.format.php). Deux représentations sont supportées :

- **Étendue** : avec séparateurs — `2026-05-14T08:15:30+02:00`
- **Basic** : sans séparateurs — `20260514T081530+0200`

Pour un catalogue plus large incluant RFC, HTTP et MySQL, voir [`DateFormat`](../common/DateFormat.md) qui étend cette classe.

## Constantes

### Date

| Constante | Valeur | Exemple |
|---|---|---|
| `DATE` | `'Y-m-d'` | `2026-05-14` |
| `DATE_BASIC` | `'Ymd'` | `20260514` |

### Date + heure

| Constante | Valeur | Exemple |
|---|---|---|
| `DATE_TIME_LOCAL` | `'Y-m-d\TH:i:s'` | `2026-05-14T08:15:30` (sans tz) |
| `DATE_TIME` | `'Y-m-d\TH:i:sP'` | `2026-05-14T08:15:30+02:00` |
| `DATE_TIME_ZULU` | `'Y-m-d\TH:i:s\Z'` | `2026-05-14T08:15:30Z` |
| `DATE_TIME_MILLI` | `'Y-m-d\TH:i:s.vP'` | `2026-05-14T08:15:30.123+02:00` |
| `DATE_TIME_MILLI_ZULU` | `'Y-m-d\TH:i:s.v\Z'` | `2026-05-14T08:15:30.123Z` |
| `DATE_TIME_MICRO` | `'Y-m-d\TH:i:s.uP'` | `2026-05-14T08:15:30.123456+02:00` |
| `DATE_TIME_MICRO_ZULU` | `'Y-m-d\TH:i:s.u\Z'` | `2026-05-14T08:15:30.123456Z` |
| `DATE_TIME_BASIC` | `'Ymd\THisO'` | `20260514T081530+0200` |
| `DATE_TIME_BASIC_ZULU` | `'Ymd\THis\Z'` | `20260514T081530Z` |

### Heure seule

| Constante | Valeur | Exemple |
|---|---|---|
| `TIME` | `'H:i:s'` | `08:15:30` |
| `TIME_OFFSET` | `'H:i:sP'` | `08:15:30+02:00` |
| `TIME_ZULU` | `'H:i:s\Z'` | `08:15:30Z` |
| `TIME_BASIC` | `'His'` | `081530` |

### Date ordinale / semaine

| Constante | Valeur | Exemple |
|---|---|---|
| `ORDINAL_DATE` | `'Y-z'` | `2026-134` (⚠️ PHP `z` est 0-based) |
| `WEEK_DATE` | `'o-\WW-N'` | `2026-W20-4` |
| `WEEK_DATE_BASIC` | `'o\WWN'` | `2026W204` |
| `WEEK` | `'o-\WW'` | `2026-W20` |
| `YEAR_MONTH` | `'Y-m'` | `2026-05` |
| `YEAR` | `'Y'` | `2026` |

## Méthodes héritées

Voir le guide [ConstantsTrait](../../guides/constants-trait.md) pour `getAll()`, `enums()`, `includes()`, `getConstant()`, etc.

## Exemples

### Formater une date courante

```php
use org\iso\Iso8601Format;

$now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

echo $now->format(Iso8601Format::DATE);           // "2026-05-14"
echo $now->format(Iso8601Format::DATE_TIME_ZULU); // "2026-05-14T08:15:30Z"
echo $now->format(Iso8601Format::WEEK_DATE);      // "2026-W20-4"
```

### Lookup inverse

```php
Iso8601Format::includes('Y-m-d');                 // true
Iso8601Format::getConstant('Y-m-d\TH:i:s\Z');     // "DATE_TIME_ZULU"
```

### Cas d'usage métier — sérialisation API

```php
use org\iso\Iso8601Format;

function serializeForApi(DateTimeImmutable $dt): string
{
    return $dt->setTimezone(new DateTimeZone('UTC'))
              ->format(Iso8601Format::DATE_TIME_MILLI_ZULU);
}
```

## ⚠️ Note sur `ORDINAL_DATE`

PHP utilise un index 0-based pour le jour de l'année (`z`), alors qu'ISO 8601 utilise 1-based. Si tu as besoin d'une date ordinale strictement conforme, construis la chaîne à la main :

```php
$dt = new DateTimeImmutable('2026-05-14');
$ordinal = $dt->format('Y') . '-' . str_pad((int) $dt->format('z') + 1, 3, '0', STR_PAD_LEFT);
// "2026-134"
```

## Lié

- [`DateFormat`](../common/DateFormat.md) — étend cette classe avec RFC, HTTP, MySQL, Unix
- [`TimePrecision`](TimePrecision.md) — précision pour formats fractionnaires
- [`Iso8601DateTime`](Iso8601DateTime.md) — utilise ces constantes en interne

## Voir aussi

- [PHP `date()` format characters](https://www.php.net/manual/fr/datetime.format.php)
- [ConstantsTrait](../../guides/constants-trait.md)
