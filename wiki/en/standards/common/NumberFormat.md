# NumberFormat

> 🇫🇷 [Version française](../../../fr/standards/common/NumberFormat.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\common\NumberFormat` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [NumberFormat.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/common/NumberFormat.php) |
> | **Since** | `1.0.2` |

## Overview

`NumberFormat` groups the common **numeric separators and symbols** used to format numbers per regional conventions. Designed to be passed straight to [`number_format()`](https://www.php.net/manual/en/function.number-format.php).

Notation conventions:
- **EU**: comma decimal, dot thousands — `1.234.567,89` (DE, IT, ES, NL…)
- **US**: dot decimal, comma thousands — `1,234,567.89` (US, UK, JP, CN…)
- **FR**: comma decimal, narrow no-break space thousands — `1 234 567,89` (French typography)
- **CH**: dot decimal, apostrophe thousands — `1'234'567.89` (Switzerland)

## Constants

### Decimal separators

| Constant | Value | Usage |
|---|---|---|
| `DECIMAL_SEP_EU` | `','` | Continental Europe |
| `DECIMAL_SEP_US` | `'.'` | US, UK, Asia |
| `DECIMAL_SEP_FR` | `','` | France |
| `DECIMAL_SEP_CH` | `'.'` | Switzerland |

### Thousands separators

| Constant | Value | Usage |
|---|---|---|
| `THOUSANDS_SEP_EU` | `'.'` | Continental Europe |
| `THOUSANDS_SEP_US` | `','` | US, UK, Asia |
| `THOUSANDS_SEP_FR` | `"\u{202F}"` | France (narrow no-break space U+202F) |
| `THOUSANDS_SEP_CH` | `"'"` | Switzerland |
| `THOUSANDS_SEP_NONE` | `''` | None |

### Scientific notation

| Constant | Value | Example |
|---|---|---|
| `SCIENTIFIC_E_LOWER` | `'e'` | `1.23e+45` |
| `SCIENTIFIC_E_UPPER` | `'E'` | `1.23E+45` |

### Symbols

| Constant | Value | Description |
|---|---|---|
| `PERCENT_SYMBOL` | `'%'` | Percent |
| `PERMILLE_SYMBOL` | `'‰'` | Per-mille (U+2030) |
| `INFINITY` | `'∞'` | Infinity (U+221E) |
| `NEGATIVE_INFINITY` | `'-∞'` | Negative infinity |
| `NAN_SYMBOL` | `'NaN'` | "Not a Number" |

## Inherited methods

See [ConstantsTrait](../../guides/constants-trait.md).

## Examples

### Regional formatting

```php
use org\common\NumberFormat;

$n = 1234567.89;

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_EU, NumberFormat::THOUSANDS_SEP_EU);
// "1.234.567,89"

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_US, NumberFormat::THOUSANDS_SEP_US);
// "1,234,567.89"

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_FR, NumberFormat::THOUSANDS_SEP_FR);
// "1 234 567,89" (with narrow no-break space)

echo number_format($n, 2, NumberFormat::DECIMAL_SEP_CH, NumberFormat::THOUSANDS_SEP_CH);
// "1'234'567.89"
```

### Without thousands separator

```php
echo number_format(1234567.89, 2, NumberFormat::DECIMAL_SEP_US, NumberFormat::THOUSANDS_SEP_NONE);
// "1234567.89"
```

### Domain use case — format per user locale

```php
use org\common\NumberFormat;
use org\ietf\Locale;

function formatMoney(float $amount, Locale $locale): string
{
    [$dec, $thou] = match ($locale->region) {
        'FR'        => [NumberFormat::DECIMAL_SEP_FR, NumberFormat::THOUSANDS_SEP_FR],
        'CH'        => [NumberFormat::DECIMAL_SEP_CH, NumberFormat::THOUSANDS_SEP_CH],
        'US', 'GB'  => [NumberFormat::DECIMAL_SEP_US, NumberFormat::THOUSANDS_SEP_US],
        default     => [NumberFormat::DECIMAL_SEP_EU, NumberFormat::THOUSANDS_SEP_EU],
    };

    return number_format($amount, 2, $dec, $thou);
}

formatMoney(1234567.89, new Locale('fr-FR')); // "1 234 567,89"
formatMoney(1234567.89, new Locale('en-US')); // "1,234,567.89"
```

### Reverse lookup

```php
NumberFormat::includes('%');                          // true
NumberFormat::includes("\u{202F}");                   // true
NumberFormat::getConstant('%');                       // "PERCENT_SYMBOL"
NumberFormat::getConstant(',');                       // ['DECIMAL_SEP_EU', 'DECIMAL_SEP_FR'] (share the value)
```

## ⚠️ Note

For advanced rules (currencies with locale-positioned symbol, plurals, CLDR formats), this pure constants catalog is not enough. See the upcoming `oihana/php-format` package or PHP's [`ext-intl`](https://www.php.net/manual/en/book.intl.php) extension.

## Related

- Common index: [README.md](README.md)

## See also

- [PHP `number_format()`](https://www.php.net/manual/en/function.number-format.php)
- [ConstantsTrait](../../guides/constants-trait.md)
