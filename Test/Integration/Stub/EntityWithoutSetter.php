<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\ExtensionAttributesInterface;
use Magento\Framework\DataObject;

class EntityWithoutSetter extends DataObject implements ExtensibleDataInterface
{
    public function getExtensionAttributes(): ExtensionAttributesInterface
    {
        return new class implements ExtensionAttributesInterface {
        };
    }
}
