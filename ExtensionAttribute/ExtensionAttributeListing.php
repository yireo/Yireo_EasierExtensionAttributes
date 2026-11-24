<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\ExtensionAttribute;

use Yireo\EasierExtensionAttributes\Config\Provider;

class ExtensionAttributeListing
{
    /**
     * @var ExtensionAttributeInterface[][]
     */
    private array $extensionAttributesByClass = [];

    public function __construct(
        private readonly Provider $provider
    ) {
    }

    /**
     * @return ExtensionAttributeInterface[]
     */
    public function getAll(): array
    {
        return $this->provider->getExtensionAttributes();
    }

    /**
     * @return ExtensionAttributeInterface[]
     */
    public function getByClass(string $class): array
    {
        if (!isset($this->extensionAttributesByClass[$class])) {
            $this->extensionAttributesByClass[$class] = array_values(array_filter(
                $this->getAll(),
                fn (ExtensionAttributeInterface $extensionAttribute) => is_a(
                    $class,
                    $extensionAttribute->getEntityClass(),
                    true
                )
            ));
        }

        return $this->extensionAttributesByClass[$class];
    }
}
