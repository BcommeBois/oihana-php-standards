# toIso8601Date()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/toIso8601Date.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601Date` |
> | **Source** | [toIso8601Date.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601Date.php) |
> | **Since** | `1.0.2` |

## Signature

```php
function toIso8601Date(DateTimeInterface $date, bool $basic = false): string
```

## Description

Converts a `DateTimeInterface` to an ISO 8601 date string. The time and timezone components of the input are ignored.

## Parameters

| Name | Type | Description |
|---|---|---|
| `$date` | `DateTimeInterface` | The date to convert |
| `$basic` | `bool` | If `true`, returns the basic `YYYYMMDD` format (default: `false`, extended format) |

## Return value

`string` — the ISO 8601 string, e.g. `"2026-05-14"` or `"20260514"`.

## Examples

```php
use function org\iso\helpers\toIso8601Date;

$dt = new DateTimeImmutable('2026-05-14 08:15:30');
echo toIso8601Date($dt);         // "2026-05-14"
echo toIso8601Date($dt, true);   // "20260514"
```

## Related

- [`Iso8601Date`](../Iso8601Date.md) — value-object
- [`isIso8601Date`](isIso8601Date.md) — validation
- [`Iso8601Format::DATE`](../Iso8601Format.md) — format used internally
- [Helpers convention](../../../guides/helpers.md)
