<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Config;

use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleEntity;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\FixtureProviderFactory;

class ProviderTest extends TestCase
{
    public function testGetExtensionAttributes()
    {
        $provider = FixtureProviderFactory::create();
        $extensionAttributes = $provider->getExtensionAttributes();
        $this->assertCount(1, $extensionAttributes);

        $extensionAttribute = array_shift($extensionAttributes);
        $this->assertSame('example', $extensionAttribute->getAttributeCode());
        $this->assertSame('boolean', $extensionAttribute->getAttributeType());
        $this->assertSame(ExampleEntity::class, $extensionAttribute->getEntityClass());
        $this->assertNotEmpty($extensionAttribute->getStorage());
        $this->assertTrue($extensionAttribute->isStorageColumn());
        $this->assertSame('example', $extensionAttribute->getStorageColumn());
    }
}
