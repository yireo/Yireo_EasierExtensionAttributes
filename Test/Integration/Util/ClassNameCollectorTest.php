<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Util;

use Magento\Framework\App\ObjectManager;
use Magento\Inventory\Model\Source;
use Magento\InventoryApi\Api\Data\SourceInterface;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Util\ClassNameCollector;

class ClassNameCollectorTest extends TestCase
{
    public function testGetClassNames()
    {
        $interfaceName = SourceInterface::class;
        $classNameCollector = ObjectManager::getInstance()->get(ClassNameCollector::class);
        $classNames = $classNameCollector->getClassNames($interfaceName);
        $realInstance = ObjectManager::getInstance()->get($interfaceName);
        $this->assertContains(get_class($realInstance), $classNames, var_export($classNames, true));
    }
}
