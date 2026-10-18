<?php declare(strict_types=1);

namespace Yireo\EasierExtensionAttributes\Test\Integration\Stub;

use Magento\Framework\Config\FileResolverInterface;

class FixtureFileResolver implements FileResolverInterface
{
    public function get($filename, $scope)
    {
        $file = __DIR__ . '/../_files/' . $filename;
        return [$file => file_get_contents($file)];
    }
}
