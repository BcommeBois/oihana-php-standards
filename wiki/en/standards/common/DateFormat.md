# DateFormat

> 🇫🇷 [Version française](../../../fr/standards/common/DateFormat.md)
>
> | | |
> |---|---|
> | **Standards** | [RFC 2822](https://www.rfc-editor.org/rfc/rfc2822), [RFC 7231](https://www.rfc-editor.org/rfc/rfc7231) |
> | **Namespace** | `org\common\DateFormat` |
> | **Type** | Constants class (`ConstantsTrait`) — extends [`Iso8601Format`](../iso/Iso8601Format.md) |
> | **Source** | [DateFormat.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/common/DateFormat.php) |
> | **Since** | `1.0.2` |

## Overview

`DateFormat` is an **extended catalog of date/time format patterns**. It inherits all [`Iso8601Format`](../iso/Iso8601Format.md) constants (extended + basic) and adds the most common RFC, HTTP, SQL and Unix formats.

> **On RFC 3339 / ATOM**: these formats are strictly equivalent to `Iso8601Format::DATE_TIME` (= `Y-m-d\TH:i:sP`). They are **not** redeclared here to keep `getConstant()` reverse lookup deterministic.

## Added constants (in addition to `Iso8601Format`'s)

### Email / Usenet dates

| Constant | Pattern | Example |
|---|---|---|
| `RFC822` | `D, d M y H:i:s O` | `Thu, 14 May 26 08:15:30 +0200` (2-digit year, obsolete) |
| `RFC850` | `l, d-M-y H:i:s T` | `Thursday, 14-May-26 08:15:30 UTC` (Usenet, obsolete) |
| `RFC1036` | `D, d M y H:i:s O` | Same as RFC 822 |
| `RFC1123` | `D, d M Y H:i:s O` | `Thu, 14 May 2026 08:15:30 +0200` (modern) |
| `RFC2822` | `D, d M Y H:i:s O` | `Thu, 14 May 2026 08:15:30 +0200` (modern RFC) |
| `RSS` | `D, d M Y H:i:s O` | RSS 2.0 `pubDate` format |

### HTTP

| Constant | Pattern | Example |
|---|---|---|
| `RFC7231` | `D, d M Y H:i:s \G\M\T` | `Thu, 14 May 2026 06:15:30 GMT` (HTTP IMF-fixdate, always GMT) |

### Cookies

| Constant | Pattern | Example |
|---|---|---|
| `COOKIE` | `l, d-M-Y H:i:s T` | `Thursday, 14-May-2026 08:15:30 UTC` (RFC 6265) |

### SQL / Unix

| Constant | Pattern | Example |
|---|---|---|
| `MYSQL` | `Y-m-d H:i:s` | `2026-05-14 08:15:30` (MySQL/SQLite DATETIME, space instead of T) |
| `UNIX` | `U` | `1778889330` (seconds since epoch UTC) |

## Inherited methods

All [`ConstantsTrait`](../../guides/constants-trait.md) methods (`getAll()`, `enums()`, `includes()`, `getConstant()`, …) — include both ISO constants and the added ones.

## Examples

### Formatting with inherited and added constants

```php
use org\common\DateFormat;

$dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));

// Inherited from Iso8601Format
echo $dt->format(DateFormat::DATE_TIME);        // "2026-05-14T08:15:30+02:00"
echo $dt->format(DateFormat::DATE_TIME_ZULU);   // (see Iso8601Format)

// RFC / HTTP / MySQL constants
echo $dt->format(DateFormat::RFC2822);          // "Thu, 14 May 2026 08:15:30 +0200"
echo $dt->format(DateFormat::RFC7231);          // careful: requires UTC, see below
echo $dt->format(DateFormat::MYSQL);            // "2026-05-14 08:15:30"
```

### RFC 7231 — convert to UTC first

```php
$dt = new DateTimeImmutable('2026-05-14T08:15:30+02:00');
$utc = $dt->setTimezone(new DateTimeZone('UTC'));
echo $utc->format(DateFormat::RFC7231); // "Thu, 14 May 2026 06:15:30 GMT"
```

### Reverse lookup — ISO + non-ISO aggregation

```php
DateFormat::includes(\org\iso\Iso8601Format::DATE);   // true (inherited)
DateFormat::includes(DateFormat::MYSQL);              // true
DateFormat::getConstant('D, d M Y H:i:s O');          // "RFC1123" (or "RFC2822" / "RSS" — share the same value)
DateFormat::getConstant('Y-m-d H:i:s');               // "MYSQL"
```

### Domain use case — HTTP `Last-Modified` header

```php
use org\common\DateFormat;

function lastModifiedHeader(DateTimeImmutable $dt): string
{
    $utc = $dt->setTimezone(new DateTimeZone('UTC'));
    return 'Last-Modified: ' . $utc->format(DateFormat::RFC7231);
}
```

## ⚠️ Notes

- **Shared values**: several constants share the same pattern (`RFC1123`, `RFC2822`, `RSS` = `'D, d M Y H:i:s O'`). `getConstant()` may return an array in that case.
- **RFC 7231 and timezone**: the pattern forces `GMT` literally; passing a non-UTC date produces an incorrect time. Convert first with `setTimezone(new DateTimeZone('UTC'))`.

## Related

- [`Iso8601Format`](../iso/Iso8601Format.md) — parent class
- [`TimePrecision`](../iso/TimePrecision.md) — for inherited fractional formats

## See also

- [RFC 2822](https://www.rfc-editor.org/rfc/rfc2822)
- [RFC 7231](https://www.rfc-editor.org/rfc/rfc7231)
- [PHP `date()` format characters](https://www.php.net/manual/en/datetime.format.php)
- [ConstantsTrait](../../guides/constants-trait.md)
