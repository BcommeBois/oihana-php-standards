# isIso8601Time()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/isIso8601Time.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Time` |
> | **Source** | [isIso8601Time.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Time.php) |
> | **Disponible depuis** | `1.0.1` |

## Signature

```php
function isIso8601Time(string $time, bool $strict = false): bool
```

## Description

Valide qu'une chaîne est une heure ISO 8601 valide :
- Préfixe `T` optionnel (obligatoire en mode strict)
- Heures `00-23`, minutes/secondes `00-59`
- Fractions de seconde acceptées
- Fuseau optionnel : `Z` ou `±HH:MM`

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$time` | `string` | La chaîne à valider |
| `$strict` | `bool` | Si `true`, le préfixe `T` est obligatoire (défaut : `false`) |

## Valeur de retour

`bool` — `true` si la chaîne est une heure ISO 8601 valide.

## Exemples

```php
use function org\iso\helpers\isIso8601Time;

isIso8601Time('T14:30:00Z');       // true
isIso8601Time('T08:15:30+02:00');  // true
isIso8601Time('T12:34:56.789');    // true (fractions)
isIso8601Time('14:30:00');         // true (sans T, non strict)
isIso8601Time('14:30:00', true);   // false (strict exige T)
isIso8601Time('T24:00:00');        // false (heure invalide)
isIso8601Time('T12:60:00');        // false (minute invalide)
```

## Lié

- [`Iso8601Time`](../Iso8601Time.md) — value-object
- [`toIso8601Time`](toIso8601Time.md) — conversion inverse
- [Convention des helpers](../../../guides/helpers.md)
