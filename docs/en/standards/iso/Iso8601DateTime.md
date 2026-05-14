# Iso8601DateTime

> 🇫🇷 [Version française](../../../fr/standards/iso/Iso8601DateTime.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Combined date and time](https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations) |
> | **Namespace** | `org\iso\Iso8601DateTime` |
> | **Type** | Value-object |
> | **Source** | [Iso8601DateTime.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601DateTime.php) |
> | **Since** | `1.0.2` |

## Overview

`Iso8601DateTime` combines ISO 8601 date and time in a single value-object. The class **composes** [`Iso8601Date`](Iso8601Date.md) and [`Iso8601Time`](Iso8601Time.md) via the `datePart` and `timePart` properties.

**Strict validation:**
- Only the `T` separator is accepted (space is rejected).
- Date format is `YYYY-MM-DD` (extended only).
- Time is `HH:MM:SS` with optional fractional seconds (`.fff…`).
- Offset is `Z`, `±HH:MM` or `±HHMM`.

**Auto-detected precision:** when assigning an ISO string with fractions, the `precision` property updates automatically (3 digits → `MILLISECONDS`, 4+ → `MICROSECONDS`, none → `SECONDS`).

## API

### Constants

| Name | Value | Description |
|---|---|---|
| `ZERO` | `'1970-01-01T00:00:00Z'` | Default date-time (UTC epoch) |
| `FORMAT` | `'Y-m-d\TH:i:s'` | Base `date()` format (no fraction nor offset) |
| `PATTERN` | (regex) | Strict validation |
| `TIME` | `'T'` | Date/time separator |
| `TIME_ZONE` | `'Z'` | UTC designator |

### Properties

| Name | Type | Access | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | ISO 8601 string |
| `$dateTime` | `DateTimeInterface` | get/set | Internal `DateTimeImmutable` |
| `$datePart` | `Iso8601Date` | get | Date component (fresh object on each read) |
| `$timePart` | `Iso8601Time` | get | Time component (fresh object on each read) |
| `$timezone` | `?DateTimeZone` | get | Timezone |
| `$precision` | `string` | get/set | Output precision ([`TimePrecision`](TimePrecision.md)); the setter regenerates `iso` |

### Methods

| Signature | Description |
|---|---|
| `__construct(string\|DateTimeInterface\|null $dateTime = null)` | Creates an instance |
| `__toString(): string` | Returns the ISO string |

## Composition

`$datePart` and `$timePart` return **fresh objects** on each access. Mutating them does not affect the parent — to modify, go through `$iso` or `$dateTime`.

```php
$dt = new Iso8601DateTime('2026-05-14T08:15:30Z');
$dt->datePart->year;    // 2026
$dt->timePart->hours;   // 8

// ⚠️ Doesn't work (no propagation)
$dt->datePart->iso = '2030-01-01'; // mutates the copy, not $dt
```

## Examples

### Creation from an ISO string

```php
use org\iso\Iso8601DateTime;

$dt = new Iso8601DateTime('2026-05-14T08:15:30+02:00');
echo $dt->iso;                  // "2026-05-14T08:15:30+02:00"
echo $dt->datePart->year;       // 2026
echo $dt->timePart->hours;      // 8
echo $dt->timezone->getName();  // "+02:00"
```

### Auto-detected precision

```php
$utc   = new Iso8601DateTime('2026-05-14T08:15:30Z');
echo $utc->precision; // "seconds"

$milli = new Iso8601DateTime('2026-05-14T08:15:30.123Z');
echo $milli->precision; // "milliseconds"

$micro = new Iso8601DateTime('2026-05-14T08:15:30.123456+02:00');
echo $micro->precision; // "microseconds"
```

### Changing precision (regenerates `iso`)

```php
use org\iso\TimePrecision;

$dt = new Iso8601DateTime('2026-05-14T08:15:30Z');

$dt->precision = TimePrecision::MILLISECONDS;
echo $dt->iso; // "2026-05-14T08:15:30.000Z"

$dt->precision = TimePrecision::MICROSECONDS;
echo $dt->iso; // "2026-05-14T08:15:30.000000Z"
```

### Round-trip via `dateTime`

```php
$dt = new Iso8601DateTime('2026-05-14T08:15:30.123Z'); // precision = MILLISECONDS
$dt->dateTime = new DateTimeImmutable('2030-01-01T00:00:00', new DateTimeZone('UTC'));
echo $dt->iso; // "2030-01-01T00:00:00.000Z" (precision preserved)
```

### Domain use case — parsing an API timestamp

```php
use org\iso\Iso8601DateTime;
use InvalidArgumentException;

function parseApiTimestamp(string $iso): Iso8601DateTime
{
    try
    {
        return new Iso8601DateTime($iso);
    }
    catch (InvalidArgumentException $e)
    {
        throw new \RuntimeException("Invalid API timestamp: $iso", previous: $e);
    }
}

$created = parseApiTimestamp('2026-05-14T08:15:30.123Z');
```

### Error handling

```php
new Iso8601DateTime('INVALID');                   // throws
new Iso8601DateTime('2026-05-14 08:15:30Z');      // throws (space instead of T)
new Iso8601DateTime('2023-02-29T12:00:00Z');      // throws (invalid date)

$dt = new Iso8601DateTime();
$dt->precision = 'nanoseconds';                    // throws (not a TimePrecision constant)
```

## Related

- [`Iso8601Date`](Iso8601Date.md) — date component
- [`Iso8601Time`](Iso8601Time.md) — time component
- [`TimePrecision`](TimePrecision.md) — precision constants
- Helpers: [`isIso8601DateTime`](helpers/isIso8601DateTime.md), [`toIso8601DateTime`](helpers/toIso8601DateTime.md)

## See also

- [ISO 8601 — combined representations](https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations)
- [*Value-object* pattern](../../guides/value-objects.md)
