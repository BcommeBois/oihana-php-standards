# Iso8601Duration

> 🇬🇧 [English version](../../../en/standards/iso/Iso8601Duration.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Durations](https://en.wikipedia.org/wiki/ISO_8601#Durations) |
> | **Namespace** | `org\iso\Iso8601Duration` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Duration.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Duration.php) |
> | **Disponible depuis** | `1.0.1` |

## Vue d'ensemble

`Iso8601Duration` enveloppe `DateInterval` de PHP avec la chaîne ISO 8601 correspondante. Format général : `P[n]Y[n]M[n]DT[n]H[n]M[n]S`.

Composantes :
- `P` (obligatoire) — désignateur de période
- `T` — sépare partie date et partie temps
- `Y` / `M` / `D` — années, mois, jours
- `H` / `M` / `S` — heures, minutes, secondes (après `T`)
- `W` — semaines (alternatif aux jours)

## API

### Constantes

| Nom | Valeur | Description |
|---|---|---|
| `ZERO` | `'P0D'` | Durée nulle |
| `PERIOD` | `'P'` | Désignateur de période |
| `TIME` | `'T'` | Désignateur de temps |
| `YEAR` / `MONTH` / `DAY` | `'Y'` / `'M'` / `'D'` | Désignateurs date |
| `HOUR` / `MINUTE` / `SECOND` | `'H'` / `'M'` / `'S'` | Désignateurs temps |
| `WEEK` | `'W'` | Désignateur de semaines |
| `PATTERN` | (regex) | Validation stricte |

### Propriétés

| Nom | Type | Accès | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | Chaîne ISO 8601, ex. `"P1Y2M3D"` |
| `$interval` | `DateInterval` | get/set | `DateInterval` interne (cloné en lecture) |
| `$years` | `int` | get | Composante années |
| `$months` | `int` | get | Composante mois |
| `$days` | `int` | get | Composante jours |
| `$hours` | `int` | get | Composante heures |
| `$minutes` | `int` | get | Composante minutes |
| `$seconds` | `int` | get | Composante secondes |

### Méthodes

| Signature | Description |
|---|---|
| `__construct(string\|DateInterval\|null $duration = null)` | Crée une instance |
| `addTo(DateTime $date): DateTime` | Renvoie une nouvelle date avec la durée ajoutée |
| `subtractFrom(DateTime $date): DateTime` | Renvoie une nouvelle date avec la durée soustraite |
| `toSeconds(): int` | Conversion approximative en secondes (1 an = 365 j, 1 mois = 30 j) |
| `__toString(): string` | Renvoie la chaîne ISO |

## Exemples

### Création et accès aux composantes

```php
use org\iso\Iso8601Duration;

$d = new Iso8601Duration('P1Y2M3D');
echo $d->years;   // 1
echo $d->months;  // 2
echo $d->days;    // 3
echo $d->iso;     // "P1Y2M3D"

$t = new Iso8601Duration('PT4H30M');
echo $t->hours;   // 4
echo $t->minutes; // 30
```

### Addition / soustraction à une date

```php
$d = new Iso8601Duration('P1M');
$start = new DateTime('2024-01-31');
$end   = $d->addTo($start);
echo $end->format('Y-m-d'); // "2024-02-29" (année bissextile)
```

### Depuis un `DateInterval`

```php
$interval = new DateInterval('PT2H30M');
$d = new Iso8601Duration($interval);
echo $d->iso;        // "PT2H30M"
echo $d->toSeconds(); // 9000
```

### Depuis la différence entre deux dates

```php
$start = new DateTime('2024-01-01');
$end   = new DateTime('2024-12-31');
$d     = new Iso8601Duration($start->diff($end));
echo $d->iso; // ex. "P11M30D"
```

### Cas d'usage métier — calcul d'expiration

```php
use org\iso\Iso8601Duration;

function computeExpiry(DateTime $issuedAt, string $ttl): DateTime
{
    $duration = new Iso8601Duration($ttl);
    return $duration->addTo($issuedAt);
}

$expiry = computeExpiry(new DateTime('now'), 'P30D');
```

### Gestion d'erreurs

```php
new Iso8601Duration('INVALID');  // InvalidArgumentException
new Iso8601Duration('P');        // throws (aucune composante)
new Iso8601Duration('1Y2M');     // throws (préfixe P manquant)
```

## Lié

- Helpers : [`isIso8601Duration`](helpers/isIso8601Duration.md), [`toIso8601Duration`](helpers/toIso8601Duration.md)
- [`Iso8601Interval`](Iso8601Interval.md) — utilise une durée pour les formes `<start>/<duration>` et `<duration>/<end>`
- [`Iso8601Recurrence`](Iso8601Recurrence.md) — utilise l'intervalle (et sa durée) pour calculer la période de répétition

## Voir aussi

- [ISO 8601 — durations](https://en.wikipedia.org/wiki/ISO_8601#Durations)
- [PHP `DateInterval`](https://www.php.net/manual/fr/class.dateinterval.php)
- [Pattern *value-object*](../../guides/value-objects.md)
