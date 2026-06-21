# Guide — *Value-object* pattern

> 🇫🇷 [Version française](../../fr/guides/value-objects.md)

All classes that represent a **typed value** (Iso8601Date, Iso8601Time, Iso8601DateTime, Iso8601Duration, Iso8601Interval, Iso8601Recurrence, Locale) follow the same pattern, built on PHP 8.4 *property hooks*.

## Principles

### 1. Single constructor

The constructor accepts a string (ISO form), an equivalent native PHP object (e.g. `DateTimeInterface`), or `null` for the default value.

```php
new Iso8601Date('2026-05-14');
new Iso8601Date(new DateTimeImmutable('2026-05-14'));
new Iso8601Date(); // default value (ZERO)
```

### 2. `$iso` property always present

Every value-object exposes an `$iso` (string) property as **read/write**. Assigning a new value validates the string, updates internal components and keeps it canonical.

```php
$d = new Iso8601Date('2026-05-14');
echo $d->iso;          // "2026-05-14"

$d->iso = '2030-01-01'; // rewrites everything
echo $d->year;          // 2030
```

### 3. Native property ↔ `$iso` synchronized

For ISO 8601 date/time classes, a native property (`$date`, `$time`, `$dateTime`, `$interval`) mirrors the corresponding PHP object.

```php
$d = new Iso8601Date();
$d->date = new DateTimeImmutable('2026-05-14');
echo $d->iso;          // "2026-05-14" (auto-updated)
```

### 4. Common constants per class

| Constant | Role |
|---|---|
| `ZERO` | Default value returned if nothing is passed to the constructor. |
| `FORMAT` | PHP `date()` format used for serialization (when applicable). |
| `PATTERN` | Strict validation regex (when applicable). |

### 5. `__toString()` returns the ISO form

Every value-object can be cast to string:

```php
$d = new Iso8601Date('2026-05-14');
echo "Date: $d\n"; // "Date: 2026-05-14"
```

### 6. Validation by exception

Any invalid value passed to `$iso` or the constructor throws `InvalidArgumentException` with an explicit message.

```php
new Iso8601Date('INVALID');   // throws InvalidArgumentException
new Iso8601Date('20260514');  // throws (basic format rejected, strict extended only)
new Iso8601Date('2023-02-29');// throws (invalid calendar date)
```

## Classes following this pattern

| Class | Native PHP type | `ZERO` |
|---|---|---|
| [`Iso8601Date`](../standards/iso/Iso8601Date.md) | `DateTimeImmutable` | `1970-01-01` |
| [`Iso8601Time`](../standards/iso/Iso8601Time.md) | `DateTimeImmutable` | `T00:00:00` |
| [`Iso8601DateTime`](../standards/iso/Iso8601DateTime.md) | `DateTimeImmutable` | `1970-01-01T00:00:00Z` |
| [`Iso8601Duration`](../standards/iso/Iso8601Duration.md) | `DateInterval` | `P0D` |
| [`Iso8601Interval`](../standards/iso/Iso8601Interval.md) | — | `1970-01-01T00:00:00Z/PT0S` |
| [`Iso8601Recurrence`](../standards/iso/Iso8601Recurrence.md) | — | `R0/1970-01-01T00:00:00Z/PT0S` |
| [`Locale`](../standards/ietf/Locale.md) | — | `und` |

## See also

- [ConstantsTrait](constants-trait.md) — for constants classes
- [Helpers convention](helpers.md)
