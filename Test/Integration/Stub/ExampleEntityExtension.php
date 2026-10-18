<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\Api\ExtensionAttributesInterface;

class ExampleEntityExtension implements ExtensionAttributesInterface
{
    private mixed $example = null;

    public function getExample(): mixed
    {
        return $this->example;
    }

    public function setExample(mixed $example): self
    {
        $this->example = $example;
        return $this;
    }
}
