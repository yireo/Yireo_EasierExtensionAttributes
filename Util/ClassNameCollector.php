<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

use Magento\Framework\App\ObjectManager;

class ClassNameCollector
{
    private ObjectManager $objectManager;
    
    public function __construct(
        ObjectManager $objectManager
    ) {
        $this->objectManager = $objectManager;
    }
    
    /**
     * @param string $instance
     * @return string[]
     */
    public function getClassNames(string $instanceName): array
    {
        $instance = $this->objectManager->get($instanceName);
        $classNames = [$instanceName];
        $classNames[] = get_class($instance);
        $classNames = array_merge($classNames, class_parents($instance) ?? []);
        return array_unique($classNames);
    }
}
