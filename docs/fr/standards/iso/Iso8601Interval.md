# Iso8601Interval

> 🇬🇧 [English version](../../../en/standards/iso/Iso8601Interval.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Time intervals](https://en.wikipedia.org/wiki/ISO_8601#Time_intervals) |
> | **Namespace** | `org\iso\Iso8601Interval` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Interval.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Interval.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`Iso8601Interval` représente un intervalle temporel ISO 8601, composé de deux expressions séparées par `/`. Trois formes bornées sont supportées :

| Forme | Exemple |
|---|---|
| `<start>/<end>` | `2026-05-14T00:00:00Z/2026-05-15T00:00:00Z` |
| `<start>/<duration>` | `2026-05-14T00:00:00Z/P1D` |
| `<duration>/<end>` | `P1D/2026-05-15T00:00:00Z` |

**Toujours disponibles :** `start` et `end` sont calculés automatiquement quand la forme d'entrée n'en fournit qu'un. `duration` est `null` quand la forme d'entrée était `<start>/<end>`.

**Round-trip :** la propriété `iso` préserve la forme d'origine (pas de canonicalisation forcée).

**Cas rejetés :** durée seule (`P1D`), deux durées (`P1D/P2D`), intervalles ouverts (`--/...`), `end` antérieur à `start`.

## API

### Constantes

| Nom | Valeur | Description |
|---|---|---|
| `SEPARATOR` | `'/'` | Séparateur d'intervalle |
| `ZERO` | `'1970-01-01T00:00:00Z/PT0S'` | Intervalle de durée nulle à l'epoch |

### Propriétés

| Nom | Type | Accès | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | Chaîne ISO 8601, forme d'origine préservée |
| `$start` | `Iso8601DateTime` | get | Début (toujours présent) |
| `$end` | `Iso8601DateTime` | get | Fin (toujours présente, calculée si besoin) |
| `$duration` | `?Iso8601Duration` | get | Durée si présente dans l'input, sinon `null` |

### Méthodes

| Signature | Description |
|---|---|
| `__construct(?string $iso = null)` | Crée une instance |
| `contains(DateTimeInterface\|Iso8601DateTime $instant): bool` | Teste l'inclusion (semi-ouvert `[start, end)`) |
| `overlaps(self $other): bool` | Teste le chevauchement avec un autre intervalle (semi-ouvert) |
| `__toString(): string` | Renvoie la chaîne ISO |

## Sémantique semi-ouverte

Les méthodes `contains()` et `overlaps()` traitent les intervalles comme **`[start, end)`** : le début est inclus, la fin est exclue. Conséquences :
- Deux intervalles adjacents (la fin de l'un = le début de l'autre) ne se chevauchent pas.
- `contains(end)` retourne toujours `false`.

## Exemples

### Forme `<start>/<end>`

```php
use org\iso\Iso8601Interval;

$i = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
echo $i->start->iso;   // "2026-05-14T00:00:00Z"
echo $i->end->iso;     // "2026-05-15T00:00:00Z"
$i->duration;           // null (forme <start>/<end>)
```

### Forme `<start>/<duration>` — `end` calculé

```php
$i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');
echo $i->end->iso;       // "2026-05-15T00:00:00Z" (calculé)
echo $i->duration->iso;  // "P1D"
echo $i->iso;            // "2026-05-14T00:00:00Z/P1D" (forme préservée)
```

### Forme `<duration>/<end>` — `start` calculé

```php
$i = new Iso8601Interval('PT2H/2026-05-14T10:00:00Z');
echo $i->start->iso;     // "2026-05-14T08:00:00Z"
echo $i->duration->iso;  // "PT2H"
```

### Inclusion d'un instant

```php
$i = new Iso8601Interval('2026-05-14T00:00:00Z/P1D');

$i->contains(new DateTimeImmutable('2026-05-14T00:00:00Z')); // true  (start inclus)
$i->contains(new DateTimeImmutable('2026-05-14T12:00:00Z')); // true
$i->contains(new DateTimeImmutable('2026-05-15T00:00:00Z')); // false (end exclu)
```

### Chevauchement

```php
$a = new Iso8601Interval('2026-05-14T00:00:00Z/2026-05-15T00:00:00Z');
$b = new Iso8601Interval('2026-05-14T18:00:00Z/2026-05-16T00:00:00Z');
$a->overlaps($b); // true

$c = new Iso8601Interval('2026-05-15T00:00:00Z/2026-05-16T00:00:00Z'); // adjacent à $a
$a->overlaps($c); // false (semi-ouvert)
```

### Cas d'usage métier — fenêtre de validité d'un coupon

```php
use org\iso\Iso8601Interval;

function isCouponValid(string $couponInterval, DateTimeImmutable $at): bool
{
    return (new Iso8601Interval($couponInterval))->contains($at);
}

isCouponValid('2026-01-01T00:00:00Z/2026-12-31T23:59:59Z', new DateTimeImmutable('now'));
```

### Gestion d'erreurs

```php
new Iso8601Interval('P1D');                                      // throws (durée seule)
new Iso8601Interval('P1D/P2D');                                  // throws (deux durées)
new Iso8601Interval('2026-05-15T00:00:00Z/2026-05-14T00:00:00Z');// throws (end < start)
new Iso8601Interval('--/2026-05-15T00:00:00Z');                  // throws (open interval)
```

## Lié

- [`Iso8601DateTime`](Iso8601DateTime.md) — type de `$start` et `$end`
- [`Iso8601Duration`](Iso8601Duration.md) — type de `$duration`
- [`Iso8601Recurrence`](Iso8601Recurrence.md) — utilise un `Iso8601Interval` comme période
- Helpers : [`isIso8601Interval`](helpers/isIso8601Interval.md)

## Voir aussi

- [ISO 8601 — time intervals](https://en.wikipedia.org/wiki/ISO_8601#Time_intervals)
- [Pattern *value-object*](../../guides/value-objects.md)
