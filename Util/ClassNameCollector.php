<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

use Magento\Framework\ObjectManagerInterface;
use Throwable;

class ClassNameCollector
{
    private ObjectManagerInterface $objectManager;
    
    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }
    
    /**
     * @param string $instanceName
     * @return string[]
     */
    public function getClassNames(string $instanceName): array
    {
        try {
            $instance = $this->objectManager->get($instanceName);
        } catch (Throwable $throwable) {
            return [];
        }
        
        $classNames = [$instanceName];
        $classNames[] = get_class($instance);
        $classNames = array_merge($classNames, class_parents($instance) ?? []);
        return array_unique($classNames);
    }
}
