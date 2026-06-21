# Oihana PHP – Standards

![Oihana PHP System](https://raw.githubusercontent.com/BcommeBois/oihana-php-standards/main/assets/images/oihana-php-standards-logo-inline-512x160.png)

**Oihana PHP – Standards** is a library of **constants**, **value-objects** and **helpers** built on top of international standards (ISO, IETF, UN/CEFACT, UN M49).

It is designed for **strong typing**, **validation** and **easy lookups** in your PHP 8.4+ applications.

[![Latest Version](https://img.shields.io/packagist/v/oihana/php-standards.svg?style=flat-square)](https://packagist.org/packages/oihana/php-standards)
[![Total Downloads](https://img.shields.io/packagist/dt/oihana/php-standards.svg?style=flat-square)](https://packagist.org/packages/oihana/php-standards)
[![License](https://img.shields.io/packagist/l/oihana/php-standards.svg?style=flat-square)](LICENSE)

---

## 📚 Documentation

📖 **[API documentation](https://bcommebois.github.io/oihana-php-standards)** — the full phpDocumentor API reference (classes, methods, constants).

Guides and standards references are available in two languages:

- 🇬🇧 **[English documentation](wiki/en/README.md)**
- 🇫🇷 **[Documentation française](wiki/fr/README.md)**

Quick links: [Getting started](wiki/en/getting-started.md) · [ConstantsTrait](wiki/en/guides/constants-trait.md) · [Value-objects](wiki/en/guides/value-objects.md) · [Helpers convention](wiki/en/guides/helpers.md)

---

## 📦 Installation

> Requires **[PHP 8.4+](https://php.net/releases/)** (uses property hooks).

```bash
composer require oihana/php-standards
```

---

## 🗂 What's inside

| Namespace | Coverage |
|---|---|
| [`org\iso`](wiki/en/standards/iso/README.md) | ISO 8601 (date/time/duration/interval/recurrence + format), ISO 3166-1, ISO 639-1, ISO 4217, ISO 15924 |
| [`org\ietf`](wiki/en/standards/ietf/README.md) | BCP 47 / RFC 5646 locale tags |
| [`org\unece\uncefact`](wiki/en/standards/unece/README.md) | UN/CEFACT units of measure (Rec. 20) and package types (Rec. 21) |
| [`org\unstats`](wiki/en/standards/unstats/README.md) | UN M49 country/area codes |
| [`org\common`](wiki/en/standards/common/README.md) | Cross-standard format catalogs (date, number) |

---

## 💡 At a glance

```php
use org\iso\ISO4217;
use org\iso\Iso8601DateTime;
use org\ietf\Locale;

// Constants with built-in validation/lookup
ISO4217::EUR;                                  // "EUR"
ISO4217::includes('XYZ');                      // false

// ISO 8601 value-objects with property hooks
$dt = new Iso8601DateTime('2026-05-14T08:15:30+02:00');
$dt->datePart->year;                           // 2026
$dt->timePart->hours;                          // 8

// BCP 47 locales with cross-validation against ISO
new Locale('zh-Hant-TW', strict: true);        // OK
new Locale('zz-ZZ', strict: true);             // throws
```

Many more examples in the [documentation](wiki/en/README.md).

---

## 📜 License

**[MPL 2.0](LICENSE)** — Mozilla Public License Version 2.0

## 👤 Author

- **Marc ALCARAZ** (aka *eKameleon*)
- 📧 [marc@ooop.fr](mailto:marc@ooop.fr)
- 🌐 [https://www.ooop.fr](https://www.ooop.fr)
