<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Config;

use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Config\Provider;

class ProviderTest extends TestCase
{
    public function testGetExtensionAttributes()
    {
        $provider = ObjectManager::getInstance()->get(Provider::class);
        $extensionAttributes = $provider->getExtensionAttributes();
        $this->assertNotEmpty($extensionAttributes);
        
        foreach ($extensionAttributes as $extensionAttribute) {
            $this->assertNotEmpty($extensionAttribute->getAttributeCode());
            $this->assertNotEmpty($extensionAttribute->getAttributeType());
            $this->assertNotEmpty($extensionAttribute->getEntityClass());
            $this->assertNotEmpty($extensionAttribute->getStorage());
            
            if ($extensionAttribute->isStorageColumn()) {
                $this->assertNotEmpty($extensionAttribute->getStorageColumn());
            }
        }
    }
}