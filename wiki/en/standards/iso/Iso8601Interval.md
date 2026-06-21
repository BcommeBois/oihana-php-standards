# Iso8601Interval

> 🇫🇷 [Version française](../../../fr/standards/iso/Iso8601Interval.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Time intervals](https://en.wikipedia.org/wiki/ISO_8601#Time_intervals) |
> | **Namespace** | `org\iso\Iso8601Interval` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Interval.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Interval.php) |
> | **Since** | `1.0.2` |

## Overview

`Iso8601Interval` represents an ISO 8601 time interval, composed of two expressions joined by `/`. Three bounded forms are supported:

| Form | Example |
|---|---|
| `<start>/<end>` | `2026-05-14T00:00:00Z/2026-05-15T00:00:00Z` |
| `<start>/<duration>` | `2026-05-14T00:00:00Z/P1D` |
| `<duration>/<end>` | `P1D/2026-05-15T00:00:00Z` |

**Always available:** `start` and `end` are computed automatically when the input form omits one. `duration` is `null` when the input form was `<start>/<end>`.

**Round-trip:** the `iso` property preserves the original form (no forced canonicalization).

**Rejected:** single duration (`P1D`), two durations (`P1D/P2D`), open intervals (`--/...`), `end` before `start`.

## API

### Constants

| Name | Value | Description |
|---|---|---|
| `SEPARATOR` | `'/'` | Interval separator |
| `ZERO` | `'1970-01-01T00:00:00Z/PT0S'` | Zero-length interval at the epoch |

### Properties

| Name | Type | Access | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | ISO 8601 string, original form preserved |
| `$start` | `Iso8601DateTime` | get | Start (always present) |
| `$end` | `Iso8601DateTime` | get | End (always present, computed if needed) |
| `$duration` | `?Iso8601Duration` | get | Duration if present in the input, otherwise `null` |

### Methods

| Signature | Description |
|---|---|
| `__construct(?string $iso = null)` | Creates an instance |
| `contains(DateTimeInterface\|Iso8601DateTime $instant): bool` | Inclusion test (half-open `[start, end)`) |
| `overlaps(self $other): bool` | Overlap test against another interval (half-open) |
| `__toString(): string` | Returns the ISO string |

## Half-open semantics

`contains()` and `overlaps()` treat intervals as **`[start, end)`**: the start is included, the end is excluded. Consequences:
- Two adjacent intervals (one ending where the other begins) do not overlap.
- `contains(end)` always returns `false`.

## Examples

### Form `<start>/<end>`

```php
use org\iso\Iso8601Interval;

$i = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
echo $i->start->iso;   // "2026-05-14T00:00:00Z"
echo $i->end->iso;     // "2026-05-15T00:00:00Z"
$i->duration;           // null (form <start>/<end>)
```

### Form `<start>/<duration>` — `end` computed

```php
$i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');
echo $i->end->iso;       // "2026-05-15T00:00:00Z" (computed)
echo $i->duration->iso;  // "P1D"
echo $i->iso;            // "2026-05-14T00:00:00Z/P1D" (form preserved)
```

### Form `<duration>/<end>` — `start` computed

```php
$i = new Iso8601Interval('PT2H/2026-05-14T10:00:00Z');
echo $i->start->iso;     // "2026-05-14T08:00:00Z"
echo $i->duration->iso;  // "PT2H"
```

### Instant containment

```php
$i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');

$i->contains(new DateTimeImmutable('2026-05-14T00:00:00Z')); // true  (start included)
$i->contains(new DateTimeImmutable('2026-05-14T12:00:00Z')); // true
$i->contains(new DateTimeImmutable('2026-05-15T00:00:00Z')); // false (end excluded)
```

### Overlap

```php
$a = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
$b = new Iso8601Interval('2026-05-14T18:00:00Z/2026-05-16T00:00:00Z');
$a->overlaps($b); // true

$c = new Iso8601Interval('2026-05-15T00:00:00Z/2026-05-16T00:00:00Z'); // adjacent to $a
$a->overlaps($c); // false (half-open)
```

### Domain use case — coupon validity window

```php
use org\iso\Iso8601Interval;

function isCouponValid(string $couponInterval, DateTimeImmutable $at): bool
{
    return (new Iso8601Interval($couponInterval))->contains($at);
}

isCouponValid('2026-01-01T00:00:00Z/2026-12-31T23:59:59Z', new DateTimeImmutable('now'));
```

### Error handling

```php
new Iso8601Interval('P1D');                                      // throws (single duration)
new Iso8601Interval('P1D/P2D');                                  // throws (two durations)
new Iso8601Interval('2026-05-15T00:00:00Z/2026-05-14T00:00:00Z');// throws (end < start)
new Iso8601Interval('--/2026-05-15T00:00:00Z');                  // throws (open interval)
```

## Related

- [`Iso8601DateTime`](Iso8601DateTime.md) — type of `$start` and `$end`
- [`Iso8601Duration`](Iso8601Duration.md) — type of `$duration`
- [`Iso8601Recurrence`](Iso8601Recurrence.md) — uses an `Iso8601Interval` as its period
- Helpers: [`isIso8601Interval`](helpers/isIso8601Interval.md)

## See also

- [ISO 8601 — time intervals](https://en.wikipedia.org/wiki/ISO_8601#Time_intervals)
- [*Value-object* pattern](../../guides/value-objects.md)
