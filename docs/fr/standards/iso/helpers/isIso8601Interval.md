# isIso8601Interval()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/isIso8601Interval.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Interval` |
> | **Source** | [isIso8601Interval.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Interval.php) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function isIso8601Interval(string $value): bool
```

## Description

Valide qu'une chaîne est un intervalle ISO 8601 borné, dans l'une des trois formes :
- `<start>/<end>`
- `<start>/<duration>`
- `<duration>/<end>`

Les date-heures sont validées en **mode strict** (séparateur `T` obligatoire).

**Rejetés :** durée seule (`P1D`), deux durées (`P1D/P2D`), intervalles ouverts (`--/...`).

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$value` | `string` | La chaîne à valider |

## Valeur de retour

`bool` — `true` si la chaîne est un intervalle ISO 8601 valide.

## Exemples

```php
use function org\iso\helpers\isIso8601Interval;

isIso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z'); // true
isIso8601Interval('2026-05-14T00:00:00Z/P1D');                   // true
isIso8601Interval('P1D/2026-05-15T00:00:00Z');                   // true
isIso8601Interval('P1D');                                         // false (durée seule)
isIso8601Interval('P1D/P2D');                                     // false (deux durées)
isIso8601Interval('--/2026-05-15T00:00:00Z');                     // false (open interval)
isIso8601Interval('2026-05-14 00:00:00Z/P1D');                    // false (espace au lieu de T)
```

## Lié

- [`Iso8601Interval`](../Iso8601Interval.md) — value-object
- [Convention des helpers](../../../guides/helpers.md)
