<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Util;

use Magento\Framework\App\ObjectManager;
use Magento\InventoryApi\Api\Data\SourceInterface;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Util\CopyDataAttributeToExtensionAttribute;

class CopyDataAttributeToExtensionAttributeTest extends TestCase
{
    public function testExecute()
    {
        $target = ObjectManager::getInstance()->get(CopyDataAttributeToExtensionAttribute::class);
        $sourceEntity = ObjectManager::getInstance()->get(SourceInterface::class);
        $sourceEntity->setData('example', 42);
        $target->execute($sourceEntity, 'example', 'integer', 'example');
        $this->assertEquals(42, $sourceEntity->getExample());
    }
}
