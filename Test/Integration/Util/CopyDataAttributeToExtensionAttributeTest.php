<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Util;

use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\CollectingLogger;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\EntityWithoutSetter;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleEntity;
use Yireo\EasierExtensionAttributes\Util\CopyDataAttributeToExtensionAttribute;

class CopyDataAttributeToExtensionAttributeTest extends TestCase
{
    public function testExecute()
    {
        $target = ObjectManager::getInstance()->get(CopyDataAttributeToExtensionAttribute::class);
        $entity = new ExampleEntity();
        $entity->setData('example', '42');
        $target->execute($entity, 'example', 'integer', 'example');
        $this->assertSame(42, $entity->getExtensionAttributes()->getExample());
    }

    public function testMissingSetterIsLoggedOnceInsteadOfThrown()
    {
        $logger = new CollectingLogger();
        $target = ObjectManager::getInstance()->create(CopyDataAttributeToExtensionAttribute::class, [
            'logger' => $logger,
        ]);

        $target->execute(new EntityWithoutSetter(['example' => 1]), 'example', 'integer', 'example');
        $target->execute(new EntityWithoutSetter(['example' => 1]), 'example', 'integer', 'example');
        $this->assertCount(1, $logger->messages);
    }
}
