# isIso8601Duration()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/isIso8601Duration.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Duration` |
> | **Source** | [isIso8601Duration.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Duration.php) |
> | **Since** | `1.0.1` |

## Signature

```php
function isIso8601Duration(string $duration, bool $strict = false): bool
```

## Description

Validates whether a string is a valid ISO 8601 duration. Format: `P[n]Y[n]M[n]W[n]DT[n]H[n]M[n]S`.

- **Non-strict** mode (default): uses `new DateInterval()` (accepts decimals and some tolerant cases)
- **Strict** mode: regex-based validation, rejects decimals, rejects `P` or `PT` alone

## Parameters

| Name | Type | Description |
|---|---|---|
| `$duration` | `string` | The string to validate |
| `$strict` | `bool` | Strict regex mode (default: `false`) |

## Return value

`bool` — `true` if the string is a valid ISO 8601 duration.

## Examples

```php
use function org\iso\helpers\isIso8601Duration;

isIso8601Duration('P1Y2M3D');       // true
isIso8601Duration('PT4H30M');       // true
isIso8601Duration('P1W');           // true (week)
isIso8601Duration('P0D');           // true
isIso8601Duration('P');             // false (no component)
isIso8601Duration('1Y2M');          // false (missing P prefix)
isIso8601Duration('P1.5Y', true);   // false (decimals rejected in strict)
isIso8601Duration('INVALID');       // false
```

## Related

- [`Iso8601Duration`](../Iso8601Duration.md) — value-object
- [`toIso8601Duration`](toIso8601Duration.md) — inverse conversion
- [Helpers convention](../../../guides/helpers.md)
