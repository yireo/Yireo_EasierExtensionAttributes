<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Unit\Util;

use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Util\Caster;

class CasterTest extends TestCase
{
    /**
     * @param string $type
     * @param $value
     * @param $expectedValue
     * @return void
     * @dataProvider castDataProvider
     */
    public function testCast(string $type, $value, $expectedValue)
    {
        $caster = new Caster();
        $this->assertSame($expectedValue, $caster->cast($type, $value));
    }
    
    public function castDataProvider(): array
    {
        return [
            ['integer', 42, 42],
            ['integer', '42a', 42],
            ['number', '-1', -1],
            ['string', '-1', '-1'],
            ['string', 42, '42'],
            ['string', \stdClass::class, 'stdClass'],
            ['bool', 1, true],
            ['bool', 0, false],
            ['bool', 'false', true],
            ['bool', 'true', true],
            ['bool', '0true', true],
        ];
    }
}