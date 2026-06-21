# Locale

> 🇬🇧 [English version](../../../en/standards/ietf/Locale.md)
>
> | | |
> |---|---|
> | **Standard** | [BCP 47 / RFC 5646](https://www.rfc-editor.org/rfc/rfc5646) |
> | **Namespace** | `org\ietf\Locale` |
> | **Type** | Value-object |
> | **Source** | [Locale.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/Locale.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`Locale` représente un tag de langue BCP 47, combinant ISO 639-1 (langue), ISO 15924 (script) et ISO 3166-1 (région) dans un value-object unique.

Grammaire minimale supportée :
```
language[-script][-region][-variant…][-x-private…]
```

Deux niveaux de validation :
- **Tolérant** (défaut) : syntaxe BCP 47 uniquement
- **Strict** : cross-validation contre [`ISO639_1`](../iso/ISO639_1.md), [`ISO15924`](../iso/ISO15924.md), [`ISO3166_1`](../iso/ISO3166_1.md)

Les sous-tags sont **normalisés** automatiquement : langue en minuscules, script en Titlecase, région en majuscules.

> Les extlangs, extensions Unicode (`-u-`, `-t-`) et tags grandfathered ne sont pas supportés dans cette version.

## API

### Constantes

| Nom | Valeur | Description |
|---|---|---|
| `ZERO` | `'und'` | Tag par défaut — "undetermined" (ISO 639-2 réservé) |
| `SEPARATOR` | `'-'` | Séparateur de sous-tags |

### Propriétés

| Nom | Type | Accès | Description |
|---|---|---|---|
| `$tag` | `string` | get/set | Tag BCP 47 canonique, ex. `"fr-FR"` |
| `$language` | `string` | get | Composante langue (minuscules) |
| `$script` | `?string` | get | Composante script (Titlecase) ou `null` |
| `$region` | `?string` | get | Composante région (2 lettres majuscules ou 3 chiffres) ou `null` |
| `$variants` | `array<int,string>` | get | Sous-tags variants en minuscules |
| `$privateUse` | `?string` | get | Sous-tag privé `x-…` ou `null` |

### Méthodes

| Signature | Description |
|---|---|
| `__construct(?string $tag = null, bool $strict = false)` | Crée une instance |
| `isStrict(): bool` | Vérifie si les composants passent la cross-validation ISO (indépendant du mode de construction) |
| `__toString(): string` | Renvoie le tag canonique |

## Exemples

### Création

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

### Normalisation de casse

```php
$l = new Locale('FR-latn-fr');
echo $l->language; // "fr"   (minuscules)
echo $l->script;   // "Latn" (Titlecase)
echo $l->region;   // "FR"   (majuscules)
echo $l->tag;      // "fr-Latn-FR" (forme canonique)
```

### Mode strict — cross-validation ISO

```php
new Locale('fr-FR', strict: true);  // OK
new Locale('zh-Hant-TW', strict: true); // OK
new Locale('zz-ZZ', strict: true);  // throws InvalidArgumentException
```

### Vérification à la demande (sans throw)

```php
$tolerant = new Locale('zz-ZZ'); // OK en tolérant
$tolerant->isStrict();           // false (zz n'est pas ISO 639-1)
```

### Variantes et région UN M49

```php
$l = new Locale('de-CH-1996');
$l->variants;  // ["1996"]

$l = new Locale('es-419');  // 419 = Latin America (UN M49)
$l->region;    // "419"
```

### Cas d'usage métier — sélection de locale supportée

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

selectLocale('fr-CA', ['en-US', 'fr-FR']); // fr-CA (la langue fr est supportée)
```

### Gestion d'erreurs

```php
new Locale('');           // throws (vide)
new Locale('!!');         // throws (syntaxe invalide)
new Locale('toolong');    // throws (langue > 3 lettres)
new Locale('fr-x');       // throws (x sans sous-tag privé)
```

## Lié

- [`ISO639_1`](../iso/ISO639_1.md) — codes langue
- [`ISO15924`](../iso/ISO15924.md) — codes script
- [`ISO3166_1`](../iso/ISO3166_1.md) — codes région
- Helpers : [`isLocale`](helpers/isLocale.md), [`parseLocaleTag`](helpers/parseLocaleTag.md)

## Voir aussi

- [RFC 5646 — BCP 47](https://www.rfc-editor.org/rfc/rfc5646)
- [Registre IANA des sous-tags de langue](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)
- [Pattern *value-object*](../../guides/value-objects.md)
