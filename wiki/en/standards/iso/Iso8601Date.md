# Iso8601Date

> 🇫🇷 [Version française](../../../fr/standards/iso/Iso8601Date.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Calendar dates](https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates) |
> | **Namespace** | `org\iso\Iso8601Date` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Date.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Date.php) |
> | **Since** | `1.0.2` |

## Overview

`Iso8601Date` wraps an ISO 8601 calendar date in **strict extended format** `YYYY-MM-DD`. The class keeps a bidirectional synchronization between the ISO string and an internal `DateTimeImmutable`, and exposes the components (`year`, `month`, `day`, `weekday`, `dayOfYear`) as read-only properties.

**Strict validation:**
- The basic format (`YYYYMMDD`) is **rejected** — see `Iso8601Date::PATTERN`.
- Calendar validity is enforced (Feb 29 only on leap years, etc.).
- Month and day must be *zero-padded* (`05`, not `5`).

It is the *date-only* counterpart of [`Iso8601Time`](Iso8601Time.md) and the [`datePart`](Iso8601DateTime.md#composition) component of [`Iso8601DateTime`](Iso8601DateTime.md).

## API

### Constants

| Name | Value | Description |
|---|---|---|
| `ZERO` | `'1970-01-01'` | Default date (Unix epoch) |
| `FORMAT` | `'Y-m-d'` | PHP `date()` format |
| `PATTERN` | (regex) | Strict extended-format validation |
| `YEAR` / `MONTH` / `DAY` | `'Y'` / `'m'` / `'d'` | Component `date()` format characters |
| `WEEKDAY` | `'N'` | ISO day-of-week (1=Monday..7=Sunday) |
| `DAY_OF_YEAR` | `'z'` | Day of year (0-based in PHP; the property returns 1-based) |

### Properties

| Name | Type | Access | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | ISO 8601 string, e.g. `"2026-05-14"` |
| `$date` | `DateTimeInterface` | get/set | Internal `DateTimeImmutable` |
| `$year` | `int` | get | 4-digit year |
| `$month` | `int` | get | Month 1–12 |
| `$day` | `int` | get | Day of month 1–31 |
| `$weekday` | `int` | get | ISO day-of-week (1=Monday..7=Sunday) |
| `$dayOfYear` | `int` | get | 1-based day of year (1 = Jan 1, 366 = Dec 31 on leap years) |

### Methods

| Signature | Description |
|---|---|
| `__construct(string\|DateTimeInterface\|null $date = null)` | Creates an instance from an ISO string, a native object, or `null` (epoch) |
| `__toString(): string` | Returns the ISO string |

## Examples

### Creation and component access

```php
use org\iso\Iso8601Date;

$d = new Iso8601Date('2026-05-14');
echo $d->year;       // 2026
echo $d->month;      // 5
echo $d->day;        // 14
echo $d->weekday;    // 4 (Thursday)
echo $d->dayOfYear;  // 134
```

### From a `DateTimeImmutable`

```php
$dt = new DateTimeImmutable('2024-02-29 12:34:56');
$d  = new Iso8601Date($dt);
echo $d->iso; // "2024-02-29" (the time is ignored)
```

### Round-trip via setters

```php
$d = new Iso8601Date('2026-05-14');

// Modify via $iso
$d->iso = '2030-12-31';
echo $d->year; // 2030

// Modify via $date
$d->date = new DateTimeImmutable('1999-01-01');
echo $d->iso; // "1999-01-01"
```

### Domain use case — form date validation

```php
use org\iso\Iso8601Date;
use InvalidArgumentException;

function validateBirthDate(string $input): Iso8601Date
{
    try
    {
        $date = new Iso8601Date($input);
    }
    catch (InvalidArgumentException $e)
    {
        throw new InvalidArgumentException("Invalid birth date: $input");
    }

    if ($date->year < 1900 || $date->date > new DateTimeImmutable('today'))
    {
        throw new InvalidArgumentException("Birth date out of range: $input");
    }

    return $date;
}
```

### Error handling — rejected formats

```php
new Iso8601Date('INVALID');     // InvalidArgumentException
new Iso8601Date('20260514');    // throws (basic format rejected)
new Iso8601Date('2023-02-29');  // throws (2023 is not a leap year)
new Iso8601Date('2026-5-14');   // throws (month not zero-padded)
new Iso8601Date('2026/05/14');  // throws (wrong separator)
```

## Related

- [`Iso8601Time`](Iso8601Time.md) — time-only counterpart
- [`Iso8601DateTime`](Iso8601DateTime.md) — combines date + time (composition via `datePart`)
- Helpers: [`isIso8601Date`](helpers/isIso8601Date.md), [`toIso8601Date`](helpers/toIso8601Date.md)
- [`Iso8601Format`](Iso8601Format.md) — format constants used internally

## See also

- [ISO 8601 — calendar dates](https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates)
- [PHP `DateTimeImmutable`](https://www.php.net/manual/en/class.datetimeimmutable.php)
- [PHP `checkdate()`](https://www.php.net/manual/en/function.checkdate.php) — used for calendar validation
- [Project *value-object* pattern](../../guides/value-objects.md)
