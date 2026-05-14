# Iso8601DateTime

> 🇬🇧 [English version](../../../en/standards/iso/Iso8601DateTime.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Combined date and time](https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations) |
> | **Namespace** | `org\iso\Iso8601DateTime` |
> | **Type** | Value-object |
> | **Source** | [Iso8601DateTime.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601DateTime.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`Iso8601DateTime` combine date et heure ISO 8601 dans un value-object unique. La classe **compose** [`Iso8601Date`](Iso8601Date.md) et [`Iso8601Time`](Iso8601Time.md) via les propriétés `datePart` et `timePart`.

**Validation stricte :**
- Seul le séparateur `T` est accepté (l'espace est rejeté).
- Le format de date est `YYYY-MM-DD` (étendu, pas de basic).
- L'heure est `HH:MM:SS` avec fractions de seconde optionnelles (`.fff…`).
- L'offset est `Z`, `±HH:MM` ou `±HHMM`.

**Précision auto-détectée :** quand on assigne une chaîne ISO avec fractions, la propriété `precision` se met à jour automatiquement (3 chiffres → `MILLISECONDS`, 4+ → `MICROSECONDS`, aucun → `SECONDS`).

## API

### Constantes

| Nom | Valeur | Description |
|---|---|---|
| `ZERO` | `'1970-01-01T00:00:00Z'` | Date-heure par défaut (epoch UTC) |
| `FORMAT` | `'Y-m-d\TH:i:s'` | Format `date()` de base (sans fraction ni offset) |
| `PATTERN` | (regex) | Validation stricte |
| `TIME` | `'T'` | Séparateur date/heure |
| `TIME_ZONE` | `'Z'` | Désignateur UTC |

### Propriétés

| Nom | Type | Accès | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | Chaîne ISO 8601 |
| `$dateTime` | `DateTimeInterface` | get/set | `DateTimeImmutable` interne |
| `$datePart` | `Iso8601Date` | get | Composant date (objet frais à chaque lecture) |
| `$timePart` | `Iso8601Time` | get | Composant heure (objet frais à chaque lecture) |
| `$timezone` | `?DateTimeZone` | get | Fuseau horaire |
| `$precision` | `string` | get/set | Précision de sortie ([`TimePrecision`](TimePrecision.md)) ; le setter regénère `iso` |

### Méthodes

| Signature | Description |
|---|---|
| `__construct(string\|DateTimeInterface\|null $dateTime = null)` | Crée une instance |
| `__toString(): string` | Renvoie la chaîne ISO |

## Composition

`$datePart` et `$timePart` retournent des **objets frais** à chaque accès. Les modifier n'affecte pas l'instance parente — pour modifier, passer par `$iso` ou `$dateTime`.

```php
$dt = new Iso8601DateTime('2026-05-14T08:15:30Z');
$dt->datePart->year;    // 2026
$dt->timePart->hours;   // 8

// ⚠️ Ne fonctionne pas (pas de propagation)
$dt->datePart->iso = '2030-01-01'; // muté sur la copie, pas sur $dt
```

## Exemples

### Création depuis une chaîne ISO

```php
use org\iso\Iso8601DateTime;

$dt = new Iso8601DateTime('2026-05-14T08:15:30+02:00');
echo $dt->iso;                  // "2026-05-14T08:15:30+02:00"
echo $dt->datePart->year;       // 2026
echo $dt->timePart->hours;      // 8
echo $dt->timezone->getName();  // "+02:00"
```

### Précision auto-détectée

```php
$utc   = new Iso8601DateTime('2026-05-14T08:15:30Z');
echo $utc->precision; // "seconds"

$milli = new Iso8601DateTime('2026-05-14T08:15:30.123Z');
echo $milli->precision; // "milliseconds"

$micro = new Iso8601DateTime('2026-05-14T08:15:30.123456+02:00');
echo $micro->precision; // "microseconds"
```

### Changer la précision (regénère `iso`)

```php
use org\iso\TimePrecision;

$dt = new Iso8601DateTime('2026-05-14T08:15:30Z');

$dt->precision = TimePrecision::MILLISECONDS;
echo $dt->iso; // "2026-05-14T08:15:30.000Z"

$dt->precision = TimePrecision::MICROSECONDS;
echo $dt->iso; // "2026-05-14T08:15:30.000000Z"
```

### Round-trip via `dateTime`

```php
$dt = new Iso8601DateTime('2026-05-14T08:15:30.123Z'); // precision = MILLISECONDS
$dt->dateTime = new DateTimeImmutable('2030-01-01T00:00:00', new DateTimeZone('UTC'));
echo $dt->iso; // "2030-01-01T00:00:00.000Z" (précision préservée)
```

### Cas d'usage métier — parsing d'un timestamp d'API

```php
use org\iso\Iso8601DateTime;
use InvalidArgumentException;

function parseApiTimestamp(string $iso): Iso8601DateTime
{
    try
    {
        return new Iso8601DateTime($iso);
    }
    catch (InvalidArgumentException $e)
    {
        throw new \RuntimeException("Timestamp API invalide : $iso", previous: $e);
    }
}

$created = parseApiTimestamp('2026-05-14T08:15:30.123Z');
```

### Gestion d'erreurs

```php
new Iso8601DateTime('INVALID');                   // throws
new Iso8601DateTime('2026-05-14 08:15:30Z');      // throws (espace au lieu de T)
new Iso8601DateTime('2023-02-29T12:00:00Z');      // throws (date invalide)

$dt = new Iso8601DateTime();
$dt->precision = 'nanoseconds';                    // throws (hors TimePrecision)
```

## Lié

- [`Iso8601Date`](Iso8601Date.md) — composant date
- [`Iso8601Time`](Iso8601Time.md) — composant heure
- [`TimePrecision`](TimePrecision.md) — constantes de précision
- Helpers : [`isIso8601DateTime`](helpers/isIso8601DateTime.md), [`toIso8601DateTime`](helpers/toIso8601DateTime.md)

## Voir aussi

- [ISO 8601 — combined representations](https://en.wikipedia.org/wiki/ISO_8601#Combined_date_and_time_representations)
- [Pattern *value-object*](../../guides/value-objects.md)
