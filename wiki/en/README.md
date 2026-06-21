# Oihana PHP Standards — Documentation

A library of **constants**, **value-objects** and **helpers** built on top of international standards (ISO, IETF, UN/CEFACT, UN M49).

> 🇫🇷 [Version française](../fr/README.md)

## Quick links
- 🚀 [Getting started](getting-started.md) — install and first usage
- 🧰 Guides
  - [ConstantsTrait](guides/constants-trait.md) — methods shared by all constants classes
  - [Value-objects](guides/value-objects.md) — common pattern for ISO date/time and Locale
  - [Helpers convention](guides/helpers.md) — `is*` / `to*` / `parse*`

## Browse by standard

### 📐 ISO ([standards/iso](standards/iso/README.md))

| Type | Classes |
|---|---|
| **Constants** | [ISO3166_1](standards/iso/ISO3166_1.md), [ISO639_1](standards/iso/ISO639_1.md), [ISO4217](standards/iso/ISO4217.md), [ISO15924](standards/iso/ISO15924.md) |
| **Date / time value-objects** | [Iso8601Date](standards/iso/Iso8601Date.md), [Iso8601Time](standards/iso/Iso8601Time.md), [Iso8601DateTime](standards/iso/Iso8601DateTime.md), [Iso8601Duration](standards/iso/Iso8601Duration.md), [Iso8601Interval](standards/iso/Iso8601Interval.md), [Iso8601Recurrence](standards/iso/Iso8601Recurrence.md) |
| **Format catalogs** | [Iso8601Format](standards/iso/Iso8601Format.md), [TimePrecision](standards/iso/TimePrecision.md) |
| **Helpers** | [is* / to* helpers](standards/iso/helpers/README.md) |

### 🌐 IETF ([standards/ietf](standards/ietf/README.md))

| Type | Classes |
|---|---|
| **Locale value-object** | [Locale](standards/ietf/Locale.md) (BCP 47 / RFC 5646) |
| **Helpers** | [isLocale](standards/ietf/helpers/isLocale.md), [parseLocaleTag](standards/ietf/helpers/parseLocaleTag.md) |

### 🏭 UN/CEFACT ([standards/unece](standards/unece/README.md))

| Type | Classes |
|---|---|
| **Units of measure** | [MeasureCode](standards/unece/MeasureCode.md), [MeasureName](standards/unece/MeasureName.md), [MeasureSymbol](standards/unece/MeasureSymbol.md) |
| **Package types** | [PackageCode](standards/unece/PackageCode.md), [PackageName](standards/unece/PackageName.md) |

### 🌍 UN M49 ([standards/unstats](standards/unstats/README.md))

| Type | Classes |
|---|---|
| **Country/area codes** | [UNM49](standards/unstats/UNM49.md) |

### 🧩 Cross-standard / common ([standards/common](standards/common/README.md))

| Type | Classes |
|---|---|
| **Format catalogs** | [DateFormat](standards/common/DateFormat.md), [NumberFormat](standards/common/NumberFormat.md) |

## Browse by type

- **Constants classes** : ISO3166_1, ISO639_1, ISO4217, ISO15924, Iso8601Format, TimePrecision, DateFormat, NumberFormat, MeasureCode, MeasureName, MeasureSymbol, PackageCode, PackageName, UNM49
- **Value-objects** : Iso8601Date, Iso8601Time, Iso8601DateTime, Iso8601Duration, Iso8601Interval, Iso8601Recurrence, Locale
- **Helpers** : `is*` / `to*` validators and converters for every ISO 8601 type, plus `isLocale` and `parseLocaleTag`

## License
[MPL 2.0](https://github.com/BcommeBois/oihana-php-standards/blob/main/LICENSE)
