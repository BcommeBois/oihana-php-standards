# isIso8601DateTime()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/isIso8601DateTime.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601DateTime` |
> | **Source** | [isIso8601DateTime.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601DateTime.php) |
> | **Since** | `1.0.2` |

## Signature

```php
function isIso8601DateTime(string $value, bool $strict = false): bool
```

## Description

Validates whether a string is a valid ISO 8601 date-time:
- Date: `YYYY-MM-DD` (extended)
- Separator: `T` (mandatory in strict) or space (tolerated otherwise)
- Time: `HH:MM:SS` with optional fractions
- Optional offset: `Z`, `±HH:MM` or `±HHMM`

Calendar validity is enforced.

## Parameters

| Name | Type | Description |
|---|---|---|
| `$value` | `string` | The string to validate |
| `$strict` | `bool` | If `true`, the `T` separator is mandatory (default: `false`) |

## Return value

`bool` — `true` if the string is a valid ISO 8601 date-time.

## Examples

```php
use function org\iso\helpers\isIso8601DateTime;

isIso8601DateTime('2026-05-14T08:15:30Z');         // true
isIso8601DateTime('2026-05-14T08:15:30+02:00');    // true
isIso8601DateTime('2026-05-14T08:15:30.123Z');     // true (milliseconds)
isIso8601DateTime('2026-05-14 08:15:30');          // true (space tolerated)
isIso8601DateTime('2026-05-14 08:15:30', true);    // false (strict requires T)
isIso8601DateTime('2026-02-30T00:00:00Z');         // false (invalid date)
isIso8601DateTime('2026-05-14T24:00:00');          // false (invalid hour)
```

## Related

- [`Iso8601DateTime`](../Iso8601DateTime.md) — value-object (uses this helper in strict mode)
- [`toIso8601DateTime`](toIso8601DateTime.md) — inverse conversion
- [Helpers convention](../../../guides/helpers.md)
