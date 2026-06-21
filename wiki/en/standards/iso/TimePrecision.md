# TimePrecision

> 🇫🇷 [Version française](../../../fr/standards/iso/TimePrecision.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\TimePrecision` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [TimePrecision.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/TimePrecision.php) |
> | **Since** | `1.0.2` |

## Overview

`TimePrecision` enumerates precision levels for fractional seconds in ISO 8601 representations:

- `SECONDS` — no fraction (`08:15:30`)
- `MILLISECONDS` — 3 digits (`08:15:30.123`)
- `MICROSECONDS` — 6 digits (`08:15:30.123456`)

Used mainly by [`Iso8601DateTime`](Iso8601DateTime.md) (`$precision` property) and by the [`toIso8601DateTime`](helpers/toIso8601DateTime.md) helper (`$precision` parameter).

## Constants

| Name | Value | Description |
|---|---|---|
| `SECONDS` | `'seconds'` | Second-level precision, no fractional part |
| `MILLISECONDS` | `'milliseconds'` | 3 fractional digits |
| `MICROSECONDS` | `'microseconds'` | 6 fractional digits |

## Inherited methods

See [ConstantsTrait](../../guides/constants-trait.md) for `enums()`, `includes()`, `getConstant()`, etc.

## Examples

### Usage with `Iso8601DateTime`

```php
use org\iso\Iso8601DateTime;
use org\iso\TimePrecision;

$dt = new Iso8601DateTime('2026-05-14T08:15:30Z');
$dt->precision = TimePrecision::MILLISECONDS;
echo $dt->iso; // "2026-05-14T08:15:30.000Z"
```

### Usage with the helper

```php
use function org\iso\helpers\toIso8601DateTime;
use org\iso\TimePrecision;

$dt = new DateTimeImmutable('2026-05-14 08:15:30.123456', new DateTimeZone('UTC'));
echo toIso8601DateTime($dt, TimePrecision::MILLISECONDS); // "2026-05-14T08:15:30.123Z"
echo toIso8601DateTime($dt, TimePrecision::MICROSECONDS); // "2026-05-14T08:15:30.123456Z"
```

### Validation and enumeration

```php
TimePrecision::includes('milliseconds');        // true
TimePrecision::includes('nanoseconds');         // false
TimePrecision::enums();                         // ['microseconds','milliseconds','seconds']
TimePrecision::getConstant('milliseconds');     // "MILLISECONDS"
```

### Domain use case — emit timestamps suited to the consumer

```php
use function org\iso\helpers\toIso8601DateTime;
use org\iso\TimePrecision;

function serializeTimestamp(DateTimeImmutable $dt, string $consumer): string
{
    // Legacy clients don't accept fractions
    $precision = $consumer === 'legacy'
        ? TimePrecision::SECONDS
        : TimePrecision::MILLISECONDS;

    return toIso8601DateTime($dt, $precision, zulu: true);
}
```

## Related

- [`Iso8601DateTime`](Iso8601DateTime.md) — `$precision` property
- [`toIso8601DateTime`](helpers/toIso8601DateTime.md) — `$precision` parameter
- [`Iso8601Format`](Iso8601Format.md) — format constants `DATE_TIME_MILLI`, `DATE_TIME_MICRO`

## See also

- [ConstantsTrait](../../guides/constants-trait.md)
