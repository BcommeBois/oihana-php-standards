# ISO standards

> 🇫🇷 [Version française](../../../fr/standards/iso/README.md)

This section covers all classes in the [`org\iso`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/iso) namespace.

## Constants — ISO codes

| Class | Standard | Description |
|---|---|---|
| [`ISO3166_1`](ISO3166_1.md) | ISO 3166-1 | Country codes alpha-2 (FR, US, JP, …) |
| [`ISO639_1`](ISO639_1.md) | ISO 639-1 | Language codes alpha-2 (fr, en, ja, …) |
| [`ISO639_2`](ISO639_2.md) | ISO 639-2 | Language codes alpha-3 canonical form (fra, deu, zho, …) |
| [`ISO639_2B`](ISO639_2B.md) | ISO 639-2 | Language codes alpha-3 bibliographic form (fre, ger, chi, …) + B→T conversion |
| [`ISO639_5`](ISO639_5.md) | ISO 639-5 | Alpha-3 codes for language families (roa Romance, gem Germanic, …) |
| [`ISO4217`](ISO4217.md) | ISO 4217 | Currency codes alpha-3 (EUR, USD, JPY, …) |
| [`ISO15924`](ISO15924.md) | ISO 15924 | Writing system codes (Latn, Cyrl, Hant, …) |

## ISO 8601 family — date/time value-objects

| Class | ISO form | Description |
|---|---|---|
| [`Iso8601Date`](Iso8601Date.md) | `YYYY-MM-DD` | Calendar date only |
| [`Iso8601Time`](Iso8601Time.md) | `THH:MM:SS[±OFFSET]` | Time only (optional timezone) |
| [`Iso8601DateTime`](Iso8601DateTime.md) | `YYYY-MM-DDTHH:MM:SS[±OFFSET]` | Date + time |
| [`Iso8601Duration`](Iso8601Duration.md) | `P[n]Y[n]M[n]DT[n]H[n]M[n]S` | Duration |
| [`Iso8601Interval`](Iso8601Interval.md) | `<start>/<end>`, `<start>/<duration>`, `<duration>/<end>` | Bounded interval |
| [`Iso8601Recurrence`](Iso8601Recurrence.md) | `R[n]/<interval>` | Recurrence (lazy generator) |

## ISO 8601 — format catalogs

| Class | Description |
|---|---|
| [`Iso8601Format`](Iso8601Format.md) | PHP `date()` format constants for ISO 8601 (extended + basic) |
| [`TimePrecision`](TimePrecision.md) | Output precision for fractional seconds (`seconds`, `milliseconds`, `microseconds`) |

## Helpers

See the [ISO 8601 helpers index](helpers/README.md) for `is*` (validation) and `to*` (conversion) functions.

## See also

- [*Value-object* pattern](../../guides/value-objects.md)
- [Helpers convention](../../guides/helpers.md)
- [ConstantsTrait](../../guides/constants-trait.md)
