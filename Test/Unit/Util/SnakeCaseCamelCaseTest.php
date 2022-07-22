<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Unit\Util;

use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Util\SnakeCaseCamelCase;

class SnakeCaseCamelCaseTest extends TestCase
{
    public function testFromSnakeCaseToCamelCase()
    {
        $snakeCaseCamelCase = new SnakeCaseCamelCase();
        $this->assertEquals('Example', $snakeCaseCamelCase->fromSnakeCaseToCamelCase('example'));
        $this->assertEquals('FooBar', $snakeCaseCamelCase->fromSnakeCaseToCamelCase('foo_bar'));
        $this->assertEquals('AFooBar', $snakeCaseCamelCase->fromSnakeCaseToCamelCase('a_foo_bar'));
    }
    
    public function testToSetter()
    {
        $snakeCaseCamelCase = new SnakeCaseCamelCase();
        $this->assertEquals('setExample', $snakeCaseCamelCase->toSetter('example'));
    }
    
    public function testToGetter()
    {
        $snakeCaseCamelCase = new SnakeCaseCamelCase();
        $this->assertEquals('getExample', $snakeCaseCamelCase->toGetter('example'));
    }
}
