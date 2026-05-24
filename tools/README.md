# tools/

Maintenance scripts used to regenerate the constants classes in `src/org/` from
their upstream sources. These scripts are **intentionally outside the composer
autoload** (no PSR-4 mapping, no `autoload.files`) — they are not runtime code.

They are versioned for reproducibility: anyone can re-run them to refresh a
generated class when the upstream registry is updated.

## Available generators

| Script | Generates | Upstream source |
|---|---|---|
| [`generate-unm49-numeric.php`](generate-unm49-numeric.php) | [`src/org/unstats/UNM49Numeric.php`](../src/org/unstats/UNM49Numeric.php) | [UN M49](https://unstats.un.org/unsd/methodology/m49/) + [ISO 3166-1 numeric](https://en.wikipedia.org/wiki/ISO_3166-1_numeric) |

## Usage

From the repository root:

```bash
php tools/generate-unm49-numeric.php
```

Each script prints what it wrote and exits with a non-zero status on error.

## Updating after an upstream change

The datasets are inlined inside each generator script — they are not fetched
live, because the upstream portals (UN, IANA, LoC) do not all expose stable
machine-readable endpoints and a CI fetch would be brittle.

To incorporate an upstream update:

1. Locate the dataset constant at the top of the relevant script.
2. Reconcile each entry against the latest upstream publication (the script
   header lists the URLs).
3. Re-run the script.
4. Inspect the diff on the generated file and on the unit tests.
5. Update the `CHANGELOG.md` if any code or display name changed.
