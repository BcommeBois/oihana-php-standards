# isIso8601Interval()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/isIso8601Interval.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Interval` |
> | **Source** | [isIso8601Interval.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Interval.php) |
> | **Since** | `1.0.2` |

## Signature

```php
function isIso8601Interval(string $value): bool
```

## Description

Validates whether a string is a bounded ISO 8601 interval, in one of three forms:
- `<start>/<end>`
- `<start>/<duration>`
- `<duration>/<end>`

Date-times are validated in **strict mode** (mandatory `T` separator).

**Rejected:** single duration (`P1D`), two durations (`P1D/P2D`), open intervals (`--/...`).

## Parameters

| Name | Type | Description |
|---|---|---|
| `$value` | `string` | The string to validate |

## Return value

`bool` — `true` if the string is a valid ISO 8601 interval.

## Examples

```php
use function org\iso\helpers\isIso8601Interval;

isIso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z'); // true
isIso8601Interval('2026-05-14T00:00:00Z/P1D');                   // true
isIso8601Interval('P1D/2026-05-15T00:00:00Z');                   // true
isIso8601Interval('P1D');                                         // false (single duration)
isIso8601Interval('P1D/P2D');                                     // false (two durations)
isIso8601Interval('--/2026-05-15T00:00:00Z');                     // false (open interval)
isIso8601Interval('2026-05-14 00:00:00Z/P1D');                    // false (space instead of T)
```

## Related

- [`Iso8601Interval`](../Iso8601Interval.md) — value-object
- [Helpers convention](../../../guides/helpers.md)
