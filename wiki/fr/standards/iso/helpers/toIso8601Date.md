# toIso8601Date()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/toIso8601Date.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601Date` |
> | **Source** | [toIso8601Date.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601Date.php) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function toIso8601Date(DateTimeInterface $date, bool $basic = false): string
```

## Description

Convertit un `DateTimeInterface` en chaîne de date ISO 8601. Les composantes d'heure et de fuseau de l'objet d'entrée sont ignorées.

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$date` | `DateTimeInterface` | La date à convertir |
| `$basic` | `bool` | Si `true`, renvoie le format basic `YYYYMMDD` (défaut : `false`, format étendu) |

## Valeur de retour

`string` — la chaîne ISO 8601, ex. `"2026-05-14"` ou `"20260514"`.

## Exemples

```php
use function org\iso\helpers\toIso8601Date;

$dt = new DateTimeImmutable('2026-05-14 08:15:30');
echo toIso8601Date($dt);         // "2026-05-14"
echo toIso8601Date($dt, true);   // "20260514"
```

## Lié

- [`Iso8601Date`](../Iso8601Date.md) — value-object
- [`isIso8601Date`](isIso8601Date.md) — validation
- [`Iso8601Format::DATE`](../Iso8601Format.md) — format utilisé en interne
- [Convention des helpers](../../../guides/helpers.md)
