# Pour commencer

> 🇬🇧 [English version](../en/getting-started.md)

## Prérequis

- **PHP 8.4+** (la bibliothèque utilise les *property hooks* introduits en 8.4)
- [Composer](https://getcomposer.org)

## Installation

```bash
composer require oihana/php-standards
```

## Premier usage — 3 exemples

### 1. Utiliser une constante ISO

```php
use org\iso\ISO4217;

$usd = ISO4217::USD;             // "USD"
ISO4217::includes('EUR');        // true
ISO4217::getConstant('JPY');     // "JPY" (nom de la constante)
```

Voir le guide [ConstantsTrait](guides/constants-trait.md) pour la liste complète des méthodes communes.

### 2. Manipuler une date ISO 8601

```php
use org\iso\Iso8601Date;

$date = new Iso8601Date('2026-05-14');
echo $date->year;       // 2026
echo $date->weekday;    // 4 (jeudi, ISO 1=lundi..7=dimanche)
echo $date->dayOfYear;  // 134

// Round-trip via DateTimeImmutable
$dt = new DateTimeImmutable('2030-12-31');
echo (new Iso8601Date($dt))->iso; // "2030-12-31"
```

Voir le guide [Value-objects](guides/value-objects.md) pour le pattern commun à toutes les classes date/heure et `Locale`.

### 3. Valider un format avec un helper

```php
use function org\iso\helpers\isIso8601DateTime;
use function org\iso\helpers\toIso8601DateTime;

isIso8601DateTime('2026-05-14T08:15:30Z');         // true
isIso8601DateTime('2026-05-14 08:15:30Z', true);   // false (strict requiert T)

$dt = new DateTimeImmutable('2026-05-14T08:15:30+02:00');
toIso8601DateTime($dt);                             // "2026-05-14T08:15:30+02:00"
```

Voir le guide [Convention des helpers](guides/helpers.md) pour comprendre la séparation `is*` / `to*` / `parse*`.

## Que faire ensuite ?

- Parcourir le [catalogue par standard](README.md#parcourir-par-standard)
- Lire les 3 [guides transverses](README.md#accès-rapide)
- Voir le [code source sur GitHub](https://github.com/BcommeBois/oihana-php-standards)
