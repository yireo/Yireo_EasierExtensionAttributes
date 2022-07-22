<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

use Magento\Framework\Api\ExtensibleDataInterface;

class CopyDataAttributeToExtensionAttribute
{
    private SnakeCaseCamelCase $snakeCaseCamelCase;
    private Caster $caster;
    
    /**
     * @param SnakeCaseCamelCase $snakeCaseCamelCase
     * @param Caster $caster
     */
    public function __construct(
        SnakeCaseCamelCase $snakeCaseCamelCase,
        Caster $caster
    ) {
        $this->snakeCaseCamelCase = $snakeCaseCamelCase;
        $this->caster = $caster;
    }
    
    /**
     *
     * @param ExtensibleDataInterface $entity
     * @param string $attributeCode
     * @param string $attributeType
     * @param string $columnName
     * @return void
     */
    public function execute(ExtensibleDataInterface $entity, string $attributeCode, string $attributeType, string $columnName)
    {
        $extensionAttributes = $entity->getExtensionAttributes();
        if (!$extensionAttributes) {
            return;
        }
        
        if (!$entity->hasData($attributeCode)) {
            return;
        }
        
        $attributeSetter = $this->snakeCaseCamelCase->toSetter($attributeCode);
        if (!method_exists($extensionAttributes, $attributeSetter)) {
            return;
        }
        
        $attributeValue = $entity->getData($columnName);
        $attributeValue = $this->caster->cast($attributeType, $attributeValue);
        call_user_func([$extensionAttributes, $attributeSetter], $attributeValue);
    }
}
