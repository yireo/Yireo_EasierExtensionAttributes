<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Config\Data;
use Magento\Framework\Config\DataInterface;
use Magento\Framework\Config\ReaderInterface;
use Psr\Log\LoggerInterface;
use Yireo\EasierExtensionAttributes\Config\Provider;
use Yireo\EasierExtensionAttributes\Config\Reader\Filesystem;

class FixtureProviderFactory
{
    /**
     * @param string[] $files
     */
    public static function create(array $files = ['easier_extension_attributes.xml']): Provider
    {
        return self::createFromConfigData(self::createConfigData(self::createReader($files)));
    }

    /**
     * @param string[] $files
     */
    public static function createReader(array $files = ['easier_extension_attributes.xml']): ReaderInterface
    {
        return ObjectManager::getInstance()->create(Filesystem::class, [
            'fileResolver' => new FixtureFileResolver($files),
        ]);
    }

    public static function createConfigData(ReaderInterface $reader, ?string $cacheId = null): Data
    {
        return ObjectManager::getInstance()->create(Data::class, [
            'reader' => $reader,
            'cacheId' => $cacheId ?? 'yireo_easier_extension_attributes_test_' . uniqid(),
        ]);
    }

    public static function createFromConfigData(DataInterface $configData, ?LoggerInterface $logger = null): Provider
    {
        $arguments = ['configData' => $configData];
        if ($logger) {
            $arguments['logger'] = $logger;
        }

        return ObjectManager::getInstance()->create(Provider::class, $arguments);
    }
}
