<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\ExtensionAttribute;

use Yireo\EasierExtensionAttributes\Config\Provider;
use Yireo\EasierExtensionAttributes\Util\ClassNameCollector;

class ExtensionAttributeListing
{
    private ClassNameCollector $classNameCollector;
    private Provider $provider;
    
    /**
     * @param ClassNameCollector $classNameCollector
     * @param Provider $provider
     */
    public function __construct(
        ClassNameCollector $classNameCollector,
        Provider $provider
    ) {
        $this->classNameCollector = $classNameCollector;
        $this->provider = $provider;
    }
    
    /**
     * @return ExtensionAttributeInterface[]
     */
    public function getAll(): array
    {
        return $this->provider->getExtensionAttributes();
    }
    
    /**
     * @return ExtensionAttributeInterface[]
     */
    public function getByClass(string $class): array
    {
        $listing = [];
        foreach ($this->getAll() as $extensionAttribute) {
            if (in_array($class, $this->classNameCollector->getClassNames($extensionAttribute->getEntityClass()))) {
                $listing[] = $extensionAttribute;
            }
        }
        
        return $listing;
    }
}