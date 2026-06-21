# isIso8601DateTime()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/isIso8601DateTime.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601DateTime` |
> | **Source** | [isIso8601DateTime.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601DateTime.php) |
> | **Disponible depuis** | `1.0.2` |

## Signature

```php
function isIso8601DateTime(string $value, bool $strict = false): bool
```

## Description

Valide qu'une chaîne est une date-heure ISO 8601 valide :
- Date : `YYYY-MM-DD` (étendu)
- Séparateur : `T` (obligatoire en strict) ou espace (toléré sinon)
- Heure : `HH:MM:SS` avec fractions optionnelles
- Offset optionnel : `Z`, `±HH:MM` ou `±HHMM`

La validité calendaire est vérifiée.

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$value` | `string` | La chaîne à valider |
| `$strict` | `bool` | Si `true`, le séparateur `T` est obligatoire (défaut : `false`) |

## Valeur de retour

`bool` — `true` si la chaîne est une date-heure ISO 8601 valide.

## Exemples

```php
use function org\iso\helpers\isIso8601DateTime;

isIso8601DateTime('2026-05-14T08:15:30Z');         // true
isIso8601DateTime('2026-05-14T08:15:30+02:00');    // true
isIso8601DateTime('2026-05-14T08:15:30.123Z');     // true (millisecondes)
isIso8601DateTime('2026-05-14 08:15:30');          // true (espace toléré)
isIso8601DateTime('2026-05-14 08:15:30', true);    // false (strict exige T)
isIso8601DateTime('2026-02-30T00:00:00Z');         // false (date invalide)
isIso8601DateTime('2026-05-14T24:00:00');          // false (heure invalide)
```

## Lié

- [`Iso8601DateTime`](../Iso8601DateTime.md) — value-object (utilise ce helper en mode strict)
- [`toIso8601DateTime`](toIso8601DateTime.md) — conversion inverse
- [Convention des helpers](../../../guides/helpers.md)
