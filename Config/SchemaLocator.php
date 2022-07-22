<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Config;

use Magento\Framework\Config\Dom\UrnResolver;
use Magento\Framework\Config\SchemaLocatorInterface;
use Magento\Framework\Exception\NotFoundException;

class SchemaLocator implements SchemaLocatorInterface
{
    /**
     * Initialize dependencies.
     *
     * @param UrnResolver $urnResolver
     */
    public function __construct(
        private UrnResolver $urnResolver
    ) {
    }
    
    /**
     * {@inheritdoc}
     *
     * @throws NotFoundException
     */
    public function getSchema()
    {
        $schema = 'urn:magento:module:Yireo_EasierExtensionAttributes:etc/easier_extension_attributes.xsd';
        return $this->urnResolver->getRealPath($schema);
    }
    
    /**
     * {@inheritdoc}
     *
     * @throws NotFoundException
     */
    public function getPerFileSchema()
    {
        $schema = 'urn:magento:module:Yireo_EasierExtensionAttributes:etc/easier_extension_attributes.xsd';
        return $this->urnResolver->getRealPath($schema);
    }
}
