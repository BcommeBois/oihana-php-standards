# Iso8601Duration

> 🇫🇷 [Version française](../../../fr/standards/iso/Iso8601Duration.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Durations](https://en.wikipedia.org/wiki/ISO_8601#Durations) |
> | **Namespace** | `org\iso\Iso8601Duration` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Duration.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Duration.php) |
> | **Since** | `1.0.1` |

## Overview

`Iso8601Duration` wraps PHP's `DateInterval` with the corresponding ISO 8601 string. General format: `P[n]Y[n]M[n]DT[n]H[n]M[n]S`.

Components:
- `P` (required) — period designator
- `T` — separates date and time parts
- `Y` / `M` / `D` — years, months, days
- `H` / `M` / `S` — hours, minutes, seconds (after `T`)
- `W` — weeks (alternative to days)

## API

### Constants

| Name | Value | Description |
|---|---|---|
| `ZERO` | `'P0D'` | Zero duration |
| `PERIOD` | `'P'` | Period designator |
| `TIME` | `'T'` | Time designator |
| `YEAR` / `MONTH` / `DAY` | `'Y'` / `'M'` / `'D'` | Date designators |
| `HOUR` / `MINUTE` / `SECOND` | `'H'` / `'M'` / `'S'` | Time designators |
| `WEEK` | `'W'` | Week designator |
| `PATTERN` | (regex) | Strict validation |

### Properties

| Name | Type | Access | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | ISO 8601 string, e.g. `"P1Y2M3D"` |
| `$interval` | `DateInterval` | get/set | Internal `DateInterval` (cloned on read) |
| `$years` | `int` | get | Years component |
| `$months` | `int` | get | Months component |
| `$days` | `int` | get | Days component |
| `$hours` | `int` | get | Hours component |
| `$minutes` | `int` | get | Minutes component |
| `$seconds` | `int` | get | Seconds component |

### Methods

| Signature | Description |
|---|---|
| `__construct(string\|DateInterval\|null $duration = null)` | Creates an instance |
| `addTo(DateTime $date): DateTime` | Returns a new date with the duration added |
| `subtractFrom(DateTime $date): DateTime` | Returns a new date with the duration subtracted |
| `toSeconds(): int` | Approximate conversion to seconds (1 year = 365 d, 1 month = 30 d) |
| `__toString(): string` | Returns the ISO string |

## Examples

### Creation and component access

```php
use org\iso\Iso8601Duration;

$d = new Iso8601Duration('P1Y2M3D');
echo $d->years;   // 1
echo $d->months;  // 2
echo $d->days;    // 3
echo $d->iso;     // "P1Y2M3D"

$t = new Iso8601Duration('PT4H30M');
echo $t->hours;   // 4
echo $t->minutes; // 30
```

### Add / subtract from a date

```php
$d = new Iso8601Duration('P1M');
$start = new DateTime('2024-01-31');
$end   = $d->addTo($start);
echo $end->format('Y-m-d'); // "2024-02-29" (leap year)
```

### From a `DateInterval`

```php
$interval = new DateInterval('PT2H30M');
$d = new Iso8601Duration($interval);
echo $d->iso;        // "PT2H30M"
echo $d->toSeconds(); // 9000
```

### From the diff between two dates

```php
$start = new DateTime('2024-01-01');
$end   = new DateTime('2024-12-31');
$d     = new Iso8601Duration($start->diff($end));
echo $d->iso; // e.g. "P11M30D"
```

### Domain use case — expiry computation

```php
use org\iso\Iso8601Duration;

function computeExpiry(DateTime $issuedAt, string $ttl): DateTime
{
    $duration = new Iso8601Duration($ttl);
    return $duration->addTo($issuedAt);
}

$expiry = computeExpiry(new DateTime('now'), 'P30D');
```

### Error handling

```php
new Iso8601Duration('INVALID');  // InvalidArgumentException
new Iso8601Duration('P');        // throws (no component)
new Iso8601Duration('1Y2M');     // throws (missing P prefix)
```

## Related

- Helpers: [`isIso8601Duration`](helpers/isIso8601Duration.md), [`toIso8601Duration`](helpers/toIso8601Duration.md)
- [`Iso8601Interval`](Iso8601Interval.md) — uses a duration in the `<start>/<duration>` and `<duration>/<end>` forms
- [`Iso8601Recurrence`](Iso8601Recurrence.md) — uses the interval (and its duration) to compute the repetition period

## See also

- [ISO 8601 — durations](https://en.wikipedia.org/wiki/ISO_8601#Durations)
- [PHP `DateInterval`](https://www.php.net/manual/en/class.dateinterval.php)
- [*Value-object* pattern](../../guides/value-objects.md)
