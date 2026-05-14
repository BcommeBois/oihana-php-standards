# Oihana PHP Standards library - Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Added
- Adds the iso 3166-1 alpha 2 standard constants.
- Adds the Iso8601Duration class + isIso8601Duration and toIso8601Duration helpers.
- Adds the Iso8601Time class + the isIso8601Time and toIso8601Time helpers.
- Adds the Iso8601Format constants class (single entry point for ISO 8601 date/time format strings).
- Adds the TimePrecision constants class (seconds, milliseconds, microseconds).
- Adds the isIso8601Date and toIso8601Date helpers.
- Adds the isIso8601DateTime and toIso8601DateTime helpers.
- Adds the DateFormat class (org\common namespace) extending Iso8601Format with RFC, HTTP, MySQL and Unix date formats.
- Adds the Iso8601Date value-object class (strict extended format, year/month/day/weekday/dayOfYear accessors).
- Adds the Iso8601DateTime value-object class (strict T separator, composition with Iso8601Date and Iso8601Time, configurable output precision).
- Adds the Iso8601Interval value-object class (start/end, start/duration, duration/end forms) with contains() and overlaps() methods, plus the isIso8601Interval helper.
- Adds the Iso8601Recurrence value-object class (R[n]/<interval> form) with a lazy occurrences() generator, plus the isIso8601Recurrence helper.

### Fixed
- Fix the PackageCode::ROLL value.
- Fix the PackageCode::PLATES value.
- Rename the ISO639_1 class (use the '_' separator)

## [1.0.0] - 2025-08-13

### Added

- Adds the iso 4217 constants
- Adds the iso 6369-1 constants
- Adds the iso 15924 constants
- Adds the Un CEFACT Measures codes constants
- Adds the Un CEFACT Packages codes constants
- Adds he UN M49 standards constants