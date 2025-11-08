# Oihana PHP – Standards

![Oihana PHP System](https://raw.githubusercontent.com/BcommeBois/oihana-php-standards/main/assets/images/oihana-php-standards-logo-inline-512x160.png)

**Oihana PHP – Standards** is a library of **constants**, **enumerations**, and **helpers** based on major international standards (ISO, UN, UN/CEFACT, etc.).  

It is designed for **strong typing**, **validation**, and **easy lookups** in your PHP applications.

[![Latest Version](https://img.shields.io/packagist/v/oihana/php-standards.svg?style=flat-square)](https://packagist.org/packages/oihana/php-standards)  
[![Total Downloads](https://img.shields.io/packagist/dt/oihana/php-standards.svg?style=flat-square)](https://packagist.org/packages/oihana/php-standards)  
[![License](https://img.shields.io/packagist/l/oihana/php-standards.svg?style=flat-square)](LICENSE)

---

## 📑 Table of Contents
1. [Installation](#-installation)
2. [Features](#-features)
    - [Namespace Overview](#-namespace-overview)
    - [Available Enumerations](#-available-enumerations)
3. [Core Helper Methods](#-core-helper-methods-constantstrait)
4. [Usage Examples](#-usage-examples)
5. [License](#-license)
6. [Author](#-author)

---

## 📦 Installation

> **Requires [PHP 8.4+](https://php.net/releases/)**

Install via [Composer](https://getcomposer.org):

```bash
composer require oihana/php-standards
```

---

## ✨ Features

- **Ready-to-use enumerations** for currencies, languages, scripts, country codes, measurement units, package types, and more.
- **Built-in helpers** for validation, lookups, and cross-conversions (e.g., code ↔ name ↔ symbol).
- **Clear namespace organization** for quick navigation and maintainability.

### 🗂 Namespace Overview

| Namespace                     | Description |
|--------------------------------|-------------|
| `org\iso`                      | ISO-related enumerations (currencies, languages, scripts). |
| `org\unstats`                  | United Nations M49 country and area codes (alpha-3). |
| `org\unece\uncefact`           | UN/CEFACT recommendations (units of measure, package types) with cross lookups. |

---

## 📚 Available Enumerations

| Class                              | Description | Example                               |
|------------------------------------|-------------|---------------------------------------|
| `org\iso\ISO4217`                  | ISO 4217 currency codes (alpha-3) | `ISO4217::USD // 'USD'`               |
| `org\iso\ISO639_1`                 | ISO 639-1 language codes (alpha-2) | `ISO639_1::EN // 'en'`                |
| `org\iso\ISO15924`                 | ISO 15924 script codes | `ISO15924::LATN // 'Latn'`            |
| `org\iso\ISO3166_1`                | ISO 3166-1 country codes (alpha-2) | `ISO3166_1::FR // 'FR'`               |
| `org\unstats\UNM49`                | UN M49 country/area codes (alpha-3) | `UNM49::FRA // 'FRA'`                 |
| `org\unece\uncefact\MeasureCode`   | UN/CEFACT Rec. 20 unit codes | `MeasureCode::KILOGRAM // 'KGM'`      |
| `org\unece\uncefact\MeasureName`   | UN/CEFACT unit names | `MeasureName::KILOGRAM // 'Kilogram'` |
| `org\unece\uncefact\MeasureSymbol` | UN/CEFACT unit symbols | `MeasureSymbol::KILOGRAM // 'kg'`     |
| `org\unece\uncefact\PackageCode`   | UN/CEFACT Rec. 21 package type codes | `PackageCode::BOX // 'BX'`            |
| `org\unece\uncefact\PackageName`   | UN/CEFACT package type names | `PackageName::BOX // 'Box'`           |

---

## 🔧 Core Helper Methods (`ConstantsTrait`)

All constant classes use `oihana\reflections\traits\ConstantsTrait`, which provides:

| Method | Description |
|--------|-------------|
| `getAll()` | Returns a `[name => value]` map of constants. |
| `enums(int $flags = SORT_STRING)` | Returns unique sorted values. |
| `includes(mixed $value, bool $strict = false, ?string $separator = null)` | Checks if a value exists. |
| `get(mixed $value, mixed $default = null)` | Returns the value if valid, otherwise `$default`. |
| `validate(mixed $value, bool $strict = true, ?string $separator = null)` | Validates or throws an exception. |
| `getConstant(string $value, array|string|null $separator = null)` | Returns constant name(s) for a given value. |
| `resetCaches()` | Clears internal caches. |

---

## 💡 Usage Examples

### Basic Enum Access
```php
use org\iso\ISO4217;
use org\iso\ISO639_1;

$usd = ISO4217::USD; // 'USD'
$en  = ISO639_1::EN;  // 'en'
```

### Validation & Listing
```php
use org\iso\ISO4217;

ISO4217::validate('EUR');             // OK
$isValid = ISO4217::includes('JPY');  // true
$all     = ISO4217::getAll();         // ['AED' => 'AED', ...]
$values  = ISO4217::enums();          // ['AED', 'AFN', ...]
```

### UN/CEFACT Unit Cross-Lookups
```php
use org\unece\uncefact\MeasureCode;
use org\unece\uncefact\MeasureName;
use org\unece\uncefact\MeasureSymbol;

$code   = MeasureCode::KILOGRAM;        // 'KGM'
$name   = MeasureCode::getName($code);  // 'Kilogram'
$symbol = MeasureCode::getSymbol($code);// 'kg'

// Reverse lookups
$fromName   = MeasureCode::getFromName('Kilogram'); // 'KGM'
$fromSymbol = MeasureCode::getFromSymbol('kg');     // 'KGM'
```

### UN/CEFACT Package Conversion
```php
use org\unece\uncefact\PackageCode;
use org\unece\uncefact\PackageName;

$bx   = PackageCode::BOX;            // 'BX'
$name = PackageCode::getName($bx);   // 'Box'
$code = PackageName::getCode('Box'); // 'BX'
```

### ISO 3166-1 Country Codes
```php
use org\iso\ISO3166_1;

$fr = ISO3166_1::FR;        // 'FR'
ISO3166_1::validate('US');  // OK
$all = ISO3166_1::getAll(); // ['FR' => 'FR', ...]
```

### UN M49 Country Codes
```php
use org\unstats\UNM49;

$fr = UNM49::FRA; // 'FRA'
```

### Utility: ISO 8601 Durations

The `Iso8601Duration` class (PHP 8.4+) provides robust handling of duration strings using property hooks.

```php
use org\iso\Iso8601Duration;
use DateTime;

// 1. Create a duration
$duration = new Iso8601Duration('P1M5D'); // 1 Month and 5 Days

// 2. Use helper methods to add/subtract
$date = new DateTime('2024-01-10');
$newDate = $duration->addTo($date);

echo $newDate->format('Y-m-d'); // '2024-02-15'

// 3. Properties are synchronized
$duration->iso = 'PT2H30M'; // Change duration to 2 hours 30 minutes
echo $duration->toSeconds(); // 9000

$date2 = new DateTime('2024-01-01 10:00:00');
echo $duration->subtractFrom($date2)->format('Y-m-d H:i:s'); // '2024-01-01 07:30:00'

// 4. Create from DateInterval
$interval = $date->diff($newDate);
$durationFromInterval = new Iso8601Duration($interval);
echo $durationFromInterval->iso; // 'P1M5D'
```

### Helper: toIso8601Duration()

Converts a `DateInterval` object directly into a normalized ISO 8601 string.

```php
use function org\iso\helpers\toIso8601Duration;
use DateTime;
use DateInterval;

// From a diff
$start = new DateTime('2024-01-01');
$end = new DateTime('2024-03-15');
$interval = $start->diff($end);

echo toIso8601Duration($interval); // 'P2M14D'

// From a new interval
$interval = new DateInterval('PT1H30M');
echo toIso8601Duration($interval); // 'PT1H30M'
```

---

## 📜 License
**MPL 2.0** — Mozilla Public License Version 2.0

---

## 👤 Author
- **Marc ALCARAZ** (aka *eKameleon*)  
- 📧 [marc@ooop.fr](mailto:marc@ooop.fr)  
- 🌐 [http://www.ooop.fr](http://www.ooop.fr)
