# isIso8601Date()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/isIso8601Date.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Date` |
> | **Source** | [isIso8601Date.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Date.php) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function isIso8601Date(string $date, bool $strict = false): bool
```

## Description

Valide qu'une chaîne est une date ISO 8601 valide, syntaxiquement **et calendairement** (`checkdate()`).

Formats acceptés par défaut :
- **Étendu** : `YYYY-MM-DD` (ex. `2026-05-14`)
- **Basic** : `YYYYMMDD` (ex. `20260514`)

En mode strict (`$strict = true`), seul le format étendu est accepté.

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$date` | `string` | La chaîne à valider |
| `$strict` | `bool` | Si `true`, n'accepte que le format étendu `YYYY-MM-DD` (défaut : `false`) |

## Valeur de retour

`bool` — `true` si la chaîne est une date ISO 8601 valide.

## Exemples

```php
use function org\iso\helpers\isIso8601Date;

isIso8601Date('2026-05-14');         // true
isIso8601Date('20260514');           // true (basic)
isIso8601Date('20260514', true);     // false (strict refuse basic)
isIso8601Date('2026-02-30');         // false (date calendaire invalide)
isIso8601Date('2024-02-29');         // true  (année bissextile)
isIso8601Date('2023-02-29');         // false (non bissextile)
isIso8601Date('2026-5-14');          // false (mois non zero-padded)
```

## Lié

- [`Iso8601Date`](../Iso8601Date.md) — value-object (utilise ce helper en interne avec `$strict = true`)
- [`toIso8601Date`](toIso8601Date.md) — conversion inverse
- [Convention des helpers](../../../guides/helpers.md)
