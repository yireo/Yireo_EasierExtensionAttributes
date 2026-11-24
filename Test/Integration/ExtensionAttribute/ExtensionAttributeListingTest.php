<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\ExtensionAttribute;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeListing;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleChildEntity;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleEntity;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleOtherEntity;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\FixtureProviderFactory;

class ExtensionAttributeListingTest extends TestCase
{
    public function testGetByClass()
    {
        $listing = ObjectManager::getInstance()->create(ExtensionAttributeListing::class, [
            'provider' => FixtureProviderFactory::create(),
        ]);

        $this->assertCount(1, $listing->getByClass(ExampleEntity::class));
        $this->assertCount(1, $listing->getByClass(ExampleChildEntity::class));
        $this->assertCount(0, $listing->getByClass(DataObject::class));
        $this->assertCount(0, $listing->getByClass(ExampleOtherEntity::class));
    }
}
