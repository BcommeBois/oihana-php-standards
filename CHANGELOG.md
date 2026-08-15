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

#### BCP 47 Variant subtags (`org\ietf`)
- `BCP47Variant` — 139 variant subtags from the IANA Language Subtag Registry (`1996`, `1901`, `valencia`, `fonipa`, `tarask`, `pinyin`, `wadegile`, `monoton`, `polyton`, `scotland`, `oxendict`, …). Numeric subtags are exposed via `V_`-prefixed constants (e.g. `V_1996 = '1996'`, `V_1606NICT = '1606nict'`) since PHP identifiers cannot start with a digit. Deprecated variants remain enumerated (their syntax is still valid for legacy content).

#### UN/CEFACT units of measure (`org\unece\uncefact`)
- Density units: `MeasureCode::KILOGRAM_PER_CUBIC_METER` (`KMQ`), `MeasureName::KILOGRAM_PER_CUBIC_METER` (`Kilogram per cubic metre`) and `MeasureSymbol::KILOGRAM_PER_CUBIC_METER` (`kg/m³`)
- `org\unece\uncefact\helpers\unitCodeName` — resolves the official name of a unit code against both families, measures (Rec. 20) first and packages (Rec. 21) as a fallback; returns `null` for a `null`, unknown or wrongly-cased code. The two families are flattened into a single name: callers that must tell a unit that measures from a unit that merely holds should ask `MeasureCode::getName()` directly. No code is claimed by both families.

#### UN/CEFACT package types (`org\unece\uncefact`)
- `PackageCode::PACKET` (`PA`) and `PackageName::PACKET` (`Packet`) — the packet had no constant of its own, its code being held by `PARCEL`.

#### Reference datasets and generator
- `tools/generate-uncefact-rec20.php` — generates `MeasureCode`, `MeasureName` and `MeasureSymbol` from the official Rec 20 dataset. Supports `--dry-run`. Refuses to write when a selected code is absent from the dataset, is used twice, or when two constants would share a name or a symbol — the invariant a duplicated value would break in `ConstantsTrait::getConstant()`.
- `tools/data/uncefact-rec20.csv` — the 2136 official unit codes, extracted from `rec20_Rev17e-2021.xlsx` (Annex II & III).
- `tools/data/uncefact-rec20-selection.csv` — the curated subset the library exposes, one row per constant. The only file to edit by hand: adding a unit means adding a row, its name and symbol are then read from the official dataset. `name_override` / `symbol_override` keep a display string that deliberately differs from the official one (American spelling, title case), which makes every deviation explicit instead of silent.
- `tools/data/uncefact-rec21.csv` — the 406 official package type codes (Rec 21 Rev 12).
- `tools/data/unsd-m49.csv` — the 249 UNSD M49 countries and areas with their ISO alpha-2 and alpha-3 codes.
- `tools/data/iso4217.csv` — the 178 ISO 4217 currency codes, list one published 2026-01-01.

#### Currencies (`org\iso`)
- `ISO4217::XCG` (Caribbean guilder), `SLE` (Sierra Leonean leone), `ZWG` (Zimbabwe Gold) and `VED` (Venezuelan bolívar digital) — four currencies in circulation that the class did not declare. It kept `ANG`, `SLL` and `ZWL` without their replacements, so a transaction in any of the four went unrecognised.
- The five withdrawn codes kept for historical data — `ANG`, `BGN`, `HRK`, `SLL`, `ZWL` — now say so in their docblock, and name their replacement where there is one.

#### Conformance testing
- `tests/org/iso/ISO4217Test` — checks every declared currency against `tools/data/iso4217.csv`, and enforces the rule the class had silently broken: a withdrawn code may be kept for historical data, but never without the code that replaced it.
- `tests/org/unece/uncefact/PackageConformanceTest` — checks `PackageCode` and `PackageName` against `tools/data/uncefact-rec21.csv`: every code exists in Rec 21, every name matches the official wording, both classes declare the same constants, no value is duplicated. `PackageCode` is maintained by hand — one error in 108 entries did not justify a generator — so this test is what replaces one. It is what would have caught `PARCEL`, and it immediately surfaced two further wording drifts. Deliberate departures are declared in a `KNOWN_DEVIATIONS` list, which keeps the debt visible and bounded.

#### Tooling
- `tools/generate-unm49-numeric.php` — maintenance script to regenerate `UNM49Numeric` from a curated dataset (outside composer autoload)
- `tools/generate-iso639-2.php` — generator script that parses the official LoC dataset versioned at `tools/data/iso639-2.txt`
- `tools/generate-iso639-5.php` — generator script that parses the LoC TSV dataset versioned at `tools/data/iso639-5.tsv`
- `tools/generate-bcp47-iana.php` — single generator script that parses the IANA Language Subtag Registry (versioned at `tools/data/iana-language-subtag-registry.txt`, 731 KB) and can produce `BCP47Variant`, `BCP47Grandfathered`, `BCP47Redundant` (selectable via `--variant` / `--grandfathered` / `--redundant` flags). Only `BCP47Variant` is generated in this release; the two others come in a follow-up.

#### Documentation
- phpDocumentor API documentation: `phpdoc.xml` configuration and a `composer doc` script that generates the site under `docs/`.
- Custom phpDocumentor template (`.phpdoc/template/`) extending the default one with a README-based landing page (logo, badges, quick links) and the namespace table of contents moved to the bottom of the index.
- A GitHub Actions workflow (`.github/workflows/docs.yml`) that builds the documentation and deploys it to GitHub Pages on every push to `main`.

### Changed
- `MeasureCode`, `MeasureName` and `MeasureSymbol` are now **generated** from the official UN/CEFACT Rec 20 Rev 17 dataset — do not edit them by hand. An audit against that dataset found 58 of the 105 hand-typed constants non-conforming, which is what this change fixes and prevents. `MeasureName` and `MeasureSymbol` values are unchanged to the character: the generator keeps the existing display strings through explicit overrides, so no `unitText` moves downstream.
- **27 `MeasureCode` values corrected.** Two change the meaning of the constant, not merely its code:
  - `PERCENT` — `'PC1'` → `'P1'`. `PC1` is not a Rec 20 code.
  - `OUNCE` — `'OZA'` → `'ONZ'`. `OZA` is a *fluid ounce*, a unit of volume, while the constant is declared among the masses. `ONZ` is the avoirdupois ounce.

  The 25 others replace a code that either did not exist or denoted an unrelated unit — `DB` was a *dry pound*, not a decibel; `GB` a *gallon (US) per day*, not a gigabyte; `PCE` and `RAD` were not Rec 20 codes at all: `ACRE_FOOT` `AFK`→`M67`, `BIT` `BIT`→`A99`, `BYTE` `BTE`→`AD`, `CALORIE` `CAL`→`R4`, `COULOMB` `CLB`→`COU`, `DECIBEL` `DB`→`2N`, `GIGABYTE` `GB`→`E34`, `GRAY` `GRY`→`A95`, `HENRY` `HNH`→`81`, `KILOBYTE` `KB`→`2P`, `KILOCALORIE` `KCC`→`E14`, `MEGABYTE` `MB`→`4L`, `PARTS_PER_MILLION` `PPM`→`59`, `PER_THOUSAND` `PER`→`NX`, `PIECE` `PCE`→`H87`, `POUND_FORCE` `LBF`→`C78`, `POUND_PER_SQUARE_INCH` `PSI`→`PS`, `RADIAN` `RAD`→`C81`, `SIEVERT` `SVT`→`D13`, `SQUARE_MILE` `SMK`→`MIK`, `SQUARE_YARD` `YKM`→`YDK`, `TEN_PAIRS` `DPA`→`TPR`, `TESLA` `TSL`→`D33`, `THOUSAND` `THM`→`MIL`, `US_GALLON` `GLD`→`GLL`.
- **5 constants removed** (105 → 100). `NUMBER`, `RATIO` and `COUNT` describe a factor or a way of counting, not a unit of measure, and Rec 20 has no equivalent — the dimensionless quantity is `C62` (*one*) and the proportion is `P1` (*percent*). `POINT` and `UNIT_OF_CAPITAL` denoted a *pint (US)* and a *telecommunication port* respectively; no Rec 20 code matches what they were meant to express.
- `MeasureName::getSymbol()` parameter renamed from `$code` to `$name`, and `MeasureSymbol::getName()` parameter renamed from `$code` to `$symbol`; both were misnamed and neither ever received a code. **Breaking for named arguments only**: use `MeasureName::getSymbol(name: …)` and `MeasureSymbol::getName(symbol: …)`. Positional calls are unaffected.
- Moved the hand-written bilingual (en/fr) documentation from `docs/` to `wiki/`; the `docs/` directory is now reserved for the generated phpDocumentor site and is no longer versioned.

### Fixed
- `isLocale()` in strict mode accepted neither `bh` (Bihari languages) nor `sh` (Serbo-Croatian), although both are valid and non-deprecated BCP 47 language subtags. BCP 47 takes its authority from the IANA Language Subtag Registry, a superset of ISO 639-1 that keeps collections and macrolanguages the ISO list omits. The two are now accepted through a narrow `BCP47_ONLY_LANGUAGES` exception; the five deprecated forms — `in`, `iw`, `ji`, `jw`, `mo` — stay rejected, and every other subtag of the tag is still validated.
- Documentation of `UNM49`: the class claimed to carry M49 codes, but M49 assigns *numeric* codes only — `250` for France. Its 248 entries are the ISO 3166-1 alpha-3 column the UNSD publishes next to its own, making it the alpha-3 counterpart of `ISO3166_1` rather than a registry of its own. The library's actual M49 registry is `UNM49Numeric`. Values are unchanged and match the UNSD table exactly.
- **`PackageCode::PARCEL` — `'PA'` → `'PC'`.** In Rec 21 Rev 12, `PA` is the **packet**; the parcel is `PC`. The class merged the two and had no `PACKET` constant, so `PackageCode::getName('PA')` answered `Parcel` and no code resolved to a packet. **Breaking**: a stored `'PA'` meant as a parcel must be migrated to `'PC'`.
- `PackageName::MATCH_BOX` — `'Match Box'` → `'Matchbox'`, and `PackageName::PALLET_SHRINK_WRAPPED` — `'Pallet, shrink, wrapped'` → `'Pallet, shrinkwrapped'`, to match the official wording.
- `unitCodeName()` no longer has to arbitrate between the two families: correcting the codes against the official dataset removed the only two collisions instead of resolving them. `PT` and `DB` collided solely because `MeasureCode` declared them wrongly — in Rec 20 they are a pint and a dry pound, never a Point nor a Decibel. `MeasureCode` and `PackageCode` now share no value, which a test pins.
- Documentation of `MeasureCode`, `MeasureName` and `MeasureSymbol`: the class examples referenced five classes that do not exist (`UnitCodes`, `UnitNames`, `UnitSymbols`, `MeasureNames`, `MeasureSymbols`) and documented `get()` as returning a `{"name":…,"unitCode":…,"unitText":…}` object, when it is inherited from `ConstantsTrait` and returns the raw value. `MeasureSymbol::getCode()` gave `'P1'` as a sample code, which is not declared anywhere. Examples are now runnable as written, and each class states that the three mirror each other and declare the same constant names — the invariant every cross lookup depends on.
- `MeasureName::ANGULAR_DEGREE` renamed to `MeasureName::ANGULAR` to match `MeasureCode::ANGULAR` and `MeasureSymbol::ANGULAR`. The cross-class lookups resolve a value to its constant name, so the mismatch made `MeasureCode::getName('DD')`, `MeasureSymbol::getName('°')` and `MeasureName::getCode('Angular Degree')` return `null`. **Breaking**: use `MeasureName::ANGULAR` instead of `MeasureName::ANGULAR_DEGREE` (the value `'Angular Degree'` is unchanged).
- `PackageCode::ROLL` value
- `PackageCode::PLATES` value
- Rename the `ISO639_1` class (use the `_` separator)
- `composer.json` `homepage` pointed to `oihana-php-schema`; now points to `oihana-php-standards`.

## [1.0.0] - 2025-08-13

### Added

- Adds the iso 4217 constants
- Adds the iso 6369-1 constants
- Adds the iso 15924 constants
- Adds the Un CEFACT Measures codes constants
- Adds the Un CEFACT Packages codes constants
- Adds he UN M49 standards constants