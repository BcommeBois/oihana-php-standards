# DateFormat

> 🇬🇧 [English version](../../../en/standards/common/DateFormat.md)
>
> | | |
> |---|---|
> | **Standards** | [RFC 2822](https://www.rfc-editor.org/rfc/rfc2822), [RFC 7231](https://www.rfc-editor.org/rfc/rfc7231) |
> | **Namespace** | `org\common\DateFormat` |
> | **Type** | Classe de constantes (`ConstantsTrait`) — étend [`Iso8601Format`](../iso/Iso8601Format.md) |
> | **Source** | [DateFormat.php](https://github.com/BcommeBois/oihana-php-standards/blob/main/src/org/common/DateFormat.php) |
> | **Disponible depuis** | `1.0.2` |

## Vue d'ensemble

`DateFormat` est un **catalogue étendu de patterns de format date/heure**. Il hérite de toutes les constantes [`Iso8601Format`](../iso/Iso8601Format.md) (étendues + basic) et ajoute les formats RFC, HTTP, SQL et Unix les plus courants.

> **Sur RFC 3339 / ATOM** : ces formats sont strictement équivalents à `Iso8601Format::DATE_TIME` (= `Y-m-d\TH:i:sP`). Ils ne sont **pas** redéclarés ici, pour garder une recherche inverse (`getConstant()`) déterministe.

## Constantes ajoutées (en plus de celles d'`Iso8601Format`)

### Date emails / Usenet

| Constante | Pattern | Exemple |
|---|---|---|
| `RFC822` | `D, d M y H:i:s O` | `Thu, 14 May 26 08:15:30 +0200` (année 2 chiffres, obsolète) |
| `RFC850` | `l, d-M-y H:i:s T` | `Thursday, 14-May-26 08:15:30 UTC` (Usenet, obsolète) |
| `RFC1036` | `D, d M y H:i:s O` | Identique à RFC 822 |
| `RFC1123` | `D, d M Y H:i:s O` | `Thu, 14 May 2026 08:15:30 +0200` (moderne) |
| `RFC2822` | `D, d M Y H:i:s O` | `Thu, 14 May 2026 08:15:30 +0200` (RFC moderne) |
| `RSS` | `D, d M Y H:i:s O` | Format `pubDate` RSS 2.0 |

### HTTP

| Constante | Pattern | Exemple |
|---|---|---|
| `RFC7231` | `D, d M Y H:i:s \G\M\T` | `Thu, 14 May 2026 06:15:30 GMT` (HTTP IMF-fixdate, toujours GMT) |

### Cookies

| Constante | Pattern | Exemple |
|---|---|---|
| `COOKIE` | `l, d-M-Y H:i:s T` | `Thursday, 14-May-2026 08:15:30 UTC` (RFC 6265) |

### SQL / Unix

| Constante | Pattern | Exemple |
|---|---|---|
| `MYSQL` | `Y-m-d H:i:s` | `2026-05-14 08:15:30` (MySQL/SQLite DATETIME, espace au lieu de T) |
| `UNIX` | `U` | `1778889330` (secondes depuis l'epoch UTC) |

## Méthodes héritées

Toutes les méthodes de [`ConstantsTrait`](../../guides/constants-trait.md) (`getAll()`, `enums()`, `includes()`, `getConstant()`, …) — incluent à la fois les constantes ISO et les constantes ajoutées.

## Exemples

### Formatage avec constantes héritées et ajoutées

```php
use org\common\DateFormat;

$dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));

// Constantes héritées d'Iso8601Format
echo $dt->format(DateFormat::DATE_TIME);        // "2026-05-14T08:15:30+02:00"
echo $dt->format(DateFormat::DATE_TIME_ZULU);   // (cf. Iso8601Format)

// Constantes RFC / HTTP / MySQL
echo $dt->format(DateFormat::RFC2822);          // "Thu, 14 May 2026 08:15:30 +0200"
echo $dt->format(DateFormat::RFC7231);          // attention : nécessite UTC, voir ci-dessous
echo $dt->format(DateFormat::MYSQL);            // "2026-05-14 08:15:30"
```

### RFC 7231 — convertir vers UTC d'abord

```php
$dt = new DateTimeImmutable('2026-05-14T08:15:30+02:00');
$utc = $dt->setTimezone(new DateTimeZone('UTC'));
echo $utc->format(DateFormat::RFC7231); // "Thu, 14 May 2026 06:15:30 GMT"
```

### Lookup inverse — agrégation ISO + non-ISO

```php
DateFormat::includes(\org\iso\Iso8601Format::DATE);   // true (héritage)
DateFormat::includes(DateFormat::MYSQL);              // true
DateFormat::getConstant('D, d M Y H:i:s O');          // "RFC1123" (ou "RFC2822" / "RSS" — partagent la même valeur)
DateFormat::getConstant('Y-m-d H:i:s');               // "MYSQL"
```

### Cas d'usage métier — header HTTP `Last-Modified`

```php
use org\common\DateFormat;

function lastModifiedHeader(DateTimeImmutable $dt): string
{
    $utc = $dt->setTimezone(new DateTimeZone('UTC'));
    return 'Last-Modified: ' . $utc->format(DateFormat::RFC7231);
}
```

## ⚠️ Notes

- **Valeurs partagées** : plusieurs constantes partagent le même pattern (`RFC1123`, `RFC2822`, `RSS` = `'D, d M Y H:i:s O'`). `getConstant()` peut renvoyer un tableau dans ce cas.
- **RFC 7231 et timezone** : le pattern force `GMT` littéralement ; passer une date non-UTC produit une heure incorrecte. Convertir d'abord via `setTimezone(new DateTimeZone('UTC'))`.

## Lié

- [`Iso8601Format`](../iso/Iso8601Format.md) — classe parente
- [`TimePrecision`](../iso/TimePrecision.md) — pour les formats fractionnaires hérités

## Voir aussi

- [RFC 2822](https://www.rfc-editor.org/rfc/rfc2822)
- [RFC 7231](https://www.rfc-editor.org/rfc/rfc7231)
- [PHP `date()` format characters](https://www.php.net/manual/fr/datetime.format.php)
- [ConstantsTrait](../../guides/constants-trait.md)
