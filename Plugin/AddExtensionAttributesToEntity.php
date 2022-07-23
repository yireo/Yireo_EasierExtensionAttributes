<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Plugin;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttribute;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeInterface;
use Yireo\EasierExtensionAttributes\ExtensionAttribute\ExtensionAttributeListing;
use Yireo\EasierExtensionAttributes\Util\CopyDataAttributeToExtensionAttribute;
use Yireo\EasierExtensionAttributes\Util\CopyExtensionAttributeToDataAttribute;

class AddExtensionAttributesToEntity
{
    /**
     * @param CopyDataAttributeToExtensionAttribute $copyDataAttributeToExtensionAttribute
     * @param CopyExtensionAttributeToDataAttribute $copyExtensionAttributeToDataAttribute
     * @param ExtensionAttributeListing $extensionAttributeListing
     */
    public function __construct(
        private CopyDataAttributeToExtensionAttribute $copyDataAttributeToExtensionAttribute,
        private CopyExtensionAttributeToDataAttribute $copyExtensionAttributeToDataAttribute,
        private ExtensionAttributeListing $extensionAttributeListing
    ) {
    }
    
    /**
     * @param object $target
     * @param ExtensibleDataInterface $entity
     * @return ExtensibleDataInterface
     */
    public function afterGet($target, ExtensibleDataInterface $entity): ExtensibleDataInterface
    {
        $extensionAttributes = $this->getExtensionAttributesByEntity($entity);
        foreach ($extensionAttributes as $extensionAttribute) {
            $this->copyDataPropertyToExtensionAttribute($entity, $extensionAttribute);
        }
        
        return $entity;
    }
    
    /**
     * @param object $target
     * @param ExtensibleDataInterface $entity
     * @return ExtensibleDataInterface
     */
    public function afterGetById($target, ExtensibleDataInterface $entity): ExtensibleDataInterface
    {
        return $this->afterGet($target, $entity);
    }
    
    /**
     * @param object $target
     * @param SearchResultsInterface $searchResults
     * @return SearchResultsInterface
     */
    public function afterGetList($target, SearchResultsInterface $searchResults): SearchResultsInterface
    {
        foreach ($searchResults->getItems() as $entity) {
            $easierExtensionAttributes = $this->getExtensionAttributesByEntity($entity);
            foreach ($easierExtensionAttributes as $extensionAttribute) {
                $this->copyDataPropertyToExtensionAttribute($entity, $extensionAttribute);
            }
        }
        
        return $searchResults;
    }
    
    /**
     * @param $target
     * @param ExtensibleDataInterface $entity
     * @return ExtensibleDataInterface[]
     */
    public function beforeSave($target, ExtensibleDataInterface $entity)
    {
        $extensionAttributes = $this->getExtensionAttributesByEntity($entity);
        foreach ($extensionAttributes as $extensionAttribute) {
            $this->copyExtensionAttributeToDataProperty($entity, $extensionAttribute);
        }
        
        return [$entity];
    }
    
    /**
     * @param ExtensibleDataInterface $entity
     * @param ExtensionAttribute $extensionAttribute
     * @return void
     */
    private function copyDataPropertyToExtensionAttribute(
        ExtensibleDataInterface $entity,
        ExtensionAttribute $extensionAttribute
    ) {
        if ($extensionAttribute->isStorageColumn()) {
            $this->copyDataAttributeToExtensionAttribute->execute(
                $entity,
                $extensionAttribute->getAttributeCode(),
                $extensionAttribute->getAttributeType(),
                $extensionAttribute->getStorageColumn(),
            );
        }
    }
    
    /**
     * @param ExtensionAttribute $extensionAttribute
     * @param ExtensibleDataInterface $entity
     * @return void
     */
    private function copyExtensionAttributeToDataProperty(
        ExtensibleDataInterface $entity,
        ExtensionAttribute $extensionAttribute
    ) {
        if ($extensionAttribute->isStorageColumn()) {
            $this->copyExtensionAttributeToDataAttribute->execute(
                $entity,
                $extensionAttribute->getAttributeCode(),
                $extensionAttribute->getStorageColumn(),
            );
        }
    }
    
    /**
     * @param ExtensibleDataInterface $entity
     * @return ExtensionAttributeInterface[]
     */
    private function getExtensionAttributesByEntity(ExtensibleDataInterface $entity)
    {
        return $this->extensionAttributeListing->getByClass(get_class($entity));
    }
}
