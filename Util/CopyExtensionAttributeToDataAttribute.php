<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;

class CopyExtensionAttributeToDataAttribute
{
    private SnakeCaseCamelCase $snakeCaseCamelCase;
    
    /**
     * @param SnakeCaseCamelCase $snakeCaseCamelCase
     */
    public function __construct(
        SnakeCaseCamelCase $snakeCaseCamelCase
    ) {
        $this->snakeCaseCamelCase = $snakeCaseCamelCase;
    }
    
    /**
     *
     * @param ExtensibleDataInterface $entity
     * @param string $attributeCode
     * @param string $columnName
     * @return void
     */
    public function execute(ExtensibleDataInterface $entity, string $attributeCode, string $columnName)
    {
        $extensionAttributes = $entity->getExtensionAttributes();
        if (!$extensionAttributes instanceof ExtensionAttributesInterface) {
            return;
        }
        
        $attributeMethod = $this->snakeCaseCamelCase->toGetter($attributeCode);
        if (!method_exists($extensionAttributes, $attributeMethod)) {
            return;
        }
    
        $attributeValue = call_user_func([$extensionAttributes, $attributeMethod]);
        $entity->setData($columnName, (string)$attributeValue);
    }
}
