# Oihana PHP Standards — Documentation

Bibliothèque de **constantes**, **value-objects** et **helpers** basée sur les standards internationaux (ISO, IETF, UN/CEFACT, UN M49).

> 🇬🇧 [English version](../en/README.md)

## Accès rapide
- 🚀 [Pour commencer](getting-started.md) — installation et premier usage
- 🧰 Guides
  - [ConstantsTrait](guides/constants-trait.md) — méthodes partagées par toutes les classes de constantes
  - [Value-objects](guides/value-objects.md) — pattern commun aux types date/heure ISO et Locale
  - [Convention des helpers](guides/helpers.md) — `is*` / `to*` / `parse*`

## Parcourir par standard

### 📐 ISO ([standards/iso](standards/iso/README.md))

| Type | Classes |
|---|---|
| **Constantes** | [ISO3166_1](standards/iso/ISO3166_1.md), [ISO639_1](standards/iso/ISO639_1.md), [ISO4217](standards/iso/ISO4217.md), [ISO15924](standards/iso/ISO15924.md) |
| **Value-objects date/heure** | [Iso8601Date](standards/iso/Iso8601Date.md), [Iso8601Time](standards/iso/Iso8601Time.md), [Iso8601DateTime](standards/iso/Iso8601DateTime.md), [Iso8601Duration](standards/iso/Iso8601Duration.md), [Iso8601Interval](standards/iso/Iso8601Interval.md), [Iso8601Recurrence](standards/iso/Iso8601Recurrence.md) |
| **Catalogues de formats** | [Iso8601Format](standards/iso/Iso8601Format.md), [TimePrecision](standards/iso/TimePrecision.md) |
| **Helpers** | [Helpers is* / to*](standards/iso/helpers/README.md) |

### 🌐 IETF ([standards/ietf](standards/ietf/README.md))

| Type | Classes |
|---|---|
| **Value-object Locale** | [Locale](standards/ietf/Locale.md) (BCP 47 / RFC 5646) |
| **Helpers** | [isLocale](standards/ietf/helpers/isLocale.md), [parseLocaleTag](standards/ietf/helpers/parseLocaleTag.md) |

### 🏭 UN/CEFACT ([standards/unece](standards/unece/README.md))

| Type | Classes |
|---|---|
| **Unités de mesure** | [MeasureCode](standards/unece/MeasureCode.md), [MeasureName](standards/unece/MeasureName.md), [MeasureSymbol](standards/unece/MeasureSymbol.md) |
| **Types d'emballage** | [PackageCode](standards/unece/PackageCode.md), [PackageName](standards/unece/PackageName.md) |

### 🌍 UN M49 ([standards/unstats](standards/unstats/README.md))

| Type | Classes |
|---|---|
| **Codes pays/zone** | [UNM49](standards/unstats/UNM49.md) |

### 🧩 Cross-standard / commun ([standards/common](standards/common/README.md))

| Type | Classes |
|---|---|
| **Catalogues de formats** | [DateFormat](standards/common/DateFormat.md), [NumberFormat](standards/common/NumberFormat.md) |

## Parcourir par type

- **Classes de constantes** : ISO3166_1, ISO639_1, ISO4217, ISO15924, Iso8601Format, TimePrecision, DateFormat, NumberFormat, MeasureCode, MeasureName, MeasureSymbol, PackageCode, PackageName, UNM49
- **Value-objects** : Iso8601Date, Iso8601Time, Iso8601DateTime, Iso8601Duration, Iso8601Interval, Iso8601Recurrence, Locale
- **Helpers** : validateurs / convertisseurs `is*` / `to*` pour chaque type ISO 8601, plus `isLocale` et `parseLocaleTag`

## Licence
[MPL 2.0](https://github.com/BcommeBois/oihana-php-standards/blob/main/LICENSE)
