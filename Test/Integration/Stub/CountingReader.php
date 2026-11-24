<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\Config\ReaderInterface;

class CountingReader implements ReaderInterface
{
    public int $count = 0;

    public function __construct(
        private readonly ReaderInterface $reader
    ) {
    }

    public function read($scope = null)
    {
        $this->count++;
        return $this->reader->read($scope);
    }
}
