<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Config;

use Magento\Framework\Config\DataInterface;
use Psr\Log\LoggerInterface;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttribute;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeFactory;
use Yireo\EasierExtensionAttributes\Util\NameValidator;

class Provider
{
    /**
     * @var ExtensionAttribute[]|null
     */
    private ?array $extensionAttributes = null;

    public function __construct(
        private readonly DataInterface $configData,
        private readonly ExtensionAttributeFactory $extensionAttributeFactory,
        private readonly NameValidator $nameValidator,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @return ExtensionAttribute[]
     */
    public function getExtensionAttributes(): array
    {
        if ($this->extensionAttributes === null) {
            $this->extensionAttributes = $this->parse($this->configData->get());
        }

        return $this->extensionAttributes;
    }

    /**
     * @param mixed $config
     * @return ExtensionAttribute[]
     */
    private function parse(mixed $config): array
    {
        $blocks = $config['config'][0]['extension_attributes'] ?? [];
        if (!is_array($blocks)) {
            return [];
        }

        $extensionAttributes = [];
        foreach ($blocks as $block) {
            $entityClass = is_array($block) ? (string)($block['@attributes']['for'] ?? '') : '';
            if ($entityClass === '' || (!class_exists($entityClass) && !interface_exists($entityClass))) {
                $this->warn('Unknown entity class "' . $entityClass . '"');
                continue;
            }

            $attributes = $block['attribute'] ?? [];
            foreach (is_array($attributes) ? $attributes : [] as $attribute) {
                $extensionAttribute = $this->createExtensionAttribute($entityClass, $attribute);
                if ($extensionAttribute instanceof ExtensionAttribute) {
                    $extensionAttributes[] = $extensionAttribute;
                }
            }
        }

        return $extensionAttributes;
    }

    private function createExtensionAttribute(string $entityClass, mixed $attribute): ?ExtensionAttribute
    {
        if (!is_array($attribute)) {
            return null;
        }

        $attributeCode = (string)($attribute['@attributes']['code'] ?? '');
        if (!$this->nameValidator->isValidAttributeCode($attributeCode)) {
            $this->warn('Invalid attribute code "' . $attributeCode . '" for "' . $entityClass . '"');
            return null;
        }

        $storage = is_array($attribute['storage'] ?? null) ? $attribute['storage'] : [];
        if (isset($storage[0]['column'])) {
            $columnName = (string)($storage[0]['column'][0]['@attributes']['name'] ?? '');
            if (!$this->nameValidator->isValidColumnName($columnName)) {
                $this->warn('Invalid column "' . $columnName . '" for attribute "' . $attributeCode . '"');
                return null;
            }
        }

        return $this->extensionAttributeFactory->create([
            'attributeCode' => $attributeCode,
            'attributeType' => (string)($attribute['@attributes']['type'] ?? ''),
            'entityClass' => $entityClass,
            'storage' => $storage,
        ]);
    }

    private function warn(string $message): void
    {
        $this->logger->warning('Yireo_EasierExtensionAttributes: ' . $message . ', skipping');
    }
}
