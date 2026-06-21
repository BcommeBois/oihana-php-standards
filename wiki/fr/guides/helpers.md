# Guide — Convention des helpers

> 🇬🇧 [English version](../../en/guides/helpers.md)

Les helpers sont des **fonctions standalone** (pas des méthodes statiques de classes). Ils vivent dans `src/<namespace>/helpers/` et sont chargés via la section `autoload.files` de `composer.json`.

## Trois familles

| Préfixe | Rôle | Signature type |
|---|---|---|
| `is<Type>` | Validation booléenne | `function isXxx(string $value, bool $strict = false): bool` |
| `to<Type>` | Conversion native → string ISO | `function toXxx(<NativeType> $value, ...): string` |
| `parse<Type>` | Parsing string → composants structurés | `function parseXxx(string $value): ?array` |

## Règle de séparation des responsabilités

Les helpers sont **complémentaires** aux value-objects, pas duplicatifs :

| Tâche | Outil à utiliser |
|---|---|
| Valider un format avant instanciation | Helper `is<Type>` |
| Convertir un `DateTimeInterface` en string ISO | Helper `to<Type>` |
| Manipuler une valeur (accès composants, sérialisation) | Value-object (`new Iso8601Date(...)`) |
| Calculer une opération métier (overlap, contains, etc.) | Méthode d'instance sur le value-object |

> **Note de design :** les helpers ne dupliquent jamais une méthode d'instance d'un value-object. Par exemple, il n'y a pas d'helper `intervalContains()` — c'est `Iso8601Interval::contains()` qui assume cette responsabilité.

## Exemples

### Validation rapide sans instancier

```php
use function org\iso\helpers\isIso8601DateTime;
use function org\ietf\helpers\isLocale;

isIso8601DateTime($_POST['timestamp'], true); // strict T
isLocale($_POST['locale'], strict: true);     // cross-validation ISO
```

### Conversion depuis du natif

```php
use function org\iso\helpers\toIso8601Date;
use function org\iso\helpers\toIso8601DateTime;
use org\iso\TimePrecision;

toIso8601Date(new DateTime('2026-05-14'));            // "2026-05-14"
toIso8601DateTime(new DateTimeImmutable('now'), TimePrecision::MILLISECONDS);
```

### Parsing avec composants

```php
use function org\ietf\helpers\parseLocaleTag;

$parts = parseLocaleTag('zh-Hant-TW');
// [
//   'language'   => 'zh',
//   'script'     => 'Hant',
//   'region'     => 'TW',
//   'variants'   => [],
//   'privateUse' => null,
// ]
```

## Liste complète des helpers

### ISO 8601 (`org\iso\helpers`)
| `is*` | `to*` |
|---|---|
| [`isIso8601Date`](../standards/iso/helpers/isIso8601Date.md) | [`toIso8601Date`](../standards/iso/helpers/toIso8601Date.md) |
| [`isIso8601Time`](../standards/iso/helpers/isIso8601Time.md) | [`toIso8601Time`](../standards/iso/helpers/toIso8601Time.md) |
| [`isIso8601DateTime`](../standards/iso/helpers/isIso8601DateTime.md) | [`toIso8601DateTime`](../standards/iso/helpers/toIso8601DateTime.md) |
| [`isIso8601Duration`](../standards/iso/helpers/isIso8601Duration.md) | [`toIso8601Duration`](../standards/iso/helpers/toIso8601Duration.md) |
| [`isIso8601Interval`](../standards/iso/helpers/isIso8601Interval.md) | — |
| [`isIso8601Recurrence`](../standards/iso/helpers/isIso8601Recurrence.md) | — |

### Locale (`org\ietf\helpers`)
- [`isLocale`](../standards/ietf/helpers/isLocale.md)
- [`parseLocaleTag`](../standards/ietf/helpers/parseLocaleTag.md)

## Voir aussi

- [Pattern value-object](value-objects.md)
- [ConstantsTrait](constants-trait.md)
