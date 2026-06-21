# UNM49Numeric

> 🇬🇧 [English version](../../../en/standards/unstats/UNM49Numeric.md)
>
> | | |
> |---|---|
> | **Standard** | [UN M49 — Standard Country or Area Codes](https://unstats.un.org/unsd/methodology/m49/) |
> | **Namespace** | `org\unstats\UNM49Numeric` |
> | **Type** | Classe de constantes (`ConstantsTrait`) |
> | **Source** | [UNM49Numeric.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unstats/UNM49Numeric.php) |
> | **Disponible depuis** | `1.0.3` |

## Vue d'ensemble

`UNM49Numeric` énumère les **codes numériques 3 chiffres** du standard UN M49 publié par la Division statistique des Nations Unies. Le standard couvre :

- les **pays et territoires** (chevauchement avec ISO 3166-1 numeric) — ex. `004` Afghanistan, `250` France, `840` États-Unis ;
- les **groupements géographiques** (continents, sous-régions, catégories spéciales) — ex. `001` World, `019` Americas, `142` Asia, `150` Europe, `419` Latin America and the Caribbean.

Les valeurs préservent toujours la forme **3 chiffres avec zéros de remplissage** (`'004'`, pas `'4'`).

> Pour les codes alpha-3 (`FRA`, `USA`, …), voir [`UNM49`](UNM49.md). Pour les codes alpha-2 (`FR`, `US`, …), voir [`ISO3166_1`](../iso/ISO3166_1.md).

## Convention de nommage

Les identifiants PHP ne pouvant pas commencer par un chiffre, **toutes les constantes sont préfixées par `M_`** :

| Constante | Valeur | Description |
|---|---|---|
| `M_001` | `'001'` | World (région M49) |
| `M_004` | `'004'` | Afghanistan |
| `M_250` | `'250'` | France |
| `M_419` | `'419'` | Latin America and the Caribbean (région M49) |

Cette convention reste cohérente avec celle adoptée pour les variants BCP 47 numériques (`V_1996`, etc.).

## Régions M49 (sous-ensemble utile pour BCP 47)

Selon [RFC 5646 §2.2.4](https://www.rfc-editor.org/rfc/rfc5646#section-2.2.4), seuls les **codes régionaux M49 sans équivalent ISO 3166-1 alpha-2** sont autorisés comme `region` subtag numérique :

| Code | Région |
|---|---|
| `001` | World |
| `002` | Africa |
| `019` | Americas |
| `009` | Oceania |
| `142` | Asia |
| `150` | Europe |
| `419` | Latin America and the Caribbean |
| `029` | Caribbean |
| `030` | Eastern Asia |
| `034` | Southern Asia |
| `035` | South-eastern Asia |
| `143` | Central Asia |
| `145` | Western Asia |
| `151` | Eastern Europe |
| `154` | Northern Europe |
| `155` | Western Europe |
| `039` | Southern Europe |
| `011` | Western Africa |
| `014` | Eastern Africa |
| `015` | Northern Africa |
| `017` | Middle Africa |
| `018` | Southern Africa |
| `202` | Sub-Saharan Africa |
| `053` | Australia and New Zealand |
| `054` | Melanesia |
| `057` | Micronesia |
| `061` | Polynesia |
| `003` | North America |
| `005` | South America |
| `013` | Central America |
| `021` | Northern America |

Cette classe contient ces codes **en plus** des codes pays (~248) et des groupements spéciaux (`199`, `432`, `722`, `778`, etc.) — voir la [liste complète](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/unstats/UNM49Numeric.php) (~285 entrées au total).

## Méthodes héritées

Voir le guide [ConstantsTrait](../../guides/constants-trait.md).

## Exemples

```php
use org\unstats\UNM49Numeric;

UNM49Numeric::M_250;               // '250' (France)
UNM49Numeric::M_419;               // '419' (Latin America and the Caribbean)

UNM49Numeric::includes('001');     // true
UNM49Numeric::includes('999');     // false (non assigné)

UNM49Numeric::getConstant('419');  // 'M_419'
```

### Cas d'usage — locale BCP 47 régionale

```php
use org\ietf\Locale;

// Espagnol "Latin American" (subtag region = 419)
$locale = new Locale('es-419', strict: true);
echo $locale->language;  // 'es'
echo $locale->region;    // '419'
```

En mode strict, [`isLocale`](../ietf/helpers/isLocale.md) cross-valide les régions 3 chiffres contre `UNM49Numeric` :

```php
use function org\ietf\helpers\isLocale;

isLocale('es-419', strict: true);   // true  (419 = Latin America and the Caribbean)
isLocale('es-999', strict: true);   // false (999 non assigné)
```

## Régénération à partir des sources

Le fichier est généré par [`tools/generate-unm49-numeric.php`](https://github.com/BcommeBois/oihana-php-standards/blob/main/tools/generate-unm49-numeric.php). Pour mettre à jour après une révision UN M49 :

```bash
# 1. Mettre à jour le dataset inline en tête du script
# 2. Régénérer
php tools/generate-unm49-numeric.php
```

## Lié

- [`UNM49`](UNM49.md) — codes alpha-3 (`FRA`, `USA`, …) du même standard
- [`ISO3166_1`](../iso/ISO3166_1.md) — codes pays alpha-2 (`FR`, `US`, …)
- [`Locale`](../ietf/Locale.md) — utilise `UNM49Numeric` pour valider les régions 3 chiffres en mode strict
- Index UN/STATS : [README.md](README.md)

## Voir aussi

- [UN M49 — méthodologie](https://unstats.un.org/unsd/methodology/m49/)
- [RFC 5646 §2.2.4 — Region subtag](https://www.rfc-editor.org/rfc/rfc5646#section-2.2.4)
- [ConstantsTrait](../../guides/constants-trait.md)
