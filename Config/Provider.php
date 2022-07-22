<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Config;

use Magento\Framework\Config\ReaderInterface;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttribute;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeFactory;

class Provider
{
    public function __construct(
        private ReaderInterface $configReader,
        private ExtensionAttributeFactory $extensionAttributeFactory
    ) {
    }
    
    /**
     * @return ExtensionAttribute[]
     */
    public function getExtensionAttributes(): array
    {
        $config = $this->configReader->read();
        
        if (empty($config['config'][0]['extension_attributes'])) {
            return [];
        }
        
        $extensionAttributes = [];
        foreach ($config['config'][0]['extension_attributes'] as $attribute) {
            $entityClass = $attribute['@attributes']['for'];
            $storage = $attribute['attribute'][0]['storage'];
            $attributeCode = $attribute['attribute'][0]['@attributes']['code'];
            $attributeType = $attribute['attribute'][0]['@attributes']['type'];
            
            $storageDefinition = [];
            if (isset($storage[0]['column'])) {
                $storageDefinition['column'] = $storage[0]['column'][0]['@attributes'];
            }
    
            $extensionAttributes[] = $this->extensionAttributeFactory->create([
                'attributeCode' => $attributeCode,
                'attributeType' => $attributeType,
                'entityClass' => $entityClass,
                'storage' => $storage
            ]);
        }
        
        return $extensionAttributes;
    }
}
