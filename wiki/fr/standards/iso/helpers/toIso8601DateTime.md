# toIso8601DateTime()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/toIso8601DateTime.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601DateTime` |
> | **Source** | [toIso8601DateTime.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601DateTime.php) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function toIso8601DateTime(
    DateTimeInterface $dt,
    string $precision = TimePrecision::SECONDS,
    bool $zulu = false
): string
```

## Description

Convertit un `DateTimeInterface` en chaîne date-heure ISO 8601 normalisée :
- `YYYY-MM-DDTHH:MM:SS[.fff…]Z` si offset zéro
- `YYYY-MM-DDTHH:MM:SS[.fff…]±HH:MM` sinon

L'offset est construit manuellement (cohérent avec [`toIso8601Time`](toIso8601Time.md)).

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$dt` | `DateTimeInterface` | L'objet à convertir |
| `$precision` | `string` | Une des constantes [`TimePrecision`](../TimePrecision.md) (défaut : `SECONDS`) |
| `$zulu` | `bool` | Si `true`, convertit d'abord vers UTC et affiche `Z` (défaut : `false`) |

## Valeur de retour

`string` — la chaîne ISO 8601.

## Exceptions

- `InvalidArgumentException` si `$precision` n'est pas une constante [`TimePrecision`](../TimePrecision.md).

## Exemples

```php
use function org\iso\helpers\toIso8601DateTime;
use org\iso\TimePrecision;

$dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));

echo toIso8601DateTime($dt);                                  // "2026-05-14T08:15:30+02:00"
echo toIso8601DateTime($dt, TimePrecision::MILLISECONDS);     // "2026-05-14T08:15:30.000+02:00"
echo toIso8601DateTime($dt, TimePrecision::SECONDS, true);    // "2026-05-14T06:15:30Z" (UTC)

$utc = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('UTC'));
echo toIso8601DateTime($utc);                                 // "2026-05-14T08:15:30Z"
```

## Lié

- [`Iso8601DateTime`](../Iso8601DateTime.md) — value-object
- [`isIso8601DateTime`](isIso8601DateTime.md) — validation
- [`TimePrecision`](../TimePrecision.md) — constantes du paramètre `$precision`
- [Convention des helpers](../../../guides/helpers.md)
