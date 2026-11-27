# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 27 November 2026
### Added
- Declare extension attributes for the product, category and MSI source repositories in `easier_extension_attributes.xml`. They are then loaded and saved automatically
- Support for PHP 8.5

### Changed
- PHP 8.1 support is dropped, so PHP 8.2 or newer is required
- Magento_Catalog is now a required dependency and Magento_InventoryApi is optional (suggested)
- The customer repository is no longer supported, because of typing issues with `save()`

### Fixed
- Configuration is now cached and merged, so modules that declare attributes for the same entity no longer overwrite each other
- Entries with an unknown entity class, an invalid attribute code or an invalid column name are skipped and logged instead of causing a TypeError
- Saving an entity no longer overwrites a stored column with an empty string when the extension attribute is not set
- An extension attributes object without a matching setter is logged once instead of breaking every repository load
- The plugin no longer drops the remaining arguments of `save()`
- Configured classes are no longer instantiated just to match entities
- A fatal error in the frontend
- The Magento framework dependency no longer uses a wildcard version
