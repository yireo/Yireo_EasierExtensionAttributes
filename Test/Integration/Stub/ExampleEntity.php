<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\DataObject;

class ExampleEntity extends DataObject implements ExtensibleDataInterface
{
    private ?ExampleEntityExtension $extensionAttributes = null;

    public function getExtensionAttributes(): ExampleEntityExtension
    {
        if ($this->extensionAttributes === null) {
            $this->extensionAttributes = new ExampleEntityExtension();
        }

        return $this->extensionAttributes;
    }

    public function setExtensionAttributes(ExampleEntityExtension $extensionAttributes): self
    {
        $this->extensionAttributes = $extensionAttributes;
        return $this;
    }
}
