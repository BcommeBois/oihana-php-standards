# Standards UN/CEFACT

> 🇬🇧 [English version](../../../en/standards/unece/README.md)

Cette section couvre les classes du namespace [`org\unece\uncefact`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/unece/uncefact). UN/CEFACT (United Nations Centre for Trade Facilitation and Electronic Business) publie des recommandations standardisant les codes commerciaux internationaux.

## Unités de mesure — Recommandation 20

Trois classes en miroir (code ↔ nom ↔ symbole), avec lookups croisés intégrés.

| Classe | Rôle | Exemple |
|---|---|---|
| [`MeasureCode`](MeasureCode.md) | Codes alpha numériques | `MeasureCode::KILOGRAM // 'KGM'` |
| [`MeasureName`](MeasureName.md) | Noms anglais | `MeasureName::KILOGRAM // 'Kilogram'` |
| [`MeasureSymbol`](MeasureSymbol.md) | Symboles | `MeasureSymbol::KILOGRAM // 'kg'` |

## Types d'emballage — Recommandation 21

Deux classes en miroir (code ↔ nom).

| Classe | Rôle | Exemple |
|---|---|---|
| [`PackageCode`](PackageCode.md) | Codes alpha | `PackageCode::BOX // 'BX'` |
| [`PackageName`](PackageName.md) | Noms anglais | `PackageName::BOX // 'Box'` |

## Voir aussi

- [Recommandations UN/CEFACT](https://unece.org/trade/uncefact/cl-recommendations)
- [ConstantsTrait](../../guides/constants-trait.md)
