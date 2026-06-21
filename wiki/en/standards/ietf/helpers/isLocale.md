# isLocale()

> 🇫🇷 [Version française](../../../../fr/standards/ietf/helpers/isLocale.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\ietf\helpers\isLocale` |
> | **Source** | [isLocale.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/helpers/isLocale.php) |
> | **Since** | `1.0.2` |

## Signature

```php
function isLocale(string $tag, bool $strict = false): bool
```

## Description

Validates whether a string is a valid BCP 47 language tag. See [`Locale`](../Locale.md) for the supported grammar.

In strict mode, components are **cross-validated** against:
- 2-letter language → [`ISO639_1`](../../iso/ISO639_1.md)
- Script → [`ISO15924`](../../iso/ISO15924.md)
- 2-letter region → [`ISO3166_1`](../../iso/ISO3166_1.md)

3-letter languages and 3-digit regions (UN M49) are not cross-validated (no class available).

## Parameters

| Name | Type | Description |
|---|---|---|
| `$tag` | `string` | The tag to validate |
| `$strict` | `bool` | If `true`, cross-validates against ISO classes (default: `false`) |

## Return value

`bool` — `true` if the tag is a valid BCP 47.

## Examples

```php
use function org\ietf\helpers\isLocale;

isLocale('fr-FR');                   // true
isLocale('zh-Hant-TW');              // true
isLocale('de-CH-1996');              // true
isLocale('en-x-pig-latin');          // true
isLocale('zz-ZZ');                   // true (syntax OK)
isLocale('zz-ZZ', strict: true);     // false (zz is not in ISO 639-1)
isLocale('fr-FR', strict: true);     // true
isLocale('');                         // false
isLocale('toolong');                 // false (language > 3 letters)
```

## Related

- [`Locale`](../Locale.md) — value-object
- [`parseLocaleTag`](parseLocaleTag.md) — structured parsing
- [Helpers convention](../../../guides/helpers.md)
