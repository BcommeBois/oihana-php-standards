# parseLocaleTag()

> 🇬🇧 [English version](../../../../en/standards/ietf/helpers/parseLocaleTag.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\ietf\helpers\parseLocaleTag` |
> | **Source** | [isLocale.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/helpers/isLocale.php) (défini dans le même fichier) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function parseLocaleTag(string $tag): ?array
```

## Description

Parse un tag BCP 47 en ses composants canoniques, avec normalisation de casse :
- `language` → minuscules
- `script` → Titlecase
- `region` → majuscules
- `variants` → minuscules

Renvoie `null` si la chaîne ne respecte pas la grammaire supportée.

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$tag` | `string` | Le tag à parser |

## Valeur de retour

Tableau associatif (ou `null` si invalide) :

```php
[
    'language'   => string,
    'script'     => ?string,
    'region'     => ?string,
    'variants'   => array<int,string>,
    'privateUse' => ?string,
]
```

## Exemples

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
// language=fr, script=Latn, region=FR (normalisation de casse)

parseLocaleTag('!!');           // null
parseLocaleTag('');             // null
```

## Lié

- [`Locale`](../Locale.md) — value-object qui utilise ce helper en interne
- [`isLocale`](isLocale.md) — validation seule
- [Convention des helpers](../../../guides/helpers.md)
