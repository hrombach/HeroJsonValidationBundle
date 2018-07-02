<?php

declare(strict_types=1);

/**
 * @copyright  Copyright (c) 2018, Net Inventors GmbH
 * @category   peggy
 * @author     hrombach
 */

namespace Hero\Bundle\JsonValidation\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HeroJsonValidationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container) : void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yaml');
    }
}