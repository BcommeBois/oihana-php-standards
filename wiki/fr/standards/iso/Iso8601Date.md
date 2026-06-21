# Iso8601Date

> 🇬🇧 [English version](../../../en/standards/iso/Iso8601Date.md)
>
> | | |
> |---|---|
> | **Standard** | [ISO 8601 — Calendar dates](https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates) |
> | **Namespace** | `org\iso\Iso8601Date` |
> | **Type** | Value-object |
> | **Source** | [Iso8601Date.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/iso/Iso8601Date.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`Iso8601Date` encapsule une date calendaire ISO 8601 au **format étendu strict** `YYYY-MM-DD`. La classe maintient une synchronisation bidirectionnelle entre la chaîne ISO et un `DateTimeImmutable` interne, et expose les composants (`year`, `month`, `day`, `weekday`, `dayOfYear`) en lecture.

**Validation stricte :**
- Le format basic (`YYYYMMDD`) est **rejeté** — voir le pattern `Iso8601Date::PATTERN`.
- La validité calendaire est vérifiée (29 février uniquement les années bissextiles, etc.).
- Le mois et le jour doivent être *zero-padded* (`05`, pas `5`).

C'est le pendant *date-only* de [`Iso8601Time`](Iso8601Time.md) et le composant [`datePart`](Iso8601DateTime.md#composition) de [`Iso8601DateTime`](Iso8601DateTime.md).

## API

### Constantes

| Nom | Valeur | Description |
|---|---|---|
| `ZERO` | `'1970-01-01'` | Date par défaut (epoch Unix) |
| `FORMAT` | `'Y-m-d'` | Format `date()` PHP |
| `PATTERN` | (regex) | Validation stricte du format étendu |
| `YEAR` / `MONTH` / `DAY` | `'Y'` / `'m'` / `'d'` | Format `date()` des composants |
| `WEEKDAY` | `'N'` | Jour de la semaine ISO (1=lundi..7=dimanche) |
| `DAY_OF_YEAR` | `'z'` | Jour de l'année (0-based en PHP ; la propriété renvoie 1-based) |

### Propriétés

| Nom | Type | Accès | Description |
|---|---|---|---|
| `$iso` | `string` | get/set | Chaîne ISO 8601, ex. `"2026-05-14"` |
| `$date` | `DateTimeInterface` | get/set | `DateTimeImmutable` interne |
| `$year` | `int` | get | Année 4 chiffres |
| `$month` | `int` | get | Mois 1–12 |
| `$day` | `int` | get | Jour du mois 1–31 |
| `$weekday` | `int` | get | Jour de la semaine ISO (1=lundi..7=dimanche) |
| `$dayOfYear` | `int` | get | Jour de l'année 1-based (1=1er janvier, 366=31 déc. en année bissextile) |

### Méthodes

| Signature | Description |
|---|---|
| `__construct(string\|DateTimeInterface\|null $date = null)` | Crée une instance depuis une chaîne ISO, un objet natif ou `null` (epoch) |
| `__toString(): string` | Renvoie la chaîne ISO |

## Exemples

### Création et accès aux composants

```php
use org\iso\Iso8601Date;

$d = new Iso8601Date('2026-05-14');
echo $d->year;       // 2026
echo $d->month;      // 5
echo $d->day;        // 14
echo $d->weekday;    // 4 (jeudi)
echo $d->dayOfYear;  // 134
```

### Depuis un `DateTimeImmutable`

```php
$dt = new DateTimeImmutable('2024-02-29 12:34:56');
$d  = new Iso8601Date($dt);
echo $d->iso; // "2024-02-29" (l'heure est ignorée)
```

### Round-trip via les setters

```php
$d = new Iso8601Date('2026-05-14');

// Modifier via $iso
$d->iso = '2030-12-31';
echo $d->year; // 2030

// Modifier via $date
$d->date = new DateTimeImmutable('1999-01-01');
echo $d->iso; // "1999-01-01"
```

### Cas d'usage métier — validation de date dans un formulaire

```php
use org\iso\Iso8601Date;
use InvalidArgumentException;

function validateBirthDate(string $input): Iso8601Date
{
    try
    {
        $date = new Iso8601Date($input);
    }
    catch (InvalidArgumentException $e)
    {
        throw new InvalidArgumentException("Date de naissance invalide : $input");
    }

    if ($date->year < 1900 || $date->date > new DateTimeImmutable('today'))
    {
        throw new InvalidArgumentException("Date de naissance hors plage : $input");
    }

    return $date;
}
```

### Gestion d'erreurs — formats rejetés

```php
new Iso8601Date('INVALID');     // InvalidArgumentException
new Iso8601Date('20260514');    // throws (format basic rejeté)
new Iso8601Date('2023-02-29');  // throws (2023 n'est pas bissextile)
new Iso8601Date('2026-5-14');   // throws (mois non zero-padded)
new Iso8601Date('2026/05/14');  // throws (mauvais séparateur)
```

## Lié

- [`Iso8601Time`](Iso8601Time.md) — pendant time-only
- [`Iso8601DateTime`](Iso8601DateTime.md) — combine date + heure (composition via `datePart`)
- Helpers : [`isIso8601Date`](helpers/isIso8601Date.md), [`toIso8601Date`](helpers/toIso8601Date.md)
- [`Iso8601Format`](Iso8601Format.md) — constantes de formats utilisées en interne

## Voir aussi

- [ISO 8601 — calendar dates](https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates)
- [PHP `DateTimeImmutable`](https://www.php.net/manual/fr/class.datetimeimmutable.php)
- [PHP `checkdate()`](https://www.php.net/manual/fr/function.checkdate.php) — utilisée pour la validation calendaire
- [Pattern *value-object* du projet](../../guides/value-objects.md)
