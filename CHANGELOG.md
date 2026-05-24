# Oihana PHP Standards library - Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Added

#### ISO 8601 — date and time value objects (`org\iso`)
- `Iso8601Date` — strict extended format with `year`/`month`/`day`/`weekday`/`dayOfYear` accessors; helpers `isIso8601Date` and `toIso8601Date`
- `Iso8601DateTime` — strict `T` separator; composes `Iso8601Date` + `Iso8601Time`; configurable output precision; helpers `isIso8601DateTime` and `toIso8601DateTime`
- `Iso8601Duration` — wraps PHP `DateInterval`; helpers `isIso8601Duration` and `toIso8601Duration`
- `Iso8601Time` — time-of-day with timezone designator; helpers `isIso8601Time` and `toIso8601Time`
- `Iso8601Interval` — three bounded forms (`<start>/<end>`, `<start>/<duration>`, `<duration>/<end>`) with `contains()` and `overlaps()`; helper `isIso8601Interval`
- `Iso8601Recurrence` — `R[n]/<interval>` form with a lazy `occurrences()` generator; helper `isIso8601Recurrence`

#### Date and time format catalogs
- `org\iso\Iso8601Format` — single entry point for ISO 8601 date/time format strings (extended and basic)
- `org\common\DateFormat` — extends `Iso8601Format` with RFC 822/850/1036/1123/2822/7231, RSS, Cookie, MySQL and Unix formats
- `org\iso\TimePrecision` — `seconds` / `milliseconds` / `microseconds` constants

#### Locale (`org\ietf`)
- `Locale` — BCP 47 / RFC 5646 value-object with cross-validation against `ISO639_1`, `ISO15924` and `ISO3166_1`; helpers `isLocale` and `parseLocaleTag`

#### Number formatting (`org\common`)
- `NumberFormat` — decimal/thousands separators (EU, US, FR, CH) and common numeric symbols (`%`, `‰`, `∞`, `NaN`, scientific notation)

#### Other ISO standards
- ISO 3166-1 alpha-2 country code constants

#### UN M49 numeric codes (`org\unstats`)
- `UNM49Numeric` — 3-digit numeric codes for the 248 countries/areas and 37 geographical regions of the UN M49 standard (001 World, 019 Americas, 142 Asia, 150 Europe, 419 Latin America and the Caribbean, …); constants prefixed with `M_` (PHP identifier constraint)
- `org\ietf\helpers\isLocale` strict mode now cross-validates 3-digit region subtags against `UNM49Numeric` (e.g. `es-419` accepted, `es-999` rejected)

#### ISO 639-2 alpha-3 language codes (`org\iso`)
- `ISO639_2` — 486 alpha-3 language codes in canonical form (terminologic when both B and T exist, single alpha-3 otherwise), per RFC 5646 §4.1.2; includes special-purpose codes `mis`/`mul`/`und`/`zxx`; the `qaa-qtz` private range is intentionally not enumerated
- `ISO639_2B` — the 20 bibliographic-only forms (`fre`, `ger`, `chi`, `dut`, …) with `getBibliographicToTerminologicMap()` and `toTerminologic()` for B→T conversion

#### ISO 639-5 language families (`org\iso`)
- `ISO639_5` — 115 alpha-3 codes for language families and groups (`roa` Romance, `gem` Germanic, `sla` Slavic, `cel` Celtic, `sem` Semitic, `bnt` Bantu, `aus` Australian, `myn` Mayan, `afa` Afro-Asiatic, …); useful for language fallback chains. Roughly 65 codes overlap with `ISO639_2` (historical family codes); each registry remains independent and authoritative for its intended use.

#### Tooling
- `tools/generate-unm49-numeric.php` — maintenance script to regenerate `UNM49Numeric` from a curated dataset (outside composer autoload)
- `tools/generate-iso639-2.php` — generator script that parses the official LoC dataset versioned at `tools/data/iso639-2.txt`
- `tools/generate-iso639-5.php` — generator script that parses the LoC TSV dataset versioned at `tools/data/iso639-5.tsv`

### Fixed
- `PackageCode::ROLL` value
- `PackageCode::PLATES` value
- Rename the `ISO639_1` class (use the `_` separator)

## [1.0.0] - 2025-08-13

### Added

- Adds the iso 4217 constants
- Adds the iso 6369-1 constants
- Adds the iso 15924 constants
- Adds the Un CEFACT Measures codes constants
- Adds the Un CEFACT Packages codes constants
- Adds he UN M49 standards constants