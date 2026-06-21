# toIso8601Duration()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/toIso8601Duration.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601Duration` |
> | **Source** | [toIso8601Duration.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601Duration.php) |
> | **Disponible depuis** | `1.0.1` |

## Signature

```php
function toIso8601Duration(DateInterval $interval): string
```

## Description

Convertit un `DateInterval` PHP en chaîne ISO 8601 normalisée (`P…`). Les composantes nulles sont omises.

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$interval` | `DateInterval` | L'intervalle à convertir |

## Valeur de retour

`string` — la chaîne ISO 8601, ex. `"P1Y2M3D"`, `"PT2H30M"`.

## Exemples

```php
use function org\iso\helpers\toIso8601Duration;

// Depuis un new DateInterval
$interval = new DateInterval('PT1H30M');
echo toIso8601Duration($interval); // "PT1H30M"

// Depuis une diff
$start = new DateTime('2024-01-01');
$end   = new DateTime('2024-03-15');
echo toIso8601Duration($start->diff($end)); // "P2M14D"
```

## Lié

- [`Iso8601Duration`](../Iso8601Duration.md) — value-object
- [`isIso8601Duration`](isIso8601Duration.md) — validation
- [Convention des helpers](../../../guides/helpers.md)
