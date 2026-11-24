<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\Config\FileResolverInterface;

class FixtureFileResolver implements FileResolverInterface
{
    /**
     * @param string[] $files
     */
    public function __construct(
        private readonly array $files = ['easier_extension_attributes.xml']
    ) {
    }

    public function get($filename, $scope)
    {
        $fileList = [];
        foreach ($this->files as $file) {
            $path = __DIR__ . '/../_files/' . $file;
            $fileList[$path] = file_get_contents($path);
        }

        return $fileList;
    }
}
