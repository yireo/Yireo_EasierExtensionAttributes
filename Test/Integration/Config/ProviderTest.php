<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Config;

use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Config\Provider;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ArrayConfigData;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\CollectingLogger;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\CountingReader;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleEntity;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleOtherEntity;
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

    public function testConfigIsReadOnlyOnce()
    {
        $reader = new CountingReader(FixtureProviderFactory::createReader());
        $cacheId = 'yireo_easier_extension_attributes_test_' . uniqid();
        $configData = FixtureProviderFactory::createConfigData($reader, $cacheId);
        $provider = FixtureProviderFactory::createFromConfigData($configData);
        $provider->getExtensionAttributes();
        $provider->getExtensionAttributes();

        $secondProvider = FixtureProviderFactory::createFromConfigData(
            FixtureProviderFactory::createConfigData($reader, $cacheId)
        );
        $this->assertCount(1, $secondProvider->getExtensionAttributes());
        $this->assertSame(1, $reader->count);

        $configData->reset();
    }

    public function testMergeOfMultipleFilesWithMultipleAttributes()
    {
        $provider = FixtureProviderFactory::create(['merge/first.xml', 'merge/second.xml']);
        $mapping = [];
        foreach ($provider->getExtensionAttributes() as $extensionAttribute) {
            $mapping[$extensionAttribute->getAttributeCode()] = [
                $extensionAttribute->getEntityClass(),
                $extensionAttribute->getStorageColumn(),
            ];
        }

        ksort($mapping);
        $this->assertSame([
            'example' => [ExampleEntity::class, 'example'],
            'other' => [ExampleOtherEntity::class, 'other'],
            'second_example' => [ExampleEntity::class, 'second_example'],
            'third' => [ExampleEntity::class, 'third'],
        ], $mapping);
    }

    public function testAttributeWithoutStorageDoesNotFail()
    {
        $provider = $this->createArrayProvider([
            self::createBlock(ExampleEntity::class, [
                ['@attributes' => ['code' => 'example', 'type' => 'string']],
            ]),
        ]);

        $extensionAttributes = $provider->getExtensionAttributes();
        $this->assertCount(1, $extensionAttributes);
        $this->assertFalse($extensionAttributes[0]->isStorageColumn());
    }

    /**
     * @dataProvider invalidConfigProvider
     */
    public function testInvalidConfigIsSkippedAndLogged(array $block)
    {
        $logger = new CollectingLogger();
        $validBlock = self::createBlock(ExampleEntity::class, [self::createAttribute('example', 'example')]);
        $provider = $this->createArrayProvider([$block, $validBlock], $logger);

        $extensionAttributes = $provider->getExtensionAttributes();
        $this->assertCount(1, $extensionAttributes);
        $this->assertSame('example', $extensionAttributes[0]->getAttributeCode());
        $this->assertNotEmpty($logger->messages);
    }

    public static function invalidConfigProvider(): array
    {
        $entity = ExampleEntity::class;

        return [
            'missing for' => [['attribute' => [self::createAttribute('foo', 'foo')]]],
            'unknown class' => [self::createBlock('Foo\Bar\Unknown', [self::createAttribute('foo', 'foo')])],
            'missing code' => [self::createBlock($entity, [self::createAttribute('', 'foo')])],
            'invalid code' => [self::createBlock($entity, [self::createAttribute('Foo-Bar', 'foo')])],
            'reserved code' => [self::createBlock($entity, [self::createAttribute('data', 'foo')])],
            'empty column' => [self::createBlock($entity, [self::createAttribute('foo', '')])],
            'invalid column' => [self::createBlock($entity, [self::createAttribute('foo', 'a; DROP')])],
            'identity column' => [self::createBlock($entity, [self::createAttribute('foo', 'entity_id')])],
            'sku column' => [self::createBlock($entity, [self::createAttribute('foo', 'sku')])],
        ];
    }

    private function createArrayProvider(array $blocks, ?CollectingLogger $logger = null): Provider
    {
        $configData = new ArrayConfigData(['config' => [['extension_attributes' => $blocks]]]);
        return FixtureProviderFactory::createFromConfigData($configData, $logger ?? new CollectingLogger());
    }

    private static function createBlock(string $class, array $attributes): array
    {
        return ['@attributes' => ['for' => $class], 'attribute' => $attributes];
    }

    private static function createAttribute(string $code, string $column): array
    {
        return [
            '@attributes' => ['code' => $code, 'type' => 'string'],
            'storage' => [['column' => [['@attributes' => ['name' => $column]]]]],
        ];
    }
}
