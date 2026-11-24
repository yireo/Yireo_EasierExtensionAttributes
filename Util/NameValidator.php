<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

class NameValidator
{
    private const NAME_PATTERN = '/^[a-z][a-z0-9_]{0,63}\z/';

    private const RESERVED_ATTRIBUTE_CODES = [
        'data',
        'extension_attributes',
        'custom_attributes',
    ];

    private const RESERVED_COLUMN_NAMES = [
        'id',
        'entity_id',
        'row_id',
        'sku',
        'source_code',
        'attribute_set_id',
        'type_id',
        'store_id',
        'website_id',
        'parent_id',
        'path',
        'created_in',
        'updated_in',
        'extension_attributes',
        'custom_attributes',
    ];

    public function isValidAttributeCode(string $attributeCode): bool
    {
        return $this->isValidName($attributeCode)
            && !in_array($attributeCode, self::RESERVED_ATTRIBUTE_CODES, true);
    }

    public function isValidColumnName(string $columnName): bool
    {
        return $this->isValidName($columnName)
            && !in_array($columnName, self::RESERVED_COLUMN_NAMES, true);
    }

    private function isValidName(string $name): bool
    {
        return preg_match(self::NAME_PATTERN, $name) === 1;
    }
}
