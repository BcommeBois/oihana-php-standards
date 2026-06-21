# Guide — Helpers convention

> 🇫🇷 [Version française](../../fr/guides/helpers.md)

Helpers are **standalone functions** (not static methods on classes). They live in `src/<namespace>/helpers/` and are loaded through the `autoload.files` section of `composer.json`.

## Three families

| Prefix | Role | Typical signature |
|---|---|---|
| `is<Type>` | Boolean validation | `function isXxx(string $value, bool $strict = false): bool` |
| `to<Type>` | Native → ISO string conversion | `function toXxx(<NativeType> $value, ...): string` |
| `parse<Type>` | String → structured components parsing | `function parseXxx(string $value): ?array` |

## Separation-of-concerns rule

Helpers are **complementary** to value-objects, not duplicative:

| Task | Tool to use |
|---|---|
| Validate a format before instantiation | `is<Type>` helper |
| Convert a `DateTimeInterface` to an ISO string | `to<Type>` helper |
| Manipulate a value (component access, serialization) | Value-object (`new Iso8601Date(...)`) |
| Perform a domain operation (overlap, contains, etc.) | Instance method on the value-object |

> **Design note:** helpers never duplicate an instance method of a value-object. For example, there is no `intervalContains()` helper — that responsibility lives on `Iso8601Interval::contains()`.

## Examples

### Quick validation without instantiation

```php
use function org\iso\helpers\isIso8601DateTime;
use function org\ietf\helpers\isLocale;

isIso8601DateTime($_POST['timestamp'], true); // strict T
isLocale($_POST['locale'], strict: true);     // ISO cross-validation
```

### Conversion from native

```php
use function org\iso\helpers\toIso8601Date;
use function org\iso\helpers\toIso8601DateTime;
use org\iso\TimePrecision;

toIso8601Date(new DateTime('2026-05-14'));            // "2026-05-14"
toIso8601DateTime(new DateTimeImmutable('now'), TimePrecision::MILLISECONDS);
```

### Parsing into components

```php
use function org\ietf\helpers\parseLocaleTag;

$parts = parseLocaleTag('zh-Hant-TW');
// [
//   'language'   => 'zh',
//   'script'     => 'Hant',
//   'region'     => 'TW',
//   'variants'   => [],
//   'privateUse' => null,
// ]
```

## Full list of helpers

### ISO 8601 (`org\iso\helpers`)
| `is*` | `to*` |
|---|---|
| [`isIso8601Date`](../standards/iso/helpers/isIso8601Date.md) | [`toIso8601Date`](../standards/iso/helpers/toIso8601Date.md) |
| [`isIso8601Time`](../standards/iso/helpers/isIso8601Time.md) | [`toIso8601Time`](../standards/iso/helpers/toIso8601Time.md) |
| [`isIso8601DateTime`](../standards/iso/helpers/isIso8601DateTime.md) | [`toIso8601DateTime`](../standards/iso/helpers/toIso8601DateTime.md) |
| [`isIso8601Duration`](../standards/iso/helpers/isIso8601Duration.md) | [`toIso8601Duration`](../standards/iso/helpers/toIso8601Duration.md) |
| [`isIso8601Interval`](../standards/iso/helpers/isIso8601Interval.md) | — |
| [`isIso8601Recurrence`](../standards/iso/helpers/isIso8601Recurrence.md) | — |

### Locale (`org\ietf\helpers`)
- [`isLocale`](../standards/ietf/helpers/isLocale.md)
- [`parseLocaleTag`](../standards/ietf/helpers/parseLocaleTag.md)

## See also

- [Value-object pattern](value-objects.md)
- [ConstantsTrait](constants-trait.md)
