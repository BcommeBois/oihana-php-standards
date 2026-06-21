# toIso8601DateTime()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/toIso8601DateTime.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601DateTime` |
> | **Source** | [toIso8601DateTime.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601DateTime.php) |
> | **Since** | `1.0.2` |

## Signature

```php
function toIso8601DateTime(
    DateTimeInterface $dt,
    string $precision = TimePrecision::SECONDS,
    bool $zulu = false
): string
```

## Description

Converts a `DateTimeInterface` to a normalized ISO 8601 date-time string:
- `YYYY-MM-DDTHH:MM:SS[.fff…]Z` for zero offset
- `YYYY-MM-DDTHH:MM:SS[.fff…]±HH:MM` otherwise

The offset is built manually (consistent with [`toIso8601Time`](toIso8601Time.md)).

## Parameters

| Name | Type | Description |
|---|---|---|
| `$dt` | `DateTimeInterface` | The object to convert |
| `$precision` | `string` | One of the [`TimePrecision`](../TimePrecision.md) constants (default: `SECONDS`) |
| `$zulu` | `bool` | If `true`, first converts to UTC and renders with `Z` (default: `false`) |

## Return value

`string` — the ISO 8601 string.

## Exceptions

- `InvalidArgumentException` if `$precision` is not a [`TimePrecision`](../TimePrecision.md) constant.

## Examples

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

## Related

- [`Iso8601DateTime`](../Iso8601DateTime.md) — value-object
- [`isIso8601DateTime`](isIso8601DateTime.md) — validation
- [`TimePrecision`](../TimePrecision.md) — constants for the `$precision` parameter
- [Helpers convention](../../../guides/helpers.md)
