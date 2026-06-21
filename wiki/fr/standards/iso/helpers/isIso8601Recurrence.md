# isIso8601Recurrence()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/isIso8601Recurrence.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Recurrence` |
> | **Source** | [isIso8601Recurrence.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Recurrence.php) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function isIso8601Recurrence(string $value): bool
```

## Description

Valide qu'une chaîne est un intervalle répétitif ISO 8601 : `R[n]/<interval>`. `n` est optionnel (absent = infini). L'intervalle interne est validé via [`isIso8601Interval`](isIso8601Interval.md) (donc forme bornée obligatoire).

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$value` | `string` | La chaîne à valider |

## Valeur de retour

`bool` — `true` si la chaîne est une récurrence ISO 8601 valide.

## Exemples

```php
use function org\iso\helpers\isIso8601Recurrence;

isIso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');     // true (infini)
isIso8601Recurrence('R5/2026-05-14T00:00:00Z/P1D');    // true (5 occurrences)
isIso8601Recurrence('R0/2026-05-14T00:00:00Z/PT0S');   // true (zéro, dégénéré)
isIso8601Recurrence('R10/P1D/2026-05-15T00:00:00Z');   // true
isIso8601Recurrence('2026-05-14T00:00:00Z/P1D');       // false (R manquant)
isIso8601Recurrence('R-1/P1D/2026-05-15T00:00:00Z');   // false (count négatif)
isIso8601Recurrence('R/P1D');                          // false (intervalle non borné)
```

## Lié

- [`Iso8601Recurrence`](../Iso8601Recurrence.md) — value-object
- [`isIso8601Interval`](isIso8601Interval.md) — validation de l'intervalle interne
- [Convention des helpers](../../../guides/helpers.md)
