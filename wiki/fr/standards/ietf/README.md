# Standards IETF

> 🇬🇧 [English version](../../../en/standards/ietf/README.md)

Cette section couvre les classes du namespace [`org\ietf`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/ietf), basées sur les RFC de l'IETF (Internet Engineering Task Force).

## Locale (BCP 47 / RFC 5646)

| Classe | Description |
|---|---|
| [`Locale`](Locale.md) | Value-object pour les tags de langue BCP 47 (`fr-FR`, `zh-Hant-TW`, …) |
| [`BCP47Variant`](BCP47Variant.md) | Sous-tags variants IANA (`1996`, `valencia`, `fonipa`, `tarask`, …) |

### Helpers

| Helper | Description |
|---|---|
| [`isLocale`](helpers/isLocale.md) | Validation d'un tag BCP 47 (mode tolérant ou strict) |
| [`parseLocaleTag`](helpers/parseLocaleTag.md) | Parsing structuré en composants (language, script, region, …) |

## Voir aussi

- [BCP 47 / RFC 5646](https://www.rfc-editor.org/rfc/rfc5646)
- [Pattern *value-object*](../../guides/value-objects.md)
- [Convention des helpers](../../guides/helpers.md)
