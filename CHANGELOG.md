# Changelog

All notable changes to `laravel-stateful-resources` will be documented in this file.

## v1.0.0 - 2026-03-31

### What's Changed

* build: bump dependencies to add laravel 13 support by @jsperrer in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/17
* [Fix]: Per-Request Scoping of Shared States by @julian-farbcode in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/18
* [Docs]: Performance Considerations by @julian-farbcode in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/5
* chore(deps): bump actions/checkout from 4 to 5 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/6
* chore(deps): bump actions/setup-node from 4 to 6 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/10
* chore(deps): bump stefanzweifel/git-auto-commit-action from 6 to 7 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/9
* chore(deps): bump actions/upload-pages-artifact from 3 to 4 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/7
* chore(deps): bump dependabot/fetch-metadata from 2.4.0 to 2.5.0 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/12
* chore(deps): bump dependabot/fetch-metadata from 2.5.0 to 3.0.0 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/16
* chore(deps): bump actions/deploy-pages from 4 to 5 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/15
* chore(deps): bump actions/configure-pages from 5 to 6 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/14
* chore(deps): bump ramsey/composer-install from 3 to 4 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/13
* chore(deps): bump actions/checkout from 5 to 6 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/11

### New Contributors

* @jsperrer made their first contribution in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/17

**Full Changelog**: https://github.com/farbcodegmbh/laravel-stateful-resources/compare/v0.3.0...v1.0.0

## v0.3.0 - 2025-08-05

### What's Changed

* [Feature]: Shared State by @julian-farbcode in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/3
* chore(deps): bump aglipanci/laravel-pint-action from 2.5 to 2.6 by @dependabot[bot] in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/2
* New and improved documentation structure ✨

### Potentially Breaking Changes

The new shared state feature is enabled by default for new installations. This might lead to previously unforeseen behaviors. The internally used Context Scope was removed. More info in the [PR](https://github.com/farbcodegmbh/laravel-stateful-resources/pull/3).

### New Contributors

* @dependabot[bot] made their first contribution in https://github.com/farbcodegmbh/laravel-stateful-resources/pull/2

**Full Changelog**: https://github.com/farbcodegmbh/laravel-stateful-resources/compare/v0.2.0...v0.3.0
