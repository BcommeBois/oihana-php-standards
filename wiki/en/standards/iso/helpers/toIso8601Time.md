# toIso8601Time()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/toIso8601Time.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601Time` |
> | **Source** | [toIso8601Time.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601Time.php) |
> | **Since** | `1.0.1` |

## Signature

```php
function toIso8601Time(DateTimeInterface $time): string
```

## Description

Converts a `DateTimeInterface` to a normalized ISO 8601 time string:
- `"THH:MM:SSZ"` for UTC (zero offset)
- `"THH:MM:SS±HH:MM"` for other offsets

The offset is built manually (not via the `P` format) to guarantee consistent output even with unusual timezones.

## Parameters

| Name | Type | Description |
|---|---|---|
| `$time` | `DateTimeInterface` | The object to convert |

## Return value

`string` — the ISO 8601 string, e.g. `"T14:30:00Z"` or `"T08:15:30+02:00"`.

## Examples

```php
use function org\iso\helpers\toIso8601Time;

$utc = new DateTimeImmutable('14:30:00', new DateTimeZone('UTC'));
echo toIso8601Time($utc); // "T14:30:00Z"

$off = new DateTimeImmutable('08:15:30', new DateTimeZone('+02:00'));
echo toIso8601Time($off); // "T08:15:30+02:00"

$minOff = new DateTimeImmutable('10:00:00', new DateTimeZone('+05:30'));
echo toIso8601Time($minOff); // "T10:00:00+05:30"
```

## Related

- [`Iso8601Time`](../Iso8601Time.md) — value-object
- [`isIso8601Time`](isIso8601Time.md) — validation
- [Helpers convention](../../../guides/helpers.md)
