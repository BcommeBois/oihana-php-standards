# Cross-standard / Common

> 🇫🇷 [Version française](../../../fr/standards/common/README.md)

The [`org\common`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/common) namespace groups classes that **aggregate or complement** base standards (ISO, IETF, etc.) without belonging to a single body.

## Format catalogs

| Class | Description |
|---|---|
| [`DateFormat`](DateFormat.md) | Extends [`Iso8601Format`](../iso/Iso8601Format.md) with RFC, HTTP, MySQL and Unix timestamp formats |
| [`NumberFormat`](NumberFormat.md) | Decimal/thousands separators (EU, US, FR, CH) and numeric symbols (`%`, `‰`, `∞`, `NaN`, etc.) |

## See also

- [*Value-object* pattern](../../guides/value-objects.md)
- [ConstantsTrait](../../guides/constants-trait.md)
