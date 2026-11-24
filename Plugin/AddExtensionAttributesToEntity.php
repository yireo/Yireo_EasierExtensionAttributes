<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Plugin;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeInterface;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeListing;
use Yireo\EasierExtensionAttributes\Util\CopyDataAttributeToExtensionAttribute;
use Yireo\EasierExtensionAttributes\Util\CopyExtensionAttributeToDataAttribute;

class AddExtensionAttributesToEntity
{
    public function __construct(
        private readonly CopyDataAttributeToExtensionAttribute $copyDataAttributeToExtensionAttribute,
        private readonly CopyExtensionAttributeToDataAttribute $copyExtensionAttributeToDataAttribute,
        private readonly ExtensionAttributeListing $extensionAttributeListing
    ) {
    }

    /**
     * @param mixed $subject
     * @param ExtensibleDataInterface $entity
     * @return ExtensibleDataInterface
     */
    public function afterGet(mixed $subject, ExtensibleDataInterface $entity): ExtensibleDataInterface
    {
        foreach ($this->getExtensionAttributesByEntity($entity) as $extensionAttribute) {
            $this->copyDataAttributeToExtensionAttribute->execute(
                $entity,
                $extensionAttribute->getAttributeCode(),
                $extensionAttribute->getAttributeType(),
                $extensionAttribute->getStorageColumn(),
            );
        }

        return $entity;
    }

    /**
     * @param mixed $subject
     * @param ExtensibleDataInterface $entity
     * @return ExtensibleDataInterface
     */
    public function afterGetById(mixed $subject, ExtensibleDataInterface $entity): ExtensibleDataInterface
    {
        return $this->afterGet($subject, $entity);
    }

    /**
     * @param mixed $subject
     * @param SearchResultsInterface $searchResults
     * @return SearchResultsInterface
     */
    public function afterGetList(mixed $subject, SearchResultsInterface $searchResults): SearchResultsInterface
    {
        if ($this->extensionAttributeListing->getAll() === []) {
            return $searchResults;
        }

        foreach ($searchResults->getItems() as $entity) {
            if ($entity instanceof ExtensibleDataInterface) {
                $this->afterGet($subject, $entity);
            }
        }

        return $searchResults;
    }

    /**
     * @param mixed $subject
     * @param ExtensibleDataInterface $entity
     * @return void
     */
    public function beforeSave(mixed $subject, ExtensibleDataInterface $entity): void
    {
        foreach ($this->getExtensionAttributesByEntity($entity) as $extensionAttribute) {
            $this->copyExtensionAttributeToDataAttribute->execute(
                $entity,
                $extensionAttribute->getAttributeCode(),
                $extensionAttribute->getStorageColumn(),
                $extensionAttribute->getAttributeType(),
            );
        }
    }

    /**
     * @param ExtensibleDataInterface $entity
     * @return ExtensionAttributeInterface[]
     */
    private function getExtensionAttributesByEntity(ExtensibleDataInterface $entity): array
    {
        return array_filter(
            $this->extensionAttributeListing->getByClass(get_class($entity)),
            fn (ExtensionAttributeInterface $extensionAttribute) => $extensionAttribute->isStorageColumn()
        );
    }
}
