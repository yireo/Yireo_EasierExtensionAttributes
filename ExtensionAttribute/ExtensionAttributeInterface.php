<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\ExtensionAttribute;

interface ExtensionAttributeInterface
{
    /**
     * @return string
     */
    public function getAttributeCode(): string;
    
    /**
     * @return string
     */
    public function getAttributeType(): string;
    
    /**
     * @return string
     */
    public function getEntityClass(): string;
    
    /**
     * @return array
     */
    public function getStorage(): array;
    
    /**
     * @return bool
     */
    public function isStorageColumn(): bool;
    
    /**
     * @return string
     */
    public function getStorageColumn(): string;
}
