# TimePrecision

> 🇬🇧 [English version](../../../en/standards/iso/TimePrecision.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\TimePrecision` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [TimePrecision.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/TimePrecision.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`TimePrecision` énumère les niveaux de précision pour les fractions de seconde dans les représentations ISO 8601 :

- `SECONDS` — pas de fraction (`08:15:30`)
- `MILLISECONDS` — 3 chiffres (`08:15:30.123`)
- `MICROSECONDS` — 6 chiffres (`08:15:30.123456`)

Utilisée principalement par [`Iso8601DateTime`](Iso8601DateTime.md) (propriété `$precision`) et par le helper [`toIso8601DateTime`](helpers/toIso8601DateTime.md) (paramètre `$precision`).

## Constantes

| Nom | Valeur | Description |
|---|---|---|
| `SECONDS` | `'seconds'` | Précision à la seconde, sans partie fractionnaire |
| `MILLISECONDS` | `'milliseconds'` | 3 chiffres fractionnaires |
| `MICROSECONDS` | `'microseconds'` | 6 chiffres fractionnaires |

## Méthodes héritées

Voir [ConstantsTrait](../../guides/constants-trait.md) pour `enums()`, `includes()`, `getConstant()`, etc.

## Exemples

### Usage avec `Iso8601DateTime`

```php
use org\iso\Iso8601DateTime;
use org\iso\TimePrecision;

$dt = new Iso8601DateTime('2026-05-14T08:15:30Z');
$dt->precision = TimePrecision::MILLISECONDS;
echo $dt->iso; // "2026-05-14T08:15:30.000Z"
```

### Usage avec le helper

```php
use function org\iso\helpers\toIso8601DateTime;
use org\iso\TimePrecision;

$dt = new DateTimeImmutable('2026-05-14 08:15:30.123456', new DateTimeZone('UTC'));
echo toIso8601DateTime($dt, TimePrecision::MILLISECONDS); // "2026-05-14T08:15:30.123Z"
echo toIso8601DateTime($dt, TimePrecision::MICROSECONDS); // "2026-05-14T08:15:30.123456Z"
```

### Validation et énumération

```php
TimePrecision::includes('milliseconds');        // true
TimePrecision::includes('nanoseconds');         // false
TimePrecision::enums();                         // ['microseconds','milliseconds','seconds']
TimePrecision::getConstant('milliseconds');     // "MILLISECONDS"
```

### Cas d'usage métier — sortir des timestamps adaptés au consommateur

```php
use function org\iso\helpers\toIso8601DateTime;
use org\iso\TimePrecision;

function serializeTimestamp(DateTimeImmutable $dt, string $consumer): string
{
    // Les clients legacy n'acceptent pas de fractions
    $precision = $consumer === 'legacy'
        ? TimePrecision::SECONDS
        : TimePrecision::MILLISECONDS;

    return toIso8601DateTime($dt, $precision, zulu: true);
}
```

## Lié

- [`Iso8601DateTime`](Iso8601DateTime.md) — propriété `$precision`
- [`toIso8601DateTime`](helpers/toIso8601DateTime.md) — paramètre `$precision`
- [`Iso8601Format`](Iso8601Format.md) — constantes de formats `DATE_TIME_MILLI`, `DATE_TIME_MICRO`

## Voir aussi

- [ConstantsTrait](../../guides/constants-trait.md)
