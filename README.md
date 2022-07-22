# Yireo EasierExtensionAttributes

**This module tries to make implementing Magento 2 Extension Attributes easier by offering generic DI plugins that hook into various repositories.**

## Current features
- Creation of plugins for various entities (See `etc/di.xml` for a listing of current repositories supported)
- Saving simple Extension Attributes in the table of the original entity (by copying the Extension Attribute to a data property of the entity and vice versa)

## Example

For an example implementation, see [YireoTraining_EasierExtensionAttributesExample](https://github.com/yireo-training/YireoTraining_EasierExtensionAttributesExample), more specifically its `easier_extension_attributes.xml` which complements the regular `extension_attributes.xml`. For extending the MSI Source entity, it adds a column `example` to the `source` database table, which is then automatically filled with the Yireo EasierExtensionAttributes module.

## TODO
- Connect your own simple Extension Attribute with a separate table
- Connect your own Extension Attribute with a custom repository
- Connect your own complex Extension Attribute
- Try to merge `extension_attributes.xml` with `easier_extension_attributes.xml` to cleanup code
- Automatically add extension attributes to frontend and backend forms