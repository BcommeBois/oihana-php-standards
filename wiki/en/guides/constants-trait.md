# Guide — `ConstantsTrait`

> 🇫🇷 [Version française](../../fr/guides/constants-trait.md)

All **constants classes** in the library use the [`oihana\reflect\traits\ConstantsTrait`](https://github.com/BcommeBois/oihana-php-reflect/blob/main/src/oihana/reflect/traits/ConstantsTrait.php) trait (shipped with the `oihana/php-reflect` package). It exposes a set of static utility methods to enumerate, validate and look up constants.

## Available methods

| Method | Signature | Description |
|---|---|---|
| `getAll()` | `array<string,mixed>` | `[name => value]` map of all public constants (internally cached). |
| `enums()` | `array` | Flat, deduplicated, sorted list of values. |
| `includes($value)` | `bool` | Checks whether a value exists among the constants. |
| `get($value, $default = null)` | `mixed` | Returns the value if it exists, otherwise `$default`. |
| `validate($value, bool $strict = true)` | `mixed` | Returns the value if valid, otherwise throws `ConstantException`. |
| `getConstant($value, $separator = null)` | `string\|array\|null` | Reverse lookup: constant name for a given value. Returns an array if several constants share the same value. |
| `resetCaches()` | `void` | Clears the internal caches (useful in tests). |

## Examples

### Enumeration and validation

```php
use org\iso\ISO4217;

ISO4217::enums();              // ['AED', 'AFN', 'ALL', ...] (sorted, deduplicated)
ISO4217::includes('EUR');      // true
ISO4217::includes('FAKE');     // false
ISO4217::validate('USD');      // 'USD'
ISO4217::validate('FAKE');     // throws ConstantException
```

### Reverse lookup

```php
use org\common\NumberFormat;

NumberFormat::getConstant('%');   // "PERCENT_SYMBOL"
NumberFormat::getConstant('NaN'); // "NAN_SYMBOL"

// When several constants share the same value, getConstant() returns an array
NumberFormat::getConstant(',');   // ['DECIMAL_SEP_EU', 'DECIMAL_SEP_FR']
```

### Cache

`getAll()` and `getConstant()` cache their results. If you modify a class dynamically (rarely needed, except in tests), call `resetCaches()`:

```php
ISO4217::resetCaches();
```

## Classes that use this trait

- `org\iso\ISO3166_1`, `org\iso\ISO639_1`, `org\iso\ISO4217`, `org\iso\ISO15924`
- `org\iso\Iso8601Format`, `org\iso\TimePrecision`
- `org\common\DateFormat`, `org\common\NumberFormat`
- `org\unece\uncefact\MeasureCode`, `MeasureName`, `MeasureSymbol`, `PackageCode`, `PackageName`
- `org\unstats\UNM49`

## See also

- [`ConstantsTrait` source code](https://github.com/BcommeBois/oihana-php-reflect/blob/main/src/oihana/reflect/traits/ConstantsTrait.php)
- [Helpers convention](helpers.md)
