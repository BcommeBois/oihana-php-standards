# IETF standards

> 🇫🇷 [Version française](../../../fr/standards/ietf/README.md)

This section covers classes in the [`org\ietf`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/ietf) namespace, based on IETF (Internet Engineering Task Force) RFCs.

## Locale (BCP 47 / RFC 5646)

| Class | Description |
|---|---|
| [`Locale`](Locale.md) | Value-object for BCP 47 language tags (`fr-FR`, `zh-Hant-TW`, …) |
| [`BCP47Variant`](BCP47Variant.md) | IANA variant subtags (`1996`, `valencia`, `fonipa`, `tarask`, …) |

### Helpers

| Helper | Description |
|---|---|
| [`isLocale`](helpers/isLocale.md) | BCP 47 tag validation (tolerant or strict mode) |
| [`parseLocaleTag`](helpers/parseLocaleTag.md) | Structured parsing into components (language, script, region, …) |

## See also

- [BCP 47 / RFC 5646](https://www.rfc-editor.org/rfc/rfc5646)
- [*Value-object* pattern](../../guides/value-objects.md)
- [Helpers convention](../../guides/helpers.md)
