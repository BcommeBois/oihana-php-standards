# toIso8601Duration()

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/toIso8601Duration.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\toIso8601Duration` |
> | **Source** | [toIso8601Duration.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/toIso8601Duration.php) |
> | **Since** | `1.0.1` |

## Signature

```php
function toIso8601Duration(DateInterval $interval): string
```

## Description

Converts a PHP `DateInterval` to a normalized ISO 8601 string (`P…`). Zero components are omitted.

## Parameters

| Name | Type | Description |
|---|---|---|
| `$interval` | `DateInterval` | The interval to convert |

## Return value

`string` — the ISO 8601 string, e.g. `"P1Y2M3D"`, `"PT2H30M"`.

## Examples

```php
use function org\iso\helpers\toIso8601Duration;

// From a new DateInterval
$interval = new DateInterval('PT1H30M');
echo toIso8601Duration($interval); // "PT1H30M"

// From a diff
$start = new DateTime('2024-01-01');
$end   = new DateTime('2024-03-15');
echo toIso8601Duration($start->diff($end)); // "P2M14D"
```

## Related

- [`Iso8601Duration`](../Iso8601Duration.md) — value-object
- [`isIso8601Duration`](isIso8601Duration.md) — validation
- [Helpers convention](../../../guides/helpers.md)
