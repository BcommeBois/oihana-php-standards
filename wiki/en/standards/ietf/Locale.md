# Locale

> 🇫🇷 [Version française](../../../fr/standards/ietf/Locale.md)
>
> | | |
> |---|---|
> | **Standard** | [BCP 47 / RFC 5646](https://www.rfc-editor.org/rfc/rfc5646) |
> | **Namespace** | `org\ietf\Locale` |
> | **Type** | Value-object |
> | **Source** | [Locale.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/Locale.php) |
> | **Since** | `1.0.2` |

## Overview

`Locale` represents a BCP 47 language tag, combining ISO 639-1 (language), ISO 15924 (script) and ISO 3166-1 (region) in a single value-object.

Supported minimal grammar:
```
language[-script][-region][-variant…][-x-private…]
```

Two validation levels:
- **Tolerant** (default): BCP 47 syntax only
- **Strict**: cross-validation against [`ISO639_1`](../iso/ISO639_1.md), [`ISO15924`](../iso/ISO15924.md), [`ISO3166_1`](../iso/ISO3166_1.md)

Subtags are **normalized** automatically: language lowercase, script Titlecase, region uppercase.

> Extlangs, Unicode extensions (`-u-`, `-t-`) and grandfathered tags are not supported in this release.

## API

### Constants

| Name | Value | Description |
|---|---|---|
| `ZERO` | `'und'` | Default tag — "undetermined" (ISO 639-2 reserved) |
| `SEPARATOR` | `'-'` | Subtag separator |

### Properties

| Name | Type | Access | Description |
|---|---|---|---|
| `$tag` | `string` | get/set | Canonical BCP 47 tag, e.g. `"fr-FR"` |
| `$language` | `string` | get | Language component (lowercase) |
| `$script` | `?string` | get | Script component (Titlecase) or `null` |
| `$region` | `?string` | get | Region component (2 uppercase letters or 3 digits) or `null` |
| `$variants` | `array<int,string>` | get | Variant subtags (lowercase) |
| `$privateUse` | `?string` | get | Private subtag `x-…` or `null` |

### Methods

| Signature | Description |
|---|---|
| `__construct(?string $tag = null, bool $strict = false)` | Creates an instance |
| `isStrict(): bool` | Checks if components pass ISO cross-validation (independent of construction mode) |
| `__toString(): string` | Returns the canonical tag |

## Examples

### Creation

```php
use org\ietf\Locale;

$l = new Locale('fr-FR');
echo $l->language; // "fr"
echo $l->region;   // "FR"

$l = new Locale('zh-Hant-TW');
echo $l->script;   // "Hant"

$l = new Locale('en-x-pig-latin');
echo $l->privateUse; // "x-pig-latin"
```

### Case normalization

```php
$l = new Locale('FR-latn-fr');
echo $l->language; // "fr"   (lowercase)
echo $l->script;   // "Latn" (Titlecase)
echo $l->region;   // "FR"   (uppercase)
echo $l->tag;      // "fr-Latn-FR" (canonical form)
```

### Strict mode — ISO cross-validation

```php
new Locale('fr-FR', strict: true);  // OK
new Locale('zh-Hant-TW', strict: true); // OK
new Locale('zz-ZZ', strict: true);  // throws InvalidArgumentException
```

### On-demand check (without throwing)

```php
$tolerant = new Locale('zz-ZZ'); // OK in tolerant mode
$tolerant->isStrict();           // false (zz is not in ISO 639-1)
```

### Variants and UN M49 region

```php
$l = new Locale('de-CH-1996');
$l->variants;  // ["1996"]

$l = new Locale('es-419');  // 419 = Latin America (UN M49)
$l->region;    // "419"
```

### Domain use case — supported locale selection

```php
use org\ietf\Locale;

function selectLocale(string $userTag, array $supported): Locale
{
    try
    {
        $locale = new Locale($userTag);
    }
    catch (\InvalidArgumentException)
    {
        return new Locale($supported[0]);
    }

    foreach ($supported as $tag)
    {
        if ($locale->language === (new Locale($tag))->language)
        {
            return $locale;
        }
    }

    return new Locale($supported[0]);
}

selectLocale('fr-CA', ['en-US', 'fr-FR']); // fr-CA (fr language is supported)
```

### Error handling

```php
new Locale('');           // throws (empty)
new Locale('!!');         // throws (invalid syntax)
new Locale('toolong');    // throws (language > 3 letters)
new Locale('fr-x');       // throws (x without private subtag)
```

## Related

- [`ISO639_1`](../iso/ISO639_1.md) — language codes
- [`ISO15924`](../iso/ISO15924.md) — script codes
- [`ISO3166_1`](../iso/ISO3166_1.md) — region codes
- Helpers: [`isLocale`](helpers/isLocale.md), [`parseLocaleTag`](helpers/parseLocaleTag.md)

## See also

- [RFC 5646 — BCP 47](https://www.rfc-editor.org/rfc/rfc5646)
- [IANA Language Subtag Registry](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)
- [*Value-object* pattern](../../guides/value-objects.md)
