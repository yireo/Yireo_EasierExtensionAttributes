<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Util;

use Magento\Framework\App\ObjectManager;
use Magento\InventoryApi\Api\Data\SourceInterface;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Util\CopyExtensionAttributeToDataAttribute;

class CopyExtensionAttributeToDataAttributeTest extends TestCase
{
    public function testExecute()
    {
        $target = ObjectManager::getInstance()->get(CopyExtensionAttributeToDataAttribute::class);
        $entity = ObjectManager::getInstance()->get(SourceInterface::class);
        $entity->getExtensionAttributes()->setExample(42);
        $target->execute($entity, 'example', 'example');
        $this->assertEquals(42, $entity->getExample());
    }
}