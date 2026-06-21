# Iso8601Format

> 🇫🇷 [Version française](../../../fr/standards/iso/Iso8601Format.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) |
> | **Namespace** | `org\iso\Iso8601Format` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [Iso8601Format.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Format.php) |
> | **Since** | `1.0.2` |

## Overview

`Iso8601Format` is a **catalog of ISO 8601 format patterns** ready to be passed to [`DateTimeInterface::format()`](https://www.php.net/manual/en/datetime.format.php). Two representations are supported:

- **Extended**: with separators — `2026-05-14T08:15:30+02:00`
- **Basic**: without separators — `20260514T081530+0200`

For a broader catalog including RFC, HTTP and MySQL formats, see [`DateFormat`](../common/DateFormat.md) which extends this class.

## Constants

### Date

| Constant | Value | Example |
|---|---|---|
| `DATE` | `'Y-m-d'` | `2026-05-14` |
| `DATE_BASIC` | `'Ymd'` | `20260514` |

### Date + time

| Constant | Value | Example |
|---|---|---|
| `DATE_TIME_LOCAL` | `'Y-m-d\TH:i:s'` | `2026-05-14T08:15:30` (no tz) |
| `DATE_TIME` | `'Y-m-d\TH:i:sP'` | `2026-05-14T08:15:30+02:00` |
| `DATE_TIME_ZULU` | `'Y-m-d\TH:i:s\Z'` | `2026-05-14T08:15:30Z` |
| `DATE_TIME_MILLI` | `'Y-m-d\TH:i:s.vP'` | `2026-05-14T08:15:30.123+02:00` |
| `DATE_TIME_MILLI_ZULU` | `'Y-m-d\TH:i:s.v\Z'` | `2026-05-14T08:15:30.123Z` |
| `DATE_TIME_MICRO` | `'Y-m-d\TH:i:s.uP'` | `2026-05-14T08:15:30.123456+02:00` |
| `DATE_TIME_MICRO_ZULU` | `'Y-m-d\TH:i:s.u\Z'` | `2026-05-14T08:15:30.123456Z` |
| `DATE_TIME_BASIC` | `'Ymd\THisO'` | `20260514T081530+0200` |
| `DATE_TIME_BASIC_ZULU` | `'Ymd\THis\Z'` | `20260514T081530Z` |

### Time only

| Constant | Value | Example |
|---|---|---|
| `TIME` | `'H:i:s'` | `08:15:30` |
| `TIME_OFFSET` | `'H:i:sP'` | `08:15:30+02:00` |
| `TIME_ZULU` | `'H:i:s\Z'` | `08:15:30Z` |
| `TIME_BASIC` | `'His'` | `081530` |

### Ordinal / week date

| Constant | Value | Example |
|---|---|---|
| `ORDINAL_DATE` | `'Y-z'` | `2026-134` (⚠️ PHP's `z` is 0-based) |
| `WEEK_DATE` | `'o-\WW-N'` | `2026-W20-4` |
| `WEEK_DATE_BASIC` | `'o\WWN'` | `2026W204` |
| `WEEK` | `'o-\WW'` | `2026-W20` |
| `YEAR_MONTH` | `'Y-m'` | `2026-05` |
| `YEAR` | `'Y'` | `2026` |

## Inherited methods

See the [ConstantsTrait](../../guides/constants-trait.md) guide for `getAll()`, `enums()`, `includes()`, `getConstant()`, etc.

## Examples

### Format the current date

```php
use org\iso\Iso8601Format;

$now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

echo $now->format(Iso8601Format::DATE);           // "2026-05-14"
echo $now->format(Iso8601Format::DATE_TIME_ZULU); // "2026-05-14T08:15:30Z"
echo $now->format(Iso8601Format::WEEK_DATE);      // "2026-W20-4"
```

### Reverse lookup

```php
Iso8601Format::includes('Y-m-d');                 // true
Iso8601Format::getConstant('Y-m-d\TH:i:s\Z');     // "DATE_TIME_ZULU"
```

### Domain use case — API serialization

```php
use org\iso\Iso8601Format;

function serializeForApi(DateTimeImmutable $dt): string
{
    return $dt->setTimezone(new DateTimeZone('UTC'))
              ->format(Iso8601Format::DATE_TIME_MILLI_ZULU);
}
```

## ⚠️ Note on `ORDINAL_DATE`

PHP uses a 0-based index for day-of-year (`z`), whereas ISO 8601 uses 1-based. If you need a strictly compliant ordinal date, build the string manually:

```php
$dt = new DateTimeImmutable('2026-05-14');
$ordinal = $dt->format('Y') . '-' . str_pad((int) $dt->format('z') + 1, 3, '0', STR_PAD_LEFT);
// "2026-134"
```

## Related

- [`DateFormat`](../common/DateFormat.md) — extends this class with RFC, HTTP, MySQL, Unix
- [`TimePrecision`](TimePrecision.md) — precision for fractional formats
- [`Iso8601DateTime`](Iso8601DateTime.md) — uses these constants internally

## See also

- [PHP `date()` format characters](https://www.php.net/manual/en/datetime.format.php)
- [ConstantsTrait](../../guides/constants-trait.md)
