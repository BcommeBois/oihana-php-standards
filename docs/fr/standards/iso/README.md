# Standards ISO

> 🇬🇧 [English version](../../../en/standards/iso/README.md)

Cette section couvre toutes les classes du namespace [`org\iso`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/iso).

## Constantes — codes ISO

| Classe | Standard | Description |
|---|---|---|
| [`ISO3166_1`](ISO3166_1.md) | ISO 3166-1 | Codes pays alpha-2 (FR, US, JP, …) |
| [`ISO639_1`](ISO639_1.md) | ISO 639-1 | Codes langue alpha-2 (fr, en, ja, …) |
| [`ISO639_2`](ISO639_2.md) | ISO 639-2 | Codes langue alpha-3 forme canonique (fra, deu, zho, …) |
| [`ISO639_2B`](ISO639_2B.md) | ISO 639-2 | Codes langue alpha-3 forme bibliographique (fre, ger, chi, …) + conversion B→T |
| [`ISO4217`](ISO4217.md) | ISO 4217 | Codes monnaies alpha-3 (EUR, USD, JPY, …) |
| [`ISO15924`](ISO15924.md) | ISO 15924 | Codes systèmes d'écriture (Latn, Cyrl, Hant, …) |

## Famille ISO 8601 — value-objects date/heure

| Classe | Forme ISO | Description |
|---|---|---|
| [`Iso8601Date`](Iso8601Date.md) | `YYYY-MM-DD` | Date calendaire seule |
| [`Iso8601Time`](Iso8601Time.md) | `THH:MM:SS[±OFFSET]` | Heure seule (avec fuseau optionnel) |
| [`Iso8601DateTime`](Iso8601DateTime.md) | `YYYY-MM-DDTHH:MM:SS[±OFFSET]` | Date + heure |
| [`Iso8601Duration`](Iso8601Duration.md) | `P[n]Y[n]M[n]DT[n]H[n]M[n]S` | Durée |
| [`Iso8601Interval`](Iso8601Interval.md) | `<start>/<end>`, `<start>/<duration>`, `<duration>/<end>` | Intervalle borné |
| [`Iso8601Recurrence`](Iso8601Recurrence.md) | `R[n]/<interval>` | Récurrence (lazy generator) |

## ISO 8601 — catalogues de formats

| Classe | Description |
|---|---|
| [`Iso8601Format`](Iso8601Format.md) | Constantes de formats `date()` PHP pour ISO 8601 (étendu + basic) |
| [`TimePrecision`](TimePrecision.md) | Précision de sortie pour les fractions de seconde (`seconds`, `milliseconds`, `microseconds`) |

## Helpers

Voir l'index des [helpers ISO 8601](helpers/README.md) pour les fonctions `is*` (validation) et `to*` (conversion).

## Voir aussi

- [Pattern *value-object*](../../guides/value-objects.md)
- [Convention des helpers](../../guides/helpers.md)
- [ConstantsTrait](../../guides/constants-trait.md)
