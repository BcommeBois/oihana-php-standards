# Iso8601Time

> 🇬🇧 [English version](../../../en/standards/iso/Iso8601Time.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Times](https://en.wikipedia.org/wiki/ISO_8601#Times) |
> | **Namespace** | `org\iso\Iso8601Time` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Time.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Time.php) |
> | **Disponible depuis** | `1.0.1` |

## Vue d'ensemble

`Iso8601Time` représente une heure du jour selon ISO 8601, avec préfixe `T` et fuseau horaire optionnel (`Z` ou `±HH:MM`).

Formes acceptées :
- `T14:30:00Z` — 14:30:00 UTC
- `T08:15:30+02:00` — 08:15:30 en UTC+2
- `T23:59:59` — 23:59:59 heure locale (sans offset)

La classe normalise le préfixe `T` automatiquement (l'input `14:30:00Z` devient `T14:30:00Z`).

## API

### Constantes

| Nom | Valeur | Description |
|---|---|---|
| `ZERO` | `'00:00:00'` | Heure zéro (sans préfixe) |
| `TIME_ZERO` | `'T00:00:00'` | Heure zéro avec préfixe |
| `FORMAT` | `'H:i:s'` | Format `date()` PHP |
| `PATTERN` | (regex) | Validation stricte du format |
| `TIME` | `'T'` | Préfixe désignateur d'heure |
| `TIME_ZONE` | `'Z'` | Désignateur UTC |
| `HOUR` / `MINUTE` / `SECOND` | `'H'` / `'i'` / `'s'` | Format `date()` des composants |

### Propriétés

| Nom | Type | Accès | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | Chaîne ISO 8601, ex. `"T14:30:00Z"` |
| `$time` | `DateTimeInterface` | get/set | `DateTimeImmutable` interne |
| `$hours` | `int` | get | Heure 0–23 |
| `$minutes` | `int` | get | Minute 0–59 |
| `$seconds` | `int` | get | Seconde 0–59 |
| `$timezone` | `?DateTimeZone` | get | Fuseau horaire (ou `null` si absent) |

### Méthodes

| Signature | Description |
|---|---|
| `__construct(string\|DateTimeInterface\|null $time = null)` | Crée une instance depuis une chaîne ISO, un objet natif ou `null` |
| `__toString(): string` | Renvoie la chaîne ISO |

## Exemples

### Création et accès aux composants

```php
use org\iso\Iso8601Time;

$t = new Iso8601Time('T14:30:00Z');
echo $t->hours;    // 14
echo $t->minutes;  // 30
echo $t->seconds;  // 0
echo $t->iso;      // "T14:30:00Z"
```

### Depuis un `DateTimeImmutable`

```php
$dt = new DateTimeImmutable('08:15:30', new DateTimeZone('+02:00'));
$t  = new Iso8601Time($dt);
echo $t->iso;                              // "T08:15:30+02:00"
echo $t->timezone->getName();              // "+02:00"
```

### Préfixe `T` ajouté automatiquement

```php
$t = new Iso8601Time('23:45:01Z'); // sans T
echo $t->iso; // "T23:45:01Z"
```

### Round-trip via les setters

```php
$t = new Iso8601Time();
$t->iso = 'T23:59:59+01:00';
echo $t->hours;                            // 23
$t->time = new DateTimeImmutable('12:34:56', new DateTimeZone('UTC'));
echo $t->iso;                              // "T12:34:56Z"
```

### Cas d'usage métier — calcul d'horaire d'ouverture

```php
use org\iso\Iso8601Time;

$opening = new Iso8601Time('T09:00:00');
$closing = new Iso8601Time('T18:30:00');

$now = new Iso8601Time(new DateTimeImmutable('now'));
$isOpen = $now->time >= $opening->time && $now->time < $closing->time;
```

### Gestion d'erreurs

```php
new Iso8601Time('INVALID');     // InvalidArgumentException
new Iso8601Time('T24:00:00');   // throws (heure invalide)
new Iso8601Time('T12:60:00');   // throws (minute invalide)
```

## Lié

- [`Iso8601Date`](Iso8601Date.md) — pendant date-only
- [`Iso8601DateTime`](Iso8601DateTime.md) — combine date + heure (composition via `timePart`)
- Helpers : [`isIso8601Time`](helpers/isIso8601Time.md), [`toIso8601Time`](helpers/toIso8601Time.md)

## Voir aussi

- [ISO 8601 — times](https://en.wikipedia.org/wiki/ISO_8601#Times)
- [PHP `DateTimeImmutable`](https://www.php.net/manual/fr/class.datetimeimmutable.php)
- [Pattern *value-object*](../../guides/value-objects.md)
