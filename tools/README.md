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
| [`generate-iso639-2.php`](generate-iso639-2.php) | [`src/org/iso/ISO639_2.php`](../src/org/iso/ISO639_2.php) + [`src/org/iso/ISO639_2B.php`](../src/org/iso/ISO639_2B.php) | [LoC ISO 639-2](https://www.loc.gov/standards/iso639-2/) (file at [`data/iso639-2.txt`](data/iso639-2.txt)) |
| [`generate-iso639-5.php`](generate-iso639-5.php) | [`src/org/iso/ISO639_5.php`](../src/org/iso/ISO639_5.php) | [LoC ISO 639-5](https://id.loc.gov/vocabulary/iso639-5.html) (file at [`data/iso639-5.tsv`](data/iso639-5.tsv)) |

## Usage

From the repository root:

```bash
php tools/generate-unm49-numeric.php
```

Each script prints what it wrote and exits with a non-zero status on error.

## Updating after an upstream change

Datasets live either **inlined in the script** (UN M49 — no stable upstream
endpoint) or **in `tools/data/` as raw upstream files** (LoC ISO 639-2,
IANA registry — stable text endpoints that are versioned alongside the
generator). A CI fetch is intentionally avoided.

To incorporate an upstream update:

1. For inlined datasets: edit the dataset constant at the top of the script.
2. For `tools/data/` files: refresh the file with curl (the script header lists
   the URL).
3. Re-run the script.
4. Inspect the diff on the generated file and on the unit tests.
5. Update the `CHANGELOG.md` if any code or display name changed.
