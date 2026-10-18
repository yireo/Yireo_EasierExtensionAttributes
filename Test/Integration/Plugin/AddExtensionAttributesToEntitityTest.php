<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Plugin;

use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeListing;
use Yireo\EasierExtensionAttributes\Plugin\AddExtensionAttributesToEntity;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleEntity;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\FixtureProviderFactory;

class AddExtensionAttributesToEntitityTest extends TestCase
{
    public function testAfterGet()
    {
        $plugin = $this->getPlugin();
        $entity = new ExampleEntity();
        $entity->setData('example', 1);
        $entity = $plugin->afterGet(null, $entity);
        $this->assertSame(true, $entity->getExtensionAttributes()->getExample());
    }

    public function testBeforeSave()
    {
        $plugin = $this->getPlugin();
        $entity = new ExampleEntity();
        $entity->getExtensionAttributes()->setExample(true);
        [$entity] = $plugin->beforeSave(null, $entity);
        $this->assertSame('1', $entity->getData('example'));
    }

    private function getPlugin(): AddExtensionAttributesToEntity
    {
        $objectManager = ObjectManager::getInstance();
        $extensionAttributeListing = $objectManager->create(ExtensionAttributeListing::class, [
            'provider' => FixtureProviderFactory::create(),
        ]);

        return $objectManager->create(AddExtensionAttributesToEntity::class, [
            'extensionAttributeListing' => $extensionAttributeListing,
        ]);
    }
}
