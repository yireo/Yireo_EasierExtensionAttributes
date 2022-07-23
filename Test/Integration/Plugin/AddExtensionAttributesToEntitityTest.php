<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Plugin;

use Magento\Framework\App\ObjectManager;
use Magento\InventoryApi\Api\Data\SourceInterface;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Plugin\AddExtensionAttributesToEntity;

class AddExtensionAttributesToEntitityTest extends TestCase
{
    public function testAfterGet()
    {
        $plugin = ObjectManager::getInstance()->get(AddExtensionAttributesToEntity::class);
        $source = ObjectManager::getInstance()->get(SourceInterface::class);
        $source->setData('example', true);
        $source = $plugin->afterGet($source, $source);
        $this->assertSame(true, $source->getExtensionAttributes()->getExample());
    }
}