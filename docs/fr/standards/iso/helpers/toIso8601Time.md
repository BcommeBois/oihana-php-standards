# toIso8601Time()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/toIso8601Time.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601Time` |
> | **Source** | [toIso8601Time.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601Time.php) |
> | **Disponible depuis** | `1.0.1` |

## Signature

```php
function toIso8601Time(DateTimeInterface $time): string
```

## Description

Convertit un `DateTimeInterface` en chaîne d'heure ISO 8601 normalisée :
- `"THH:MM:SSZ"` pour UTC (offset zéro)
- `"THH:MM:SS±HH:MM"` pour les autres offsets

L'offset est construit manuellement (pas via le format `P`) pour garantir une sortie cohérente même avec des fuseaux atypiques.

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$time` | `DateTimeInterface` | L'objet à convertir |

## Valeur de retour

`string` — la chaîne ISO 8601, ex. `"T14:30:00Z"` ou `"T08:15:30+02:00"`.

## Exemples

```php
use function org\iso\helpers\toIso8601Time;

$utc = new DateTimeImmutable('14:30:00', new DateTimeZone('UTC'));
echo toIso8601Time($utc); // "T14:30:00Z"

$off = new DateTimeImmutable('08:15:30', new DateTimeZone('+02:00'));
echo toIso8601Time($off); // "T08:15:30+02:00"

$minOff = new DateTimeImmutable('10:00:00', new DateTimeZone('+05:30'));
echo toIso8601Time($minOff); // "T10:00:00+05:30"
```

## Lié

- [`Iso8601Time`](../Iso8601Time.md) — value-object
- [`isIso8601Time`](isIso8601Time.md) — validation
- [Convention des helpers](../../../guides/helpers.md)
