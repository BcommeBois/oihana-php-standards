# Iso8601Recurrence

> 🇫🇷 [Version française](../../../fr/standards/iso/Iso8601Recurrence.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Repeating intervals](https://en.wikipedia.org/wiki/ISO_8601#Repeating_intervals) |
> | **Namespace** | `org\iso\Iso8601Recurrence` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Recurrence.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Recurrence.php) |
> | **Since** | `1.0.2` |

## Overview

`Iso8601Recurrence` represents an ISO 8601 repeating interval: `R[n]/<interval>`, where `n` is the repetition count (absent = infinite) and `<interval>` is a bounded [`Iso8601Interval`](Iso8601Interval.md).

Examples:
- `R5/2026-05-14T00:00:00Z/P1D` — 5 daily repetitions starting May 14
- `R/2026-05-14T00:00:00Z/PT1H` — every hour, infinite
- `R10/P1D/2026-05-15T00:00:00Z` — 10 daily repetitions ending May 15

The `occurrences()` method is a **lazy generator**: no occurrence is computed until iteration.

## API

### Constants

| Name | Value | Description |
|---|---|---|
| `DESIGNATOR` | `'R'` | Recurrence designator prefix |
| `ZERO` | `'R0/1970-01-01T00:00:00Z/PT0S'` | Zero recurrence (0 repetitions at epoch) |
| `PATTERN` | `'/^R(\d*)\/(.+)$/'` | Format validation |

### Properties

| Name | Type | Access | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | ISO 8601 string, form preserved |
| `$count` | `?int` | get | Repetition count, `null` = infinite |
| `$interval` | `Iso8601Interval` | get | Underlying interval |

### Methods

| Signature | Description |
|---|---|
| `__construct(?string $iso = null)` | Creates an instance |
| `occurrences(?int $max = null): Generator<int, DateTimeImmutable>` | Yields the start instant of each occurrence |
| `__toString(): string` | Returns the ISO string |

### Semantics of `occurrences()`

| `count` | `$max` | Result |
|---|---|---|
| finite | `null` | Yields `count` occurrences |
| finite | provided | Yields `min(count, $max)` occurrences |
| `null` (infinite) | provided | Yields `$max` occurrences |
| `null` (infinite) | `null` | Throws `LogicException` (infinite loop avoided) |

## Examples

### Finite recurrence

```php
use org\iso\Iso8601Recurrence;

$r = new Iso8601Recurrence('R3/2026-05-14T00:00:00Z/P1D');
foreach ($r->occurrences() as $instant)
{
    echo $instant->format('Y-m-d') . PHP_EOL;
}
// 2026-05-14
// 2026-05-15
// 2026-05-16
```

### Infinite recurrence — `max` required

```php
$r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');
foreach ($r->occurrences(max: 5) as $instant)
{
    echo $instant->format('Y-m-d') . PHP_EOL;
}
// 5 consecutive dates

$r->occurrences(); // LogicException: max required for infinite
```

### `max` caps a finite `count`

```php
$r = new Iso8601Recurrence('R100/2026-05-14T00:00:00Z/P1D');
$first10 = iterator_to_array($r->occurrences(max: 10), false);
// 10 occurrences only (instead of 100)
```

### Interval expressed as `<start>/<end>` (no explicit duration)

```php
$r = new Iso8601Recurrence('R3/2026-05-14T00:00:00Z/2026-05-14T12:00:00Z');
// Period between occurrences is computed from end - start = 12 hours
foreach ($r->occurrences() as $instant)
{
    echo $instant->format('Y-m-d\TH:i:sP') . PHP_EOL;
}
// 2026-05-14T00:00:00+00:00
// 2026-05-14T12:00:00+00:00
// 2026-05-15T00:00:00+00:00
```

### Form-preserving round-trip

```php
$cases = [
    'R/2026-05-14T00:00:00Z/P1D',
    'R5/2026-05-14T00:00:00Z/P1D',
    'R10/P1D/2026-05-15T00:00:00Z',
];

foreach ($cases as $iso)
{
    echo (new Iso8601Recurrence($iso))->iso . PHP_EOL; // identical to $iso
}
```

### Domain use case — appointment slots

```php
use org\iso\Iso8601Recurrence;

function nextSlots(string $recurrence, int $maxSlots = 10): array
{
    return iterator_to_array(
        (new Iso8601Recurrence($recurrence))->occurrences(max: $maxSlots),
        false
    );
}

// 30-minute slots through the day
$slots = nextSlots('R16/2026-05-14T09:00:00Z/PT30M');
```

### Error handling

```php
new Iso8601Recurrence('INVALID');                    // throws
new Iso8601Recurrence('2026-05-14T00:00:00Z/P1D');   // throws (missing R)
new Iso8601Recurrence('R-1/2026-05-14T00:00:00Z/P1D');// throws (negative count)
new Iso8601Recurrence('R5/P1D');                      // throws (unbounded interval)

$r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');
iterator_to_array($r->occurrences(), false);          // LogicException
```

## Related

- [`Iso8601Interval`](Iso8601Interval.md) — type of `$interval`
- Helpers: [`isIso8601Recurrence`](helpers/isIso8601Recurrence.md)

## See also

- [ISO 8601 — repeating intervals](https://en.wikipedia.org/wiki/ISO_8601#Repeating_intervals)
- [PHP `Generator`](https://www.php.net/manual/en/class.generator.php)
- [*Value-object* pattern](../../guides/value-objects.md)
