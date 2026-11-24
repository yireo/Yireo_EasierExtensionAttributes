<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\Config\DataInterface;

class ArrayConfigData implements DataInterface
{
    public function __construct(
        private array $data
    ) {
    }

    public function merge(array $config)
    {
        $this->data = array_replace_recursive($this->data, $config);
    }

    public function get($key = null, $default = null)
    {
        return $key === null ? $this->data : ($this->data[$key] ?? $default);
    }
}
