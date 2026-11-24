<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Util;

use Magento\Framework\App\ObjectManager;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yireo\EasierExtensionAttributes\Test\Integration\Stub\ExampleEntity;
use Yireo\EasierExtensionAttributes\Util\CopyExtensionAttributeToDataAttribute;

class CopyExtensionAttributeToDataAttributeTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
    public function testExecute(string $type, mixed $value, mixed $expectedValue)
    {
        $target = ObjectManager::getInstance()->get(CopyExtensionAttributeToDataAttribute::class);
        $entity = new ExampleEntity(['example' => 'original']);
        $entity->getExtensionAttributes()->setExample($value);
        $target->execute($entity, 'example', 'example', $type);
        $this->assertSame($expectedValue, $entity->getData('example'));
    }

    public static function valueProvider(): array
    {
        return [
            ['integer', 42, 42],
            ['integer', '42', 42],
            ['string', 42, '42'],
            ['boolean', true, 1],
            ['boolean', false, 0],
            ['string', null, 'original'],
            ['string', ['foo'], 'original'],
            ['string', new stdClass(), 'original'],
        ];
    }
}
