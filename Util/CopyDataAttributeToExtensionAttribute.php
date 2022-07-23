<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

use Magento\Framework\Api\ExtensibleDataInterface;
use Yireo\EasierExtensionAttributes\Exception\NoExtensionAttributesException;

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
     * @throws NoExtensionAttributesException
     */
    public function execute(
        ExtensibleDataInterface $entity,
        string $attributeCode,
        string $attributeType,
        string $columnName
    ) {
        $extensionAttributes = $entity->getExtensionAttributes();
        if (!$extensionAttributes) {
            $msg = 'No extension attributes found for entity "' . get_class($entity) . '"';
            throw new NoExtensionAttributesException($msg);
        }
        
        $attributeSetter = $this->snakeCaseCamelCase->toSetter($attributeCode);
        if (!method_exists($extensionAttributes, $attributeSetter)) {
            $msg = 'No method "' . $attributeSetter . '" found for entity "' . get_class($entity) . '"';
            throw new NoExtensionAttributesException($msg);
        }
        
        $attributeValue = $entity->getData($columnName);
        $attributeValue = $this->caster->cast($attributeType, $attributeValue);
        call_user_func([$extensionAttributes, $attributeSetter], $attributeValue);
    }
}
