<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Psr\Log\LoggerInterface;

class CopyDataAttributeToExtensionAttribute
{
    /**
     * @var bool[]
     */
    private array $reported = [];

    public function __construct(
        private readonly SnakeCaseCamelCase $snakeCaseCamelCase,
        private readonly Caster $caster,
        private readonly LoggerInterface $logger
    ) {
    }

    public function execute(
        ExtensibleDataInterface $entity,
        string $attributeCode,
        string $attributeType,
        string $columnName
    ): void {
        $extensionAttributes = $entity->getExtensionAttributes();
        $attributeSetter = $this->snakeCaseCamelCase->toSetter($attributeCode);
        if (!$extensionAttributes instanceof ExtensionAttributesInterface
            || !is_callable([$extensionAttributes, $attributeSetter])
            || !is_callable([$entity, 'getData'])) {
            $this->reportOnce(get_class($entity), $attributeSetter);
            return;
        }

        $attributeValue = $entity->getData($columnName);
        if ($attributeValue !== null) {
            $attributeValue = $this->caster->cast($attributeType, $attributeValue);
        }

        $extensionAttributes->$attributeSetter($attributeValue);
    }

    private function reportOnce(string $entityClass, string $attributeSetter): void
    {
        $key = $entityClass . '::' . $attributeSetter;
        if (isset($this->reported[$key])) {
            return;
        }

        $this->reported[$key] = true;
        $this->logger->warning(
            'Yireo_EasierExtensionAttributes: No extension attribute setter "' . $attributeSetter
            . '" found for entity "' . $entityClass . '"'
        );
    }
}
