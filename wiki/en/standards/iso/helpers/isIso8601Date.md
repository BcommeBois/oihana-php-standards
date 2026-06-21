# isIso8601Date()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/isIso8601Date.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Date` |
> | **Source** | [isIso8601Date.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Date.php) |
> | **Since** | `1.0.2` |

## Signature

```php
function isIso8601Date(string $date, bool $strict = false): bool
```

## Description

Validates whether a string is a valid ISO 8601 date, syntactically **and** calendar-wise (`checkdate()`).

Formats accepted by default:
- **Extended**: `YYYY-MM-DD` (e.g. `2026-05-14`)
- **Basic**: `YYYYMMDD` (e.g. `20260514`)

In strict mode (`$strict = true`), only the extended format is accepted.

## Parameters

| Name | Type | Description |
|---|---|---|
| `$date` | `string` | The string to validate |
| `$strict` | `bool` | If `true`, accepts only the extended `YYYY-MM-DD` format (default: `false`) |

## Return value

`bool` — `true` if the string is a valid ISO 8601 date.

## Examples

```php
use function org\iso\helpers\isIso8601Date;

isIso8601Date('2026-05-14');         // true
isIso8601Date('20260514');           // true (basic)
isIso8601Date('20260514', true);     // false (strict rejects basic)
isIso8601Date('2026-02-30');         // false (invalid calendar date)
isIso8601Date('2024-02-29');         // true  (leap year)
isIso8601Date('2023-02-29');         // false (non-leap)
isIso8601Date('2026-5-14');          // false (month not zero-padded)
```

## Related

- [`Iso8601Date`](../Iso8601Date.md) — value-object (uses this helper internally with `$strict = true`)
- [`toIso8601Date`](toIso8601Date.md) — inverse conversion
- [Helpers convention](../../../guides/helpers.md)
