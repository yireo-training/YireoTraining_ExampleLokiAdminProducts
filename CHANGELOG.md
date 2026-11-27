# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.0.1] - 27 November 2026
### Added
- Example product grid built on Loki Admin Components, with search, filters, cell templates, buttons with sub-buttons and mass actions
- Quick edit form for products
- Support for PHP 8.5

### Changed
- Product grid searches on both name and SKU; unused row action removed
- Mass actions and default grid filter are configured via XML layout
- Moved to the Loki_AdminComponents namespaces
- Requires magento/framework ^103.0 and declares its Loki and Magento module dependencies

### Removed
- Support for PHP 8.1

### Fixed
- Redirect after running a mass action
- Wrong options model in the store view filter
- Label and URL being swapped in cell actions

### Security
- Product pages, inline edit and mass actions now require the Magento_Catalog::products ACL resource
- Quick edit form only saves declared fields, and only for the requested product