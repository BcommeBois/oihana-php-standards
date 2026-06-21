# isIso8601Duration()

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/isIso8601Duration.md)
>
> | | |
> |---|---|
> | **Namespace** | `org\iso\helpers\isIso8601Duration` |
> | **Source** | [isIso8601Duration.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/helpers/isIso8601Duration.php) |
> | **Disponible depuis** | `1.0.1` |

## Signature

```php
function isIso8601Duration(string $duration, bool $strict = false): bool
```

## Description

Valide qu'une chaîne est une durée ISO 8601 valide. Format : `P[n]Y[n]M[n]W[n]DT[n]H[n]M[n]S`.

- Mode **non strict** (défaut) : utilise `new DateInterval()` (accepte les décimales et certains cas tolérants)
- Mode **strict** : validation par regex, refuse les décimales, refuse `P` ou `PT` seul

## Paramètres

| Nom | Type | Description |
|---|---|---|
| `$duration` | `string` | La chaîne à valider |
| `$strict` | `bool` | Mode strict regex (défaut : `false`) |

## Valeur de retour

`bool` — `true` si la chaîne est une durée ISO 8601 valide.

## Exemples

```php
use function org\iso\helpers\isIso8601Duration;

isIso8601Duration('P1Y2M3D');       // true
isIso8601Duration('PT4H30M');       // true
isIso8601Duration('P1W');           // true (semaine)
isIso8601Duration('P0D');           // true
isIso8601Duration('P');             // false (aucune composante)
isIso8601Duration('1Y2M');          // false (préfixe P manquant)
isIso8601Duration('P1.5Y', true);   // false (décimales refusées en strict)
isIso8601Duration('INVALID');       // false
```

## Lié

- [`Iso8601Duration`](../Iso8601Duration.md) — value-object
- [`toIso8601Duration`](toIso8601Duration.md) — conversion inverse
- [Convention des helpers](../../../guides/helpers.md)
