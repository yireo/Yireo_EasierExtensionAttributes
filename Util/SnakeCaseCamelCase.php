<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

class SnakeCaseCamelCase
{
    /**
     *
     * @param string $snakeCase
     * @return string
     */
    public function fromSnakeCaseToCamelCase(string $snakeCase): string
    {
        return str_replace('_', '', ucwords($snakeCase, '_'));
    }
    
    /**
     * @param string $value
     * @return string
     */
    public function toSetter(string $value): string
    {
        return 'set'.$this->fromSnakeCaseToCamelCase($value);
    }
    
    /**
     * @param string $value
     * @return string
     */
    public function toGetter(string $value): string
    {
        return 'get'.$this->fromSnakeCaseToCamelCase($value);
    }
}
