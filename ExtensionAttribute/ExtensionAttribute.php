<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\ExtensionAttribute;

class ExtensionAttribute implements ExtensionAttributeInterface
{
    private string $attributeCode;
    private string $attributeType;
    private string $entityClass;
    private array $storage;
    
    public function __construct(
        string $attributeCode,
        string $attributeType,
        string $entityClass,
        array $storage
    ) {
        $this->attributeCode = $attributeCode;
        $this->attributeType = $attributeType;
        $this->entityClass = $entityClass;
        $this->storage = $storage;
    }
    
    /**
     * @return string
     */
    public function getAttributeCode(): string
    {
        return $this->attributeCode;
    }
    
    /**
     * @return string
     */
    public function getAttributeType(): string
    {
        return $this->attributeType;
    }
    
    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }
    
    /**
     * @return array
     */
    public function getStorage(): array
    {
        return $this->storage;
    }
    
    /**
     * @return bool
     */
    public function isStorageColumn(): bool
    {
        return !empty($this->storage[0]['column']);
    }
    
    /**
     * @return string
     */
    public function getStorageColumn(): string
    {
        return $this->storage[0]['column'][0]['@attributes']['name'] ?? '';
    }
}
