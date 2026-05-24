# BCP47Variant

> 🇫🇷 [Version française](../../../fr/standards/ietf/BCP47Variant.md)
>
> | | |
> |---|---|
> | **Standard** | [BCP 47 / RFC 5646 §2.2.5](https://www.rfc-editor.org/rfc/rfc5646#section-2.2.5) — Variant Subtags |
> | **Upstream source** | [IANA Language Subtag Registry](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry) |
> | **Namespace** | `org\ietf\BCP47Variant` |
> | **Type** | Constants class (`ConstantsTrait`) |
> | **Source** | [BCP47Variant.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/BCP47Variant.php) |
> | **Available since** | `1.0.3` |

## Overview

`BCP47Variant` enumerates the **variant subtags** defined by the IANA registry for BCP 47 / RFC 5646. Variants refine the language/script/region triple of a locale tag by specifying:

- a **notation** or **transcription**: `fonipa` (IPA), `fonkirsh` (Kirshenbaum), `fonnapa` (NAPA), `fonupa` (UPA), `pinyin`, `wadegile`
- a historical or reformed **orthography**: `1996` (post-reform German), `1901` (pre-reform German), `1606nict`, `1694acad`
- a regional or local **dialect**: `valencia` (Valencian Catalan), `tarask` (Belarusian Taraškievica), `aluku`, `nedis`, `biscayan`
- other **variants**: `monoton` (monotonic Greek), `polyton` (polytonic Greek), `arkaika` (archaic Esperanto)

Position in a BCP 47 tag:
```
de-CH-1996           # Swiss German, 1996 orthography
ca-ES-valencia       # Catalan, Valencian variant, in Spain
sl-Latn-fonipa       # IPA transcription of Slovenian
```

## Naming convention

| Subtag form | Constant | Example |
|---|---|---|
| Alphabetic 5-8 chars | `<UPPER>` | `VALENCIA = 'valencia'` |
| Numeric 4 chars (digit + 3 alphanum) | `V_<UPPER>` | `V_1996 = '1996'` |
| Numeric 5-8 chars | `V_<UPPER>` | `V_1606NICT = '1606nict'` |

The `V_` prefix is required because PHP identifiers cannot start with a digit. Consistent with [`UNM49Numeric`](../unstats/UNM49Numeric.md) (prefix `M_`).

## Metadata not enumerated

This class only enumerates **variant codes**. The following metadata is documented per-constant in the PHPDoc but **not exposed as API**:

- **`Prefix:`** — combination constraint (e.g. `valencia` requires `ca` as the language). Combination validation belongs to [`Locale`](Locale.md) / [`isLocale()`](helpers/isLocale.md), not this class.
- **`Deprecated:`** — deprecated variants (`arevela`, `arevmda`, `heploc`, `laukika`, `vaidika`) remain enumerated because their syntax is still valid for legacy content.

## Sample of common constants

| Constant | Value | Description |
|---|---|---|
| `V_1996` | `'1996'` | Reformed German orthography (prefix `de`) |
| `V_1901` | `'1901'` | Traditional German orthography (prefix `de`) |
| `VALENCIA` | `'valencia'` | Valencian Catalan (prefix `ca`) |
| `FONIPA` | `'fonipa'` | IPA phonetic transcription |
| `FONUPA` | `'fonupa'` | UPA phonetic transcription |
| `PINYIN` | `'pinyin'` | Hanyu Pinyin romanization (prefixes `zh-Latn`, `bo-Latn`) |
| `WADEGILE` | `'wadegile'` | Wade-Giles romanization |
| `TARASK` | `'tarask'` | Belarusian Taraškievica (prefix `be`) |
| `MONOTON` | `'monoton'` | Monotonic Greek (prefix `el`) |
| `POLYTON` | `'polyton'` | Polytonic Greek (prefix `el`) |
| `SCOTLAND` | `'scotland'` | Scots English (prefix `en`) |
| `OXENDICT` | `'oxendict'` | Oxford English Dictionary spelling |

> 📋 **Complete list** (~139 variants): see the [source on GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/BCP47Variant.php).

## Inherited methods

See the [ConstantsTrait](../../guides/constants-trait.md) guide.

## Examples

```php
use org\ietf\BCP47Variant;

BCP47Variant::V_1996;                    // '1996'
BCP47Variant::VALENCIA;                  // 'valencia'
BCP47Variant::FONIPA;                    // 'fonipa'

BCP47Variant::includes('1996');          // true
BCP47Variant::includes('valencia');      // true
BCP47Variant::includes('xyz');           // false

BCP47Variant::getConstant('valencia');   // 'VALENCIA'
BCP47Variant::getConstant('1996');       // 'V_1996'
```

### Use case — building a tag with a variant

```php
use org\ietf\Locale;
use org\ietf\BCP47Variant;
use org\iso\ISO639_1;
use org\iso\ISO3166_1;

// Swiss German, 1996 orthography
$tag    = ISO639_1::DE . '-' . ISO3166_1::CH . '-' . BCP47Variant::V_1996;
$locale = new Locale($tag); // 'de-CH-1996'

echo $locale->language;     // 'de'
echo $locale->region;       // 'CH'
print_r($locale->variants); // ['1996']
```

## Related

- [`Locale`](Locale.md) — BCP 47 value-object that parses variants
- [`BCP47Grandfathered`](BCP47Grandfathered.md) — legacy **full** tags (`i-klingon`, `art-lojban`)
- [`BCP47Redundant`](BCP47Redundant.md) — redundant registered **full** tags
- IETF index: [README.md](README.md)

## See also

- [IANA Language Subtag Registry](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)
- [RFC 5646 §2.2.5 — Variant Subtags](https://www.rfc-editor.org/rfc/rfc5646#section-2.2.5)
- [ConstantsTrait](../../guides/constants-trait.md)
