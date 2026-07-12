# Changelog

All notable changes to `Esi` will be documented in this file.

## v0.7 - 2026-07-12

### What's Changed
* Test coverage for all endpoints + PHPStan level 9 type safety by @NicolasKion in https://github.com/NicolasKion/Esi/pull/19
* chore: bump ESI compatibility date to 2026-06-09 by @NicolasKion in https://github.com/NicolasKion/Esi/pull/20
* refactor: pin ESI compatibility date to a version constant by @NicolasKion in https://github.com/NicolasKion/Esi/pull/21
* feat: add dogma attribute and effect endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/22
* ci: enforce 100% code coverage by @NicolasKion in https://github.com/NicolasKion/Esi/pull/23
* feat: add alliance corporations and icons endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/24
* feat: add market group, price, order and type endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/25
* feat: add universe reference endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/26
* feat: add remaining corporation endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/27
* feat: add remaining character endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/28
* feat: add faction warfare endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/29
* feat: add wallet balance, transactions and corporation wallet endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/30
* feat: add incursions, insurance, route and loyalty endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/31
* feat: add skills and clones endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/32
* feat: add fleet endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/33
* feat: add mail labels, mailing lists and delete endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/34
* feat: add corporation contracts, recent killmails and war lists by @NicolasKion in https://github.com/NicolasKion/Esi/pull/35
* feat: add industry endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/36
* feat: add personal market orders, loyalty points and asset locations by @NicolasKion in https://github.com/NicolasKion/Esi/pull/37
* feat: add calendar, fittings, planetary interaction and UI window endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/38
* feat: add structure and corporation project endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/39
* feat: add meta, search, access-list, mercenary-ops and freelance-job endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/40
* feat: automatically walk ESI cursor-paginated endpoints by @NicolasKion in https://github.com/NicolasKion/Esi/pull/41
* chore: remove unused package skeleton files by @NicolasKion in https://github.com/NicolasKion/Esi/pull/42
* docs: refresh README for full ESI coverage by @NicolasKion in https://github.com/NicolasKion/Esi/pull/43

### New Contributors
* @NicolasKion made their first contribution in https://github.com/NicolasKion/Esi/pull/19

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.6...v0.7

## v0.6 - 2026-07-10

### What's Changed

* feat: add universe ids endpoint — `Esi::getIds()` resolves names to IDs via `POST /universe/ids/`, the inverse of `getNames()`
* ci: rework release automation — tests and PHPStan gate every PR, Dependabot PRs auto-merge when green, and dependency updates are auto-released nightly
* docs: rewrite README and backfill missing changelog entries
* chore(deps): bump actions/checkout from 6 to 7 by @dependabot[bot] in https://github.com/NicolasKion/Esi/pull/18

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.5.1...v0.6

## v0.5.1 - 2026-06-18

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.5...v0.5.1

## v0.5 - 2026-06-18

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.4...v0.5

## v0.4 - 2026-05-19

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.3.2...v0.4

## v0.3.2 - 2026-05-19

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.3.1...v0.3.2

## v0.3.1 - 2026-03-19

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.3...v0.3.1

## v0.3 - 2026-03-16

### What's Changed

* chore(deps): bump dependabot/fetch-metadata from 2.4.0 to 2.5.0 by @dependabot[bot] in https://github.com/NicolasKion/Esi/pull/13

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.2.3...v0.3

## v0.2.3 - 2025-11-18

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.2.2...v0.2.3

## v0.2.2 - 2025-10-01

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.2.1...v0.2.2

## v0.2.1 - 2025-10-01

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.2...v0.2.1

## v0.2 - 2025-09-23

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.9...v0.2

## v0.1.9 - 2025-08-08

### What's Changed

* chore(deps): bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/NicolasKion/Esi/pull/6

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.8...v0.1.9

## v0.1.8 - 2025-07-23

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.7...v0.1.8

## v0.1.7 - 2025-07-19

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.6...v0.1.7

## v0.1.6 - 2025-07-12

Add SetWaypoint support

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.5...v0.1.6

## v0.1.5 - 2025-07-08

### What's Changed

* Bump dependabot/fetch-metadata from 2.3.0 to 2.4.0 by @dependabot in https://github.com/NicolasKion/Esi/pull/3

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.4...v0.1.5

## v0.1.3 - 2025-01-30

### What's Changed

* Bump dependabot/fetch-metadata from 2.2.0 to 2.3.0 by @dependabot in https://github.com/NicolasKion/Esi/pull/1

### New Contributors

* @dependabot made their first contribution in https://github.com/NicolasKion/Esi/pull/1

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.2...v0.1.3

## v0.1.2 - 2025-01-06

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1.1...v0.1.2

## v0.1.1 - 2025-01-06

**Full Changelog**: https://github.com/NicolasKion/Esi/compare/v0.1...v0.1.1
