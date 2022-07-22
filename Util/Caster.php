<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Util;

class Caster
{
    /**
     * @param string $type
     * @param mixed $value
     * @return mixed
     */
    public function cast(string $type, $value)
    {
        switch ($type) {
            case 'int':
            case 'integer':
            case 'number':
                return (int)$value;
            case 'string':
            case 'str':
                return (string)$value;
            case 'bool':
            case 'boolean':
                return (bool)$value;
            default:
                return $value;
        }
    }
}