# isIso8601Recurrence()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/isIso8601Recurrence.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Recurrence` |
> | **Source** | [isIso8601Recurrence.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Recurrence.php) |
> | **Since** | `1.0.2` |

## Signature

```php
function isIso8601Recurrence(string $value): bool
```

## Description

Validates whether a string is an ISO 8601 repeating interval: `R[n]/<interval>`. `n` is optional (absent = infinite). The inner interval is validated via [`isIso8601Interval`](isIso8601Interval.md) (so bounded form mandatory).

## Parameters

| Name | Type | Description |
|---|---|---|
| `$value` | `string` | The string to validate |

## Return value

`bool` — `true` if the string is a valid ISO 8601 recurrence.

## Examples

```php
use function org\iso\helpers\isIso8601Recurrence;

isIso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');     // true (infinite)
isIso8601Recurrence('R5/2026-05-14T00:00:00Z/P1D');    // true (5 occurrences)
isIso8601Recurrence('R0/2026-05-14T00:00:00Z/PT0S');   // true (zero, degenerate)
isIso8601Recurrence('R10/P1D/2026-05-15T00:00:00Z');   // true
isIso8601Recurrence('2026-05-14T00:00:00Z/P1D');       // false (missing R)
isIso8601Recurrence('R-1/P1D/2026-05-15T00:00:00Z');   // false (negative count)
isIso8601Recurrence('R/P1D');                          // false (unbounded interval)
```

## Related

- [`Iso8601Recurrence`](../Iso8601Recurrence.md) — value-object
- [`isIso8601Interval`](isIso8601Interval.md) — validation of the inner interval
- [Helpers convention](../../../guides/helpers.md)
