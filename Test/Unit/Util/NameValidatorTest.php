<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Unit\Util;

use PHPUnit\Framework\TestCase;
use Yireo\EasierExtensionAttributes\Util\NameValidator;

class NameValidatorTest extends TestCase
{
    /**
     * @dataProvider attributeCodeProvider
     */
    public function testIsValidAttributeCode(string $code, bool $expected)
    {
        $this->assertSame($expected, (new NameValidator())->isValidAttributeCode($code));
    }

    public static function attributeCodeProvider(): array
    {
        return [
            ['example', true],
            ['foo_bar2', true],
            ['', false],
            ['Example', false],
            ['2foo', false],
            ['_foo', false],
            ['foo-bar', false],
            ['foo bar', false],
            ["foo\n", false],
            [str_repeat('a', 65), false],
            ['data', false],
            ['extension_attributes', false],
            ['custom_attributes', false],
        ];
    }

    /**
     * @dataProvider columnNameProvider
     */
    public function testIsValidColumnName(string $column, bool $expected)
    {
        $this->assertSame($expected, (new NameValidator())->isValidColumnName($column));
    }

    public static function columnNameProvider(): array
    {
        return [
            ['example', true],
            ['foo_bar', true],
            [str_repeat('a', 64), true],
            [str_repeat('a', 65), false],
            ['', false],
            ['a; DROP TABLE', false],
            ["foo\n", false],
            ['entity_id', false],
            ['row_id', false],
            ['sku', false],
            ['source_code', false],
            ['attribute_set_id', false],
            ['store_id', false],
        ];
    }
}
