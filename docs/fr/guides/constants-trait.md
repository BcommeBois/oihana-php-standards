# Guide — `ConstantsTrait`

> 🇬🇧 [English version](../../en/guides/constants-trait.md)

Toutes les **classes de constantes** de la bibliothèque utilisent le trait [`oihana\reflect\traits\ConstantsTrait`](https://github.com/BcommeBois/oihana-php-reflect/blob/main/src/oihana/reflect/traits/ConstantsTrait.php) (fourni par le package `oihana/php-reflect`). Ce trait apporte un ensemble de méthodes statiques utilitaires pour énumérer, valider et résoudre les constantes.

## Méthodes disponibles

| Méthode | Signature | Description |
|---|---|---|
| `getAll()` | `array<string,mixed>` | Map `[nom => valeur]` de toutes les constantes publiques de la classe (avec cache interne). |
| `enums()` | `array` | Liste à plat, dédupliquée et triée des valeurs. |
| `includes($value)` | `bool` | Vérifie qu'une valeur existe parmi les constantes. |
| `get($value, $default = null)` | `mixed` | Retourne la valeur si elle existe, sinon `$default`. |
| `validate($value, bool $strict = true)` | `mixed` | Retourne la valeur si valide, sinon lève `ConstantException`. |
| `getConstant($value, $separator = null)` | `string\|array\|null` | Recherche inverse : nom de la constante pour une valeur. Retourne un tableau si plusieurs constantes partagent la même valeur. |
| `resetCaches()` | `void` | Réinitialise les caches internes (utile en tests). |

## Exemples

### Énumération et validation

```php
use org\iso\ISO4217;

ISO4217::enums();              // ['AED', 'AFN', 'ALL', ...] (trié, dédupliqué)
ISO4217::includes('EUR');      // true
ISO4217::includes('FAKE');     // false
ISO4217::validate('USD');      // 'USD'
ISO4217::validate('FAKE');     // throws ConstantException
```

### Recherche inverse

```php
use org\common\NumberFormat;

NumberFormat::getConstant('%');   // "PERCENT_SYMBOL"
NumberFormat::getConstant('NaN'); // "NAN_SYMBOL"

// Si plusieurs constantes partagent la même valeur, getConstant() retourne un tableau
NumberFormat::getConstant(',');   // ['DECIMAL_SEP_EU', 'DECIMAL_SEP_FR']
```

### Cache

Les méthodes `getAll()` et `getConstant()` mettent en cache leurs résultats. Si tu modifies une classe dynamiquement (rare, sauf en tests), appelle `resetCaches()` :

```php
ISO4217::resetCaches();
```

## Liste des classes qui utilisent ce trait

- `org\iso\ISO3166_1`, `org\iso\ISO639_1`, `org\iso\ISO4217`, `org\iso\ISO15924`
- `org\iso\Iso8601Format`, `org\iso\TimePrecision`
- `org\common\DateFormat`, `org\common\NumberFormat`
- `org\unece\uncefact\MeasureCode`, `MeasureName`, `MeasureSymbol`, `PackageCode`, `PackageName`
- `org\unstats\UNM49`

## Voir aussi

- [Code source de `ConstantsTrait`](https://github.com/BcommeBois/oihana-php-reflect/blob/main/src/oihana/reflect/traits/ConstantsTrait.php)
- [Convention des helpers](helpers.md)
