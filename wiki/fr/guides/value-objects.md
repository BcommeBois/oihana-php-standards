# Guide — Pattern *value-object*

> 🇬🇧 [English version](../../en/guides/value-objects.md)

Toutes les classes représentant une **valeur typée** (Iso8601Date, Iso8601Time, Iso8601DateTime, Iso8601Duration, Iso8601Interval, Iso8601Recurrence, Locale) suivent le même pattern, basé sur les *property hooks* PHP 8.4.

## Principes

### 1. Constructeur unique

Le constructeur accepte une string (forme ISO), un objet PHP natif équivalent (ex. `DateTimeInterface`), ou `null` pour la valeur par défaut.

```php
new Iso8601Date('2026-05-14');
new Iso8601Date(new DateTimeImmutable('2026-05-14'));
new Iso8601Date(); // valeur par défaut (ZERO)
```

### 2. Propriété `$iso` toujours présente

Chaque value-object expose une propriété `$iso` (string) en **lecture/écriture**. Assigner une nouvelle valeur valide la chaîne, met à jour les composants internes et la conserve canonique.

```php
$d = new Iso8601Date('2026-05-14');
echo $d->iso;          // "2026-05-14"

$d->iso = '2030-01-01'; // ré-écrit tout
echo $d->year;          // 2030
```

### 3. Propriété native ↔ `$iso` synchronisée

Pour les classes ISO 8601 date/heure, une propriété native (`$date`, `$time`, `$dateTime`, `$interval`) miroir l'objet PHP correspondant.

```php
$d = new Iso8601Date();
$d->date = new DateTimeImmutable('2026-05-14');
echo $d->iso;          // "2026-05-14" (mis à jour automatiquement)
```

### 4. Constantes communes par classe

| Constante | Rôle |
|---|---|
| `ZERO` | Valeur par défaut renvoyée si rien n'est fourni au constructeur. |
| `FORMAT` | Format PHP `date()` utilisé pour la sérialisation (quand applicable). |
| `PATTERN` | Regex de validation stricte (quand applicable). |

### 5. `__toString()` renvoie l'ISO

Toute classe value-object peut être castée en string :

```php
$d = new Iso8601Date('2026-05-14');
echo "Date: $d\n"; // "Date: 2026-05-14"
```

### 6. Validation par exception

Toute valeur invalide passée à `$iso` ou au constructeur lève `InvalidArgumentException` avec un message explicite.

```php
new Iso8601Date('INVALID');   // throws InvalidArgumentException
new Iso8601Date('20260514');  // throws (format basic rejeté, strict extended uniquement)
new Iso8601Date('2023-02-29');// throws (date calendaire invalide)
```

## Classes qui suivent ce pattern

| Classe | Type natif PHP | `ZERO` |
|---|---|---|
| [`Iso8601Date`](../standards/iso/Iso8601Date.md) | `DateTimeImmutable` | `1970-01-01` |
| [`Iso8601Time`](../standards/iso/Iso8601Time.md) | `DateTimeImmutable` | `T00:00:00` |
| [`Iso8601DateTime`](../standards/iso/Iso8601DateTime.md) | `DateTimeImmutable` | `1970-01-01T00:00:00Z` |
| [`Iso8601Duration`](../standards/iso/Iso8601Duration.md) | `DateInterval` | `P0D` |
| [`Iso8601Interval`](../standards/iso/Iso8601Interval.md) | — | `1970-01-01T00:00:00Z/PT0S` |
| [`Iso8601Recurrence`](../standards/iso/Iso8601Recurrence.md) | — | `R0/1970-01-01T00:00:00Z/PT0S` |
| [`Locale`](../standards/ietf/Locale.md) | — | `und` |

## Voir aussi

- [ConstantsTrait](constants-trait.md) — pour les classes de constantes
- [Convention des helpers](helpers.md)
