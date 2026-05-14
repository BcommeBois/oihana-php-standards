# parseLocaleTag()

> 🇫🇷 [Version française](../../../../fr/standards/ietf/helpers/parseLocaleTag.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\ietf\helpers\parseLocaleTag` |
> | **Source** | [isLocale.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/helpers/isLocale.php) (defined in the same file) |
> | **Since** | `1.0.2` |

## Signature

```php
function parseLocaleTag(string $tag): ?array
```

## Description

Parses a BCP 47 tag into its canonical components, with case normalization:
- `language` → lowercase
- `script` → Titlecase
- `region` → uppercase
- `variants` → lowercase

Returns `null` if the string does not match the supported grammar.

## Parameters

| Name | Type | Description |
|---|---|---|
| `$tag` | `string` | The tag to parse |

## Return value

Associative array (or `null` if invalid):

```php
[
    'language'   => string,
    'script'     => ?string,
    'region'     => ?string,
    'variants'   => array<int,string>,
    'privateUse' => ?string,
]
```

## Examples

```php
use function org\ietf\helpers\parseLocaleTag;

parseLocaleTag('fr-FR');
// [
//   'language'   => 'fr',
//   'script'     => null,
//   'region'     => 'FR',
//   'variants'   => [],
//   'privateUse' => null,
// ]

parseLocaleTag('zh-Hant-TW');
// language=zh, script=Hant, region=TW

parseLocaleTag('de-CH-1996');
// language=de, region=CH, variants=['1996']

parseLocaleTag('en-x-pig-latin');
// language=en, privateUse='x-pig-latin'

parseLocaleTag('FR-latn-fr');
// language=fr, script=Latn, region=FR (case normalization)

parseLocaleTag('!!');           // null
parseLocaleTag('');             // null
```

## Related

- [`Locale`](../Locale.md) — value-object that uses this helper internally
- [`isLocale`](isLocale.md) — validation only
- [Helpers convention](../../../guides/helpers.md)
