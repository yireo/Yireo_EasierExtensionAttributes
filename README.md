# Yireo EasierExtensionAttributes

<!-- badges.specs.start -->
<div class="github-specs-badges">

![Magento version](https://img.shields.io/badge/Magento-2.4.6%20%7C%202.4.9-orange)
![PHP version](https://img.shields.io/badge/PHP-8.2%E2%80%938.5-777BB4)
![License](https://img.shields.io/badge/License-OSL--3.0-blue)
![Latest Version](https://img.shields.io/packagist/v/yireo/magento2-easier-extension-attributes)

</div>
<!-- badges.specs.end -->


**This module tries to make implementing Magento 2 Extension Attributes easier by offering generic DI plugins that hook into various repositories.**

## Current features
- Creation of plugins for various entities (See `etc/di.xml` for a listing of current repositories supported)
- Saving simple Extension Attributes in the table of the original entity (by copying the Extension Attribute to a data property of the entity and vice versa)

## Example

For an example implementation, see [YireoTraining_EasierExtensionAttributesExample](https://github.com/yireo-training/YireoTraining_EasierExtensionAttributesExample), more specifically its `easier_extension_attributes.xml` which complements the regular `extension_attributes.xml`. For extending the MSI Source entity, it adds a column `example` to the `source` database table, which is then automatically filled with the Yireo EasierExtensionAttributes module.

## Security notes
- Every column mapped in `easier_extension_attributes.xml` becomes readable and writable through the REST and GraphQL APIs as an extension attribute. Restrict access by adding `<resources>` with an ACL resource to the attribute in your `extension_attributes.xml`.
- Attribute codes and column names must match `[a-z][a-z0-9_]*` (max. 64 characters). Identity columns (like `entity_id`, `row_id`, `sku`, `source_code`, `attribute_set_id`, `store_id`) cannot be mapped. Invalid entries are skipped and logged.
- When an extension attribute is not set (`null`) or not a scalar value, saving the entity leaves the existing column value untouched.

## TODO
- Integration tests for `getList`, `save` and `getById`
- Integration tests for additional repositories
- Connect your own simple Extension Attribute with a separate table
- Connect your own Extension Attribute with a custom repository
- Connect your own complex Extension Attribute
- Try to merge `extension_attributes.xml` with `easier_extension_attributes.xml` to cleanup code
- Automatically add extension attributes to frontend and backend forms
## Current status

<!-- badges.test.start -->
<div class="github-pipeline-badges">

![Static Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_EasierExtensionAttributes/static-tests.yml?label=static-tests)
![Unit Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_EasierExtensionAttributes/unit-tests.yml?label=unit-tests)
![Integration Tests](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_EasierExtensionAttributes/integration-tests.yml?label=integration-tests)
![Playwright](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_EasierExtensionAttributes/playwright.yml?label=playwright)
![DI Compilation](https://img.shields.io/github/actions/workflow/status/yireo/Yireo_EasierExtensionAttributes/compile.yml?label=compile)

</div>
<!-- badges.test.end -->
