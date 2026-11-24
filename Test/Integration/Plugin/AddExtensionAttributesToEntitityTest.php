<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Plugin;

use Magento\Framework\Api\SearchResults;
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

    public function testAfterGetKeepsNullValue()
    {
        $plugin = $this->getPlugin();
        $entity = $plugin->afterGet(null, new ExampleEntity());
        $this->assertNull($entity->getExtensionAttributes()->getExample());
    }

    public function testAfterGetList()
    {
        $plugin = $this->getPlugin();
        $first = new ExampleEntity(['example' => 1]);
        $second = new ExampleEntity(['example' => 0]);
        $searchResults = new SearchResults();
        $searchResults->setItems([$first, $second]);

        $plugin->afterGetList(null, $searchResults);
        $this->assertTrue($first->getExtensionAttributes()->getExample());
        $this->assertFalse($second->getExtensionAttributes()->getExample());
    }

    public function testBeforeSave()
    {
        $plugin = $this->getPlugin();
        $entity = new ExampleEntity();
        $entity->getExtensionAttributes()->setExample(true);
        $plugin->beforeSave(null, $entity);
        $this->assertSame(1, $entity->getData('example'));
    }

    public function testBeforeSaveKeepsExistingValueWhenExtensionAttributeIsNotSet()
    {
        $plugin = $this->getPlugin();
        $entity = new ExampleEntity(['example' => 1]);
        $plugin->beforeSave(null, $entity);
        $this->assertSame(1, $entity->getData('example'));
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
