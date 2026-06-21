# isLocale()

> 🇬🇧 [English version](../../../../en/standards/ietf/helpers/isLocale.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\ietf\helpers\isLocale` |
> | **Source** | [isLocale.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/ietf/helpers/isLocale.php) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function isLocale(string $tag, bool $strict = false): bool
```

## Description

Valide qu'une chaîne est un tag de langue BCP 47 valide. Voir [`Locale`](../Locale.md) pour la grammaire supportée.

En mode strict, les composants sont **cross-validés** contre :
- Langue 2 lettres → [`ISO639_1`](../../iso/ISO639_1.md)
- Script → [`ISO15924`](../../iso/ISO15924.md)
- Région 2 lettres → [`ISO3166_1`](../../iso/ISO3166_1.md)

Les langues 3 lettres et régions 3 chiffres (UN M49) ne sont pas cross-validées (pas de classe disponible).

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$tag` | `string` | Le tag à valider |
| `$strict` | `bool` | Si `true`, cross-valide contre les classes ISO (défaut : `false`) |

## Valeur de retour

`bool` — `true` si le tag est un BCP 47 valide.

## Exemples

```php
use function org\ietf\helpers\isLocale;

isLocale('fr-FR');                   // true
isLocale('zh-Hant-TW');              // true
isLocale('de-CH-1996');              // true
isLocale('en-x-pig-latin');          // true
isLocale('zz-ZZ');                   // true (syntaxe OK)
isLocale('zz-ZZ', strict: true);     // false (zz n'est pas ISO 639-1)
isLocale('fr-FR', strict: true);     // true
isLocale('');                         // false
isLocale('toolong');                 // false (langue > 3 lettres)
```

## Lié

- [`Locale`](../Locale.md) — value-object
- [`parseLocaleTag`](parseLocaleTag.md) — parsing structuré
- [Convention des helpers](../../../guides/helpers.md)
