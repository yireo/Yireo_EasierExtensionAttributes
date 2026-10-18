<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Util;

use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
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
}
