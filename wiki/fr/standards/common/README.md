# Cross-standard / Common

> 🇬🇧 [English version](../../../en/standards/common/README.md)

Le namespace [`org\common`](https://github.com/BcommeBois/oihana-php-standards/tree/main/src/org/common) regroupe les classes qui **agrègent ou complètent** les standards de base (ISO, IETF, etc.) sans relever d'un organisme unique.

## Catalogues de formats

| Classe | Description |
|---|---|
| [`DateFormat`](DateFormat.md) | Étend [`Iso8601Format`](../iso/Iso8601Format.md) avec les formats RFC, HTTP, MySQL et Unix timestamp |
| [`NumberFormat`](NumberFormat.md) | Séparateurs décimaux/milliers (EU, US, FR, CH) et symboles numériques (`%`, `‰`, `∞`, `NaN`, etc.) |

## Voir aussi

- [Pattern *value-object*](../../guides/value-objects.md)
- [ConstantsTrait](../../guides/constants-trait.md)
