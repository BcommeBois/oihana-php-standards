# Getting started

> 🇫🇷 [Version française](../fr/getting-started.md)

## Requirements

- **PHP 8.4+** (the library uses *property hooks* introduced in 8.4)
- [Composer](https://getcomposer.org)

## Installation

```bash
composer require oihana/php-standards
```

## First usage — 3 examples

### 1. Use an ISO constant

```php
use org\iso\ISO4217;

$usd = ISO4217::USD;             // "USD"
ISO4217::includes('EUR');        // true
ISO4217::getConstant('JPY');     // "JPY" (constant name)
```

See the [ConstantsTrait](guides/constants-trait.md) guide for the full list of shared methods.

### 2. Manipulate an ISO 8601 date

```php
use org\iso\Iso8601Date;

$date = new Iso8601Date('2026-05-14');
echo $date->year;       // 2026
echo $date->weekday;    // 4 (Thursday, ISO 1=Monday..7=Sunday)
echo $date->dayOfYear;  // 134

// Round-trip via DateTimeImmutable
$dt = new DateTimeImmutable('2030-12-31');
echo (new Iso8601Date($dt))->iso; // "2030-12-31"
```

See the [Value-objects](guides/value-objects.md) guide for the common pattern shared by all date/time classes and `Locale`.

### 3. Validate a format with a helper

```php
use function org\iso\helpers\isIso8601DateTime;
use function org\iso\helpers\toIso8601DateTime;

isIso8601DateTime('2026-05-14T08:15:30Z');         // true
isIso8601DateTime('2026-05-14 08:15:30Z', true);   // false (strict requires T)

$dt = new DateTimeImmutable('2026-05-14T08:15:30+02:00');
toIso8601DateTime($dt);                             // "2026-05-14T08:15:30+02:00"
```

See the [Helpers convention](guides/helpers.md) guide to understand the `is*` / `to*` / `parse*` separation.

## Next steps

- Browse the [catalog by standard](README.md#browse-by-standard)
- Read the 3 [cross-cutting guides](README.md#quick-links)
- See the [source code on GitHub](https://github.com/BcommeBois/oihana-php-standards)
