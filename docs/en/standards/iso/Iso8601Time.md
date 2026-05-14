# Iso8601Time

> 🇫🇷 [Version française](../../../fr/standards/iso/Iso8601Time.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Times](https://en.wikipedia.org/wiki/ISO_8601#Times) |
> | **Namespace** | `org\iso\Iso8601Time` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Time.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Time.php) |
> | **Since** | `1.0.1` |

## Overview

`Iso8601Time` represents a time-of-day per ISO 8601, with `T` prefix and optional timezone (`Z` or `±HH:MM`).

Accepted forms:
- `T14:30:00Z` — 14:30:00 UTC
- `T08:15:30+02:00` — 08:15:30 in UTC+2
- `T23:59:59` — 23:59:59 local time (no offset)

The class normalizes the `T` prefix automatically (input `14:30:00Z` becomes `T14:30:00Z`).

## API

### Constants

| Name | Value | Description |
|---|---|---|
| `ZERO` | `'00:00:00'` | Zero time (no prefix) |
| `TIME_ZERO` | `'T00:00:00'` | Zero time with prefix |
| `FORMAT` | `'H:i:s'` | PHP `date()` format |
| `PATTERN` | (regex) | Strict format validation |
| `TIME` | `'T'` | Time designator prefix |
| `TIME_ZONE` | `'Z'` | UTC designator |
| `HOUR` / `MINUTE` / `SECOND` | `'H'` / `'i'` / `'s'` | Component `date()` format characters |

### Properties

| Name | Type | Access | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | ISO 8601 string, e.g. `"T14:30:00Z"` |
| `$time` | `DateTimeInterface` | get/set | Internal `DateTimeImmutable` |
| `$hours` | `int` | get | Hours 0–23 |
| `$minutes` | `int` | get | Minutes 0–59 |
| `$seconds` | `int` | get | Seconds 0–59 |
| `$timezone` | `?DateTimeZone` | get | Timezone (or `null` if absent) |

### Methods

| Signature | Description |
|---|---|
| `__construct(string\|DateTimeInterface\|null $time = null)` | Creates an instance from an ISO string, a native object, or `null` |
| `__toString(): string` | Returns the ISO string |

## Examples

### Creation and component access

```php
use org\iso\Iso8601Time;

$t = new Iso8601Time('T14:30:00Z');
echo $t->hours;    // 14
echo $t->minutes;  // 30
echo $t->seconds;  // 0
echo $t->iso;      // "T14:30:00Z"
```

### From a `DateTimeImmutable`

```php
$dt = new DateTimeImmutable('08:15:30', new DateTimeZone('+02:00'));
$t  = new Iso8601Time($dt);
echo $t->iso;                              // "T08:15:30+02:00"
echo $t->timezone->getName();              // "+02:00"
```

### `T` prefix added automatically

```php
$t = new Iso8601Time('23:45:01Z'); // no T
echo $t->iso; // "T23:45:01Z"
```

### Round-trip via setters

```php
$t = new Iso8601Time();
$t->iso = 'T23:59:59+01:00';
echo $t->hours;                            // 23
$t->time = new DateTimeImmutable('12:34:56', new DateTimeZone('UTC'));
echo $t->iso;                              // "T12:34:56Z"
```

### Domain use case — opening hours check

```php
use org\iso\Iso8601Time;

$opening = new Iso8601Time('T09:00:00');
$closing = new Iso8601Time('T18:30:00');

$now = new Iso8601Time(new DateTimeImmutable('now'));
$isOpen = $now->time >= $opening->time && $now->time < $closing->time;
```

### Error handling

```php
new Iso8601Time('INVALID');     // InvalidArgumentException
new Iso8601Time('T24:00:00');   // throws (invalid hour)
new Iso8601Time('T12:60:00');   // throws (invalid minute)
```

## Related

- [`Iso8601Date`](Iso8601Date.md) — date-only counterpart
- [`Iso8601DateTime`](Iso8601DateTime.md) — combines date + time (composition via `timePart`)
- Helpers: [`isIso8601Time`](helpers/isIso8601Time.md), [`toIso8601Time`](helpers/toIso8601Time.md)

## See also

- [ISO 8601 — times](https://en.wikipedia.org/wiki/ISO_8601#Times)
- [PHP `DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)
- [*Value-object* pattern](../../guides/value-objects.md)
