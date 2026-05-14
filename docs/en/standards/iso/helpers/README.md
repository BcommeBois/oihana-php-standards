# ISO 8601 helpers

> 🇫🇷 [Version française](../../../../fr/standards/iso/helpers/README.md)

Standalone functions in the [`org\iso\helpers`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/iso/helpers) namespace.

See the [helpers convention guide](../../../guides/helpers.md) for the general pattern (`is*` / `to*` / `parse*`).

## Validation (`is*`)

| Helper | Target |
|---|---|
| [`isIso8601Date`](isIso8601Date.md) | Date format `YYYY-MM-DD` (strict or basic) |
| [`isIso8601Time`](isIso8601Time.md) | Time format `THH:MM:SS[±OFFSET]` |
| [`isIso8601DateTime`](isIso8601DateTime.md) | Date+time format |
| [`isIso8601Duration`](isIso8601Duration.md) | Duration format `P[n]Y[n]M[n]DT[n]H[n]M[n]S` |
| [`isIso8601Interval`](isIso8601Interval.md) | Bounded interval format |
| [`isIso8601Recurrence`](isIso8601Recurrence.md) | Recurrence format `R[n]/<interval>` |

## Conversion (`to*`)

| Helper | Native input | Output |
|---|---|---|
| [`toIso8601Date`](toIso8601Date.md) | `DateTimeInterface` | string `YYYY-MM-DD` |
| [`toIso8601Time`](toIso8601Time.md) | `DateTimeInterface` | string `THH:MM:SS[±OFFSET]` |
| [`toIso8601DateTime`](toIso8601DateTime.md) | `DateTimeInterface` | date-time string (with precision and zulu options) |
| [`toIso8601Duration`](toIso8601Duration.md) | `DateInterval` | string `P…` |

> Note: no `toIso8601Interval` or `toIso8601Recurrence` — these forms have no single PHP native equivalent. To build these strings, use the [`Iso8601Interval`](../Iso8601Interval.md) and [`Iso8601Recurrence`](../Iso8601Recurrence.md) classes directly.
