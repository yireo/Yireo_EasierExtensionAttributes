<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Config\Reader;

use Magento\Framework\Config\ConverterInterface;
use Magento\Framework\Config\Dom;
use Magento\Framework\Config\FileResolverInterface;
use Magento\Framework\Config\Reader\Filesystem as CoreFilesystem;
use Magento\Framework\Config\ValidationStateInterface;
use Yireo\EasierExtensionAttributes\Config\SchemaLocator;

class Filesystem extends CoreFilesystem
{
    /**
     * List of id attributes for merge
     *
     * @var array
     */
    //protected $_idAttributes = ['/config/extension_attributes' => 'id'];
    
    /**
     * @param FileResolverInterface $fileResolver
     * @param ConverterInterface $converter
     * @param SchemaLocator $schemaLocator
     * @param ValidationStateInterface $validationState
     * @param string $fileName
     * @param array $idAttributes
     * @param string $domDocumentClass
     * @param string $defaultScope
     */
    public function __construct(
        FileResolverInterface $fileResolver,
        ConverterInterface $converter,
        SchemaLocator $schemaLocator,
        ValidationStateInterface $validationState,
        $fileName = 'easier_extension_attributes.xml',
        $idAttributes = [],
        $domDocumentClass = Dom::class,
        $defaultScope = 'global'
    ) {
        parent::__construct(
            $fileResolver,
            $converter,
            $schemaLocator,
            $validationState,
            $fileName,
            $idAttributes,
            $domDocumentClass,
            $defaultScope
        );
    }
}
