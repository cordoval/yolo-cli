<?php

namespace Cli\Extension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class MyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container
            ->register('controller_resolver.callable_service', 'Cli\Controller\ControllerResolver')
            ->setArguments([
                new Reference('controller_resolver'),
                new Reference('service_container'),
            ])
            ->addTag('controller_resolver.decorator', [])
        ;

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/'));
        $loader->load('services.yml');
    }
}
