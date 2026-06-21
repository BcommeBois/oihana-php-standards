# Iso8601Recurrence

> 🇬🇧 [English version](../../../en/standards/iso/Iso8601Recurrence.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Repeating intervals](https://en.wikipedia.org/wiki/ISO_8601#Repeating_intervals) |
> | **Namespace** | `org\iso\Iso8601Recurrence` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Recurrence.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Recurrence.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`Iso8601Recurrence` représente un intervalle répétitif ISO 8601 : `R[n]/<interval>`, où `n` est le nombre de répétitions (absent = infini) et `<interval>` est un [`Iso8601Interval`](Iso8601Interval.md) borné.

Exemples :
- `R5/2026-05-14T00:00:00Z/P1D` — 5 répétitions journalières à partir du 14 mai
- `R/2026-05-14T00:00:00Z/PT1H` — toutes les heures, infini
- `R10/P1D/2026-05-15T00:00:00Z` — 10 répétitions journalières finissant le 15 mai

La méthode `occurrences()` est un **generator paresseux** : aucune occurrence n'est calculée tant qu'on n'itère pas.

## API

### Constantes

| Nom | Valeur | Description |
|---|---|---|
| `DESIGNATOR` | `'R'` | Préfixe désignateur de récurrence |
| `ZERO` | `'R0/1970-01-01T00:00:00Z/PT0S'` | Récurrence nulle (0 répétitions à l'epoch) |
| `PATTERN` | `'/^R(\d*)\/(.+)$/'` | Validation de format |

### Propriétés

| Nom | Type | Accès | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | Chaîne ISO 8601, forme préservée |
| `$count` | `?int` | get | Nombre de répétitions, `null` = infini |
| `$interval` | `Iso8601Interval` | get | Intervalle sous-jacent |

### Méthodes

| Signature | Description |
|---|---|
| `__construct(?string $iso = null)` | Crée une instance |
| `occurrences(?int $max = null): Generator<int, DateTimeImmutable>` | Yields l'instant de début de chaque occurrence |
| `__toString(): string` | Renvoie la chaîne ISO |

### Sémantique de `occurrences()`

| `count` | `$max` | Résultat |
|---|---|---|
| fini | `null` | Yields `count` occurrences |
| fini | fourni | Yields `min(count, $max)` occurrences |
| `null` (infini) | fourni | Yields `$max` occurrences |
| `null` (infini) | `null` | Throws `LogicException` (boucle infinie évitée) |

## Exemples

### Récurrence finie

```php
use org\iso\Iso8601Recurrence;

$r = new Iso8601Recurrence('R3/2026-05-14T00:00:00Z/P1D');
foreach ($r->occurrences() as $instant)
{
    echo $instant->format('Y-m-d') . PHP_EOL;
}
// 2026-05-14
// 2026-05-15
// 2026-05-16
```

### Récurrence infinie — `max` obligatoire

```php
$r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');
foreach ($r->occurrences(max: 5) as $instant)
{
    echo $instant->format('Y-m-d') . PHP_EOL;
}
// 5 dates consécutives

$r->occurrences(); // LogicException : max requis pour infini
```

### `max` plafonne un `count` fini

```php
$r = new Iso8601Recurrence('R100/2026-05-14T00:00:00Z/P1D');
$first10 = iterator_to_array($r->occurrences(max: 10), false);
// 10 occurrences seulement (au lieu de 100)
```

### Intervalle exprimé en `<start>/<end>` (sans durée explicite)

```php
$r = new Iso8601Recurrence('R3/2026-05-14T00:00:00Z/2026-05-14T12:00:00Z');
// La période entre occurrences est calculée via end - start = 12 heures
foreach ($r->occurrences() as $instant)
{
    echo $instant->format('Y-m-d\TH:i:sP') . PHP_EOL;
}
// 2026-05-14T00:00:00+00:00
// 2026-05-14T12:00:00+00:00
// 2026-05-15T00:00:00+00:00
```

### Round-trip préservant la forme

```php
$cases = [
    'R/2026-05-14T00:00:00Z/P1D',
    'R5/2026-05-14T00:00:00Z/P1D',
    'R10/P1D/2026-05-15T00:00:00Z',
];

foreach ($cases as $iso)
{
    echo (new Iso8601Recurrence($iso))->iso . PHP_EOL; // identique à $iso
}
```

### Cas d'usage métier — créneaux de rendez-vous

```php
use org\iso\Iso8601Recurrence;

function nextSlots(string $recurrence, int $maxSlots = 10): array
{
    return iterator_to_array(
        (new Iso8601Recurrence($recurrence))->occurrences(max: $maxSlots),
        false
    );
}

// Créneaux toutes les 30 minutes pendant la journée
$slots = nextSlots('R16/2026-05-14T09:00:00Z/PT30M');
```

### Gestion d'erreurs

```php
new Iso8601Recurrence('INVALID');                    // throws
new Iso8601Recurrence('2026-05-14T00:00:00Z/P1D');   // throws (R manquant)
new Iso8601Recurrence('R-1/2026-05-14T00:00:00Z/P1D');// throws (count négatif)
new Iso8601Recurrence('R5/P1D');                      // throws (intervalle non borné)

$r = new Iso8601Recurrence('R/2026-05-14T00:00:00Z/P1D');
iterator_to_array($r->occurrences(), false);          // LogicException
```

## Lié

- [`Iso8601Interval`](Iso8601Interval.md) — type de `$interval`
- Helpers : [`isIso8601Recurrence`](helpers/isIso8601Recurrence.md)

## Voir aussi

- [ISO 8601 — repeating intervals](https://en.wikipedia.org/wiki/ISO_8601#Repeating_intervals)
- [PHP `Generator`](https://www.php.net/manual/fr/class.generator.php)
- [Pattern *value-object*](../../guides/value-objects.md)
