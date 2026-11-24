<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;

class CopyExtensionAttributeToDataAttribute
{
    public function __construct(
        private readonly SnakeCaseCamelCase $snakeCaseCamelCase,
        private readonly Caster $caster
    ) {
    }

    public function execute(
        ExtensibleDataInterface $entity,
        string $attributeCode,
        string $columnName,
        string $attributeType = ''
    ): void {
        $extensionAttributes = $entity->getExtensionAttributes();
        if (!$extensionAttributes instanceof ExtensionAttributesInterface || !is_callable([$entity, 'setData'])) {
            return;
        }

        $attributeGetter = $this->snakeCaseCamelCase->toGetter($attributeCode);
        if (!is_callable([$extensionAttributes, $attributeGetter])) {
            return;
        }

        $attributeValue = $extensionAttributes->$attributeGetter();
        if (!is_scalar($attributeValue)) {
            return;
        }

        $attributeValue = $this->caster->cast($attributeType, $attributeValue);
        if (is_bool($attributeValue)) {
            $attributeValue = (int)$attributeValue;
        }

        $entity->setData($columnName, $attributeValue);
    }
}
