<?php declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::MODULE, 'Yireo_EasierExtensionAttributes', __DIR__);

//libxml_set_external_entity_loader(['Magento\Framework\Config\Dom\UrnResolver', 'registerEntityLoader']);
