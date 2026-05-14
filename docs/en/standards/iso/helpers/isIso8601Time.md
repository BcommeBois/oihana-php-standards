# isIso8601Time()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/isIso8601Time.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Time` |
> | **Source** | [isIso8601Time.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Time.php) |
> | **Since** | `1.0.1` |

## Signature

```php
function isIso8601Time(string $time, bool $strict = false): bool
```

## Description

Validates whether a string is a valid ISO 8601 time:
- Optional `T` prefix (mandatory in strict mode)
- Hours `00-23`, minutes/seconds `00-59`
- Fractional seconds accepted
- Optional offset: `Z` or `±HH:MM`

## Parameters

| Name | Type | Description |
|---|---|---|
| `$time` | `string` | The string to validate |
| `$strict` | `bool` | If `true`, the `T` prefix is mandatory (default: `false`) |

## Return value

`bool` — `true` if the string is a valid ISO 8601 time.

## Examples

```php
use function org\iso\helpers\isIso8601Time;

isIso8601Time('T14:30:00Z');       // true
isIso8601Time('T08:15:30+02:00');  // true
isIso8601Time('T12:34:56.789');    // true (fractional)
isIso8601Time('14:30:00');         // true (no T, non-strict)
isIso8601Time('14:30:00', true);   // false (strict requires T)
isIso8601Time('T24:00:00');        // false (invalid hour)
isIso8601Time('T12:60:00');        // false (invalid minute)
```

## Related

- [`Iso8601Time`](../Iso8601Time.md) — value-object
- [`toIso8601Time`](toIso8601Time.md) — inverse conversion
- [Helpers convention](../../../guides/helpers.md)
