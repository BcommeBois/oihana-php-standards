# Helpers ISO 8601

> 🇬🇧 [English version](../../../../en/standards/iso/helpers/README.md)

Fonctions standalone du namespace [`org\iso\helpers`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/iso/helpers).

Voir le [guide de la convention des helpers](../../../guides/helpers.md) pour le pattern général (`is*` / `to*` / `parse*`).

## Validation (`is*`)

| Helper | Cible |
|---|---|
| [`isIso8601Date`](isIso8601Date.md) | Format date `YYYY-MM-DD` (strict ou basic) |
| [`isIso8601Time`](isIso8601Time.md) | Format heure `THH:MM:SS[±OFFSET]` |
| [`isIso8601DateTime`](isIso8601DateTime.md) | Format date+heure |
| [`isIso8601Duration`](isIso8601Duration.md) | Format durée `P[n]Y[n]M[n]DT[n]H[n]M[n]S` |
| [`isIso8601Interval`](isIso8601Interval.md) | Format intervalle borné |
| [`isIso8601Recurrence`](isIso8601Recurrence.md) | Format récurrence `R[n]/<interval>` |

## Conversion (`to*`)

| Helper | Entrée native | Sortie |
|---|---|---|
| [`toIso8601Date`](toIso8601Date.md) | `DateTimeInterface` | string `YYYY-MM-DD` |
| [`toIso8601Time`](toIso8601Time.md) | `DateTimeInterface` | string `THH:MM:SS[±OFFSET]` |
| [`toIso8601DateTime`](toIso8601DateTime.md) | `DateTimeInterface` | string date-heure (avec options de précision et zulu) |
| [`toIso8601Duration`](toIso8601Duration.md) | `DateInterval` | string `P…` |

> Note : pas de `toIso8601Interval` ni `toIso8601Recurrence` — ces formes n'ont pas d'équivalent natif PHP unique. Pour construire ces chaînes, utilisez directement les classes [`Iso8601Interval`](../Iso8601Interval.md) et [`Iso8601Recurrence`](../Iso8601Recurrence.md).
