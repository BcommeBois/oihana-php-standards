# UN/CEFACT standards

> 🇫🇷 [Version française](../../../fr/standards/unece/README.md)

This section covers classes in the [`org\unece\uncefact`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/unece/uncefact) namespace. UN/CEFACT (United Nations Centre for Trade Facilitation and Electronic Business) publishes recommendations standardizing international commerce codes.

## Units of measure — Recommendation 20

Three mirrored classes (code ↔ name ↔ symbol), with built-in cross lookups.

| Class | Role | Example |
|---|---|---|
| [`MeasureCode`](MeasureCode.md) | Alphanumeric codes | `MeasureCode::KILOGRAM // 'KGM'` |
| [`MeasureName`](MeasureName.md) | English names | `MeasureName::KILOGRAM // 'Kilogram'` |
| [`MeasureSymbol`](MeasureSymbol.md) | Symbols | `MeasureSymbol::KILOGRAM // 'kg'` |

## Package types — Recommendation 21

Two mirrored classes (code ↔ name).

| Class | Role | Example |
|---|---|---|
| [`PackageCode`](PackageCode.md) | Alpha codes | `PackageCode::BOX // 'BX'` |
| [`PackageName`](PackageName.md) | English names | `PackageName::BOX // 'Box'` |

## See also

- [UN/CEFACT recommendations](https://unece.org/trade/uncefact/cl-recommendations)
- [ConstantsTrait](../../guides/constants-trait.md)
