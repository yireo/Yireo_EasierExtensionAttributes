<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Util;

use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleEntity;
use Yireo\EasierExtensionAttributes\Util\CopyExtensionAttributeToDataAttribute;

class CopyExtensionAttributeToDataAttributeTest extends TestCase
{
    public function testExecute()
    {
        $target = ObjectManager::getInstance()->get(CopyExtensionAttributeToDataAttribute::class);
        $entity = new ExampleEntity();
        $entity->getExtensionAttributes()->setExample(42);
        $target->execute($entity, 'example', 'example');
        $this->assertSame('42', $entity->getData('example'));
    }
}
