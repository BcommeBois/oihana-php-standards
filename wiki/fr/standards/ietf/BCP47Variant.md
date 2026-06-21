# BCP47Variant

> 🇬🇧 [English version](../../../en/standards/ietf/BCP47Variant.md)
>
> | | |
> |---|---|
> | **Standard** | [BCP 47 / RFC 5646 §2.2.5](https://www.rfc-editor.org/rfc/rfc5646#section-2.2.5) — Variant Subtags |
> | **Source upstream** | [IANA Language Subtag Registry](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry) |
> | **Namespace** | `org\ietf\BCP47Variant` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [BCP47Variant.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/BCP47Variant.php) |
> | **Disponible depuis** | `1.0.3` |

## Vue d'ensemble

`BCP47Variant` énumère les **sous-tags variants** définis par le registre IANA pour BCP 47 / RFC 5646. Les variants affinent le triplet langue/script/région d'un tag de locale en spécifiant :

- une **notation** ou **transcription** : `fonipa` (IPA), `fonkirsh` (Kirshenbaum), `fonnapa` (NAPA), `fonupa` (UPA), `pinyin`, `wadegile`
- une **orthographe** historique ou réformée : `1996` (allemand post-réforme), `1901` (allemand pré-réforme), `1606nict`, `1694acad`
- un **dialecte** régional ou local : `valencia` (catalan valencien), `tarask` (biélorusse Taraškievica), `aluku`, `nedis`, `biscayan`
- d'autres **variantes** : `monoton` (grec monotonique), `polyton` (grec polytonique), `arkaika` (espéranto archaïque)

Position dans un tag BCP 47 :
```
de-CH-1996           # allemand suisse, orthographe 1996
ca-ES-valencia       # catalan, variante valencienne, en Espagne
sl-Latn-fonipa       # transcription IPA du slovène
```

## Convention de nommage

| Type de sous-tag | Constante | Exemple |
|---|---|---|
| Alphabétique 5-8 chars | `<UPPER>` | `VALENCIA = 'valencia'` |
| Numérique 4 chars (digit + 3 alphanum) | `V_<UPPER>` | `V_1996 = '1996'` |
| Numérique 5-8 chars | `V_<UPPER>` | `V_1606NICT = '1606nict'` |

Le préfixe `V_` est obligatoire car les identifiants PHP ne peuvent pas commencer par un chiffre. Cohérent avec [`UNM49Numeric`](../unstats/UNM49Numeric.md) (préfixe `M_`).

## Métadonnées non énumérées

Cette classe énumère uniquement les **codes de variants**. Les métadonnées suivantes sont documentées dans le PHPDoc par constante mais **non exposées comme API** :

- **`Prefix:`** — contrainte de combinaison (ex : `valencia` requiert `ca` comme langue). La validation des combinaisons relève de [`Locale`](Locale.md) / [`isLocale()`](helpers/isLocale.md), pas de cette classe.
- **`Deprecated:`** — les variants dépréciés (`arevela`, `arevmda`, `heploc`, `laukika`, `vaidika`) restent énumérés car leur syntaxe reste valide pour le contenu legacy.

## Échantillon de constantes courantes

| Constante | Valeur | Description |
|---|---|---|
| `V_1996` | `'1996'` | Orthographe allemande réformée (préfixe `de`) |
| `V_1901` | `'1901'` | Orthographe allemande traditionnelle (préfixe `de`) |
| `VALENCIA` | `'valencia'` | Catalan valencien (préfixe `ca`) |
| `FONIPA` | `'fonipa'` | Phonétique IPA |
| `FONUPA` | `'fonupa'` | Phonétique UPA |
| `PINYIN` | `'pinyin'` | Romanisation Hanyu Pinyin (préfixe `zh-Latn`, `bo-Latn`) |
| `WADEGILE` | `'wadegile'` | Romanisation Wade-Giles |
| `TARASK` | `'tarask'` | Biélorusse Taraškievica (préfixe `be`) |
| `MONOTON` | `'monoton'` | Grec monotonique (préfixe `el`) |
| `POLYTON` | `'polyton'` | Grec polytonique (préfixe `el`) |
| `SCOTLAND` | `'scotland'` | Anglais écossais (préfixe `en`) |
| `OXENDICT` | `'oxendict'` | Orthographe Oxford English Dictionary |

> 📋 **Liste complète** (~139 variants) : voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/BCP47Variant.php).

## Méthodes héritées

Voir le guide [ConstantsTrait](../../guides/constants-trait.md).

## Exemples

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

### Cas d'usage — composer un tag avec variant

```php
use org\ietf\Locale;
use org\ietf\BCP47Variant;
use org\iso\ISO639_1;
use org\iso\ISO3166_1;

// Allemand suisse, orthographe 1996
$tag    = ISO639_1::DE . '-' . ISO3166_1::CH . '-' . BCP47Variant::V_1996;
$locale = new Locale($tag); // 'de-CH-1996'

echo $locale->language;     // 'de'
echo $locale->region;       // 'CH'
print_r($locale->variants); // ['1996']
```

## Lié

- [`Locale`](Locale.md) — value-object BCP 47 qui parse les variants
- [`BCP47Grandfathered`](BCP47Grandfathered.md) — tags **entiers** hérités (`i-klingon`, `art-lojban`)
- [`BCP47Redundant`](BCP47Redundant.md) — tags **entiers** redondants enregistrés
- Index IETF : [README.md](README.md)

## Voir aussi

- [IANA Language Subtag Registry](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)
- [RFC 5646 §2.2.5 — Variant Subtags](https://www.rfc-editor.org/rfc/rfc5646#section-2.2.5)
- [ConstantsTrait](../../guides/constants-trait.md)
