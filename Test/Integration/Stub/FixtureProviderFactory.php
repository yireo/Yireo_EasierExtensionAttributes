<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\App\ObjectManager;
use Yireo\EasierExtensionAttributes\Config\Provider;
use Yireo\EasierExtensionAttributes\Config\Reader\Filesystem;

class FixtureProviderFactory
{
    public static function create(): Provider
    {
        $objectManager = ObjectManager::getInstance();
        $configReader = $objectManager->create(Filesystem::class, [
            'fileResolver' => new FixtureFileResolver(),
        ]);

        return $objectManager->create(Provider::class, ['configReader' => $configReader]);
    }
}
